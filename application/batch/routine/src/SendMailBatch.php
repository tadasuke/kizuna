<?php

require_once '/upsystem/new_kizuna/kizuna/application/batch/BatchInclude.php';

require_once 'models/Mail.class.php';

//---------------
// メール送信バッチ
//---------------
sendMail();

DaoFactory::allCommit();

function sendMail() {
	
	OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
	
	Mail::sendMail();
	
	OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	
}