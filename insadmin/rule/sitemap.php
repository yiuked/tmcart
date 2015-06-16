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
$result = Db::getInstance()->ExecuteS('SELECT rule_link AS link FROM `'._DB_PREFIX_.'rule` WHERE entity="Category"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';

//brand page
$result = Db::getInstance()->ExecuteS('SELECT rule_link AS link FROM `'._DB_PREFIX_.'rule` WHERE `entity`="Brand"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';

//color page
$result = Db::getInstance()->ExecuteS('SELECT rule_link AS link FROM `'._DB_PREFIX_.'rule` WHERE `entity`="Color"');
foreach($result as $row)
$xmlString .= '
	<url>
		<loc>'.$link->getLink($row['link']).'</loc>
		<lastmod>'.date('c').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.6</priority>
	</url>';
	
//product page
$result = Db::getInstance()->ExecuteS('SELECT rule_link AS link FROM `'._DB_PREFIX_.'rule` WHERE `entity`="Product"');
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

	if(file_exists($s_file) && is_writable($s_file) && file_put_contents($s_file,$xmlString))
		echo '<div class="conf">生成SiteMap成功</div>';
	else
		$errors[] = 'sitemap.xml文件不存在，sitemap.xml或者文件不可写,请创建或更改权限后重试！';
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">SEO<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
		<span class="breadcrumb item-2 ">SiteMap </span> </span> 
	</h3>
  </div>
</div>

<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=sitemap" class="defaultForm" id="sitemap_form" name="example">
		  <fieldset>
  			<legend> <img alt="SiteMap" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/category.png">SiteMap</legend>
				<?php if(file_exists($s_file)){?>
						<p><b>最后更新:</b><?php echo date('Y-m-d H:i:s',filemtime($s_file));?></p>
						<p><b>文件权限:</b>
								<?php if(is_writable($s_file)){ ?>
								<font color="#006600">文件可写</font>
								<?php }else{ ?>
								<font color="#FF0000">文件不可写</font>
								<?php }?>
						</p>
						<p><b>链接:</b><a href="<?php echo $_tmconfig['root_dir'];?>sitemap.xml" target="_blank"><?php echo $_tmconfig['root_dir'];?>sitemap.xml</a></p>
						<input type="submit" value="更新SiteMap" name="createSiteMap" class="button" />
				<?php }else{ ?>
					<p>您还未生成过sitemap.xml文件，请在网站根目录下创建 sitemap.xml，将权限设置为可写.</p>
					<input type="submit" value="生成SiteMap" name="createSiteMap" class="button" />
				<?php }?>
		  </fieldset>
	</form>
</div>
