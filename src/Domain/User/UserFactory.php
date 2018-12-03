<?php

namespace Testapp\Domain\User;

use Testapp\Domain\User;

class UserFactory {
	public static function factory(
	    string $username,
	    string $email,
	    string $password
	): User {
		$user = new User();
		$user->setUsername($username);
		$user->setEmail($email);
		$user->setPassword($password);

		return $user;
	}
}

?>
