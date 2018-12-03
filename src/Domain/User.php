<?php

namespace Testapp\Domain;

class User {
	private $id;
	private $date;
	private $username;
	private $email;
	private $password;

	public function getId(): int {
		return $this->id;
	}

	public function getDate(): int {
		return $this->date;
	}

	public function getUsername(): string {
		return $this->username;
	}

	public function getEmail(): string {
		return $this->email;
	}

	public function getPassword(): string {
		return $this->password;
	}

	public function setId(int $id) {
		$this->id = $id;
	}

	public function setUsername(string $username) {
		$this->username = $username;
	}

	public function setEmail(string $email) {
		$this->email = $email;
	}

	public function setPassword(string $password) {
		$this->password = $password;
	}
}

?>
