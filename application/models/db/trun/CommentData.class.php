<?php

/**
 * コメントデータ
 * @author TADASUKE
 */
class CommentData extends BaseDb {
	
	private static $tableName = 'comment_data';
	
	/**
	 * コメントデータ作成
	 * @param int $userId
	 * @param string $themeId
	 * @param string $talk
	 * @param string $talkType
	 * @param int $imgSeqId
	 * @param string $talkDate
	 */
	public static function createTalkData( $talkSeqId, $userId, $comment, $commentDate ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkSeqId:'   . $talkSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'      . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'comment:'     . $comment );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentDate:' . $commentDate );
		
		$insertColumnArray = array(
			  'talk_seq_id'
			, 'user_id'
			, 'comment'
			, 'comment_date'
			, 'user_delete_flg'
		);
		$insertValueArray = array(
			  $talkSeqId
			, $userId
			, $comment
			, $commentDate
			, '0'
		);
		parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * データ取得
	 * トークシーケンスIDを元にデータを取得する
	 * @param int $seqId
	 * @return array
	 */
	public static function getDataByTalkSeqId( $talkSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		parent::$sqlcmd =
			"SELECT "
				. "  seq_id "
				. ", talk_seq_id "
				. ", user_id "
				. ", comment "
				. ", comment_date "
			. "FROM " . self::$tableName . " "
			. "WHERE talk_seq_id = ? "
			. "AND user_delete_flg = ? "
			. "AND delete_flg = ? "
			;
			
		parent::$bindArray = array(
			  $talkSeqId
			, '0'
			, '0'
		);
		
		parent::select( self::$tableName ); 
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return parent::$valueArray;
		
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
