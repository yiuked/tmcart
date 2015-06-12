<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 12498 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include_once(_TM_SWIFT_DIR.'Swift.php');
include_once(_TM_SWIFT_DIR.'Swift/Connection/SMTP.php');
include_once(_TM_SWIFT_DIR.'Swift/Connection/NativeMail.php');
include_once(_TM_SWIFT_DIR.'Swift/Plugin/Decorator.php');

class Mail
{
	public static function Send($template, $subject, $templateVars, $to,
		$toName = null, $from = null, $fromName = null, $fileAttachment = null, $modeSMTP = null, $templatePath = null, $die = false)
	{
		$configuration = Configuration::getMultiple(array('TM_SHOP_EMAIL', 'TM_MAIL_METHOD', 'TM_MAIL_SERVER', 'TM_MAIL_USER', 'TM_MAIL_PASSWD', 'TM_SHOP_NAME', 'TM_MAIL_SMTP_ENCRYPTION', 'TM_MAIL_SMTP_PORT', 'TM_MAIL_METHOD'));
		if (!isset($configuration['TM_MAIL_SMTP_ENCRYPTION'])) $configuration['TM_MAIL_SMTP_ENCRYPTION'] = 'off';
		if (!isset($configuration['TM_MAIL_SMTP_PORT'])) $configuration['TM_MAIL_SMTP_PORT'] = 'default';

		if (!isset($from)) $from = $configuration['TM_SHOP_EMAIL'];
		if (!isset($fromName)) $fromName = $configuration['TM_SHOP_NAME'];

		if (!empty($from) && !Validate::isEmail($from))
		{
 			Tools::dieOrLog(Tools::displayError('Error: parameter "from" is corrupted'), $die);
 			return false;
		}
		if (!empty($fromName) && !Validate::isMailName($fromName))
		{
	 		Tools::dieOrLog(Tools::displayError('Error: parameter "fromName" is corrupted'), $die);
	 		return false;
		}
		if (!is_array($to) && !Validate::isEmail($to))
		{
	 		Tools::dieOrLog(Tools::displayError('Error: parameter "to" is corrupted'), $die);
	 		return false;
		}

		if (!is_array($templateVars))
		{
	 		Tools::dieOrLog(Tools::displayError('Error: parameter "templateVars" is not an array'), $die);
	 		return false;
		}
		
		// Do not crash for this error, that may be a complicated customer name
		if (is_string($toName))
		{
			if (!empty($toName) && !Validate::isMailName($toName))
	 			$toName = null;
		}
			
		if (!Validate::isTplName($template))
		{
	 		Tools::dieOrLog(Tools::displayError('Error: invalid email template'), $die);
	 		return false;
		}
			
		if (!Validate::isMailSubject($subject))
		{
	 		Tools::dieOrLog(Tools::displayError('Error: invalid email subject'), $die);
	 		return false;
		}

		/* Construct multiple recipients list if needed */
		if (isset($to) && is_array($to))
		{
			$to_list = new Swift_RecipientList();
			foreach ($to as $key => $addr)
			{
				$to_name = null;
				$addr = trim($addr);
				if (!Validate::isEmail($addr))
				{
					Tools::dieOrLog(Tools::displayError('Error: invalid email address'), $die);
					return false;
				}
				if (is_array($toName))
				{
					if ($toName && is_array($toName) && Validate::isGenericName($toName[$key]))
						$to_name = $toName[$key];
				}
				$to_list->addTo($addr, base64_encode($to_name));
			}
			$to_plugin = $to[0];
			$to = $to_list;
		} else {
			/* Simple recipient, one address */
			$to_plugin = $to;
			$to = new Swift_Address($to, base64_encode($toName));
		}
		try {
			/* Connect with the appropriate configuration */
			if ($configuration['TM_MAIL_METHOD'] == 2)
			{
				if (empty($configuration['TM_MAIL_SERVER']) || empty($configuration['TM_MAIL_SMTP_PORT']))
				{
					Tools::dieOrLog(Tools::displayError('Error: invalid SMTP server or SMTP port'), $die);
					return false;
				}
				$connection = new Swift_Connection_SMTP($configuration['TM_MAIL_SERVER'], $configuration['TM_MAIL_SMTP_PORT'],
								($configuration['TM_MAIL_SMTP_ENCRYPTION'] == 'ssl') ? Swift_Connection_SMTP::ENC_SSL : 
								(($configuration['TM_MAIL_SMTP_ENCRYPTION'] == 'tls') ? Swift_Connection_SMTP::ENC_TLS : Swift_Connection_SMTP::ENC_OFF));
				$connection->setTimeout(20);
				
				if (!$connection)
					return false;
				if (!empty($configuration['TM_MAIL_USER']))
					$connection->setUsername($configuration['TM_MAIL_USER']);
				if (!empty($configuration['TM_MAIL_PASSWD']))
					$connection->setPassword($configuration['TM_MAIL_PASSWD']);
			}
			else
				$connection = new Swift_Connection_NativeMail();
			
			if (!$connection)
				return false;
			$swift = new Swift($connection, Configuration::get('TM_MAIL_DOMAIN'));

			// get templatePath
			$templatePath = _TM_THEMES_DIR.'mails/';
			$templateHtml = file_get_contents($templatePath.$template.'.html');

			/* Create mail && attach differents parts */
			$message = new Swift_Message('['.Configuration::get('TM_SHOP_NAME').'] '.$subject);
			
			$templateVars['{shop_logo}'] = (file_exists(_TM_IMG_DIR.'logo_mail.jpg'))? $message->attach(new Swift_Message_Image(new Swift_File(_TM_IMG_DIR.'logo_mail.jpg'))) : ((file_exists(_TM_IMG_DIR.'logo.jpg')) ? $message->attach(new Swift_Message_Image(new Swift_File(_TM_IMG_DIR.'logo.jpg'))) : '');
			$templateVars['{shop_name}'] = Tools::safeOutput(Configuration::get('TM_SHOP_NAME'));
			$templateVars['{shop_url}'] = Tools::getShopDomain(true, true).__TM_BASE_URI__;
			$swift->attachPlugin(new Swift_Plugin_Decorator(array($to_plugin => $templateVars)), 'decorator');
			$message->attach(new Swift_Message_Part($templateHtml, 'text/html', '8bit', 'utf-8'));
			
			if ($fileAttachment && isset($fileAttachment['content']) && isset($fileAttachment['name']) && isset($fileAttachment['mime']))
				$message->attach(new Swift_Message_Attachment($fileAttachment['content'], $fileAttachment['name'], $fileAttachment['mime']));
			/* Send mail */
			$send = $swift->send($message, $to, new Swift_Address($from, $fromName));

			$swift->disconnect();
			return $send;
		}

		catch (Swift_ConnectionException $e)
		{
			return false;
		}
	}

