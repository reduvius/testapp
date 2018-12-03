<?php

namespace Testapp\Controllers;

class HomeController extends AbstractController {
	// Get home page
	public function getHomePage(): string {
		$properties = [
			'isAuth' => $this->isAuthenticated()
		];
		return $this->render('home.twig', $properties);
	}
}

?>
