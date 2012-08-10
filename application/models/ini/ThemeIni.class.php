<?php

class ThemeIni {
	
	const TEMPLETE_01 = <<< EOD
20◯◯年◯月度　Webシステム部業務報告

【業務内容】


【合計稼働時間】
時間

【今月身に付けたスキル(技術、ヒューマンスキルどちらも含む)】


【ぶつかった問題点、解決方法、それによって学んだ事】


【今後の課題】


【その他、気になった点等】


EOD;
	
	public static $hoge = 'hoge';
	
	public static $themeArray = array(

		array(
			  'theme_id'         => '001'
			, 'theme_name'       => '近況'
			, 'templete'         => ''
			, 'default_mail_flg' => '0'
			, 'priority'         => 2
		)
		, array(
			  'theme_id'         => '002'
			, 'theme_name'       => 'お仕事開始'
			, 'templete'         => 'お仕事開始'
			, 'default_mail_flg' => '0'
			, 'priority'         => 9
		)
		, array(
			  'theme_id'         => '003'
			,  'theme_name'      => 'お仕事終了'
			, 'templete'         => 'お仕事終了'
			, 'default_mail_flg' => '0'
			, 'priority'         => 9
		)
		, array(
			  'theme_id'         => '004'
			,  'theme_name'      => '技術ブログ'
			, 'templete'         => ''
			, 'default_mail_flg' => '0'
			, 'priority'         => 2
		)
		, array(
			  'theme_id'         => '501'
			, 'theme_name'       => '金融システム部業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '502'
			, 'theme_name'       => '業務システム部業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '503'
			, 'theme_name'       => '制御システム部業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '504'
			, 'theme_name'       => '基盤ソリューション部業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '505'
			, 'theme_name'       => 'ビジネスソリューション部業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '506'
			, 'theme_name'       => 'Webシステム部業務報告書'
			, 'templete'         => self::TEMPLETE_01
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '507'
			, 'theme_name'       => '研修報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '508'
			, 'theme_name'       => '業務制御システム業務報告書'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '901'
			, 'theme_name'       => 'U.P業務連絡'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '902'
			, 'theme_name'       => 'アンケート'
			, 'templete'         => ''
			, 'default_mail_flg' => '1'
			, 'priority'         => 1
		)
		, array(
			  'theme_id'         => '999'
			, 'theme_name'       => 'ご意見・ご要望'
			, 'templete'         => ''
			, 'default_mail_flg' => '0'
			, 'priority'         => 2
		)
	);
	
	
	/**
	 * テーマ配列取得
	 * @param string $themeId
	 * @return array
	 */
	public static function getThemeArrayByThemeId( $themeId ) {
		
		$themeArray = NULL;
		foreach ( self::$themeArray as $data ) {
			if ( strcmp( $data['theme_id'], $themeId ) == 0 ) {
				$themeArray = $data;
				break;
			} else {
				;
			}
		}
		
		return $themeArray;
	}
	
}