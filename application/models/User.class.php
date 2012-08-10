<?php

require_once 'models/Img.class.php';
require_once 'models/Talk.class.php';
require_once 'models/bean/UserPersonalBean.class.php';
require_once 'models/db/trun/UserBasicData.class.php';
require_once 'models/db/trun/UserPersonalData.class.php';

/**
 * ユーザクラス
 * @author tadasuke
 */
class User{
	
	const ENTRY_RESULT_COMPLETE           = '0';
	const ENTRY_RESULT_MAIL_ADDRESS_ERROR = '1';
	
	const USER_BASIC_DATA_STATUS_PRE  = '0';
	const USER_BASIC_DATA_STATUS_TRUE = '1';
	
	/**
	 * ユーザID
	 * @var int
	 */
	private $userId = NULL;
	
	/**
	 * ユーザキー
	 * @var string
	 */
	private $userKey = NULL;
	public function getUserKey() {
		return $this -> userKey;
	}
	
	/**
	 * メールアドレス
	 * @var string
	 */
	private $mailAddress = NULL;
	public function getMailAddress() {
		return $this ->mailAddress;
	}
	
	/**
	 * 名前
	 * @var string
	 */
	private $name = NULL;
	public function getName() {
		return $this -> name;
	}
	
	/**
	 * プロフィール画像シーケンスID
	 * @var int
	 */
	private $profileImgSeqId = NULL;
	public function getProfileImgSeqId() {
		return $this -> profileImgSeqId;
	}
	
	/**
	 * プロフィール画像データ
	 * @var string
	 */
	private $profileImgData = NULL;
	public function getProfileImgData( $regetFlg = FALSE ) {
		if ( is_null( $this -> profileImgData ) === TRUE || $regetFlg === TRUE ) {
			$this -> setProfileImgData();
		} else {
			;
		}
		return $this -> profileImgData;
	}
	
	/**
	 * パーソナルデータビーン
	 * @var UserPersolanBean
	 */
	private $userPersonalBean = NULL;
	/**
	 * @return UserPersonalBean
	 */
	public function getUserPersonalBean() {
		return $this -> userPersonalBean;
	}
	
	/**
	 * 画像クラス
	 * @var Img
	 */
	private $imgClass = NULL;
	public function getImgClass( $regetFlg = FALSE ) {
		if ( is_null( $this -> imgClass ) === TRUE || $regetFlg === TRUE ) {
			$this -> imgClass = new Img( $this -> userId );
		} else {
			;
		}
		return $this -> imgClass;
	}
	
	/**
	 * お話クラス
	 * @var Talk
	 */
	private $talkClass = NULL;
	public function getTalkClass( $regetFlg = FALSE ) {
		if ( is_null( $this -> talkClass ) === TRUE || $regetFlg === TRUE ) {
			$this -> talkClass = new Talk( $this -> userId );
		} else {
			;
		}
		return $this -> talkClass;
	}
	
	/**
	 * コンストラクタ
	 * @param int $userId
	 */
	public function __construct( $userId ) {
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$this -> userId = $userId;
		
		// 基本データ設定
		$this -> setData();
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	/**
	 * プロフィール画像シーケンスID更新
	 * @param int $profileImgSeqId
	 */
	public function updateProfileImgSeqId( $profileImgSeqId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'profileImgSeqId:' . $profileImgSeqId );
		
		UserPersonalData::updateProfileImgSeqId( $this -> userId, $profileImgSeqId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	/**
	 * ユーザパーソナルデータ更新
	 * @param UserPersonalBean $userPersonalBean
	 */
	public function updateUserPersonalData( UserPersonalBean $userPersonalBean ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		UserPersonalData::_update(
			  $userPersonalBean -> getUserId()
			, $userPersonalBean -> getName()
			, $userPersonalBean -> getGender()
			, $userPersonalBean -> getBirthday()
			, $userPersonalBean -> getAddress()
			, $userPersonalBean -> getTelephoneNumber1()
			, $userPersonalBean -> getTelephoneNumber2()
		);
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
	
	//------------------------------------------- private -------------------------------------------
	
	
	/**
	 * ユーザデータ設定
	 */
	private function setData() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		//------------------
		// ユーザ基本データ取得
		//------------------
		$userBasicDataValueArray = UserBasicData::getDataByUserId( $this -> userId );
		$this -> userKey     = $userBasicDataValueArray[0]['user_key'];
		$this -> mailAddress = $userBasicDataValueArray[0]['mail_address'];
		
		//-----------------------
		// ユーザパーソナルデータ取得
		//-----------------------
		$userPersonalDataValueArray = UserPersonalData::getDataByUserId( $this -> userId );
		$name             = $userPersonalDataValueArray[0]['name'];
		$gender           = $userPersonalDataValueArray[0]['gender'];
		$birthday         = date( 'YmdHis', strtotime( $userPersonalDataValueArray[0]['birthday'] ) );
		$address          = $userPersonalDataValueArray[0]['address'];
		$telephoneNumber1 = $userPersonalDataValueArray[0]['telephone_number_1'];
		$telephoneNumber2 = $userPersonalDataValueArray[0]['telephone_number_2'];
		$profileImgSeqId  = $userPersonalDataValueArray[0]['profile_img_seq_id'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'             . $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'gender:'           . $gender );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthday:'         . $birthday );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'address:'          . $address );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber1:' . $telephoneNumber1 );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber2:' . $telephoneNumber2 );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'profileImgSeqId:'  . $profileImgSeqId );
		
