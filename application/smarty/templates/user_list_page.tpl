<!DOCTYPE html>
<html lang="ja">
<head>
{include file="include/header.tpl"}
{include file="include/js_include.tpl"}
<style type="text/css">
	#user_data_update table　{
		width:100px;
	}
</style>
</head>
<body>
<div id="base">
	{include file="include/head.tpl"}
	<div id="wrap">
		<div id="contents">
			<div id="c_pad">
				<table id="user_data">
				</table>
			</div>
		</div>
		<!--contents end-->
		{include file="include/side_menu.tpl"}
	</div>
	{include file="include/footer.tpl"}
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
