<?php

require_once 'models/db/trun/TalkData.class.php';
require_once 'models/db/trun/CommentData.class.php';
require_once 'models/bean/TalkBean.class.php';

class Talk{
	
	/**
	 * @var int
	 */
	private $userId;
	
	/**
	 * @var array
	 */
	private $talkBeanArray = NULL;
	public function getTalkBeanArray( $regetFlg = FALSE ) {
		if ( is_null( $this -> talkBeanArray ) === TRUE || $regetFlg === TRUE ) {
			$this -> setTalkBeanArray();
		} else {
			;
		}
		return $this -> talkBeanArray;
	}
	
	/**
	 * 最大トークシーケンスID
	 * @var int
	 */
	private $maxSeqId = NULL;
	public function setMaxSeqId( $maxSeqId ) {
		$this -> maxSeqId = $maxSeqId;
	}
	
	/**
	 * コンストラクタ
	 */
	public function __construct( $userId ) {
		$this -> userId = $userId;
	}
	
	/**
	 * 話す
	 * @param string $themeId
	 * @param string $talk
	 * @param int $imgSeqId
	 * @return int シーケンスID
	 */
	public function runTalk( $themeId, $talk, $imgSeqId = NULL ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:'  . $themeId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talk:'     . $talk );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		$talkDate = date( 'YmdHis' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
		
		$seqId = TalkData::createTalkData( $this -> userId, $themeId, $talk, KizunaDefine::TALK_TYPE_NORMAL, $imgSeqId, $talkDate );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $seqId;
	}
	
	
	/**
	 * コメントする
	 * @param int $talkSeqId
	 * @param string $comment
	 */
	public function runComment( $talkSeqId, $comment ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'comment:'   . $comment );
		
		$commentDate = date( 'YmdHis' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'commentDate:' . $commentDate );
		
		CommentData::createTalkData( $talkSeqId, $this -> userId, $comment, $commentDate );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * トークデータ削除
	 * @param int $seqId
	 * @return boolean $result
	 */
	public function deleteTalk( $seqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		// 自分の書き込みか調べる
		$result = $this -> checkMyTalk( $seqId );
		
		if ( $result === FALSE ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_my_talk_data' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return FALSE;
		} else {
			;
		}
		
		// 削除実行
		TalkData::updateUserDeleteFlgBySeqId( $seqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return TRUE;
		
	}
	
	
	
	
	//---------------------------------------- private ---------------------------------------------
	
	/**
	 * トークビーン設定
	 */
	private function setTalkBeanArray() {
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$talkBeanArray = array();
		
		// トークデータ取得
		$talkDataValueArray = TalkData::getDataByMaxSeqId( $this -> maxSeqId );
		
		foreach ( $talkDataValueArray as $talkData ) {
			
			$seqId    = $talkData['seq_id'];
			$userId   = $talkData['user_id'];
			$themeId  = $talkData['theme_id'];
			$talk     = $talkData['talk'];
			$talkType = $talkData['talk_type'];
			$imgSeqId = $talkData['img_seq_id'];
			$talkDate = $talkData['talk_date'];
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:'    . $seqId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:'   . $userId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'themeId:'  . $themeId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talk:'     . $talk );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'taklType:' . $talkType );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkDate:' . $talkDate );
			
			$talkBean = new TalkBean();
			$talkBean -> setSeqId( $seqId );
			$talkBean -> setUserId( $userId );
			$talkBean -> setThemeId( $themeId );
			$talkBean -> setTalk( $talk );
			$talkBean -> setTalkType( $talkType );
			$talkBean -> setImgSeqId( $imgSeqId );
			$talkBean -> setTalkDate( $talkDate );
			
			// コメントデータ取得
			$commentBeanArray = array();
			$commentDataValueArray = CommentData::getDataByTalkSeqId( $seqId );
			foreach ( $commentDataValueArray as $commentData ) {
				$commentBean = new CommentBean();
				$commentBean -> setSeqId( $commentData['seq_id'] );
				$commentBean -> setTalkSeqId( $commentData['talk_seq_id'] );
				$commentBean -> setUserId( $commentData['user_id'] );
				$commentBean -> setComment( $commentData['comment'] );
				$commentBean -> setCommentDate( $commentData['comment_date'] );
				
				$commentBeanArray[] = $commentBean;
			}
			$talkBean -> setCommentBeanArray( $commentBeanArray );
			
			$talkBeanArray[] = $talkBean;
		}
		
		$this -> talkBeanArray = $talkBeanArray;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	
	
	/**
	 * 自分のトークデータか調べる
	 * @param int $seqId
	 * @return boolean $result
	 */
	private function checkMyTalk( $seqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'seqId:' . $seqId );
		
		$talkDataValueArray = TalkData::getDataBySeqId( $seqId );
		
		// データが取得できなかった場合はエラー
		if ( count( $talkDataValueArray ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_data' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return FALSE;
		} else {
			;
		}
		
		$userId = $talkDataValueArray[0]['user_id'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$result = ($userId == $this -> userId) ? TRUE : FALSE;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $result;
	}
	
	
	
	//------------------------------------- static ------------------------------------
	
	/**
	 * ユーザID取得
	 * @param $talkSeqId
	 * @return $userId
	 */
	public static function getUserId( $talkSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		$userId = NULL;
		
		$talkDataValueArray = TalkData::getDataBySeqId( $talkSeqId );
		
		if ( count( $talkDataValueArray ) > 0 ) {
			$userId = $talkDataValueArray[0]['user_id'];
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		return $userId;
		
	}
	
	
	/**
	 * コメントしているユーザID配列を取得
	 * @param int $talkSeqId
	 * @return array
	 */
	public static function getCommentUserIdArray( $talkSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'talkSeqId:' . $talkSeqId );
		
		$valueArray = CommentData::getDataByTalkSeqId( $talkSeqId );
		
		$userIdArray = array();
		foreach ( $valueArray as $data ) {
			
			$userId = $data['user_id'];
			$userIdArray[] = $userId;
			
		}
		
		// 重複を除去
		$userIdArray = array_unique( $userIdArray );
		
		foreach ( $userIdArray as $userId ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		return $userIdArray;
		
	}
	
	
}
