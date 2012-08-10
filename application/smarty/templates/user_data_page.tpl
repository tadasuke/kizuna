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
								<img src="/img/get-profile-img?target_user_key={$personal_data.user_key}" width="200px" />
							</td>
						</tr>
						<tr>
							<th>名前</th>
							<td>
								<span>{$personal_data.name}</span>
							</td>
						</tr>
						<tr>
							<th>性別</th>
							<td>
								<span id="gender"></span>
							</td>
						</tr>
						<tr>
							<th>生年月日</th>
							<td>
								<span>{$personal_data.year}年{$personal_data.month}月{$personal_data.day}日</span>
							</td>
						</tr>
						<tr>
							<th>住所</th>
							<td>
								<span>{$personal_data.address}</span>
							</td>
						</tr>
						<tr>
							<th>電話番号その１</th>
							<td>
								<span>{$personal_data.telephone_number_1}</span>
							</td>
						</tr>
						<tr>
							<th>電話番号その２</th>
							<td>
								<span>{$personal_data.telephone_number_2}</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<!--contents end-->
		{include file="include/side_menu.tpl"}
	</div>
	{include file="include/footer.tpl"}
</div>

<script type="text/javascript">
	if ( "{$personal_data.gender}" == "1" ) {
		$("#gender").html( "男" );
	} else if ( "{$personal_data.gender}" == "2" ) {
		$("#gender").html( "女" );
	}
</script>

</body>
</html>
