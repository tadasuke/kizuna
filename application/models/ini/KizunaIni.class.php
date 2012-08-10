<?php

class KizunaIni {
	
	public static $config = array();
	
	//------------
	// 本番環境設定
	//------------
	private static $honbanConfigArray = array(
		//------------------
		// データベース接続設定
		//------------------
		'new_kizunadb' => array(
			  'user'        => 'kizuna'
			, 'password'    => 'g4fsz3zEHLdE'
			, 'dsn'         => 'mysql:dbname=new_kizunadb;host=localhost'
		)
		, 'new_kizunadb_dev' => array(
			  'user'        => 'kizuna'
			, 'password'    => 'g4fsz3zEHLdE'
			, 'dsn'         => 'mysql:dbname=new_kizunadb_dev;host=localhost'
		)
			
		//------------
		// テーブル設定
		//------------
		, 'table_type' => array(
			  'user_basic_data'    => 'new_kizunadb'
			, 'user_personal_data' => 'new_kizunadb'
			, 'img_data'           => 'new_kizunadb'
			, 'talk_data'          => 'new_kizunadb'
			, 'comment_data'       => 'new_kizunadb'
			, 'theme_master'       => 'new_kizunadb'
			, 'send_mail_data'     => 'new_kizunadb'
			, 'login_history'      => 'new_kizunadb'
		)
		//--------
		// システム
		//--------
		, 'system' => array(
			  'log_file_dir'        => '/var/log/new_kizuna/debug/'
			, 'batch_log_file_dir'  => '/var/log/new_kizuna/batch/'
			, 'out_log_level'       => 7
			// ログインクッキーキー名
			, 'login_cookie_key_name' => 'new_kizuna_key'
			// ログインクッキー保持期間
			, 'login_cookie_keep_time' => 604800 // 一週間
			// プロフィール未設定時表示データパス
			, 'non_profile_img' => '/upsystem/new_kizuna/html/img/no-image-man.jpg'
			// 新規登録時パスワード生成シークレットキー
			, 'new_entry_secret_key' => 'king_of_tadasuke'
			// ベースURL
			, 'base_url' => 'http://ki2na.jp'
			// メール送信元アドレス
			, 'from_mail_address' => 'information@ki2na.jp'
			// デフォルト表示優先度
			, 'default_priority' => 8
		)
	);
	
	//------------
	// 開発環境設定
	//------------
	private static $developConfigArray = array(
		
		//------------
		// テーブル設定
		//------------
		'table_type' => array(
				  'user_basic_data'    => 'new_kizunadb_dev'
				, 'user_personal_data' => 'new_kizunadb_dev'
				, 'img_data'           => 'new_kizunadb_dev'
				, 'talk_data'          => 'new_kizunadb_dev'
				, 'comment_data'       => 'new_kizunadb_dev'
				, 'theme_master'       => 'new_kizunadb_dev'
				, 'send_mail_data'     => 'new_kizunadb_dev'
				, 'login_history'      => 'new_kizunadb_dev'
		)
		//--------
		// システム
		//--------
		, 'system' => array(
				  'log_file_dir'        => '/var/log/new_kizuna_dev/debug/'
				, 'batch_log_file_dir'  => '/var/log/new_kizuna_dev/batch/'
				, 'out_log_level'       => 7
				// ログインクッキーキー名
				, 'login_cookie_key_name' => 'new_kizuna_dev_key'
				// ログインクッキー保持期間
				, 'login_cookie_keep_time' => 604800 // 一週間
				// プロフィール未設定時表示データパス
				, 'non_profile_img' => '/upsystem/new_kizuna/html/img/no-image-man.jpg'
				// 新規登録時パスワード生成シークレットキー
				, 'new_entry_secret_key' => 'king_of_tadasuke'
				// ベースURL
				, 'base_url' => 'http://dev.ki2na.jp'
				// メール送信元アドレス
				, 'from_mail_address' => 'information_dev@ki2na.jp'
		)
			
	);
	
	
	public static function setConfig( $serverType = 'HONBAN' ) {
		
		self::$config = self::$honbanConfigArray;
		
		// サーバタイプが開発の場合は設定を書き換え
		if ( strcmp( $serverType, 'DEVELOP' ) == 0 ) {
			foreach ( self::$developConfigArray as $section => $data ) {
				foreach ( $data as $key => $value ) {
					self::$config[$section][$key] = $value;
				}
			}
		} else {
			;
		}
	}
}
