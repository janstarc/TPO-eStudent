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
	public function isLoggedInAsAdmin() {
		return $_SESSION["user"]["VRSTA_VLOGE"]==="a";
	}
	public function isLoggedInAsStudentOfficer() {
		return $_SESSION["user"]["VRSTA_VLOGE"]==="r";
	}
	public function isLoggedInAsProfessor() {
		return $_SESSION["user"]["VRSTA_VLOGE"]==="p";
	}
	public function isLoggedInAsStudent() {
		return $_SESSION["user"]["VRSTA_VLOGE"]==="s";
	}
	public function isLoggedInAsCandidate() {
		return $_SESSION["user"]["VRSTA_VLOGE"]==="k";
	}
	public function getId() {
		return (int)$_SESSION["user"]["ID_OSEBA"];
	}
	public function getTypeOfUser() {
		return $_SESSION["user"]["VRSTA_VLOGE"];
	}
}