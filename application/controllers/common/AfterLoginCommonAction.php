<?php

class AfterLoginCommonAction extends CommonAction{
	
	public function preDispatch() {
		
		parent::preDispatch();
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		// ユーザクラスが取得できない場合はログイン前ページにリダイレクト
		if ( is_null( $this -> userClass ) === TRUE ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_login' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			$this -> _redirect( '/index/index' );
			return;
		} else {
			;
		}
		
		// ユーザ名をSmarty変数に設定
		$this -> _smarty -> assign( 'name', $this -> userClass -> getName() );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}