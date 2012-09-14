<?php

class Api_TalkController extends AfterLoginCommonAction {
	
	/**
	 * トークデータ取得
	 */
	public function getTalkAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//-------------
		// パラメータ取得
		//-------------
		$themeId       = (isset( $this -> paramArray['theme_id'] )        === TRUE) ? $this -> paramArray['theme_id']        : '';
		$talkId        = (isset( $this -> paramArray['talk_id'] )         === TRUE) ? $this -> paramArray['talk_id']         : '';
		$targetUserKey = (isset( $this -> paramArray['target_user_key'] ) === TRUE) ? $this -> paramArray['target_user_key'] : '';
		$priority      = (isset( $this -> paramArray['priority'] )        === TRUE) ? $this -> paramArray['priority']        : '';
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:'       . $themeId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkId:'        . $talkId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'priority:'      . $priority );
		
		
		
		
		exit;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	
}