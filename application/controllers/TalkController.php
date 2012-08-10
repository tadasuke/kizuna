<?php

require_once 'models/Img.class.php';
require_once 'models/Mail.class.php';

class TalkController extends AfterLoginCommonAction{

	/**
	 * 話す
	 */
	public function talkAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$themeId = $this -> paramArray['theme_id'];
		$talk    = nl2br( htmlspecialchars( $this -> paramArray['talk'] ) );
		$mailCheck = (isset( $this -> paramArray['mail_check'] ) === TRUE) ? $this -> paramArray['mail_check'] : '0';
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:' . $themeId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talk:'    . $talk );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailCheck:' . $mailCheck );
		
		$imgSeqId = NULL;
		
		//---------------
		// 添付ファイル取得
		//---------------
		$imgDataArray = $_FILES['talk_img'];
		
		// ファイルが添付されていた場合
		$size = $imgDataArray['size'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'size:' . $size );
		
		if ( $size > 0 ) {
			// 画像データインサート
			$imgSeqId = $this -> userClass -> getImgClass() -> insertImgData( $imgDataArray['tmp_name'] );
		} else {
			;
		}
		
		// トークデータ作成
		$seqId = $this -> userClass -> getTalkClass() -> runTalk( $themeId, $talk, $imgSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		// メール送信
		if ( strcmp( $mailCheck, '1' ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'send_mail!!' );
			Mail::createMailData( Mail::MAIL_TYPE_UPDATE_TALK, $this -> userId, $seqId );
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		$this -> redirect( '/top/index' );
		
	}
	
	
	/**
	 * テーマ取得
	 */
	public function getThemeAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$themeArray = ThemeIni::$themeArray;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		header( 'Content-type: application/json' );
		echo( json_encode( $themeArray ) );
		
	}
	
	/**
	 * トークデータ取得
	 */
	public function getTalkAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$maxSeqId  = (isset( $this -> paramArray['max_seq_id'] ) === TRUE) ? $this -> paramArray['max_seq_id'] : 0;
		
		$maxSeqId = $this -> paramArray['max_seq_id'];
		$maxSeqId = (strlen( $maxSeqId ) == 0) ? NULL : $maxSeqId;
		$dataCount = (isset( $this -> paramArray['data_count'] ) === TRUE) ? $this -> paramArray['data_count'] : 30;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'maxSeqId:'  . $maxSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'dataCount:' . $dataCount );
		
		// 表示テーマID設定
		$getThemeId = (isset( $this -> paramArray['theme_id'] ) === TRUE) ? $this -> paramArray['theme_id'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'getThemeId:' . $getThemeId );
		
		// 表示優先度設定
		$priority = (isset( $this -> paramArray['priority'] ) === TRUE) ? $this -> paramArray['priority'] : NULL;
		$priority = (strlen( $priority ) > 0) ? $priority : Config::getConfig( 'system', 'default_priority' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'priority:' . $priority );
		
		//----------------
		// 表示ユーザID設定
		//----------------
		// ユーザキー取得
		$targetUserKey = (isset( $this -> paramArray['user_key'] ) === TRUE) ? $this -> paramArray['user_key'] : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		// ユーザIDを取得
		$targetUserId = (is_null( $targetUserKey ) === FALSE) ? User::getUserIdByUserKey( $targetUserKey ) : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserId:' . $targetUserId );
		
		// 表示トークID設定
		$talkId = (isset( $this -> paramArray['talk_id'] ) === TRUE) ? $this -> paramArray['talk_id'] : NULL;
		$taklId = (strlen( $talkId ) > 0) ? $talkId : NULL;
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkId:' . $talkId );
		
		$talkClass = $this -> userClass -> getTalkClass();
		$talkClass -> setMaxSeqId( $maxSeqId );
		$talkBeanArray = $talkClass -> getTalkBeanArray();
		
		$talkArray = array();
		
		$i = 0;
		foreach ( $talkBeanArray as $talkBean ) {
			
			$seqId    = $talkBean -> getSeqId();
			$themeId  = $talkBean -> getThemeId();
			$talk     = $talkBean -> getTalk();
			$userId   = $talkBean -> getUserId();
			$imgSeqId = $talkBean -> getImgSeqId();
			$talkDate = $talkBean -> getTalkDate();
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:'    . $seqId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:'  . $themeId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talk:'     . $talk );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'   . $userId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
			
			// トークIDが設定されていた場合
			if ( strlen( $talkId ) > 0 ) {
				if ( strcmp( $taklId, $seqId ) != 0 ) {
					continue;
				} else {
					;
				}
			} else {
				;
			}
			
			// テーマIDが設定されていた場合
			if ( strlen( $getThemeId ) > 0 ) {
				if ( strcmp( $getThemeId, $themeId ) != 0 ) {
					continue;
				} else {
					;
				}
			} else {
				;
			}
			
			// ターゲットユーザIDが設定されていた場合
			if ( strlen( $targetUserId ) > 0 ) {
				if ( strcmp( $targetUserId, $userId ) != 0 ) {
					continue;
				} else {
					;
				}
			} else {
				;
			}
			
			// 他者のトークで優先度が低い場合はスルー
			if ( $this -> userId != $userId ) {
				$themeArray = ThemeIni::getThemeArrayByThemeId( $themeId );
				if ( $themeArray['priority'] > $priority ) {
					continue;
				} else {
					;
				}
			} else {
				;
			}
			
			//---------------------
			// 制限数に達した場合は終了
			//---------------------
			if ( $i >= $dataCount ) {
				break;
			} else {
				;
			}
			
			$userClass = UserFactory::get( $userId );
			$name    = $userClass -> getName();
			$userKey = $userClass -> getUserKey();
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'    . $name );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
			
			// コメントデータ抽出
			$commentArray = array();
			$commentBeanArray = $talkBean -> getCommentBeanArray();
			foreach ( $commentBeanArray as $commentBean ) {
				$commentSeqId   = $commentBean -> getSeqId();
				$commentUserId  = $commentBean -> getUserId();
				$comment        = $commentBean -> getComment();
				$commentDate    = $commentBean -> getCommentDate();
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentSeqId:'  . $commentSeqId );
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentUserId:' . $commentUserId );
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'comment:'       . $comment );
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentDate:'   . $commentDate );
				
				// ユーザキー取得
				$commentUserKey = UserFactory::get( $commentUserId ) -> getUserKey();
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentUserKey:' . $commentUserKey );
				
				// 名前取得
				$commentUserName = UserFactory::get( $commentUserId ) -> getName();
				OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentUserName:' . $commentUserName );
				
				$commentArray[] = array(
					  'seq_id'       => $commentSeqId
					, 'user_key'     => $commentUserKey
					, 'user_name'    => $commentUserName
					, 'comment'      => $comment
					, 'comment_date' => $commentDate
				);
			}
			
			$talkArray[] = array(
				  'seq_id'     => $seqId
				, 'talk'       => $talk
				, 'theme_id'   => $themeId
				, 'name'       => $name
				, 'user_key'   => $userKey
				, 'img_seq_id' => (strlen( $imgSeqId ) == 0 ) ? '' : $imgSeqId
				, 'talk_date'  => $talkDate
				, 'my_talk_flg' => (strcmp( $userId, $this -> userId) == 0) ? '1' : '0'
				, 'comment_array' => $commentArray
			);
			
			$i++;
			
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		header( 'Content-type: application/json' );
		echo( json_encode( $talkArray ) );
	}
	
	
	/**
	 * 削除
	 */
	public function deleteTalkAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$seqId = $this -> paramArray['seq_id'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		$talkClass = $this -> userClass -> getTalkClass();
		$result = $talkClass -> deleteTalk( $seqId );
		
		$result = ($result === TRUE) ? '0' : '1';
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'result:' . $result );
		$responseArray = array( 'result' => $result );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		echo( json_encode( $responseArray ) );
		
	}
	
	
	/**
	 * コメント書き込み
	 */
	public function commentAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkSeqId = $this -> paramArray['talk_seq_id'];
		//$comment   = $this -> paramArray['comment'];
		$comment   = nl2br( htmlspecialchars( $this -> paramArray['comment'] ) );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'comment:'   . $comment );
		
		// コメントする
		$this -> userClass -> getTalkClass() -> runComment( $talkSeqId, $comment );
		
		// トークユーザIDを取得
		$talkUserId = Talk::getUserId( $talkSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkUserId:' . $talkUserId );
		
		// トークしたユーザとコメントしたユーザが別の場合
		if ( strcmp( $talkUserId, $this -> userId ) != 0 ) {
		
			//----------------------
			// トークユーザにメール送信
			//----------------------
			// トークユーザメールアドレスを取得
			$talkUserMailAddress = UserFactory::get( $talkUserId ) -> getMailAddress();
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkUserMailAddress:' . $talkUserMailAddress );
			
			// コメントをしたユーザの名前を取得
			$commentUserName = $this -> userClass -> getName();
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentUserName:' . $commentUserName );
			
			// メール送信
			$mailTitle = 'KIZUNAからのお知らせ';
			$mailMessage = '';
			$mailMessage .= $commentUserName . 'さんがあなたにコメントをしました。' . PHP_EOL;
			$mailMessage .= Config::getConfig( 'system', 'base_url' ) . '/top/index?talk_id=' . $talkSeqId;
			
			Mail::sendSimpleMail( $talkUserMailAddress, $mailTitle, $mailMessage );
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
}