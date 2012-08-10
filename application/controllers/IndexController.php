<?php

require_once 'models/Mail.class.php';

class IndexController extends CommonAction{
	
	/**
	 * トップページ表示
	 */
	public function indexAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//----------------------------------------------------
		// ユーザクラスが設定されている場合はログイン後ページにリダイレクト
		//----------------------------------------------------
		if ( is_null( $this -> userClass ) === FALSE ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'exists_user_data' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			$this -> _redirect( '/top/index' );
			return;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		$this -> _smarty -> display( 'index.tpl' );
		
	}
	
	/**
	 * ログイン
	 */
	public function loginAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$mailAddress = $this -> paramArray['mail_address'];
		$password    = $this -> paramArray['password'];
		
		//--------------
		// ユーザIDを取得
		//--------------
		$userId = User::getUserIdByMailAddress( $mailAddress, $password );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		//---------------------------------------
		// ユーザIDが取得できなかった場合はログインエラー
		//---------------------------------------
		if ( is_null( $userId ) === TRUE ) {
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'login_error' );
			echo( '残念でちた' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return;
		} else {
			;
		}
		
		//---------------
		// ユーザクラス作成
		//---------------
		$userClass = UserFactory::get( $userId );
		
		//-----------------------
		// ユーザキーをクッキーに登録
		//-----------------------
		$userKey = $userClass -> getUserKey();
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		setcookie( Config::getConfig( 'system', 'login_cookie_key_name' ), $userKey, time() + Config::getConfig( 'system', 'login_cookie_keep_time'), '/' );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		$this -> redirect( '/top/index' );
		
	}
	
	
	
	/**
	 * ログアウト
	 */
	public function logoutAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		setcookie( Config::getConfig( 'system', 'login_cookie_key_name' ), '', time() - 10, '/' );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		$this -> redirect( '/top/index' );
		
	}
	
	
	/**
	 * 仮登録
	 */
	public function preEntryAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$mailAddress = $this -> paramArray['entry_mail_address'];
		$password    = $this -> paramArray['entry_password'];
		$name        = $this -> paramArray['entry_name'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:'    . $password );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'        . $name );
		
		// メールアドレス存在チェック
		$result = User::checkMailAddress( $mailAddress );
		
		// メールアドレスがすでに存在した場合
		if ( $result === TRUE ) {
			echo( "すでに存在するメールアドレスです" );
			return;
		} else {
			;
		}
		
		// 新規登録処理
		$userKey = User::newEntry( $mailAddress, $password, $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		// 登録キー作成
		$entryKey = $this -> createEntryKey( $userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'entryKey:' . $entryKey );
		
		// 本登録URL作成
		$entryUrl = 'http://ki2na.jp/index/new-entry?user_key=' . $userKey . '&entry_key=' . $entryKey . '&pass=' . $password;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'entryUrl:' . $entryUrl );
		
		// メール送信
		$mailTitle = 'KIZUNAからのお知らせ';
		$mailMessage = '';
		$mailMessage .= 'KIZUNAに仮登録されました。' . PHP_EOL;
		$mailMessage .= '以下のURLからアクセスして、本登録して下さい。' . PHP_EOL;
		$mailMessage .= $entryUrl;
		
		Mail::sendSimpleMail( $mailAddress, $mailTitle, $mailMessage );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		echo( 'メールを送信したんで、見てみて。' );
		
	}
	
	/**
	 * 新規登録
	 */
	public function newEntryAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$userKey  = $this -> paramArray['user_key'];
		$entryKey = $this -> paramArray['entry_key'];
		$password = $this -> paramArray['pass'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:'  . $userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'entryKey:' . $entryKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:' . $password );
		
		// エントリーキーをチェック
		$checkEntryKey = $this -> createEntryKey( $userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'checkEntryKey:' . $checkEntryKey );
		
		if ( strcmp( $entryKey, $checkEntryKey ) != 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'entry_key_error!!' );
			echo( "認証エラー" );
			exit;
		} else {
			;
		}
		
		$result = User::trueEntry( $userKey );
		
		// 本登録処理に失敗した場合
		if ( $result === FALSE ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'true_entry_failure' );
			echo( '残念でちた' );
			return ;
		} else {
			;
		}
		
		// ユーザID取得
		$userId = User::getUserIdByUserKey( $userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		//----------
		// メール送信
		//----------
		$userClass = UserFactory::get( $userId );
		$mailAddress = $userClass -> getMailAddress();
		$userName    = $userClass -> getName();
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userName:'    . $userName );
		
		$mailTitle = 'KIZUNAからのお知らせ';
		$mailMessage = '';
		$mailMessage .= $userName . 'さん！！' . PHP_EOL;
		$mailMessage .= 'KIZUNAに正常に登録されました。' . PHP_EOL;
		$mailMessage .= '登録した際のパスワード:' . $password . PHP_EOL;
		$mailMessage .= 'どうぞKIZUNAをお楽しみ下さい。' . PHP_EOL;
		$mailMessage .= 'http://develop.up-system.jp';
		
		Mail::sendSimpleMail( $mailAddress, $mailTitle, $mailMessage );
		
		//-----------------------
		// ユーザキーをクッキーに登録
		//-----------------------
		setcookie( Config::getConfig( 'system', 'login_cookie_key_name' ), $userKey, time() + Config::getConfig( 'system', 'login_cookie_keep_time'), '/' );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		$this -> redirect( '/top/index' );
		
	}
	
	
	
	//---------------------------------- private -------------------------------
	
	/**
	 * 登録キー作成
	 * @param string $userKey
	 * @return string $entryKey
	 */
	private function createEntryKey( $userKey ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		$newEntrySecretKey = Config::getConfig( 'system', 'new_entry_secret_key' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'newEntrySecretKey:' . $newEntrySecretKey );
		
		$entryKey = sha1( $userKey . $newEntrySecretKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'entryKey:' . $entryKey );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		return $entryKey;
		
	}
	
	
	
}