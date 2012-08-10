<?php

/**
 * お話データ
 * @author TADASUKE
 */
class TalkData extends BaseDb {
	
	private static $tableName = 'talk_data';
	
	/**
	 * お話データ作成
	 * @param int $userId
	 * @param string $themeId
	 * @param string $talk
	 * @param string $talkType
	 * @param int $imgSeqId
	 * @param string $talkDate
	 * @return int シーケンスID
	 */
	public static function createTalkData( $userId, $themeId, $talk, $talkType, $imgSeqId, $talkDate ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'   . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:'  . $themeId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talk:'     . $talk );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkType:' . $talkType );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
		
		$insertColumnArray = array(
			  'user_id'
			, 'theme_id'
			, 'talk'
			, 'talk_type'
			, 'img_seq_id'
			, 'talk_date'
			, 'user_delete_flg'
		);
		$insertValueArray = array(
			  $userId
			, $themeId
			, $talk
			, $talkType
			, $imgSeqId
			, $talkDate
			, '0'
		);
		$seqId = parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $seqId;
		
	}
	
	
	/**
	 * 全データ取得
	 */
	public static function getDataByMaxSeqId( $maxSeqId = NULL ) {
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'maxSeqId:' . $maxSeqId );
		
		parent::$sqlcmd =
			"SELECT "
				. "  seq_id "
				. ", user_id "
				. ", theme_id "
				. ", talk "
				. ", talk_type "
				. ", img_seq_id "
				. ", talk_date "
			. "FROM " . self::$tableName . " "
			. "WHERE user_delete_flg = ? "
			. "AND delete_flg = ? "
			;
		if ( is_null( $maxSeqId ) === FALSE ) {
			parent::$sqlcmd .= "AND seq_id <= ? ";
		} else {
			;
		}
		
		parent::$sqlcmd .= "ORDER BY talk_date DESC ";
		
		parent::$bindArray = array(
			  '0'
			, '0'
		);
		
		if ( is_null( $maxSeqId ) === FALSE ) {
			parent::$bindArray[] = $maxSeqId;
		} else {
			;
		}
		
		parent::select( self::$tableName );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return parent::$valueArray;
		
	}
	
	
	/**
	 * データ取得
	 * シーケンスIDを元にデータを取得する
	 * @param int $seqId
	 * @return array
	 */
	public static function getDataBySeqId( $seqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		$selectColumnArray = array(
			  'seq_id'
			, 'user_id'
			, 'theme_id'
			, 'talk'
			, 'talk_type'
			, 'img_seq_id'
			, 'talk_date'
		);
		
		$whereArray = array(
			  'seq_id'          => $seqId
			, 'user_delete_flg' => '0'
			, 'delete_flg'      => '0'
		);
		
		$valueArray = parent::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * ユーザ削除フラグ更新
	 * @param int $seqId
	 * @param char $userDeleteFlg
	 */
	public static function updateUserDeleteFlgBySeqId( $seqId, $userDeleteFlg = '1' ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:'         . $seqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userDeleteFlg:' . $userDeleteFlg );
		
		parent::$sqlcmd =
			"UPDATE " . self::$tableName . " "
			. "SET user_delete_flg = ? "
			. "WHERE seq_id = ? "
			;
			
		parent::$bindArray = array(
			  $userDeleteFlg
			, $seqId
		);
		
		parent::exec( self::$tableName );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
