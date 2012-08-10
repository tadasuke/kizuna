<?php

require_once 'models/bean/CommentBean.class.php';

class TalkBean{
	
	/**
	 * シーケンスID
	 * @var int
	 */
	private $seqId = NULL;
	public function setSeqId( $seqId ) {
		$this -> seqId = $seqId;
	}
	public function getSeqId() {
		return $this -> seqId;
	}
	
	/**
	 * ユーザID
	 * @var int
	 */
	private $userId = NULL;
	public function setUserId( $userId ) {
		$this -> userId = $userId;
	}
	public function getUserId() {
		return $this -> userId;
	}
	
	/**
	 * テーマID
	 * @var string
	 */
	private $themeId = NULL;
	public function setThemeId( $themeId ) {
		$this -> themeId = $themeId;
	}
	public function getThemeId() {
		return $this -> themeId;
	}
	
	/**
	 * お話
	 * @var string
	 */
	private $talk = NULL;
	public function setTalk( $talk ) {
		$this -> talk = $talk;
	}
	public function getTalk() {
		return $this -> talk;
	}
	
	/**
	 * お話タイプ
	 * @var string
	 */
	private $taklType = NULL;
	public function setTalkType( $talkType ) {
		$this -> talkType = $talkType;
	}
	public function getTalkType() {
		return $this -> talkType;
	}
	
	/**
	 * 画像シーケンスID
	 * @var int
	 */
	private $imgSeqId = NULL;
	public function setImgSeqId( $imgSeqId ) {
		$this -> imgSeqId = $imgSeqId;
	}
	public function getImgSeqId() {
		return $this -> imgSeqId;
	}
	
	/**
	 * お話日時
	 * @var string
	 */
	private $talkDate = NULL;
	public function setTalkDate( $talkDate ) {
		$this -> talkDate = $talkDate;
	}
	public function getTalkDate() {
		return $this -> talkDate;
	}
	
	/**
	 * コメントビーン配列
	 */
	private $commentBeanArray = array();
	public function setCommentBeanArray( $commentBeanArray ) {
		$this -> commentBeanArray = $commentBeanArray;
	}
	public function getCommentBeanArray() {
		return $this -> commentBeanArray;
	}
	
	
}