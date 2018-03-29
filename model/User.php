<?php

// used to store and use session variables
class User {
	public function login($user) {
		$_SESSION["user"] = $user;
	}
	public function logout() {
		session_destroy();
	}
	public function isLoggedIn() {
		return isset($_SESSION["user"]);
	}

	// STAT is user type!
	public function isLoggedInAsAdmin() {
		return $_SESSION["user"]["STAT"]==="admin";
	}
	public function isLoggedInAsStudentOfficer() {
		return $_SESSION["user"]["STAT"]==="1";
	}
	public function isLoggedInAsProfessor() {
		return $_SESSION["user"]["STAT"]==="2";
	}
	public function isLoggedInAsStudent() {
		return $_SESSION["user"]["STAT"]==="3";
	}
	public function getId() {
		return $_SESSION["user"]["ID_OSEBA"];
	}
	public function getTypeOfUser() {
		return $_SESSION["user"]["type"];
	}
}