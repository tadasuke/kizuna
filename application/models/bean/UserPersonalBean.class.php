<?php

class UserPersonalBean {
	
	private $userId = NULL;
	public function setUserId( $userId ) {
		$this -> userId = $userId;
	}
	public function getUserId() {
		return $this -> userId;
	}
	
	private $name = NULL;
	public function setName( $name ) {
		$this -> name = $name;
	}
	public function getName() {
		return $this -> name;
	}
	
	private $gender = NULL;
	public function setGender( $gender ) {
		$this -> gender = $gender;
	}
	public function getGender() {
		return $this -> gender;
	}
	
	private $birthday = NULL;
	public function setBirthday( $birthday ) {
		$this -> birthday = $birthday;
	}
	public function getBirthday() {
		return $this -> birthday;
	}
	
	private $address = NULL;
	public function setAddress( $address ) {
		$this -> address = $address;
	}
	public function getAddress() {
		return $this -> address;
	}
	
	private $telephoneNumber1 = NULL;
	public function setTelephoneNumber1( $telephoneNumber1 ) {
		$this -> telephoneNumber1 = $telephoneNumber1;
	}
	public function getTelephoneNumber1() {
		return $this -> telephoneNumber1;
	}
	
	private $telephoneNumber2 = NULL;
	public function setTelephoneNumber2( $telephoneNumber2 ) {
		$this -> telephoneNumber2 = $telephoneNumber2;
	}
	public function getTelephoneNumber2() {
		return $this -> telephoneNumber2;
	}
	
	private $profileImgSeqId = NULL;
	public function setProfileImgSeqId( $profileImgSeqId ) {
		$this -> profileImgSeqId = $profileImgSeqId;
	}
	public function getProfileImgSeqId() {
		return $this -> profileImgSeqId;
	}
	
	
}