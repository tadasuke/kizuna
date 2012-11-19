<?php

/**
 * 画像データ
 * @author TADASUKE
 */
class ImgData extends BaseDb {
	
	private static $tableName = 'img_data';
	
	/**
	 * データ取得
	 * ユーザIDを元にデータを取得する
	 * @param int $userId
	 */
	public static function getDataByUserId( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$selectColumnArray = array(
			  'seq_id'
			, 'user_id'
			, 'img'
			, 'profile_img_flg'
		);
		$whereArray = array(
			'user_id' => $userId
		);
		
		$valueArray = parent::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * シーケンスIDを元にデータを取得する
	 * @param int $seqId
	 */
	public static function getDataBySeqId( $seqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		$selectColumnArray = array(
			  'seq_id'
			, 'user_id'
			, 'img'
			, 'profile_img_flg'
			, 'type'
		);
		$whereArray = array(
			'seq_id' => $seqId
		);
		
		$valueArray = parent::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	/**
	 * インサート
	 * @param int $userId
	 * @param string $imgData
	 * @param string $type
	 * @return int $imgSeqId
	 */
	public static function _insert( $userId, $imgData, $type ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:' . $userId );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'type:'   . $type );
		
		$insertColumnArray = array(
			  'user_id'
			, 'img'
			, 'type'
		);
		$insertValueArray = array(
			  $userId
			, $imgData
			, $type
		);
		
		$imgSeqId = parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $imgSeqId;
		
	}
	
	
	/**
	 * プロフィール画像フラグリセット
	 * @param int $userId
	 * @param string $profileImgFlg
	 */
	public static function allResetProfileImgFlgByUserId( $userId, $profileImgFlg ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'        . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'profileImgFlg:' . $profileImgFlg );
		
		$updateArray = array(
			'profile_img_flg' => $profileImgFlg
		);
		$whereArray = array(
			'user_id' => $userId
		);
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
}
