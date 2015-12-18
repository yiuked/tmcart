<?php
$s_file = _TM_ROOT_DIR_.'/sitemap.xml';

if(Tools::isSubmit('createSiteMap')){

$xmlString = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.$_tmconfig['tools_dir'].'sitemap/sitemap.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

//home page
$xmlString .= '
	<url>
		<loc>'._TM_BASE_URL_.'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>';

$link = new Link();
//category page
$result = Db::getInstance()->getAll('SELECT rule_link AS link FROM `'.DB_PREFIX.'rule` WHERE entity="Category"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';

//brand page
$result = Db::getInstance()->getAll('SELECT rule_link AS link FROM `'.DB_PREFIX.'rule` WHERE `entity`="Brand"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';

//color page
$result = Db::getInstance()->getAll('SELECT rule_link AS link FROM `'.DB_PREFIX.'rule` WHERE `entity`="Color"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';
	
//product page
$result = Db::getInstance()->getAll('SELECT rule_link AS link FROM `'.DB_PREFIX.'rule` WHERE `entity`="Product"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';

$xmlString .= '
</urlset>';

	if (file_exists($s_file) && is_writable($s_file) && file_put_contents($s_file,$xmlString)) {
		UIAdminAlerts::conf('Sitemap已更新');
	} else {
		$errors[] = 'sitemap.xml文件不存在，sitemap.xml或者文件不可写,请创建或更改权限后重试！';
	}
}

/** 错误处理 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => 'Sitemap', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'button', 'title' => '更新', 'id' => 'save-sitemap-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-sitemap-form").click(function(){
		$("#sitemap-form").submit();
	})
</script>
<?php

$form = new UIAdminEditForm('post', 'index.php?rule=sitemap', 'form-horizontal', 'sitemap-form');

if  (file_exists($s_file)) {
	$form->items['last_time'] = array(
		'type' => 'custom',
		'title' => '最后更新',
		'value'=> date('Y-m-d H:i:s',filemtime($s_file)),
	);
	$form->items['is_write'] = array(
		'type' => 'custom',
		'title' => '文件权限',
		'value'=> is_writable($s_file) ? '<span class="label label-success">文件可写</span>' : '<span class="label label-danger">文件不可写</span>',
	);
	$form->items['link'] = array(
		'type' => 'custom',
		'title' => '链接',
		'value'=> '<a href ="' ._TM_ROOT_URL_ . 'sitemap.xml" target="_blank" >' . _TM_ROOT_URL_ .'sitemap.xml</a>',
	);
} else {
	$form->items['link'] = array(
		'type' => 'custom',
		'title' => '提示',
		'value'=> '<div class="alert alert-warning" role="alert">您还未生成过sitemap.xml文件，请在网站根目录下创建 sitemap.xml，将权限设置为可写.</div>',
	);
}
$form->items['createSiteMap'] = array(
	'type' => 'submit',
	'class' => 'btn-success',
	'icon' => 'save',
	'title' => '更新'
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
