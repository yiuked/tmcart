<?php
	class CMSHelper{
		
		public static function getNewCMS($n=10)
		{
			$result = Db::getInstance()->ExecuteS('
				SELECT * FROM `'._DB_PREFIX_.'cms`
				WHERE active = 1
				ORDER BY `add_date` DESC
				LIMIT 0,'.(int)($n));
			return CMS::resetCMS($result);
		}
		
		public static function getLastComment($n=10)
		{
			$result = Db::getInstance()->ExecuteS('
				SELECT cc.comment,c.rewrite
				FROM '._DB_PREFIX_.'cms_comment AS cc
				LEFT JOIN '._DB_PREFIX_.'cms AS c ON cc.id_cms = c.id_cms
				WHERE cc.active = 1
				ORDER BY cc.`add_date` DESC
				LIMIT 0,'.(int)($n));
			foreach($result as &$row)
				$row['link'] = Tools::getLink($row['rewrite']);
			return $result;
		}
	
		public static function getLevelCategory($leve=1)
		{
			$result = Db::getInstance()->ExecuteS('
						SELECT cc.`name`,cc.rewrite,
						(SELECT COUNT(*) FROM '._DB_PREFIX_.'cms_to_category ctc WHERE ctc.id_cms_category=cc.id_cms_category) as t
						FROM '._DB_PREFIX_.'cms_category AS cc
						WHERE cc.active=1 AND cc.level_depth='.(int)($leve));
			foreach($result as &$row)
				$row['link'] = Tools::getLink($row['rewrite']);
			return $result;
		}
		
		public static function getSreachCMS($query,$p=1,$m=50)
		{
			$result = Db::getInstance()->ExecuteS('
				SELECT * FROM `'._DB_PREFIX_.'cms`
				WHERE active = 1
				AND (title LIKE "%'.pSQL($query).'%" OR meta_title LIKE "%'.pSQL($query).'%" OR `meta_keywords` LIKE "%'.pSQL($query).'%" OR `meta_description` LIKE "%'.pSQL($query).'%" OR `content` LIKE "%'.pSQL($query).'%")
				ORDER BY `add_date` DESC
				LIMIT '.($p-1).','.(int)($m));
			return CMS::resetCMS($result);
		}
		
		public static function getDateCMSBlock()
		{
			$result = Db::getInstance()->ExecuteS('
				SELECT FROM_UNIXTIME(UNIX_TIMESTAMP(add_date),"%Y/%m") AS d_date, COUNT(*) AS t FROM `'._DB_PREFIX_.'cms` 
				WHERE active = 1
				GROUP BY d_date DESC');
			foreach($result as &$row)
				$row['link'] = Tools::getLink('date/'.$row['d_date']);
			return $result;
		}
		
		public static function getDateCMS($date_query,$p=1,$m=50)
		{
			$result = Db::getInstance()->ExecuteS('
				SELECT * FROM `'._DB_PREFIX_.'cms`
				WHERE active = 1
				AND FROM_UNIXTIME(UNIX_TIMESTAMP(add_date),"%Y-%m")="'.pSQL($date_query).'"
				ORDER BY `add_date` DESC
				LIMIT '.($p-1).','.(int)($m));
			return CMS::resetCMS($result);
		}
	}
?>
