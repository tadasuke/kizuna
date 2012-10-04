<?php

require_once 'models/Img.class.php';

class ImgController extends AfterLoginCommonAction{
	
	/**
	 * プロフィール画像表示
	 */
	public function getProfileImgAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		if ( array_key_exists( 'target_user_key', $this -> paramArray ) === TRUE ) {
			$targetUserId = User::getUserIdByUserKey( $this -> paramArray['target_user_key'] );
		} else {
			$targetUserId = $this -> userId;
		}
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserId:' . $targetUserId );
		
		$profileImgData = UserFactory::get( $targetUserId ) -> getProfileImgData();
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		header( 'Content-type: image/JPEG' );
		echo( $profileImgData );
		
		
	}
	
	/**
	 * プロフィール画像変更
	 */
	public function updateProfileImgAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//-----------------------------
		// アップロードされた画像データを取得
		//-----------------------------
		$imgDataArray = $_FILES['profile_img'];
		$imgFilePath = $imgDataArray['tmp_name'];
		
		// 画像データをインサート
		$imgSeqId = $this -> userClass -> getImgClass() -> insertImgData( $imgFilePath );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		// プロフィール画像を更新
		$this -> userClass -> updateProfileImgSeqId( $imgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		$this -> redirect( '/user/view-user-data-update-page' );
		
	}
	
	
	/**
	 * 画像表示
	 */
	public function getImgAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$imgSeqId = $this -> paramArray['img_seq_id'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		$imgData = Img::getImgData( $imgSeqId );
		//$imgData = $this -> userClass -> getImgClass() -> getImgData( $imgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		header( 'Content-type: image/JPEG' );
		echo( $imgData );
		
	}
	
}