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
				<div id="user_data_update">
					<table>
						<tr>
							<th>プロフィール写真</th>
							<td>
								<img src="/img/get-profile-img" width="200px" />
								<br/>
								<form action="/img/update-profile-img" method="post" enctype="multipart/form-data">
									<input type="file" name="profile_img" />
									<br/>
									<input type="submit" value="変更する" />
								</form>
							</td>
						</tr>
						<form action="/user/update-personal-data" method="get" >
							<tr>
								<th>名前</th>
								<td>
									<input type="text" id="name" name="name" />
								</td>
							</tr>
							<tr>
								<th>性別</th>
								<td>
									<input type="radio" class="gender" name="gender" value="1" />男&nbsp;
									<input type="radio" class="gender" name="gender" value="2" />女&nbsp;
									<input type="radio" class="gender" name="gender" value="0" />未公表
								</td>
							</tr>
							<tr>
								<th>生年月日</th>
								<td>
									<select id="year" name="year"></select>年<select id="month" name="month"></select>月<select id="day" name="day"></select>日
								</td>
							</tr>
							<tr>
								<th>住所</th>
								<td>
									<input type="text" id="address" name="address" />
								</td>
							</tr>
							<tr>
								<th>電話番号その１</th>
								<td>
									<input type="tel" id="telephone_number_1" name="telephone_number_1" />
								</td>
							</tr>
							<tr>
								<th>電話番号その２</th>
								<td>
									<input type="tel" id="telephone_number_2" name="telephone_number_2" />
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" value="登録" /></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<!--contents end-->
		{include file="include/side_menu.tpl"}
	</div>
	{include file="include/footer.tpl"}
	
</div>
<script type="text/javascript">

	var profileData = new Array();

	//----------
	// 初期ロード
	//----------
	// 年セレクトボックス作成
	makeYearSelect();

	// 月セレクトボックス作成
	makeMonthSelect();

	// 日セレクトボックス作成
	makeDaySelect();

	// プロフィールデータ設定
	setProfileData();
	
	
	//------------------------------ funciton ---------------------------------
	
	// 年セレクトボックス作成
	function makeYearSelect() {

		var value = '';
		for ( var year = 1970; year <= 2000; year++ ) {
			value = "<option value='" + year + "'>" + year + "</option>";
			$("#year").append( value );
		}

	}

	// 月セレクトボックス作成
	function makeMonthSelect() {

		var value = '';
		for ( var month = 1; month <= 12; month++ ) {
			value = "<option value='" + month + "'>" + month + "</option>";
			$("#month").append( value );
		}

	}

	// 日セレクトボックス作成
	function makeDaySelect() {

		var value = '';
		for ( var day = 1; day <= 31; day++ ) {
			value = "<option value='" + day + "'>" + day + "</option>";
			$("#day").append( value );
		}

	}

	// プロフィールデータ設定
	function setProfileData() {

		// プロフィールデータ取得
		getProfileData();

		// 名前
		$("#name").val( profileData['name'] );

		// 性別
		$(".gender").val( [profileData['gender']] );

		// 生年月日
		if ( profileData['birthdayYear'].length > 0 ) {
			$("#year").val( profileData['birthdayYear'] );
			$("#month").val( profileData['birthdayMonth'] );
			$("#day").val( profileData['birthdayDay'] );
		} else {
			;
		}
		
		// 住所
		$("#address").val( profileData['address'] );

		// 電話番号1
		$("#telephone_number_1").val( profileData['telephoneNumber1'] );

		// 電話番号1
		$("#telephone_number_2").val( profileData['telephoneNumber2'] );
		
	}



	// プロフィールデータ取得
	function getProfileData() {

		$.ajax( {
			  dataType : 'json'
			, url      : '/user/get-profile-data'
			, cache    : false
			, async    : false
			, type     : 'get'
			, success  : function( data ) {
				profileData = data;
			}
		} );

	}

	
	
</script>
</body>
</html>
