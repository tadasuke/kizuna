<?php

require_once 'models/db/trun/ImgData.class.php';

class Img {
	
	const IMG_TYPE_IMAGE = '1';
	const IMG_TYPE_VIDEO = '2';
	
	/**
	 * @var int $userId
	 */
	private $userId;
	
	public function __construct( $userId ) {
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$this -> userId = $userId;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	/**
	 * プロフィール画像取得
	 */
	public function getProfileImg() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$imgValueArray = ImgData::getDataByUserId( $this -> userId, self::PROFILE_IMG_FLG_TRUE );
		
		//--------------------------------
		// プロフィール画像が取得できなかった場合
		//--------------------------------
		if ( count( $imgValueArray ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_profile_img' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return NULL;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $imgValueArray[0]['img'];
		
	}
	
	
	/**
	 * 画像データインサート
	 * @param string $filePath
	 * @return int $imgSeqId
	 */
	public function insertImgData( $filePath, $type ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'filePath:' . $filePath );
		
		//-------------------
		// 画像データをインサート
		//-------------------
		$imgSeqId = ImgData::_insert( $this -> userId, file_get_contents( $filePath ), $type );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		return $imgSeqId;
		
	}
	
	//---------------------------------------------------- static --------------------------------------
	
	/**
	 * 画像データ取得
	 * @param int $imgSeqId
	 */
	public static function getImgData( $imgSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		$valueArray = ImgData::getDataBySeqId( $imgSeqId );
		
		// 画像データが取得できなかった場合
		if ( count( $valueArray ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'no_img_data' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return NULL;
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray[0]['img'];
		
	}
	
	
	/**
	 * タイプ取得
	 * @param unknown_type $imgSeqId
	 */
	public static function getType( $imgSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'imgSeqId:' . $imgSeqId );
		
		$valueArray = ImgData::getDataBySeqId( $imgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $valueArray[0]['type'];
		
	}
	
}