	public static function sendMailTest($smtpChecked, $smtpServer, $content, $subject, $type, $to, $from, $smtpLogin, $smtpPassword, $smtpPort = 25, $smtpEncryption)
	{
		$swift = null;
		$result = false;
		try
		{
			if ($smtpChecked)
			{
				$smtp = new Swift_Connection_SMTP($smtpServer, $smtpPort, ($smtpEncryption == 'off') ? 
					Swift_Connection_SMTP::ENC_OFF : (($smtpEncryption == 'tls') ? Swift_Connection_SMTP::ENC_TLS : Swift_Connection_SMTP::ENC_SSL));
				$smtp->setUsername($smtpLogin);
				$smtp->setpassword($smtpPassword);
				$smtp->setTimeout(20);
				$swift = new Swift($smtp, Configuration::get('TM_MAIL_DOMAIN'));
			}
			else
				$swift = new Swift(new Swift_Connection_NativeMail(), Configuration::get('TM_MAIL_DOMAIN'));

			$message = new Swift_Message($subject, $content, $type);

			if ($swift->send($message, $to, $from))
				$result = true;

			$swift->disconnect();
		}
		catch (Swift_ConnectionException $e)
		{
			$result = $e->getMessage();
		}
		catch (Swift_Message_MimeException $e)
		{
			$result = $e->getMessage();
		}

		return $result;
	}
}
