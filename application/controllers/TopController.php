<?php

class TopController extends AfterLoginCommonAction{
	
	/**
	 * トップページ表示
	 */
	public function indexAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		// トークID取得
		$talkId = (isset( $this -> paramArray['talk_id'] ) === TRUE) ? $this -> paramArray['talk_id'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkId:' . $talkId );
		
		// ターゲットユーザキー取得
		$targetUserKey = (isset( $this -> paramArray['user_key'] ) === TRUE) ? $this -> paramArray['user_key'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		
		// 優先度取得
		$priority = (isset( $this -> paramArray['priority'] ) === TRUE) ? $this -> paramArray['priority'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'priority:' . $priority );
		
		//---------------
		// ログイン履歴作成
		//---------------
		History::loginHistory( $this -> userId );
		
		//------------
		// テーマID設定
		//------------
		$themeId = (isset( $this -> paramArray['theme_id'] ) === TRUE) ? $this -> paramArray['theme_id'] : '000';
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:' . $themeId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		$this -> _smarty -> assign( 'theme_id', $themeId );
		$this -> _smarty -> assign( 'talk_id' , $talkId );
		$this -> _smarty -> assign( 'user_key', $targetUserKey );
		$this -> _smarty -> assign( 'priority', $priority );
		$this -> _smarty -> display( 'top_page.tpl' );
		
	}
	
}