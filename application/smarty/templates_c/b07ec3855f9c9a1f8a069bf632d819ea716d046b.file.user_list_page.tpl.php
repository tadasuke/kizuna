<?php /* Smarty version Smarty-3.1.8, created on 2012-09-04 18:23:35
         compiled from "/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/user_list_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15461197245045bb3c8553f7-74619927%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b07ec3855f9c9a1f8a069bf632d819ea716d046b' => 
    array (
      0 => '/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/user_list_page.tpl',
      1 => 1346750523,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15461197245045bb3c8553f7-74619927',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5045bb3c8d9151_24193953',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5045bb3c8d9151_24193953')) {function content_5045bb3c8d9151_24193953($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("include/js_include.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<style type="text/css">
	#user_data_update table　{
		width:100px;
	}
</style>
</head>
<body>
<div id="base">
	<?php echo $_smarty_tpl->getSubTemplate ("include/head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<div id="wrap">
		<div id="contents">
			<div id="c_pad">
				<table id="user_data">
				</table>
			</div>
		</div>
		<!--contents end-->
		<?php echo $_smarty_tpl->getSubTemplate ("include/side_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div>
	<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>

<script type="text/javascript">

	// ユーザ一覧取得
	var valueArray;
	valueArray = getAllUserData();
	
	// 表示
	var html = '';
	for ( i = 0; i < valueArray.length; i++ ) {
		html += '<tr>';
		html += '<td>';
		html += '<a href="/top/index?user_key=' + valueArray[i]['user_key'] + '&priority=9">';
		html += '<img src="/img/get-profile-img?target_user_key=' + valueArray[i]['user_key'] + '" width="30px" />';
		html += '</a>';
		html += '</td>';
		html += '<td>';
		html += valueArray[i]['user_name'];
		html += '</td>';
		html += '<td>';
		html += valueArray[i]['mail_address'];
		html += '</td>';
		html += '</tr>';
	}
	$("#user_data").append( html );
	
	//----------------
	// ユーザ一覧取得取得
	//----------------
	function getAllUserData() {

		var valueArray = new Array();
		
		$.ajax( {
			  dataType : 'json'
			, url      : '/user/get-all-user-data'
			, cache    : false
			, async    : false
			, type     : 'get'
			, success  : function( data ) {
				valueArray = data;
			}
		} );

		return valueArray;
	}

</script>

</body>
</html>
<?php }} ?>