<?php

namespace Testapp\Controllers;

use Testapp\Models\UserModel;

class HomeController extends AbstractController {
	// Get home page
	public function getHomePage(): string {
		if ($this->returnUserCookie()) {
		    $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($this->returnUserCookie());

		    $properties = [
			    'user' => $user,
				'uId' => $this->returnUserCookie(),
			    'isAuth' => $this->isAuthenticated()
		    ];
		} else {
			$properties = [
			    'isAuth' => $this->isAuthenticated()
		    ];
		}
		return $this->render('home.twig', $properties);
	}
}

?>
