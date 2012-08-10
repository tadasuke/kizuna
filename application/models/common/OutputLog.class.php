<?php

/**
 * ログ出力クラス
 * @author TADASUKE
 */
class OutputLog {
	
	const EMERG  = 0;
	const ALERT  = 1;
	const CRIT   = 2;
	const ERR    = 3;
	const WARN   = 4;
	const NOTICE = 5;
	const INFO   = 6;
	const DEBUG  = 7;
	
	/**
	 * ログ出力ディレクトリ
	 * @var string
	 */
	private static $logFileDir = NULL;
	public static function setLigFileDir( $logFileDir ) {
		self::$logFileDir = $logFileDir;
	}
	public static function getLogFileDir() {
		return self::$logFileDir;
	}
	
	/**
	 * ログファイル名
	 * @var string
	 */
	private static $logFileName = NULL;
	public static function setLogFileName( $logFileName ) {
		self::$logFileName = $logFileName;
	}
	
	/**
	 * ログレベル
	 * @var int
	 */
	private static $outLogLevel = NULL;
	public static function setOutLogLevel( $outLogLevel ) {
		self::$outLogLevel = $outLogLevel;
	}
	
	
	/**
	 * ログ出力
	 * @param int    $logLevel
	 * @param string $class
	 * @param string $function
	 * @param int    $line
	 * @param string $message
	 */
	public static function outLog( $logLevel, $method, $line, $message ) {
	
		if ( $logLevel > Config::getConfig( 'system', 'out_log_level' ) ) {
			return;
		} else {
			;
		}
		
		if ( strlen( $message ) > 512 ) {
			return;
		} else {
			;
		}
		
		// ログ出力先を設定
		if ( is_null( self::$logFileName ) === TRUE ) {
			
			if ( is_null( self::$logFileDir ) === TRUE ) {
				self::$logFileDir = Config::getConfig( 'system', 'log_file_dir' ) . date( 'Ym' ) . '/';
			} else {
				;
			}
			
			// ログ出力先ディレクトリ存在チェック
			if ( file_exists( self::$logFileDir ) === FALSE ) {
				mkdir( self::$logFileDir );
			} else {
				;
			}
			
			self::$logFileName = self::$logFileDir . date( 'Ymd' ) . '.log';
		} else {
			;
		}
		
		// ログメッセージを作成
		$outputMessage = self::makeLogMessage( $method, $line, $message );
		$outputMessage = '(' . $logLevel . ')' . "\t" . $outputMessage;
		
		$LOG_FP = fopen( self::$logFileName, 'a' );
		fwrite( $LOG_FP, $outputMessage . PHP_EOL );
		fclose( $LOG_FP );
		
		if ( strcmp( $logLevel, self::EMERG ) == 0 ) {
			$FP = fopen( self::$logFileName . '.error', 'a' );
			
			fwrite( $FP, $outputMessage . PHP_EOL );
			fclose( $FP );
		} else {
			;
		}
		
	}
	
	
	
	/**
	 * 出力メッセージ作成
	 * @param string $method
	 * @param int $line
	 * @param string $message
	 */
	private static function makeLogMessage( $method, $line, $message ) {
		
		$userKey = (Zend_Registry::isRegistered( 'USER_KEY' ) === TRUE) ? Zend_Registry::get( 'USER_KEY' ) : '';
		
		$outputMessage = Zend_Registry::get( 'PROCESS_ID' ) . "\t" . date('H:i:s') . "\t" . $userKey . "\t" . $method . "\t" . $line . "\t" . $message;
		return $outputMessage;
	}
	
}
	