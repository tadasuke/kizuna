<?php

require_once 'models/db/history/LoginHistory.class.php';

/**
 * 履歴クラス
 * @author tadasuke
 */
class History{
	
	/**
	 * ログイン履歴作成
	 * @param int $userId
	 */
	public static function loginHistory( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$loginDate = date( 'YmdHis' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'loginDate:' . $loginDate );
		
		LoginHistory::_insert( $userId, $loginDate );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
}