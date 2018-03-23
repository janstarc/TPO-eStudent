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
		return $_SESSION["user"]["type"]==="admin";
	}
	public function isLoggedInAsStudentOfficer() {
		return $_SESSION["user"]["type"]==="office";
	}
	public function isLoggedInAsProfessor() {
		return $_SESSION["user"]["type"]==="professor";
	}
	public function isLoggedInAsStudent() {
		return $_SESSION["user"]["type"]==="student";
	}
	public function getId() {
		return $_SESSION["user"]["uid"];
	}
	public function getTypeOfUser() {
		return $_SESSION["user"]["type"];
	}
}