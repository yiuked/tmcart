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
 * Do not edit or add to this file if you wish to upgrade to newer
 * versions in the future.
 *
 *  @author    Yiuked SA <yiuked@vip.qq.com>
 *  @copyright 2010-2015 Yiuked
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Address extends ObjectBase{
	protected $fields = array(
		'name' => array(
			'type' => 'isName',
		),
		'id_country' => array(
			'type' => 'isInt',
		),
		'id_user' => array(
			'type' => 'isInt',
		),
		'id_state' => array(
			'type' => 'isInt',
		),
		'city' => array(
			'type' => 'isCityName',
		),
		'postcode' => array(
			'type' => 'isPostCode',
		),
		'address' => array(
			'type' => 'isAddress',
		),
		'address2' => array(
			'type' => 'isAddress',
		),
		'phone' => array(
			'type' => 'isPhoneNumber',
		),
		'is_default' => array(
			'type' => 'isInt',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	protected $identifier 		= 'id_address';
	protected $table			= 'address';

	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter = array())
	{
		$where = '';
		if(isset($filter['id_address']))
			$where .= ' AND a.`id_address`='.intval($filter['id_address']);
		if(isset($filter['id_country']))
			$where .= ' AND a.`id_country`='.intval($filter['id_country']);
		if(isset($filter['id_state']))
			$where .= ' AND a.`id_state`='.intval($filter['id_state']);
		if(isset($filter['address']) && Validate::isCatalogName($filter['address']))
			$where .= ' AND a.`address` LIKE "%'.pSQL($filter['address']).'%"';
		if(isset($filter['city']) && Validate::isCatalogName($filter['city']))
			$where .= ' AND a.`city` LIKE "%'.pSQL($filter['city']).'%"';
		if(isset($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_address` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'address` a
				LEFT JOIN  `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				LEFT JOIN  `'.DB_PREFIX.'state` s ON (a.id_state = s.id_state)
				WHERE 1' . $where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.*, c.name AS country, s.name AS state FROM `'.DB_PREFIX.'address` a
				LEFT JOIN  `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				LEFT JOIN  `'.DB_PREFIX.'state` s ON (a.id_state = s.id_state)
				WHERE 1 ' . $where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>