		$userPersonalBean = new UserPersonalBean();
		$userPersonalBean -> setUserId( $this -> userId );
		$userPersonalBean -> setName( $name );
		$userPersonalBean -> setGender( $gender );
		$userPersonalBean -> setBirthday( $birthday );
		$userPersonalBean -> setAddress( $address );
		$userPersonalBean -> setTelephoneNumber1( $telephoneNumber1 );
		$userPersonalBean -> setTelephoneNumber2( $telephoneNumber2 );
		$userPersonalBean -> setProfileImgSeqId( $profileImgSeqId );
		
		$this -> name            = $name;
		$this -> profileImgSeqId = $profileImgSeqId;
		$this -> userPersonalBean = $userPersonalBean;
		
		// プロフィール画像シーケンスIDが取得できた場合は画像データを取得
		if ( strlen( $profileImgSeqId ) != 0 ) {
			$this -> profileImgData = $this -> getImgClass() -> getImgData( $profileImgSeqId );
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	/**
	 * プロフィール画像データ設定
	 */
	private function setProfileImgData() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		// プロフィール画像が設定されていた場合
		if ( strlen( $this -> profileImgSeqId ) != 0 ) {
			$this ->profileImgData = $this -> getImgClass() -> getImgData( $this -> profileImgSeqId );
		// プロフィール画像が設定されていなかった場合
		} else {
			$this -> profileImgData = readfile( Config::getConfig( 'system', 'non_profile_img' ) );
		}
		
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
	}
	
	
	//------------------------------------------- static --------------------------------------------
	
	
	/**
	 * メールアドレス存在チェック
	 * @param string $mailAddress
	 * @return boolean $result
	 */
	public static function checkMailAddress( $mailAddress ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		
		$valuArray = UserBasicData::getDataByMailAddress( $mailAddress );
		
		$result = (count( $valuArray ) > 0) ? TRUE : FALSE;
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $result;
	}
	
	
	/**
	 * ユーザID取得
	 * @param string $mailAddress
	 * @param string $password
	 * @return int $userId
	 */
	public static function getUserIdByMailAddress( $mailAddress, $password = NULL, $status = self::USER_BASIC_DATA_STATUS_TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		
		// パスワードが設定されていた場合はハッシュ化
		if ( is_null( $password ) === FALSE ) {
			$password = sha1( $password );
		} else {
			;
		}
		
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:' . $password );
		
		$userId = UserBasicData::getUserIdByMailAddress( $mailAddress, $password, $status );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
	
	/**
	 * ユーザID取得
	 * @param string $userKey
	 * @return int $userId
	 */
	public static function getUserIdByUserKey( $userKey, $status = self::USER_BASIC_DATA_STATUS_TRUE ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		$userId = UserBasicData::getUserIdByUesrKey( $userKey, $status );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
	/**
	 * ユーザキー取得
	 * ユーザIDを元にユーザキーを取得する
	 * @param int $userId
	 * @param string $userKey
	 */
	public static function getUserKeyByUserId( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$valueArray = UserBasicData::getDataByUserId( $userId );
		$userKey = $valueArray[0]['user_key'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userKey;
		
	}
	
	/**
	 * ユーザ名取得
	 * ユーザIDを元にユーザ名を取得する
	 * @param int $userId
	 * @param string $userName
	 */
	public static function getUserNameByUserId( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		$valueArray = UserPersonalData::getDataByUserId( $userId );
		$userName = $valueArray[0]['name'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userName:' . $userName );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userName;
		
	}
	
	
	/**
	 * 新規登録
	 * @param string $mailAddress
	 * @param string $password
	 * @param string $name
	 * @return string $userKey
	 */
	public static function newEntry( $mailAddress, $password, $name ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'password:'    . $password );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'name:'        . $name );
		
		//--------------------
		// パスワードをハッシュ化
		//--------------------
		$password = sha1( $password );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'password:' . $password );
		
		//---------
		// 新規登録
		//---------
		// ユーザ基本データ作成
		$userId = self::createUserBasicData( $mailAddress, $password );
		// ユーザキー更新
		$userKey = self::createUserKey( $userId );
		// ユーザパーソナルデータ作成
		self::createUserPersonalData( $userId, $name );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userKey;
		
	}
	
	
	/**
	 * 本登録
	 * @param string $userKey
	 * @return boolean $result
	 */
	public static function trueEntry( $userKey ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		// ユーザキーを元にユーザIDを取得
		$userId = User::getUserIdByUserKey( $userKey, self::USER_BASIC_DATA_STATUS_PRE );
		
		// ユーザIDが取得できなかった場合はエラー
		if ( strlen( $userId ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'user_key_error!!' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			return FALSE;
		} else {
			;
		}
		
		// ステータス更新
		UserBasicData::updateStatusByUserId( self::USER_BASIC_DATA_STATUS_TRUE, $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return TRUE;
		
	}
	
	
	/**
	 * ユーザ基本データ作成
	 * @param string $mailAddress
	 * @param string $password
	 * @return int $userId
	 */
	private static function createUserBasicData( $mailAddress, $password ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'mailAddress:' . $mailAddress );
		
		// データ作成
		$userId = UserBasicData::create( $mailAddress, $password, date( 'YmdHis' ), '0' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userId;
		
	}
	
	/**
	 * ユーザキーを作成し、更新する
	 * @param int $userId
	 * @return string $userKey
	 */
	private static function createUserKey( $userId ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		
		// ユーザIDを元にユーザキーを作成
		$userKey = sha1( $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userKey:' . $userKey );
		
		// ユーザキーを更新
		UserBasicData::updateUserKeyByUserId( $userKey, $userId );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		return $userKey;
		
	}
	
	/**
	 * ユーザパーソナルデータ作成
	 * @param int $userId
	 * @param string $name
	 */
	private static function createUserPersonalData( $userId, $name ) {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'userId:' . $userId );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'   . $name );
		
		UserPersonalData::_insert( $userId, $name, '0' );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
	}
	
}
