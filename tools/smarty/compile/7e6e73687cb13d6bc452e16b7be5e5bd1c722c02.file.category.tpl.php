<?php /* Smarty version Smarty-3.1.12, created on 2016-01-09 17:28:42
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17224627085690d2ca324402-90494082%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e6e73687cb13d6bc452e16b7be5e5bd1c722c02' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/category.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17224627085690d2ca324402-90494082',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'filters' => 0,
    'brand' => 0,
    'category' => 0,
    'feature' => 0,
    'value' => 0,
    'group' => 0,
    'this_url' => 0,
    'p' => 0,
    'link' => 0,
    'pages_nb' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5690d2ca436734_23586531',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5690d2ca436734_23586531')) {function content_5690d2ca436734_23586531($_smarty_tpl) {?><div class="container">
    <div class="filters">
        <div class="row filter-heading">
            <div class="col-md-12" >商品筛选</div>
        </div>
        <?php if (isset($_smarty_tpl->tpl_vars['filters']->value['brand'])&&$_smarty_tpl->tpl_vars['filters']->value['brand']){?>
        <div class="row filter-line">
            <div class="col-md-1 title">品牌</div>
            <div class="col-md-10 value">
                <ul class="inline">
                    <?php  $_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brand']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['filters']->value['brand']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->key => $_smarty_tpl->tpl_vars['brand']->value){
$_smarty_tpl->tpl_vars['brand']->_loop = true;
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['brand']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['brand']->value['filter_num'];?>
)</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-1 extra"></div>
        </div>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['filters']->value['categories'])&&$_smarty_tpl->tpl_vars['filters']->value['categories']){?>
            <div class="row filter-line">
                <div class="col-md-1 title">分类</div>
                <div class="col-md-10 value">
                    <ul class="inline">
                        <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['filters']->value['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                            <li><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['category']->value['filter_num'];?>
)</li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-1 extra"></div>
            </div>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['filters']->value['feature'])&&$_smarty_tpl->tpl_vars['filters']->value['feature']){?>
            <?php  $_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['feature']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['filters']->value['feature']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->key => $_smarty_tpl->tpl_vars['feature']->value){
$_smarty_tpl->tpl_vars['feature']->_loop = true;
?>
            <div class="row filter-line">
                <div class="col-md-1 title"><?php echo $_smarty_tpl->tpl_vars['feature']->value['name'];?>
</div>
                <div class="col-md-10 value">
                    <ul class="inline">
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['feature']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                            <li><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['value']->value['filter_num'];?>
)</li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-1 extra"></div>
            </div>
            <?php } ?>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['filters']->value['attribute'])&&$_smarty_tpl->tpl_vars['filters']->value['attribute']){?>
            <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['filters']->value['attribute']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
                <div class="row filter-line">
                    <div class="col-md-1 title"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</div>
                    <div class="col-md-10 value">
                        <ul class="inline">
                            <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                                <li><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['value']->value['filter_num'];?>
)</li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-1 extra"></div>
                </div>
            <?php } ?>
        <?php }?>
    </div>
    <div class="row product-extra-bar">
        <div class="col-md-3">
            <div class="btn-group btn-group-sm" role="group">
                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default">综合</a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default">新品</a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default">销量</a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default">评论</a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default">价格</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-daterange input-group">
                <span class="input-group-addon">价格</span>
                <input type="text" class="input-sm form-control" name="start_price">
                <span class="input-group-addon">到</span>
                <input type="text" class="input-sm form-control" name="end_price">
            </div>
        </div>
        <div class="col-md-6 text-right">
            <?php echo $_smarty_tpl->tpl_vars['p']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['pages_nb']->value;?>

            <div class="btn-group btn-group-sm" role="group">
                <?php if ($_smarty_tpl->tpl_vars['p']->value!=1){?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
" class="btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-menu-left"></span></a>
                <?php }else{ ?>
                    <button type="button" class="btn btn-default" disabled="disabled"><span aria-hidden="true" class="glyphicon glyphicon-menu-left"></span></button>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['pages_nb']->value>1&&$_smarty_tpl->tpl_vars['p']->value!=$_smarty_tpl->tpl_vars['pages_nb']->value){?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value+1);?>
" class="btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></a>
                <?php }else{ ?>
                    <button type="button" class="btn btn-default" disabled="disabled"><span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></button>
                <?php }?>

            </div>
        </div>
    </div>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div><?php }} ?>