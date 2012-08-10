<?php

/**
 * DAO作成
 * @author TADASUKE
 */
class DaoFactory{
	
	/**
	 * DAO配列
	 * @var array
	 */
	private static $daoArray = array();
	
	
	
	/**
	 * DAO取得
	 * @param string $tableName
	 * @return Dao
	 */
	public static function getDao( $tableName ) {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'table_name:' . $tableName );
		
		//---------------
		// テーブルタイプ取得
		//---------------
		$tableType = Config::getConfig( 'table_type', $tableName );
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'table_type:' . $tableType );
		
		// 配列の中に存在しなかった場合
		if ( array_key_exists( $tableType, self::$daoArray ) === FALSE ) {
			self::$daoArray[$tableType] = new Dao( $tableType );
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
		return self::$daoArray[$tableType];
	}
	
	
	
	/**
	 * 全DAO取得
	 * @return array
	 */
	public static function getAllDao() {
		
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'START' );
		return self::$daoArray;
		OutputLog::outLog( OutputLog::INFO , __METHOD__, __LINE__, 'END' );
	}
	
	
	
	/**
	 * 全DAOコミット
	 */
	public static function allCommit() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		foreach ( self::$daoArray as $dao ) {
			$dao -> commit();
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
}
