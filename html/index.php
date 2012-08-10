<?php

//----------------
// ライブラリ読み込み
//----------------
require_once 'Smarty/Smarty.class.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Debug.php';

//----------------
// プロセスタイプ設定
//----------------
setServerType();

//-----------------------
// ベースインクルードパス設定
//-----------------------
// 本番の場合
if ( strcmp( Zend_Registry::get( 'SERVER_TYPE' ), 'HONBAN' ) == 0 ) {
	define( 'APP', '/upsystem/new_kizuna/kizuna/application' );
// 開発の場合
} else if ( strcmp( Zend_Registry::get( 'SERVER_TYPE' ), 'DEVELOP' ) == 0 ) {
	define( 'APP', '/upsystem/new_kizuna_dev/kizuna/application' );
}

// インクルードパス設定
set_include_path( get_include_path() . PATH_SEPARATOR . APP );

//----------------------
// KIZUNAライブラリ読み込み
//----------------------
require_once 'lib/KizunaDefine.class.php';
require_once 'lib/Library.php';
require_once 'models/ini/KizunaIni.class.php';
require_once 'models/ini/ThemeIni.class.php';
require_once 'models/common/Config.class.php';
require_once 'models/common/OutputLog.class.php';
require_once 'models/db/BaseDb.class.php';
require_once 'models/db/DaoFactory.class.php';
require_once 'models/db/Dao.class.php';
require_once 'models/UserFactory.class.php';
require_once 'controllers/common/CommonAction.php';
require_once 'controllers/common/AfterLoginCommonAction.php';
require_once 'models/History.class.php';

$front = Zend_Controller_Front::getInstance();
$front -> throwExceptions( TRUE );
$front -> setControllerDirectory( APP . '/controllers' );

try{
	
	//-----------
	// プロセス開始
	//-----------
	$front -> dispatch();
	
}

catch ( Exception $e ) {
	
	echo( 'ERROR!!<br/>' );
	echo( $e -> getMessage() . '<br/>' );
	echo( $e -> getFile() . '<br/>' );
	echo( $e -> getLine() . '<br/>' );
	
}

/**
 * サーバタイプ設定
 */
function setServerType() {
	
	// ホスト名取得
	$url = $_SERVER['HTTP_HOST'];
	// 銭湯の.までの文字列を抽出
	$array = explode( '.', $url );
	$host = $array[0];
	
	// 本番の場合
	if ( strcmp( $host, 'ki2na' ) == 0 ) {
		Zend_Registry::set( 'SERVER_TYPE', 'HONBAN' );
	// 開発環境の場合
	} else if ( strcmp( $host, 'dev' ) == 0 ) {
		Zend_Registry::set( 'SERVER_TYPE', 'DEVELOP' );
	}
	
}
