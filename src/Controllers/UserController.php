<?php

namespace Testapp\Controllers;

use Testapp\Models\UserModel;
use Testapp\Domain\User\UserFactory;

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

        if (!$params->has('name')) {
			$params = ['errorMessage' => 'Name not provided.'];
			return $this->render('register.twig', $params);
		}

        $name = $params->getString('name');

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

        $newUser = UserFactory::factory($name, $email, $password);

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
			$user = $userModel->getUserByEmlAndPswd($email, $password);
		} catch (\Exception $e) {
			$this->log->warn('No such user: ' . $email . ', ' . $password);
			$params = ['errorMessage' => 'No such user.'];
			return $this->render('login.twig', $params);
		}

		setcookie('user', $user->getId());

        // The header() function sends a raw HTTP header to a client.
        header('Location: /');

        $newController = new PostController($this->di, $this->request);
		return $newController->getPostsByUser();
    }

    // Logout
    public function logout(): string {
        setcookie('user', "", time()-3600);

        header('Location: /');

        $newController = new PostController($this->di, $this->request);
		return $newController->getAllPosts();
    }

}

?>