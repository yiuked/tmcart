<?php
/**
 * 2010-2015 Yiuked
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to yiuked@vip.qq.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade yiukedautoseo to newer
 * versions in the future.
 *
 * @author    Yiuked SA <yiuked@vip.qq.com>
 * @copyright 2010-2015 Yiuked
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class UIAdminAlerts
{
    public static function conf($msg, $return = false)
    {
        $html = self::msg($msg, 'bg-success');
        if ($return) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function MError($errors = array(), $return = false)
    {
        if (count($errors) == 0) {
            return;
        }

        $msg = '<p>发现 '. count($errors) .' 处错误</p>';
        $msg .= '<ol>';
        foreach ($errors as $error) {
            $msg .= '<li>' .$error. '</li>';
        }
        $msg .= '</ol>';
        $html = '<div class="row"><div class="col-md-12"><div class="bg-danger alert">' . $msg . '</div></div></div>';

        if ($return) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * the type value:
     * bg-primary
     * bg-success
     * bg-info
     * bg-warning
     * bg-danger
     * */
    public static function msg($msg, $type)
    {
        $html = '<div class="row"><div class="col-md-12"><p class="' . $type . ' alert">' . $msg . '</p></div></div>';
        return $html;
    }
}