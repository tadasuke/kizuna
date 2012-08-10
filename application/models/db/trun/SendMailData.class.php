<?php

/**
 * メールデータ
 * @author TADASUKE
 */
class SendMailData extends BaseDb {
	
	private static $tableName = 'send_mail_data';
	
	/**
	 * メールデータ作成
	 * @param string $toMailAddress
	 * @param string $fromMailAddress
	 * @param string $title
	 * @param string $message
	 */
	public static function createTalkData( $toMailAddress, $fromMailAddress, $title, $message ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'toMailAddress:'   . $toMailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'fromMailAddress:' . $fromMailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'title:'           . $title );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'message:'         . $message );
		
		$now = date( 'YmdHis' );
		
		$insertColumnArray = array(
			  'to_mail_address'
			, 'from_mail_address'
			, 'title'
			, 'message'
			, 'status'
			, 'create_mail_date'
		);
		$insertValueArray = array(
			  $toMailAddress
			, $fromMailAddress
			, $title
			, $message
			, '0'
			, $now
		);
		parent::insert( self::$tableName, $insertColumnArray, $insertValueArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * データ取得
	 * ステータスを元にデータを取得する
	 * @param string $status
	 */
	public static function getDataByStatus( $status ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'status:' . $status );
		
		$selectColumnArray = array(
			  'seq_id'
			, 'to_mail_address'
			, 'from_mail_address'
			, 'title'
			, 'message'
		);
		$whereArray = array(
			'status' => $status
		);
		$valueArray = parent::simpleSelect( self::$tableName, $selectColumnArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * シーケンスIDを元にステータスを更新する
	 * @param int $seqId
	 * @param string $status
	 */
	public static function updateStatusBySeqId( $seqId, $status ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:'  . $seqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'status:' . $status );
		
		$updateArray = array(
			'status' => $status
		);
		$whereArray = array(
			'seq_id' => $seqId
		);
		parent::simpleUpdate( self::$tableName, $updateArray, $whereArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
