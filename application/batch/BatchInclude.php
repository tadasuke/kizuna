<?php

define( 'APP', '/upsystem/new_kizuna/kizuna/application' );

// インクルードパス設定
set_include_path( get_include_path() . PATH_SEPARATOR . APP );

//----------------
// ライブラリ読み込み
//----------------
require_once 'Zend/Registry.php';
require_once 'Zend/Debug.php';

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

// 設定ファイルを設定
KizunaIni::setConfig( 'HONBAN' );

// プロセスIDを設定
$processId = microtime( TRUE );
Zend_Registry::set( 'PROCESS_ID', $processId );

// ログ出力ディレクトリを設定
OutputLog::setLigFileDir( Config::getConfig( 'system', 'batch_log_file_dir' ) . date( 'Ym' ) . '/' );
		