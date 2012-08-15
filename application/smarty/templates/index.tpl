<!DOCTYPE html>
<html lang="ja">
<head> 
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
	<meta http-equiv="Content-language" content="ja" /> 
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<link rel="alternate" media="handheld" href="http://ja-jp.facebook.com/" /> 
	<title>KIZUNA - 絆 - ログイン (日本語) </title>
	<link type="text/css" rel="stylesheet" href="http://static.ak.fbcdn.net/rsrc.php/v1/y8/r/Ep4pAfkFIHF.css" /> 
	<link type="text/css" rel="stylesheet" href="http://static.ak.fbcdn.net/rsrc.php/v1/yZ/r/lc1kiePPG9e.css" /> 
	<link type="text/css" rel="stylesheet" href="http://static.ak.fbcdn.net/rsrc.php/v1/y3/r/lwfGyzKzOXO.css" /> 
	<link type="text/css" rel="stylesheet" href="http://static.ak.fbcdn.net/rsrc.php/v1/yQ/r/9qdm_pQmTM3.css" /> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="UTF-8"></script>
	<script src="/js/droparea.js" type="text/javascript" charset="UTF-8"></script>
	<script src="/js/lib/autoresize.jquery.js" type="text/javascript" charset="UTF-8"></script>
</head>
<body class="fbIndex safari4 Locale_ja_JP">
	<div id="globalContainer">
		<div class="loggedout_menubar_container">
			<div class="clearfix loggedout_menubar">
				<img src="/img/kizuna-top.png" width="100" />
				<div class="rfloat">
					<div class="menu_login_container">
						<form name="form" action="/index/login" method="get" onsubmit="return loginCheck()">
							<table cellspacing="0">
								<tr>
									<td class="html7magic">
										<label for="email">メールアドレス</label>
									</td>
									<td class="html7magic">
										<label for="pass">パスワード</label>
									</td>
								</tr>
								<tr>
									<td>
										<input type="email" class="inputtext" name="mail_address" id="ID" tabindex="1" />
									</td>
									<td>
										<input type="password" class="inputtext" name="password" id="PASSWORD" tabindex="2" />
									</td>
									<td>
										<label class="uiButton uiButtonConfirm" for="u170386_3">
											<input type="hidden" name="path" value="{$path}" />
											<input value="ログイン" tabindex="4" type="submit" id="u170386_3" />
										</label>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="dropmenu_container"></div>
		<div id="content" class="fb_content clearfix">
			<div>
				<div class="uiWashLayout">
					<div class="uiWashLayoutGradientWash">
						<div class="uiWashLayoutWashContent">
							<div class="contentContainer">
								<div class="clearfix fbIndexFeaturedRegistration">
									<div class="feature lfloat">
										<div class="plm fbIndexMap">
											<div class="plm title fsl fwb fcb">kizunaを使うと、友達や同僚、同級生、仲間たちとつながりを深められる可能性が少しだけアップします。スマートフォンからもアクセスできます。</div>
											<div class="mtl map"></div>
										</div>
									</div>
									<div class="signupForm rfloat">
										<div class="mbm phm headerTextContainer">
											<div class="mbs mainTitle fsl fwb fcb">アカウント登録</div>
												<div class="mbm subtitle fsm fwn fcg">情報の公開範囲は設定できずに刺激的です。</div>
											</div>
											<div id="registration_container">
												<div>
													<div id="simple_registration_container" class="simple_registration_container">
														<div id="reg_box">
															<!-- <form name="form" id="entry_form" action="/index/new-entry" method="get" > -->
															<form name="form" id="entry_form" action="/index/pre-entry" method="get" >
																<div id="reg_form_box" class="large_form">
																	<table class="uiGrid editor" cellspacing="0" cellpadding="1">
																		<tbody>
																			<tr>
																				<td colspan="2" style="color:#FF0000" id="entry_failure_message"></td>
																			</tr>
																			<tr>
																				<td class="label">
																					<label for="name">名前(全角・本名):</label>
																				</td>
																				<td>
																					<div class="field_container">
																						<input type="text" class="inputtext" id="name" name="entry_name" />
																					</div>
																				</td>
																			</tr>
																			<tr>
																				<td class="label">
																					<label for="id">メールアドレス:</label>
																				</td>
																				<td>
																					<div class="field_container">
																						<input type="email" class="inputtext" id="mail_address" name="entry_mail_address" maxlength="32" vlaue="" />
																					</div>
																				</td>
																			</tr>
																			<tr>
																				<td class="label">
																					<label for="reg_passwd__">パスワード(半角):</label>
																				</td>
																				<td>
																					<div class="field_container">
																						<input type="password" class="inputtext" id="passwd" name="entry_password" maxlength="32" value="" />
																					</div>
																				</td>
																			</tr>
																			<tr>
																				<td class="label">
																					<label for="reg_passwd__">パスワード(再):</label>
																				</td>
																				<td>
																					<div class="field_container">
																						<input type="password" class="inputtext" id="passwd_2" name="entry_password_2" maxlength="32" value="" />
																					</div>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	<div class="reg_btn clearfix">
																		<label class="uiButton uiButtonSpecial" for="u170385_1">
																			<input value="アカウント登録" type="submit" id="u170385_1" />
																		</label>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="pageFooter">
				<div class="clearfix" id="footerContainer">
					<div class="lfloat">
						<div class="fsm fwn fcg">
							<span title="HPHP - 65 - BEbm4xll47rH8TzYix1z1w - 867672"> 絆プロジェクト © 2011</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		
<script type="text/javascript">

	//-------------------
	// 新規登録ボタンクリック
	//-------------------
	$("#entry_form").submit( function() {

		console.log( "submit" );

		// パスワードチェック
		if ( $("#passwd").val() != $("#passwd_2").val() ) {

			$("#entry_failure_message").html( "パスワードが不一致です。" );
			$("#passwd").val( '' );
			$("#passwd_2").val( '' );
			return false;
		} else {
			;
		}

		return true;

	});

</script>
		
		
	</body>
</html>
