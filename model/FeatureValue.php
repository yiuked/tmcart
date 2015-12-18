<?php
class FeatureValue extends ObjectBase{

    protected $fields	= array(
        'id_feature_value' => array(
            'type' => 'isInt',
        ),
        'id_feature' => array(
            'type' => 'isInt',
        ),
        'name' => array(
            'required' => true,
            'size' => 56,
            'type' => 'isGenericName',
        ),
        'position' => array(
            'type' => 'isInt',
        ),
    );

    protected $identifier 		= 'id_feature_value';
    protected $table			= 'feature_value';

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
            return Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'`product_to_feature WHERE `id_feature`='.(int)($this->id));
        }
    }

    /**
     * 获得最大的postion,并且自动加1
     *
     * @param $id_category_parent
     * @return int
     */
    public function getLastPosition()
    {
        return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'.DB_PREFIX.'feature_value` WHERE `id_feature` = '.(int)($this->id_feature)));
    }

    public function cleanPositions()
    {
        $result = Db::getInstance()->getAll('
		SELECT `id_feature_value`
		FROM `'.DB_PREFIX.'feature_value`
		WHERE `id_feature` = '.(int)($this->id_feature).'
		ORDER BY `position`');
        $sizeof = sizeof($result);
        for ($i = 0; $i < $sizeof; ++$i){
            $sql = '
				UPDATE `'.DB_PREFIX.'feature_value`
				SET `position` = '.(int)($i).'
				WHERE `id_feature` = '.(int)($this->id_feature).'
				AND `id_feature_value` = '.(int)($result[$i]['id_feature_value']);
            Db::getInstance()->exec($sql);
        }
        return true;
    }

    public function updatePosition($way, $position)
    {
        if (!$result = Db::getInstance()->getAll('
			SELECT `id_feature`, `position`, `id_feature_value`
			FROM `'.DB_PREFIX.'feature_value`
			WHERE `id_feature` = '.(int)$this->id_feature.'
			ORDER BY `position` ASC'
        ))
            return false;
        foreach ($result AS $row)
            if ((int)($row['id_feature']) == (int)($this->id))
                $movedRow = $row;

        if (!isset($movedRow) || !isset($position))
            return false;
        // < and > statements rather than BETWEEN operator
        // since BETWEEN is treated differently according to databases
        return (Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'feature_value`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way
                    ? '> '.(int)($movedRow['position']).' AND `position` <= '.(int)($position)
                    : '< '.(int)($movedRow['position']).' AND `position` >= '.(int)($position)).'
			AND `id_feature`='.(int)($movedRow['id_feature']))
            AND Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'feature_value`
			SET `position` = '.(int)($position).'
			WHERE `id_feature_value` = '.(int)($movedRow['id_feature_value']).'
			AND `id_feature`='.(int)($movedRow['id_feature'])));
    }

    public static function loadData($p = 1, $limit = 1000, $orderBy = NULL, $orderWay = NULL, $filter = array())
    {
        $where = '';

        if(isset($filter['id_feature_value']) && Validate::isInt($filter['id_feature_value']))
            $where .= ' AND a.`id_feature_value`='.intval($filter['id_feature_value']);
        if(isset($filter['name']) && Validate::isCatalogName($filter['name']))
            $where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
        if(isset($filter['id_feature']) && Validate::isInt($filter['id_feature']))
            $where .= ' AND a.`id_feature`='.intval($filter['id_feature']);

        if(!is_null($orderBy) AND !is_null($orderWay))
        {
            $postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
        }else{
            $postion = 'ORDER BY `position` ASC';
        }

        $total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'feature_value` a
				WHERE 1 '.$where);
        if($total == 0)
            return false;

        $result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'feature_value` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit).','.(int) $limit);
        $rows   = array(
            'total' => $total['total'],
            'items'  => $result);
        return $rows;
    }
}
?>