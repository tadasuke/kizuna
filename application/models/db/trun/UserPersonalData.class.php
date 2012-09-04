<?php

/**
 * ユーザパーソナルデータ
 * @author TADASUKE
 */
class UserPersonalData extends BaseDb {
	
	private static $tableName = 'user_personal_data';
	
	/**
	 * インサート
	 * @param int $userId
	 * @param string $name
	 */
	public static function _insert( $userId, $name, $gender ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'   . $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'gender:' . $gender );
		
		$insertColumnArray = array(
			  'user_id'
			, 'name'
			, 'gender'
		);
		$insertValueArray = array(
			  $userId
			, $name
			, $gender
		);
		
		parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * 更新
	 * @param int $userId
	 * @param string $name
	 * @param string $gender
	 * @param string $birthday
	 * @param string $address
	 * @param string $telephoneNumber1
	 * @param string $telephoneNumber2
	 */
	public static function _update( $userId, $name, $gender, $birthday, $address, $telephoneNumber1, $telephoneNumber2 ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'           . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'             . $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'gender:'           . $gender );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthday:'         . $birthday );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'address:'          . $address );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber1:' . $telephoneNumber1 );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber2:' . $telephoneNumber2 );
		
		$updateArray = array(
			  'name'               => $name
			, 'gender'             => $gender
			, 'birthday'           => $birthday
			, 'address'            => $address
			, 'telephone_number_1' => $telephoneNumber1
			, 'telephone_number_2' => $telephoneNumber2
		);
		
		$whereArray = array(
			'user_id' => $userId
		);
		
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * データ取得
	 * ユーザIDを元にデータを取得する
	 * @param int $userId
	 */
	public static function getDataByUserId( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$selectColumnArray = array(
			  'user_id'
			, 'name'
			, 'gender'
			, 'birthday'
			, 'address'
			, 'telephone_number_1'
			, 'telephone_number_2'
			, 'profile_img_seq_id'
		);
		$whereArray = array(
			'user_id' => $userId
		);
		$valueArray = parent::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
	}
	
	/**
	 * プロフィール画像更新
	 * @param int $userId
	 * @param int $profileImgSeqId
	 */
	public static function updateProfileImgSeqId( $userId, $profileImgSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'          . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'profileImgSeqId:' . $profileImgSeqId );
		
		$updateArray = array(
			'profile_img_seq_id' => $profileImgSeqId
		);
		$whereArray = array(
			'user_id' => $userId
		);
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
