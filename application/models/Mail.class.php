<?php

require_once 'Zend/Mail.php';
require_once 'models/db/trun/SendMailData.class.php';

/**
 * メールクラス
 * @author tadasuke
 *
 */
class Mail{
	
	const MAIL_TYPE_UPDATE_TALK = '0';
	
	const SEND_MAIL_STATUS_RESERVE  = '0';
	const SEND_MAIL_STATUS_COMPLETE = '1';
	const SEND_MAIL_STATUS_FAILURE  = '2';
	
	private static $toUserName        = NULL;
	
	/**
	 * メールデータ作成
	 * @param int $toUserId
	 * @param string $mailType
	 * @param int $talkSeqId
	 */
	public static function createMailData( $mailType, $toUserId, $talkSeqId = NULL ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailType:'  . $mailType );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'toUserId:'  . $toUserId );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		// 送信者メールユーザIDが設定されていた場合は、送信者名を設定
		self::$toUserName = User::getUserNameByUserId( $toUserId );
		
		// メールデータを作成
		$mailDataArray = self::setMailData( $mailType, $talkSeqId );
		$title   = $mailDataArray['title'];
		$message = $mailDataArray['message'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'title:'   . $title );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'message:' . $message );
		
		// 全ユーザデータを取得
		$userBasicDataValueArray = UserBasicData::getAllData();
		
		// メールアドレス配列を作成
		$mailAddressArray = array();
		foreach ( $userBasicDataValueArray as $data ) {
			// 送信者の場合はスルー
			if ( $toUserId == $data['user_id'] ) {
				continue;
			} else {
				;
			}
			$mailAddressArray[] = $data['mail_address'];
		}
		
		foreach ( $mailAddressArray as $mailAddress ) {
			
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
			
			SendMailData::createTalkData( $mailAddress, 'kizuna@up-system.info', $title, $message );
			
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	public static function sendMail() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		// 未送信メールデータを取得
		$sendMailValueArray = SendMailData::getDataByStatus( self::SEND_MAIL_STATUS_RESERVE );
		
		// メール情報設定
		$mail = new Zend_Mail( 'ISO-2022-JP' );
		
		foreach ( $sendMailValueArray as $data ) {
			
			$seqId           = $data['seq_id'];
			$toMailAddress   = $data['to_mail_address'];
			$fromMailAddress = $data['from_mail_address'];
			$title           = $data['title'];
			$message         = $data['message'];
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:'           . $seqId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'toMailAddress:'   . $toMailAddress );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'fromMailAddress:' . $fromMailAddress );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'title:'           . $title );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'message:'         . $message );
			
			$toMailAddress = trim( $toMailAddress );
			
			// メールアドレスが不正の場合
			if ( strlen( $toMailAddress ) == 0 ) {
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mail_address_error!!' );
				$status = self::SEND_MAIL_STATUS_FAILURE;
			// メールアドレスが正常の場合
			} else {
			
				// メール送信
				$result = self::send( $mail, $toMailAddress, $fromMailAddress, $title, $message );
				
				// メールステータス更新
				if ( $result === TRUE ) {
				    $status = self::SEND_MAIL_STATUS_COMPLETE;
				} else {
					$status = self::SEND_MAIL_STATUS_FAILURE;
				}
			    
			}
		    
		    // メール送信ステータス更新
		    SendMailData::updateStatusBySeqId( $seqId, $status );
			
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	
	/**
	 * シンプルメール送信
	 * @param string $toMailAddress
	 * @param string $title
	 * @param string $message
	 */
	public static function sendSimpleMail( $toMailAddress, $title, $message ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'toMailAddress:' . $toMailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'title:'         . $title );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'message:'       . $message );
		
		$mail = new Zend_Mail( 'ISO-2022-JP' );
		self::send( $mail, $toMailAddress, Config::getConfig( 'system', 'from_mail_address' ), $title, $message );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	
	
	//------------------------------- private ----------------------------------------
	
	
	/**
	 * メールデータ設定
	 * メールのタイトル、本文を設定する
	 * @param string $mailType
	 * @param int $talkSeqId
	 * @return array
	 */
	private static function setMailData( $mailType, $talkSeqId = NULL ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailType:'  . $mailType );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		$title   = NULL;
		$message = NULL;
		
		switch ( $mailType ) {
			
			case self::MAIL_TYPE_UPDATE_TALK :
				$title = self::$toUserName . 'さんがお話をしました。';
				$message .= 'KIZUNAからのお知らせ' . PHP_EOL . PHP_EOL;
				$message .= self::$toUserName . 'さんがお話をしました。' . PHP_EOL . PHP_EOL;
				$message .= '↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓' . PHP_EOL;
				$message .= Config::getConfig( 'system', 'base_url' ) . '/top/index';
				
				// トークシーケンスIDが設定されていた場合
				if ( is_null( $talkSeqId ) === FALSE ) {
					$message .= '?talk_id=' . $talkSeqId;
				} else {
					;
				}
				
				break;
			
		}
		
		$mailDataArray = array(
			  'title'   => $title
			, 'message' => $message
		);
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $mailDataArray;
		
	}
	
	
	/**
	 * メール送信
	 * @param Zend_Mail $mail
	 * @return boolean $result
	 */
	private static function send( Zend_Mail $mail, $toMailAddress, $fromMailAddress, $title, $message ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'toMailAddress:'   . $toMailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'fromMailAddress:' . $fromMailAddress );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'title:'           . $title );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'message:'         . $message );
		
		$result = TRUE;
		
		// 初期化
		$mail -> clearSubject();
		$mail -> clearFrom();
		$mail -> clearRecipients();
		
		// 設定
		$mail -> setBodyText( mb_convert_encoding( $message, 'ISO-2022-JP', 'UTF-8' ) );
		$mail -> setSubject( mb_convert_encoding( $title, 'ISO-2022-JP', 'UTF-8' ) );
		$mail -> setFrom( $fromMailAddress );
		$mail -> addTo( $toMailAddress );
		
		// 送信
		try{
			$mail -> send();
		} catch ( Zend_Exception $ze ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'SEND_MAIL_ERROR!!!!' );
			$result = FALSE;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $result;
				
	}
	
}
