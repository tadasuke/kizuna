<?php

/**
 * データベース接続クラス
 * @author TADASUKE
 */
class Dao {
	
	/**
	 * コネクション
	 * @var PDO
	 */
	private $connection = null;
	
	/**
	 * トランザクションフラグ
	 * @var boolean
	 */
	private $transactionFlg = FALSE;
	
	/**
	 * DB接続文字列
	 * @var string
	 */
	private $dsn = null;
	
	/**
	 * ユーザ名
	 * @var string
	 */
	private $user = null;
	
	/**
	 * パスワード
	 * @var string
	 */
	private $password = null;
	
	
	/**
	 * コンストラクタ
	 * @param string $tableType
	 */
	public function __construct( $tableType ) {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'table_type:' . $tableType );
		
		// 接続情報設定
		$this -> dsn      = Config::getConfig( $tableType, 'dsn' );
		$this -> user     = Config::getConfig( $tableType, 'user' );
		$this -> password = Config::getConfig( $tableType, 'password' );
		OutputLog::outLog( OutputLog::DEBUG , __METHOD__, __LINE__, 'dsn:'      . $this -> dsn );
		OutputLog::outLog( OutputLog::DEBUG , __METHOD__, __LINE__, 'user:'     . $this -> user );
		OutputLog::outLog( OutputLog::DEBUG , __METHOD__, __LINE__, 'password:' . $this -> password );
		
		$this -> connect();
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
	}
	
	
	
	/**
	 * SELECT
	 * @param string $sqlcmd
	 * @param array $bindArray
	 */
	public function select( $sqlcmd, $bindArray = array() ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
		foreach ( $bindArray as $data ) {
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'data:' . $data );
		}
		
		$sth = $this -> connection -> prepare( $sqlcmd );
		$sth -> execute( $bindArray );
		$valueArray = array();
		while ( $value = $sth -> fetch( PDO::FETCH_ASSOC ) ) {
			
			foreach ( $value as $key => $val ) {
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, $key . '=>' . $val );
			} 
			
			$valueArray[] = $value;
		}

		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		
		return $valueArray;
		
	}
	
	
	
	/**
	 * 更新処理実行
	 * @param string $sqlcmd
	 * @param array $bindArray
	 */
	public function exec( $sqlcmd, $bindArray = array() ) {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
		foreach ( $bindArray as $data ) {
			OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'data:' . $data );
		}
		
		// トランザクション開始
		$this -> startTransaction();
		
		$sth = $this -> connection -> prepare( $sqlcmd );
		$sth -> execute( $bindArray );
		
		$lastInserId = $this -> getLastInsertId();

		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'last_insert_id:' . $lastInserId );
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		return $lastInserId;
		
	}
	
	
	
	/**
	 * ラストインサートID取得処理
	 */
	public function getLastInsertId() {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		
		$lastInserId = $this -> connection -> lastInsertId();
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		return $lastInserId;
	}
	
	
	
	/**
	 * コミット
	 */
	public function commit() {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		
		// トランザクション処理が開始されていた場合
		if ( $this -> transactionFlg === TRUE ) {
			
			OutputLog::outLog( OutputLog::DEBUG , __METHOD__, __LINE__, 'commit' );
			
			$this -> connection -> commit();
			$this -> transactionFlg = FALSE;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		
	}
	
	
	
	/**
	 * ロールバック
	 */
	public function rollback() {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		
		// トランザクション処理が開始されていた場合
		if ( $this -> transactionFlg === TRUE ) {
			
			OutputLog::outLog( OutputLog::DEBUG , __METHOD__, __LINE__, 'rollback' );
			
			$this -> connection -> rollback();
			$this -> transactionFlg = FALSE;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		
	}
	
	
	// ------------------------------ private ---------------------------------------
	
	
	
	/**
	 * DB接続
	 */
	private function connect() {
		$this -> connection = new PDO(
			  $this -> dsn
			, $this -> user
			, $this -> password
		);
		$this -> connection -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	
	
	
	/**
	 * トランザクション開始
	 */
	private function startTransaction() {
		
		// トランザクションが開始されていない場合
		if ( $this -> transactionFlg === FALSE ) {
			$this -> connection -> beginTransaction();
			$this -> transactionFlg = TRUE;
		} else {
			;
		}
	}
	
}