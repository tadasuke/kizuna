<?php

require_once 'Zend/Controller/Action.php';

require_once 'models/User.class.php';

/**
 * 共通アクション
 * @author tadasuke
 */
class CommonAction extends Zend_Controller_Action{
	
	protected $method = 'GET';
	protected function setMethod( $method ) {
		$this -> method = $method;
	}
	protected $paramArray = array(); // パラメータ配列
	
	/**
	 * @var Smarty
	 */
	protected $_smarty;
	
	/**
	 * @var int $userId
	 */
	protected $userId = NULL;
	
	/**
	 * @var string $userKey
	 */
	protected $userKey = NULL;
	
	/**
	 * @var User $userClass
	 */
	protected $userClass = NULL;
	
	// 初期化
	public function init() {
		$this -> _helper -> viewRenderer -> setNoRender();
	}
	
	// 前処理
	public function preDispatch() {
		
		// 設定ファイルを設定
		KizunaIni::setConfig( Zend_Registry::get( 'SERVER_TYPE' ) );
		
		// プロセスIDを設定
		$processId = microtime( TRUE );
		Zend_Registry::set( 'PROCESS_ID', $processId );
		
		// パラメータ取得
		$request = $this -> getRequest();
		/*
		// GETの場合
		if ( strcasecmp( $this -> method, 'GET' ) == 0 ) {
			foreach ( $request -> getQuery() as $key => $value ) {
				OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, $key . '=>' . $value );
				$this -> paramArray[$key] = $value;
			}
		// POSTの場合
		} else {
			foreach ( $request -> getPost() as $key => $value ) {
				OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, $key . '=>' . $value );
				$this -> paramArray[$key] = $value;
			}
		}
		*/
		foreach ( $request -> getQuery() as $key => $value ) {
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, $key . '=>' . $value );
			$this -> paramArray[$key] = $value;
		}
		foreach ( $request -> getPost() as $key => $value ) {
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, $key . '=>' . $value );
			$this -> paramArray[$key] = $value;
		}
		
		// Smartyオブジェクトの作成
		$this -> _smarty = new Smarty();
		// テンプレートディレクトリ設定
		$this -> _smarty -> template_dir = APP . '/smarty/templates/';
		$this -> _smarty -> compile_dir  = APP . '/smarty/templates_c/';

		// クッキーを元にユーザデータを設定
		$this -> setUserClassByCookie();
		
	}
	
	// 後処理
	public function postDispatch() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//----------
		// DBコミット
		//----------
		DaoFactory::allCommit();
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	//----------------------------------------------- protected -----------------------------------------------
	
	/**
	 * リダイレクト
	 * @param string $path
	 * @param boolean $dbCommitFlg
	 */
	protected function redirect( $path, $dbCommitFlg = TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'path:'        . $path );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'dbCommitFlg:' . $dbCommitFlg );
		
		//----------
		// DBコミット
		//----------
		if ( $dbCommitFlg === TRUE ) {
			DaoFactory::allCommit();
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		$this -> _redirect( $path );
		
	}
	
	
	//----------------------------------------------- private --------------------------------------------------
	
	/**
	 * クッキーからユーザキーを取得し、ユーザクラスを設定する
	 */
	private function setUserClassByCookie() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//-------------------------
		// クッキーからユーザキーを取得
		//-------------------------
		$loginCookieName = Config::getConfig( 'system', 'login_cookie_key_name' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'loginCookieName:' . $loginCookieName );
		$userKey = (isset( $_COOKIE[$loginCookieName] ) === TRUE) ? $_COOKIE[$loginCookieName] : '';
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		// ユーザキーをレジストリにも登録
		Zend_Registry::set( 'USER_KEY', $userKey );
		
		// ユーザキーが取得できなかった場合は何もしない
		if ( strlen( $userKey ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_user_key' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return;
		} else {
			;
		}
		
		$this -> userKey = $userKey;
		
		//-----------------------------
		// ユーザキーを元にユーザIDを取得する
		//-----------------------------
		$userId = User::getUserIdByUserKey( $this -> userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		$this -> userId = $userId;
		
		// ユーザIDが取得できた場合
		if ( strlen( $this -> userId ) > 0 ) {
			//-----------------
			// ユーザクラスを設定
			//-----------------
			$userClass = UserFactory::get( $userId );
			$this -> userClass = $userClass;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	
}