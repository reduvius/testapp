<?php

namespace Testapp\Models;

use Testapp\Domain\User;
use PDO;

class UserModel extends AbstractModel {
	const CLASSNAME = '\Testapp\Domain\User';

    // Get user by id
	public function getUserById(int $id): User {
		$query = 'SELECT * FROM user WHERE id = :id';
		$sth = $this->db->prepare($query);
		$sth->execute(['id' => $id]);

		$user = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

		if (empty($user)) {
			throw new \Exception('User not found.');
		}

		return $user[0];
	}

    // Get user by both email and password
	public function getUserByEmAndPw(string $email, string $password): User {
		$query = <<<SQL
SELECT *
FROM user
WHERE email = :email AND password = :password
SQL;
		$sth = $this->db->prepare($query);
		$sth->bindValue('email', $email);
		$sth->bindValue('password', $password);
		$sth->execute();

		$user = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

		if (empty($user)) {
			throw new \Exception('User not found.');
		}

		return $user[0];
	}

    // Create new user
	public function createNewUser(User $user) {
		$query = <<<SQL
INSERT INTO user (date, username, email, password)
VALUES (NOW(), :username, :email, :password)
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('username', $user->getUsername());
        $sth->bindValue('email', $user->getEmail());
        $sth->bindValue('password', $user->getPassword());
        if (!$sth->execute()) {
			throw new \Exception($sth->errorInfo()[2]);
		}
	}
}

?>
