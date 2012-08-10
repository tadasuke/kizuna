<?php

/**
 * 設定ファイル読取クラス
 * @author TADASUKE
 */
class Config {
	
	/**
	 * 設定データ取得
	 * @param string $sectionName
	 * @param string $keyName
	 * @return 設定情報
	 */
	public static function getConfig( $sectionName, $keyName ) {
		
		$config = KizunaIni::$config[$sectionName][$keyName];
		
		return $config;

	}
	
}