<?php

require_once 'models/bean/UserPersonalBean.class.php';

class UserController extends AfterLoginCommonAction{
	
	/**
	 * ユーザパーソナルデータ更新ページ表示
	 */
	public function viewUserDataUpdatePageAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		$this -> _smarty -> display( 'user_data_update_page.tpl' );
		
	}
	
	
	/**
	 * プロフィールデータ取得
	 */
	public function getProfileDataAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$userPersonalBean = $this -> userClass -> getUserPersonalBean();
		
		$name             = $userPersonalBean -> getName();
		$gender           = $userPersonalBean -> getGender();
		$birthday         = $userPersonalBean -> getBirthday();
		$address          = $userPersonalBean -> getAddress();
		$telephoneNumber1 = $userPersonalBean -> getTelephoneNumber1();
		$telephoneNumber2 = $userPersonalBean -> getTelephoneNumber2();
		
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'             . $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'gender:'           . $gender );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthday:'         . $birthday );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'address:'          . $address );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber1:' . $telephoneNumber1 );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber2:' . $telephoneNumber2 );
		
		// 生年月日設定
		$birthdayYear  = '';
		$birthdayMonth = '';
		$birthdayDay   = '';
		
		if ( strlen( $birthday ) > 0 ) {
			$birthdayYear  = date( 'Y', strtotime( $birthday ) );
			$birthdayMonth = date( 'n', strtotime( $birthday ) );
			$birthdayDay   = date( 'j', strtotime( $birthday ) );
		} else {
			;
		}
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthdayYear:'  . $birthdayYear );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthdayMonth:' . $birthdayMonth );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthdayDay:'   . $birthdayDay );
		
		$userPersonalData = array(
		
			  'name'             => $name
			, 'gender'           => $gender
			, 'birthdayYear'     => $birthdayYear
			, 'birthdayMonth'    => $birthdayMonth
			, 'birthdayDay'      => $birthdayDay
			, 'address'          => (is_null( $address ) === TRUE) ? '' : $address
			, 'telephoneNumber1' => $telephoneNumber1
			, 'telephoneNumber2' => $telephoneNumber2
		);
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		header( 'Content-type: application/json' );
		echo( json_encode( $userPersonalData ) );
		
	}
	
	
	/**
	 * パーソナルデータ更新
	 */
	public function updatePersonalDataAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$name             = $this -> paramArray['name'];
		$gender           = $this -> paramArray['gender'];
		$year             = $this -> paramArray['year'];
		$month            = $this -> paramArray['month'];
		$day              = $this -> paramArray['day'];
		$address          = $this -> paramArray['address'];
		$telephoneNumber1 = $this -> paramArray['telephone_number_1'];
		$telephoneNumber2 = $this -> paramArray['telephone_number_2'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'name:'             . $name );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'gender:'           . $gender );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'year:'             . $year );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'month:'            . $month );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'day:'              . $day );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber1:' . $telephoneNumber1 );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'telephoneNumber2:' . $telephoneNumber2 );
		
		$month = sprintf( '%02d', $month );
		$day   = sprintf( '%02d', $day );
		$birthday = $year . $month . $day;
		if ( (int)$birthday == 0 ) {
			$birthday = NULL;
		} else {
			;
		}
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthday:' . $birthday );
		
		$gender           = (strlen( $gender ) == 0)           ? NULL : $gender;
		$address          = (strlen( $address ) == 0)          ? NULL : $address;
		$telephoneNumber1 = (strlen( $telephoneNumber1 ) == 0) ? NULL : $telephoneNumber1;
		$telephoneNumber2 = (strlen( $telephoneNumber2 ) == 0) ? NULL : $telephoneNumber2;
		
		$userPersonaBean = new UserPersonalBean();
		$userPersonaBean -> setUserId( $this -> userId );
		$userPersonaBean -> setName( $name );
		$userPersonaBean -> setGender( $gender );
		$userPersonaBean -> setBirthday( $birthday );
		$userPersonaBean -> setAddress( $address );
		$userPersonaBean -> setTelephoneNumber1( $telephoneNumber1 );
		$userPersonaBean -> setTelephoneNumber2( $telephoneNumber2 );
		
		$this -> userClass -> updateUserPersonalData( $userPersonaBean );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		// リダイレクト
		$this -> redirect( '/user/view-user-data-update-page' );
		
	}
	
	
	/**
	 * ユーザプロフィールページ表示
	 */
	public function viewProfileAction() {
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'START' );
		
		$targetUserKey = $this -> paramArray['user_key'];
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserKey:' . $targetUserKey );
		
		//----------------------------------
		// 自分自身の場合は更新ページにリダイレクト
		//----------------------------------
		if ( strcmp( $targetUserKey, $this -> userKey ) == 0 ) {
			OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'myself' );
			OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
			$this -> redirect( '/user/view-user-data-update-page' );
			return;
		} else {
			;
		}
		
		$targetUserId = User::getUserIdByUserKey( $targetUserKey );
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'targetUserId:' . $targetUserId );
		
		// ユーザパーソナルデータを取得
		$userPersonalBean = UserFactory::get( $targetUserId ) -> getUserPersonalBean();
		
		// 生年月日を整形
		$birthDay = $userPersonalBean -> getBirthday();
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'birthday:' . $birthday );
		
		$year  = date( 'Y', strtotime( $birthDay ) );
		$month = date( 'm', strtotime( $birthDay ) );
		$day   = date( 'd', strtotime( $birthDay ) );
		
		OutputLog::outLog( OutputLog::DEBUG, __METHOD__, __LINE__, 'address:' . $userPersonalBean -> getAddress() );
		
		$personalDataArray = array(
			  'user_id'  => $targetUserId
			, 'user_key' => $targetUserKey
			, 'name'     => $userPersonalBean -> getName()
			, 'gender'   => $userPersonalBean -> getGender()
			, 'address'  => $userPersonalBean -> getAddress()
			, 'telephone_number_1' => $userPersonalBean -> getTelephoneNumber1()
			, 'telephone_number_2' => $userPersonalBean -> getTelephoneNumber2()
			, 'year'               => $year
			, 'month'              => $month
			, 'day'                => $day
		);
		
		$this -> _smarty -> assign( 'personal_data', $personalDataArray );
		
		OutputLog::outLog( OutputLog::INFO, __METHOD__, __LINE__, 'END' );
		
		$this -> _smarty -> display( 'user_data_page.tpl' );
		
	}
	
}