<?php

/**
 * DB基本クラス
 * @author TADASUKE
 */
abstract class BaseDb{
	
	/**
	 * SQL
	 * @var string
	 */
	protected static $sqlcmd;
	
	/**
	 * バインド配列
	 * @var array
	 */
	protected static $bindArray = array();
	
	/**
	 * クエリ結果配列
	 * @var array
	 */
	protected static $valueArray = array();
	
	
	//------------------------------ protected -------------------------------	
	
	
	/**
	 * セレクト
	 * @param string $tableName
	 */
	protected static function select( $tableName ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'table_name:' . $tableName );
		
		$dao = DaoFactory::getDao( $tableName );
		self::$valueArray = $dao -> select( self::$sqlcmd, self::$bindArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	/**
	 * 更新
	 * @param string $tableName
	 * @return int $lastInsertId
	 */
	protected static function exec( $tableName ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'tableName:' . $tableName );
		
		$dao = DaoFactory::getDao( $tableName );
		$lastInsertId = $dao -> exec( self::$sqlcmd, self::$bindArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $lastInsertId;
	}
	
	/**
	 * シンプルセレクト
	 * @param string $tableName
	 * @param mixed $selectColumnArray
	 * @param mixed $whereArray
	 * @return array
	 */
	protected static function simpleSelect( $tableName, $selectColumnArray = array(), $whereArray = array() ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'tableName:' . $tableName );
		
		//--------------------------------
		// パラメータが配列でない場合は配列にする
		//--------------------------------
		$selectColumnArray = changeArray( $selectColumnArray );
		
		//--------
		// SQL作成
		//--------
		$sqlcmd = "SELECT ";
		foreach ( $selectColumnArray as $selectColumn ) {
			$sqlcmd .= $selectColumn . ",";
		}
		// 末尾のカンマを除去
		$sqlcmd = substr( $sqlcmd, 0, strlen( $sqlcmd ) - 1 );
		$sqlcmd .= " ";
		
		$sqlcmd .= "FROM " . $tableName . " ";
		$i = 0;
		foreach ( $whereArray as $column => $value ) {
			if ( $i == 0 ) {
				$sqlcmd .= "WHERE ";
			} else {
				$sqlcmd .= "AND ";
			}
			$sqlcmd .= $column . " = ? ";
			$i++;
		}
		self::$sqlcmd = $sqlcmd;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
		
		//-------------
		// バインド値設定
		//-------------
		self::$bindArray = array();
		foreach ( $whereArray as $column => $value ) {
			self::$bindArray[] = $value;
		}
		
		//---------
		// 検索実行
		//---------
		self::select( $tableName );
		
		$valueArray = self::$valueArray;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray;
		
	}
	
	
	/**
	 * インサート
	 * @param string $tableName
	 * @param mixed $insertColumnArray
	 * @param mixed $insertValueArray
	 * @return int $lastInsertId
	 */
	protected static function insert( $tableName, $insertColumnArray, $insertValueArray ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'tableName:' . $tableName );
		
		//---------
		// SQL作成
		//---------
		$sqlcmd = "INSERT INTO " . $tableName . " ";
		$sqlcmd .= "(";
		foreach ( $insertColumnArray as $insertColumn ) {
			$sqlcmd .= $insertColumn . ",";
		}
		$sqlcmd .= "INSERT_TIME ";
		
		$sqlcmd .= ")VALUES(";
		foreach ( $insertColumnArray as $insertColumn ) {
			$sqlcmd .=  "?,";
		}
		$sqlcmd .= "NOW() ) ";
		
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'sqlcmd:' . $sqlcmd );
		self::$sqlcmd = $sqlcmd;
		self::$bindArray = $insertValueArray;
		
		$lastInsertId = self::exec( $tableName );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'lastInsertId:' . $lastInsertId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $lastInsertId;
	}
	
	
	
	/**
	 * シンプルアップデート
	 * @param string $tableName
	 * @param mixed $selectColumnArray
	 * @param mixed $whereColumnArray
	 * @param mixed $whereValueArray
	 */
	protected static function simpleUpdate( $tableName, $updateArray = array(), $whereArray = array() ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'tableName:' . $tableName );
		
		//--------------------------------
		// パラメータが配列でない場合は配列にする
		//--------------------------------
		$updateArray = changeArray( $updateArray );
		$whereArray  = changeArray( $whereArray );
		
		//--------
		// SQL作成
		//--------
		$sqlcmd = "UPDATE " . $tableName . " ";
		$sqlcmd .= "SET ";
		foreach ( $updateArray as $column => $value ) {
			$sqlcmd .= $column . " = ? ,";
		}
		$sqlcmd = substr( $sqlcmd, 0, strlen( $sqlcmd ) - 1 );
		$sqlcmd .= " ";
		$i = 0;
		foreach ( $whereArray as $column => $value ) {
			if ( $i == 0 ) {
				$sqlcmd .= "WHERE ";
			} else {
				$sqlcmd .= "AND ";
			}
			$sqlcmd .= $column . " = ? ";
			$i++;
		}
		
		self::$sqlcmd = $sqlcmd;
		
		//-------------
		// バインド値設定
		//-------------
		self::$bindArray = array();
		foreach ( $updateArray as $value ) {
			self::$bindArray[] = $value;
		}
		foreach ( $whereArray as $value ) {
			self::$bindArray[] = $value;
		}
		
		//---------
		// 更新
		//---------
		self::exec( $tableName );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
}