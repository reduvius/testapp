<?php

namespace Testapp\Controllers;

use Testapp\Models\UserModel;
use Testapp\Domain\User\UserFactory;
use Testapp\Controllers\HomeController;

class UserController extends AbstractController {
    // Get registration form
    public function getRegisterForm(): string {
        return $this->render('register.twig', []);
	}

    // Register new user
	public function register(): string {
        if (!$this->request->isPost()) {
			return $this->render('register.twig', []);
		}

        $params = $this->request->getParams();

        if (!$params->has('username')) {
			$params = ['errorMessage' => 'Username not provided.'];
			return $this->render('register.twig', $params);
		}

        $username = $params->getString('username');

        if (!$params->has('email')) {
			$params = ['errorMessage' => 'No email provided.'];
			return $this->render('register.twig', $params);
		}

        $email = $params->getString('email');

        if (!$params->has('password')) {
			$params = ['errorMessage' => 'No password provided.'];
			return $this->render('register.twig', $params);
		}

        $password = $params->getString('password');

        $newUser = UserFactory::factory($username, $email, $password);

        $userModel = new UserModel($this->db);

        try {
            $userModel->createNewUser($newUser);
        } catch (\Exception $e) {
			$this->log->warn('Error: failed to create user');
			$params = ['errorMessage' => 'Error: failed to create user.'];
			return $this->render('register.twig', $params);
		}

        return $this->getLoginForm();
    }

    // Get login form
	public function getLoginForm(): string {
        return $this->render('login.twig', []);
	}

    // Login user
	public function login(): string {
		if (!$this->request->isPost()) {
			return $this->render('login.twig', []);
		}

		$params = $this->request->getParams();

		if (!$params->has('email')) {
			$params = ['errorMessage' => 'No email provided.'];
			return $this->render('login.twig', $params);
		}

        $email = $params->getString('email');

        if (!$params->has('password')) {
			$params = ['errorMessage' => 'No password provided.'];
			return $this->render('login.twig', $params);
		}

		$password = $params->getString('password');

        $userModel = new UserModel($this->db);

		try {
			$user = $userModel->getUserByEmAndPw($email, $password);
		} catch (\Exception $e) {
			$this->log->warn('No such user: ' . $email . ', ' . $password);
			$params = ['errorMessage' => 'Error logging you in.'];
			return $this->render('login.twig', $params);
		}

		setcookie('user', $user->getId());

        // The header() function sends a raw HTTP header to a client.
        header('Location: /');
    }

    // Logout
    public function logout(): string {
        setcookie('user', "", time()-3600);

        header('Location: /');
    }

    // Search for users by username
	public function search(): string {
        if (!$this->isAuthenticated()) {
            $params = [
    			'loginMessage' => 'Please Sign In.',
    		    'isAuth' => $this->isAuthenticated()
    		];
    		return $this->render('login.twig', $params);
        }

		$username = $this->request->getParams()->getString('username');

		$userModel = new UserModel($this->db);

		try {
			$users = $userModel->search($username);
		} catch (\Exception $e) {
			$params = [
				'errorMessage' => $e->getMessage(),
				'isAuth' => $this->isAuthenticated()
			];
			return $this->render('results.twig', $params);
		}

		$properties = [
			'users' => $users,
			'isAuth' => $this->isAuthenticated(),
			'uId' => $this->returnUserCookie()
		];
		return $this->render('results.twig', $properties);
	}

}

?>
