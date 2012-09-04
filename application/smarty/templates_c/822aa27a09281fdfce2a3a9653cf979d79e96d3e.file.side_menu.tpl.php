<?php /* Smarty version Smarty-3.1.8, created on 2012-09-04 18:24:28
         compiled from "/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/include/side_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11042906975040698339a290-39372631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '822aa27a09281fdfce2a3a9653cf979d79e96d3e' => 
    array (
      0 => '/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/include/side_menu.tpl',
      1 => 1346750665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11042906975040698339a290-39372631',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_504069833a2122_92463944',
  'variables' => 
  array (
    'name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_504069833a2122_92463944')) {function content_504069833a2122_92463944($_smarty_tpl) {?><div id="side" style="text-align:center;">
	<p>
		<img src="/img/get-profile-img" width="100px" />
		<br/>
		<span><a href="/user/view-user-data-update-page"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></span>
	</p>
	<hr/>
	<p>
		<span><a href="/user/view-user-list-page">絆一覧</a></span>
	</p>
	
</div><?php }} ?>