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
			if($_POST['isDelete']==1){
				Db::getInstance()->Execute('
				DELETE  FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_category` IN('.implode(',',$_POST['categoryBox']).') AND
				`id_product`='.intval($row['id_product']));
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
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '批量换类', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			批量转移分类
			</div>
			<div class="panel-body">
				<form method="post" action="index.php?rule=product_to_category" class="form-horizontal">
					<div class="form-group">
						<label for="categoryBox" class="col-sm-2 control-label">要转移的分类</label>
						<div class="col-sm-2">
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
					</div>
					<div class="form-group">
						<label for="id_category" class="col-sm-2 control-label">要转移到的分类</label>
						<div class="col-sm-2">
							<?php
							$tree_html = '<select name="id_category"  class="form-control col-sm-1">';
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
						</div>
					</div>
					<div class="form-group">
						<label for="isDefault" class="col-sm-2 control-label">将新分类设为默认分类</label>
						<div class="col-sm-10">
							<input type="checkbox" value="1" name="isDefault"  />
						</div>
					</div>
					<div class="form-group">
						<label for="isDelete" class="col-sm-2 control-label">取消原分类关联</label>
						<div class="col-sm-10">
							<input type="checkbox" value="1" name="isDelete" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<buttom type="submit" name="changeProductCategory" id="changeProductCategory" class="btn btn-success" >开始转移产品</buttom>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
