<?php

class UserFactory{
	
	private static $userClassArray = array();
	
	/**
	 * ユーザオブジェクト取得
	 * @param int $userId
	 * @return User
	 */
	public static function get( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		// 内部配列に存在していた場合
		if ( isset( self::$userClassArray[$userId] ) === TRUE ) {
			$userClass = self::$userClassArray[$userId];
		} else {
			$userClass = new User( $userId );
			self::$userClassArray[$userId] = $userClass;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userClass;
		
	}
	
	
}