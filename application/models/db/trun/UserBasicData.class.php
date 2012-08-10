<?php

/**
 * ユーザ基本データ
 * @author TADASUKE
 */
class UserBasicData extends BaseDb {
	
	private static $tableName = 'user_basic_data';
	
	/**
	 * 全データ取得
	 */
	public static function getAllData( $status = User::USER_BASIC_DATA_STATUS_TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$selectColumnArray = array(
			  'user_id'
			, 'user_key'
			, 'mail_address'
			, 'entry_date'
			, 'cancel_flg'
		);
		$whereArray = array(
			'status' => $status
		);
		$valueArray = UserBasicData::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * ユーザIDを元にデータを取得する
	 * @param int $userId
	 */
	public static function getDataByUserId( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$selectColumnArray = array(
			  'user_key'
			, 'mail_address'
			, 'entry_date'
			, 'cancel_flg'
		);
		$whereArray = array(
			'user_id' => $userId
		);
		$valueArray = UserBasicData::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * メールアドレスを元にデータを取得する
	 * @param string $mailAddress
	 */
	public static function getDataByMailAddress( $mailAddress ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		
		$selectColumnArray = array(
			  'user_key'
			, 'mail_address'
			, 'entry_date'
			, 'cancel_flg'
		);
		$whereArray = array(
			'mail_address' => $mailAddress
		);
		$valueArray = UserBasicData::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * メールアドレスを元にユーザIDを取得する
	 * @param string $mailAddress
	 * @param string $password
	 * @return int $userId
	 */
	public static function getUserIdByMailAddress( $mailAddress, $password = NULL, $status = User::USER_BASIC_DATA_STATUS_TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:' . $password );
		
		$selectColumnArray = array( 'user_id' );
		$whereArray = array( 'mail_address' => $mailAddress );
		// パスワードが設定されていた場合
		if ( is_null( $password ) === FALSE ) {
			$whereArray['password'] = $password;
		} else {
			;
		}
		
		// ステータスが設定されていた場合
		if ( is_null( $status ) === FALSE ) {
			$whereArray['status'] = $status;
		} else {
			;
		}
		
		$valueArray = self::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		$userId = (count( $valueArray ) > 0) ? $valueArray[0]['user_id'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
	
	/**
	 * データ取得
	 * ユーザキーを元にユーザIDを取得する
	 * @param string $userKey
	 * @return int $userId
	 */
	public static function getUserIdByUesrKey( $userKey, $status = User::USER_BASIC_DATA_STATUS_TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'status:'   . $status );
		
		$selectColumnArray = array( 'user_id' );
		$whereArray = array(
			  'user_key' => $userKey
			, 'status'   => $status
		);
		$valueArray = self::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		$userId = (count( $valueArray ) > 0) ? $valueArray[0]['user_id'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
	
	/**
	 * インサート
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $entryDate
	 * @param string cancelFlg
	 * @param int $insertId
	 */
	public static function create( $mailAddress, $password, $entryDate, $cancelFlg ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:'   . $password );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'entryDate:'   . $entryDate );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'cancelFlg:'   . $cancelFlg );
		
		$insertColumnArray = array(
			  'mail_address'
			, 'password'
			, 'status'
			, 'entry_date'
			, 'cancel_flg'
		);
		$insertValueArray = array(
			  $mailAddress
			, $password
			, User::USER_BASIC_DATA_STATUS_PRE
			, $entryDate
			, $cancelFlg
		);
		$insertId = parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'insertId:' . $insertId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $insertId;
		
	}
	
	
	
	/**
	 * ユーザキー更新
	 * @param string $userKey
	 * @param char $userId
	 */
	public static function updateUserKeyByUserId( $userKey, $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:'  . $userId );
		
		$updateArray = array(
			'user_key' => $userKey
		);
		$whereArray = array(
			'user_id' => $userId
		);
		
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * ステータス更新
	 * @param string $status
	 * @param int $userId
	 */
	public static function updateStatusByUserId( $status, $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'status:' . $status );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$updateArray = array(
			'status' => $status
		);
		$whereArray = array(
			'user_id' => $userId
		);
		
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
