<?php

if(isset($_POST['changeProductCategory']))
{
	if(count($_POST['categoryBox'])>0){
		$result = Db::getInstance()->ExecuteS('
			SELECT `id_product`
			FROM `'._DB_PREFIX_.'product_to_category`
			WHERE id_category IN('.pSQL(implode(",",$_POST['categoryBox'])).')');
		foreach($result as $row){
			$ret = Db::getInstance()->getRow('SELECT `id_product` FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_product`='.intval($row['id_product']).' AND `id_category`='.intval($_POST['id_category']));
			if(!$ret){
				Db::getInstance()->Execute('
				INSERT INTO `'._DB_PREFIX_.'product_to_category` (`id_product`, `id_category`)
				VALUES ('.$row['id_product'].','.(int)$_POST['id_category'].')');
			}
			if($_POST['isDefault']==1){
				Db::getInstance()->Execute('
				UPDATE `'._DB_PREFIX_.'product` SET `id_category_default`='.(int)$_POST['id_category'].'
				WHERE `id_product`='.intval($row['id_product']));
			}
		}
	}
}

$result = Db::getInstance()->ExecuteS('
	SELECT *
	FROM `'._DB_PREFIX_.'category`
	WHERE (`active` = 1 OR `id_category` = 1)
	GROUP BY id_category
	ORDER BY `level_depth` ASC, `position` ASC');

if($result){
	$resultParents 	= array();
	$resultIds 		= array();
	
	foreach ($result as &$row)
	{
		$resultParents[$row['id_parent']][] = &$row;
		$resultIds[$row['id_category']] = &$row;
	}
}

$blockCategTree = getTree($resultParents, $resultIds, Configuration::get('BLOCK_CATEG_MAX_DEPTH'));
function getTree($resultParents, $resultIds, $maxDepth, $id_category = 1, $currentDepth = 0)
{
	global $link;

	$children = array();
	if (isset($resultParents[$id_category]) AND sizeof($resultParents[$id_category]) AND ($maxDepth == 0 OR $currentDepth < $maxDepth))
		foreach ($resultParents[$id_category] as $subcat)
			$children[] = getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
	if (!isset($resultIds[$id_category]))
		return false;
	return array('id' => $id_category, 
				 'name' => $resultIds[$id_category]['name'], 
				 'children' => $children);
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">产品管理</span><img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;">
		<span class="breadcrumb item-2 ">批量转移产品</span></span> 
	</h3>
  </div>
</div>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=product_to_category" class="defaultForm admincmscontent" id="seo_cate_meta_form" name="example">
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">批量转移产品</legend>
				<label>选择需要转移的分类：</label>
				<div class="margin-form">
				<?php
				$cate = array();
				if(isset($_POST['categoryBox'])){
					$cate = Tools::getRequest('categoryBox');
				}
				
				$trads = array(
					 'Home' 		=> '根分类', 
					 'selected' 	=> '选择', 
					 'Collapse All' => '关闭', 
					 'Expand All' 	=> '展开',
					 'Check All'	=> '全选',
					 'Uncheck All'	=> '全不选'
				);
				echo Helper::renderAdminCategorieTree($trads,$cate, 'categoryBox', false,'Tree');
			 ?>
			  </div>
			  <label>要转移到的分类：</label>
			  <div class="margin-form">
			  <?php
			  	$tree_html = '<select name="id_category">';
			  	foreach($blockCategTree['children'] as $node1)
				{
					if(count($node1['children'])>0)
					{
						$tree_html .= '<option value="'.$node1['id'].'">'.$node1['name'].'</option>';
						foreach($node1['children'] as $node2){
								$tree_html .= '<option value="'.$node2['id'].'">--'.$node2['name'].'</option>';
						}
					}
				}
				$tree_html .= '</select>';
				echo $tree_html;
			  ?>
			  <input type="checkbox" value="1" name="isDefault"  />将新分类设为默认分类.
			  </div>
			  <div class="margin-form">
			  	<input type="submit" name="changeProductCategory" value="开始转移产品" id="changeProductCategory" class="button" />
			  </div>
		  </fieldset>
	</form>
</div>
