<?php

class CommentBean{
	
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
	 * トークシーケンスID
	 * @var int
	 */
	private $talkSeqId = NULL;
	public function setTalkSeqId( $talkSeqId ) {
		$this -> talkSeqId = $talkSeqId;
	}
	public function getTalkSeqId() {
		return $this -> talkSeqId;
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
	 * トーク
	 * @var string
	 */
	private $comment = NULL;
	public function setComment( $comment ) {
		$this -> comment = $comment;
	}
	public function getComment() {
		return $this -> comment;
	}
	
	/**
	 * コメント日時
	 * @var string
	 */
	private $commentDate = NULL;
	public function setCommentDate( $commentDate ) {
		$this -> commentDate = $commentDate;
	}
	public function getCommentDate() {
		return $this -> commentDate;
	}
	
}