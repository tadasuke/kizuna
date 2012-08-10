<?php

/**
 * ユーザ基本データ
 * @author TADASUKE
 */
class LoginHistory extends BaseDb {
	
	private static $tableName = 'login_history';
	
	/**
	 * インサート
	 * @param int $userId
	 * @param string $loginDate
	 */
	public static function _insert( $userId, $loginDate ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:'    . $userId );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'loginDate:' . $loginDate );
		
		self::$sqlcmd =
			"INSERT INTO " . self::$tableName . " "
			. "( "
				. "  seq_id "
				. ", user_id "
				. ", login_date "
			. " ) VALUES ( "
				. "  ? "
				. ", ? "
				. ", ? "
			. ") "
			;
			
		self::$bindArray = array(
					0
					, $userId
					, $loginDate
				);

		self::exec( self::$tableName );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}
