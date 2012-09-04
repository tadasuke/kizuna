<?php /* Smarty version Smarty-3.1.8, created on 2012-08-31 17:26:51
         compiled from "/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/top_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12921179525040698326bcb2-71868062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '556a27b8645df06979c54d49a8048f8e74bb73c6' => 
    array (
      0 => '/upsystem/new_kizuna_dev/kizuna/application/smarty/templates/top_page.tpl',
      1 => 1346401608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12921179525040698326bcb2-71868062',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_504069833821f5_31854530',
  'variables' => 
  array (
    'theme_id' => 0,
    'talk_id' => 0,
    'user_key' => 0,
    'priority' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_504069833821f5_31854530')) {function content_504069833821f5_31854530($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ("include/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("include/js_include.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<div id="base">
	<?php echo $_smarty_tpl->getSubTemplate ("include/head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<p style="text-align:right; background-color:#000066;"><a href="/index/logout" style="color:#FFFFFF">退出する</a></p>
	<div id="wrap">
		<div id="contents">
			<div id="kizuna_pad">
				<table border="0">
					<tr>
						<td colspan="2">
							<form action="/talk/talk" method="post"  enctype="multipart/form-data">
								<select class="theme_select" id="theme" name="theme_id">
								</select>
								<textarea id="talk_text" name="talk" cols="90" rows="6" ></textarea><br/>
								<input type="checkbox" id="mail_check" name="mail_check" value="1" />お知らせメールを送信する<br/>
								<input type="file" name="talk_img" /><br/>
								<input type="submit" value="話す"/>
							</form>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="text-align:right;">
								<select class="theme_select" id="view_theme" name="theme_id">
									<option value="">全て</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table id="talk_data">
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button type="button" id="add_kizunow">もっと読む</button></td>
					</tr>
				</table>
			</div>
		</div>
		<!--contents end-->
		<?php echo $_smarty_tpl->getSubTemplate ("include/side_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div>
	<?php echo $_smarty_tpl->getSubTemplate ("include/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>

<script type="text/javascript">

	var viewThemeId = String( "<?php echo $_smarty_tpl->tpl_vars['theme_id']->value;?>
" );

	viewThemeId = (viewThemeId == '000') ? '' : viewThemeId;
	var themeArray  = new Array();
	var talkArray   = new Array();

	//----------
	// テーマ取得
	//----------
	function getTheme() {

		var themeId;
		var themeName;
		var templete;
		
		$.ajax( {
			  dataType : 'json'
			, url      : '/talk/get-theme'
			, cache    : false
			, async    : false
			, type     : 'get'
			, success  : function( data ) {
				themeArray = data;
			}
		} );

	}

	//----------
	// テーマ設定
	//----------
	function setTheme() {
		for ( var i = 0; i < themeArray.length; i++ ) {
			$(".theme_select").append( "<option value='" + themeArray[i]['theme_id'] + "'>" + themeArray[i]['theme_name'] + "</option>" );
		}

		// 初期表示設定
		if ( viewThemeId.length > 0 ) {
			$("#view_theme").val( viewThemeId );
		} else {
			;
		}
		
	}

	//----------------
	// トークデータ取得
	//----------------
	function getTalk( maxSeqId ) {

		var valueArray = new Array();
		
		$.ajax( {
			  dataType : 'json'
			, url      : '/talk/get-talk'
			, cache    : false
			, async    : false
			, type     : 'get'
			, data     : 'max_seq_id=' + maxSeqId + '&theme_id=' + viewThemeId + '&talk_id=<?php echo $_smarty_tpl->tpl_vars['talk_id']->value;?>
&user_key=<?php echo $_smarty_tpl->tpl_vars['user_key']->value;?>
&priority=<?php echo $_smarty_tpl->tpl_vars['priority']->value;?>
'
			, success  : function( data ) {
				valueArray = data;
			}
		} );

		return valueArray;
	}

	//----------------
	// トークデータ設定
	//----------------
	function setTalk( talkArray ) {

		var kizunowHtml = '';
		
		// トークデータ表示
		for ( var i = 0; i < talkArray.length; i++ ) {

			kizunowHtml += '<tr><td>';
			kizunowHtml += '<table>';
			kizunowHtml += '<tr>';
			kizunowHtml += '<td valign="top">';
			//kizunowHtml += '<a href="/user/view-profile?user_key=' + talkArray[i]['user_key'] + '">';
			kizunowHtml += '<a href="/top/index?user_key=' + talkArray[i]['user_key'] + '&priority=9">';
			kizunowHtml += '<img src="/img/get-profile-img?target_user_key=' + talkArray[i]['user_key'] + '" width="50px" />';
			kizunowHtml += '</a>';
			kizunowHtml += '</td>';
			kizunowHtml += '<td>';

			// ヘッダ部分
			kizunowHtml += '<span style="font-weight:bold"><a href="/user/view-profile?user_key=' + talkArray[i]['user_key'] + '">' + talkArray[i]['name'] + '</a></span>';
			kizunowHtml += '&nbsp;→&nbsp;';
			kizunowHtml += '<span style="font-weight:bold">' + getThemeNameByTthemeId( talkArray[i]['theme_id'] ) + '</span>';
			kizunowHtml += '&nbsp;&nbsp;&nbsp;&nbsp;';
			kizunowHtml += '<span>' + talkArray[i]['talk_date'] + '</span>';
			kizunowHtml += '<br/>';

			// 画像部分
			kizunowHtml += '<span>';
			if ( talkArray[i]['img_seq_id'] != '' ) {
				kizunowHtml += '<a href="/img/get-img?img_seq_id=' + talkArray[i]['img_seq_id'] + '" target="_blank">';
				kizunowHtml += '<img src="/img/get-img?img_seq_id=' + talkArray[i]['img_seq_id'] + '" width="200px" /></a>';
			} else {
				;
			}
			kizunowHtml += '</span>';

			// トーク部分
			kizunowHtml += '<p>';
			talk = talkArray[i]['talk'];
			//talk = talk.replace(/(http:\/\/[\x21-\x7e]+)/gi, "<a href='$1' target='_blank'>$1</a>");
			talk = talk.replace(/((http|https):\/\/[\x21-\x7e][^\x3c]+)/gi, "<a href='$1' target='_blank'>$1</a>");
			// リンク設定
			
			kizunowHtml += talk;
			kizunowHtml += '</p>';
			
			// 自分のトークの場合は削除ボタン表示
			if ( talkArray[i]['my_talk_flg'] == '1' ) {
				kizunowHtml += '<div style="text-align:right"><span class="talk_delete" id="talk_delete_' + talkArray[i]['seq_id'] + '">削除する</span></div><br/>';
			} else {
				;
			}

			// コメント部分
			kizunowHtml += '<div style="background-color:#F5F5F5">';
			kizunowHtml += '<span style="font-weight:bold">コメント</span>';

			// コメント表示部分
			kizunowHtml += '<table id="view_comment_table_"' + talkArray[i]['seq_id'] + '>';
			for ( var j = 0; j < talkArray[i]['comment_array'].length; j++ ) {
				kizunowHtml += '<tr>';
				kizunowHtml += '<td>';
				kizunowHtml += '<img src="/img/get-profile-img?target_user_key=' + talkArray[i]['comment_array'][j]['user_key'] + '" width="25px" />';
				kizunowHtml += '</td>';
				kizunowHtml += '<td>';
				kizunowHtml += '<p>';
				kizunowHtml += '<span style="font-weight:bold">' + talkArray[i]['comment_array'][j]['user_name'] + '</span>';
				kizunowHtml += '<br/>';
				//kizunowHtml += '&nbsp;&nbsp;';
				//kizunowHtml += '<span>' + talkArray[i]['comment_array'][j]['comment_date'] + '</span>';
				//kizunowHtml += '<br/>';
				kizunowHtml += '<span>' + talkArray[i]['comment_array'][j]['comment'] + '</span>';
				kizunowHtml += '</p>';
				kizunowHtml += '</td>';
				kizunowHtml += '</tr>';
			}
			kizunowHtml += '</table>';

			// コメント書き込み部分
			kizunowHtml += '<table>';
			kizunowHtml += '<tr>';
			kizunowHtml += '<td>';
			kizunowHtml += '<textarea class="comment" id="comment_' + talkArray[i]['seq_id'] + '" rows="1" cols="80"></textarea>';
			kizunowHtml += '</td>';
			kizunowHtml += '</tr>';
			kizunowHtml += '<tr>';
			kizunowHtml += '<td>';
			kizunowHtml += '<button type="button" class="comment_button" id="comment_button_' + talkArray[i]['seq_id'] + '">' + 'コメントする</button>';
			kizunowHtml += '</td>';
			kizunowHtml += '</tr>';
			kizunowHtml += '</table>';

			kizunowHtml += '</div>';

			kizunowHtml += '<br/>';
			kizunowHtml += '<hr/>';
			
			kizunowHtml += '</td>';
			kizunowHtml += '</tr>';
			kizunowHtml += '</table>';
			kizunowHtml += '</td></tr>';
			
		}

		$("#talk_data").append( kizunowHtml );

	}


	//　トークデータ削除
	function deleteTalk( seqId ) {

		var response = new Array();
		
		$.ajax( {
			  dataType : 'json'
			, url      : '/talk/delete-talk'
			, cache    : false
			, async    : false
			, type     : 'get'
			, data     : 'seq_id=' + seqId
			, success  : function( data ) {
				response = data;
			}
		} );

		var result = response['result'];

		return result;
	}


	// コメント書き込み
	function writeComment( talkSeqId, comment ) {

		var response = new Array();
		
		$.ajax( {
			  dataType : 'json'
			, url      : '/talk/comment'
			, cache    : false
			, async    : false
			, type     : 'post'
			, data     : 'talk_seq_id=' + talkSeqId + '&comment=' + comment
			, success  : function( data ) {
				;
			}
		} );

	}


	// テーマIDを元にテーマ名を取得
	function getThemeNameByTthemeId( themeId ) {

		var themeName = '';

		for ( var i = 0; i < themeArray.length; i++ ) {
			if ( themeArray[i]['theme_id'] == themeId ) {
				themeName = themeArray[i]['theme_name'];
				break;
			} else {
				;
			}
		}

		return themeName;
	}


	//-------------------------------------- イベント -----------------------------------------

	//---------
	// 初期動作
	//---------
	// テーマ取得
	getTheme();

	// テーマ設定
	setTheme();

	// トークデータ取得
	talkArray = getTalk( '' );

	// トークデータ表示
	setTalk( talkArray );

	//-----------------------
	// テーマセレクトボックス変更
	//-----------------------
	$("#theme").change( function() {
		var themeId = $("#theme").val();
		var templete = '';
		var defaultMailFlg = '0';

		// テーマ配列からテンプレートを取得
		for ( var i = 0; i < themeArray.length; i++ ) {
			if ( themeId == themeArray[i]['theme_id'] ) {
				templete = themeArray[i]['templete'];
				defaultMailFlg = themeArray[i]['default_mail_flg'];
				break;
			} else {
				;
			}
		}

		// テンプレートをテキストエリアに記述
		$("#talk_text").val( templete );
		$("#talk_text").trigger( 'change' );

		// メール送信チェックボックスデフォルト値設定
		if ( defaultMailFlg == '1' ) {
			$("#mail_check").attr( 'checked', true );
		} else {
			$("#mail_check").attr( 'checked', false );
		}
		
	});

	//--------------------------
	// 表示テーマセレクトボックス変更
	//--------------------------
	$("#view_theme").change( function() {

		viewThemeId = $("#view_theme").val();

		document.location = "/top/index?theme_id=" + viewThemeId;

	});


	//---------------------
	// もっと読むボタンクリック
	//---------------------
	$("#add_kizunow").click( function() {
		maxSeqId = talkArray[talkArray.length - 1]['seq_id'] - 1;

		// きずなうデータ取得
		var newTalkArray = getTalk( maxSeqId );

		// きずなうデータ表示
		setTalk( newTalkArray );

		talkArray = talkArray.concat( newTalkArray );
		
	});


	//---------------
	// 削除するクリック
	//---------------
	$(".talk_delete").click( function() {

		var header = 'talk_delete_';
		var seqId = $(this).attr( "id" );

		seqId = seqId.slice( header.length );

		// 削除実行
		var result = deleteTalk( seqId );

		// 削除に成功した場合
		if ( result == '0' ) {

			// トーク配列から該当のデータを削除
			var newTalkArray = new Array();
			for ( var i = 0; i < talkArray.length; i++ ) {
				if ( seqId != talkArray[i]['seq_id'] ) {
					newTalkArray.push( talkArray[i] );
				} else {
					;
				}
			}

			talkArray = newTalkArray;

			// トークデータ最表示
			$("#talk_data").empty();
			setTalk( talkArray );
			
		} else {
			;
		}
		

	});


	//---------------
	// コメント書き込み
	//---------------
	$(".comment_button").click( function() {

		var header = 'comment_button_';
		var commnetTextareaHeader = 'comment_';
		var commentViewTableHeader = 'view_comment_table_';
		var talkSeqId = $(this).attr( "id" );

		// コメント対象のトークシーケンスIDを抽出
		talkSeqId = talkSeqId.slice( header.length );

		// コメントを抽出
		var comment = $("#" + commnetTextareaHeader + talkSeqId).val();

		// コメント書き込み
		writeComment( talkSeqId, comment );

		// ページをリロード
		location.reload( true );
		
	});
	
	
	$(function() {
		//$('#talk_text').autoResize({
		$("textarea").autoResize({
			// On resize:
			onResize : function() {
				//$(this).css( "opacity", "0.8" );
			}
		});

		$('textarea#comment').trigger('change'); // 初期表示時に自動リサイズさせるためchangeイベント実行
	});

</script>

</body>
</html>
<?php }} ?>