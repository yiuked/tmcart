<?php
class Feature extends ObjectBase{

    protected $fields	= array(
        'id_feature' => array(
            'type' => 'isInt',
        ),
        'name' => array(
            'required' => true,
            'size' => 256,
            'type' => 'isGenericName',
        ),
        'position' => array(
            'type' => 'isInt',
        ),
    );

    protected $identifier 		= 'id_feature';
    protected $table			= 'feature';

    public function add()
    {
        $this->position = $this->getLastPosition();
        return parent::add();
    }

    public function delete()
    {
        if(parent::delete())
        {
            $this->cleanPositions();
            return Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'feature_value` WHERE `id_feature`='.(int)($this->id)) &&
            Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_feature` WHERE `id_feature`='.(int)($this->id));
        }
    }

    public static function loadData($p = 1, $limit = 1000, $orderBy = NULL, $orderWay = NULL, $filter = array())
    {

        $where = '';
        if(!empty($filter['id_feature']) && Validate::isInt($filter['id_feature']))
            $where .= ' AND a.`id_feature`='.intval($filter['id_feature']);
        if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
            $where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';

        if(!is_null($orderBy) AND !is_null($orderWay))
        {
            $postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
        }else{
            $postion = 'ORDER BY `position` ASC';
        }

        $total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'feature` a
				WHERE 1 '.$where);
        if($total==0)
            return false;

        $result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'feature` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
        $rows   = array(
            'total' => $total['total'],
            'items'  => $result);
        return $rows;
    }
}
?>