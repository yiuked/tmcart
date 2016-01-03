<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/12/29
 * Time: 16:45
 */

if (Tools::G('index') == 'brand') {
    /** 1.对filter表操作 **/
    $brands  = Db::getInstance()->getAllValue('SELECT id_brand FROM ' . DB_PREFIX . 'brand');
    if (is_array($brands)) {
        $filters_brand = Db::getInstance()->getAllValue('SELECT `value` FROM ' . DB_PREFIX . 'filter WHERE `key` = "id_brand"');

        $filters_brand_add_sql = array();
        if (is_array($filters_brand)) {
            $filters_brand_add = array_diff($brands, $filters_brand);
            $filters_brand_del = array_diff($filters_brand, $brands);
            if (count($filters_brand_add) > 0){
                foreach ($filters_brand_add as $id) {
                    $filters_brand_add_sql[] = '("id_brand", ' . (int)$id . ')';
                }
            }
        } else {
            foreach ($brands as $id) {
                $filters_brand_add_sql[] = '("id_brand", ' . (int)$id . ')';
            }
        }
        if (count($filters_brand_add_sql)) {
            Db::getInstance()->exec( 'INSERT INTO tm_filter (`key`, `value`) VALUES ' . implode(',', $filters_brand_add_sql));
        }
        if (count($filters_brand_del)) {
            $ret = Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE `id_filter` IN (SELECT `id_filter` FROM tm_filter WHERE `value` IN (' . implode(',', $filters_brand_del)  . ') AND `key`="id_brand")');
            if ($ret) {
                Db::getInstance()->exec('DELETE FROM tm_filter WHERE `value` IN (' . implode(',', $filters_brand_del)  . ') AND `key`="id_brand")');
            }
        }
    }
    /** 2.对filter_product表操作 **/
    Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE id_filter IN (SELECT `id_filter` FROM tm_filter WHERE `key`="id_brand")');
    Db::getInstance()->exec("INSERT INTO tm_filter_product (`id_filter`, `id_product`) SELECT f.id_filter,p.id_product FROM tm_product p
    LEFT JOIN tm_filter f ON (p.id_brand = f.value)
    WHERE f.key = 'id_brand'
    ORDER BY p.id_brand ASC");
} elseif (Tools::G('index') == 'feature') {
    /** 1.对filter表操作 **/
    $features = Db::getInstance()->getAllValue('SELECT id_feature_value FROM ' . DB_PREFIX . 'feature_value');
    if (is_array($features)) {
        $filters_feature = Db::getInstance()->getAllValue('SELECT `value` FROM ' . DB_PREFIX . 'filter WHERE `key` = "id_feature_value"');

        $filters_feature_add_sql = array();
        if (is_array($filters_feature)) {
            $filters_feature_add = array_diff($features, $filters_feature);
            $filters_feature_del = array_diff($filters_feature, $features);
            if (count($filters_feature_add) > 0){
                foreach ($filters_feature_add as $id) {
                    $filters_feature_add_sql[] = '("id_feature_value", ' . (int)$id . ')';
                }
            }
        } else {
            foreach ($features as $id) {
                $filters_feature_add_sql[] = '("id_feature_value", ' . (int)$id . ')';
            }
        }
        if (count($filters_feature_add_sql)) {
            Db::getInstance()->exec( 'INSERT INTO tm_filter (`key`, `value`) VALUES ' . implode(',', $filters_feature_add_sql));
        }
        if (count($filters_feature_del)) {
            $ret = Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE `id_filter` IN (SELECT `id_filter` FROM tm_filter WHERE `value` IN (' . implode(',', $filters_feature_del)  . ') AND `key`="id_feature_value")');
            if ($ret) {
                Db::getInstance()->exec('DELETE FROM tm_filter WHERE `value` IN (' . implode(',', $filters_feature_del)  . ') AND `key`="id_feature_value")');
            }
        }
    }

    /** 2.对filter_product表操作 **/
    Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE id_filter IN (SELECT `id_filter` FROM tm_filter WHERE `key`="id_feature_value")');
    Db::getInstance()->exec("INSERT INTO tm_filter_product (`id_filter`, `id_product`) SELECT f.id_filter,ptf.id_product FROM tm_product_to_feature ptf
    LEFT JOIN tm_filter f ON (ptf.id_feature_value = f.value)
    WHERE f.key = 'id_feature_value'");
} elseif (Tools::G('index') == 'attribute') {
    /** 1.对filter表操作 **/
    $attribute = Db::getInstance()->getAllValue('SELECT id_attribute FROM ' . DB_PREFIX . 'attribute');
    if (is_array($attribute)) {
        $filters_attribute = Db::getInstance()->getAllValue('SELECT `value` FROM ' . DB_PREFIX . 'filter WHERE `key` = "id_attribute"');

        $filters_attribute_add_sql = array();
        if (is_array($filters_attribute)) {
            $filters_attribute_add = array_diff($attribute, $filters_attribute);
            $filters_attribute_del = array_diff($filters_attribute, $attribute);
            if (count($filters_attribute_add) > 0){
                foreach ($filters_attribute_add as $id) {
                    $filters_attribute_add_sql[] = '("id_attribute", ' . (int)$id . ')';
                }
            }
        } else {
            foreach ($attribute as $id) {
                $filters_attribute_add_sql[] = '("id_attribute", ' . (int)$id . ')';
            }
        }
        if (count($filters_attribute_add_sql)) {
            Db::getInstance()->exec( 'INSERT INTO tm_filter (`key`, `value`) VALUES ' . implode(',', $filters_attribute_add_sql));
        }
        if (count($filters_attribute_del)) {
            $ret = Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE `id_filter` IN (SELECT `id_filter` FROM tm_filter WHERE `value` IN (' . implode(',', $filters_attribute_del)  . ') AND `key`="id_attribute")');
            if ($ret) {
                Db::getInstance()->exec('DELETE FROM tm_filter WHERE `value` IN (' . implode(',', $filters_attribute_del)  . ') AND `key`="id_attribute")');
            }
        }
    }

    /** 2.对filter_product表操作 **/
    Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE id_filter IN (SELECT `id_filter` FROM tm_filter WHERE `key`="id_attribute")');
    Db::getInstance()->exec("INSERT INTO tm_filter_product (`id_filter`, `id_product`) SELECT f.id_filter,pta.id_product FROM tm_product_to_attribute pta
    LEFT JOIN tm_filter f ON (pta.id_attribute = f.value)
    WHERE f.key = 'id_attribute'");
} elseif (Tools::G('index') == 'category') {
    /** 1.对filter表操作 **/
    $category = Db::getInstance()->getAllValue('SELECT id_category FROM ' . DB_PREFIX . 'category');
    if (is_array($category)) {
        $filters_category = Db::getInstance()->getAllValue('SELECT `value` FROM ' . DB_PREFIX . 'filter WHERE `key` = "id_category"');

        $filters_category_add_sql = array();
        if (is_array($filters_category)) {
            $filters_category_add = array_diff($category, $filters_category);
            $filters_category_del = array_diff($filters_category, $category);
            if (count($filters_category_add) > 0){
                foreach ($filters_category_add as $id) {
                    $filters_category_add_sql[] = '("id_category", ' . (int)$id . ')';
                }
            }
        } else {
            foreach ($category as $id) {
                $filters_category_add_sql[] = '("id_category", ' . (int)$id . ')';
            }
        }
        if (count($filters_category_add_sql)) {
            Db::getInstance()->exec( 'INSERT INTO tm_filter (`key`, `value`) VALUES ' . implode(',', $filters_category_add_sql));
        }
        if (count($filters_category_del)) {
            $ret = Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE `id_filter` IN (SELECT `id_filter` FROM tm_filter WHERE `value` IN (' . implode(',', $filters_category_del)  . ') AND `key`="id_category")');
            if ($ret) {
                Db::getInstance()->exec('DELETE FROM tm_filter WHERE `value` IN (' . implode(',', $filters_category_del)  . ') AND `key`="id_category")');
            }
        }
    }

    /** 2.对filter_product表操作 **/
    Db::getInstance()->exec('DELETE FROM tm_filter_product WHERE id_filter IN (SELECT `id_filter` FROM tm_filter WHERE `key`="id_category")');
    Db::getInstance()->exec("INSERT INTO tm_filter_product (`id_filter`, `id_product`) SELECT f.id_filter,ptc.id_product FROM tm_product_to_category ptc
    LEFT JOIN tm_filter f ON (ptc.id_category = f.value)
    WHERE f.key = 'id_category'");
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '索引', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="index.php?rule=filter&index=brand">重建品牌索引</a>
                <a href="index.php?rule=filter&index=feature">重建特征索引</a>
                <a href="index.php?rule=filter&index=attribute">重建属性索引</a>
                <a href="index.php?rule=filter&index=category">重建分类索引</a>
            </div>
        </div>
    </div>
</div>

