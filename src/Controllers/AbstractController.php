<?php

namespace Testapp\Controllers;

use Testapp\Utils\DependencyInjector;
use Testapp\Core\Request;

abstract class AbstractController {
	protected $request;
	protected $di;
	protected $db;
    protected $log;
    protected $view;
	protected $config;
	protected $userId;

	public function __construct(
	    DependencyInjector $di,
	    Request $request
	) {
		$this->request = $request;
		$this->di = $di;

		$this->db = $di->get('PDO');
		$this->log = $di->get('Logger');
		$this->view = $di->get('Twig_Environment');
		$this->config = $di->get('Config');
	}

    // Set user id
	public function setUserId(int $userId) {
		$this->userId = $userId;
	}

    // Render twig template view
	protected function render(string $template, array $params): string {
		return $this->view->loadTemplate($template)->render($params);
	}

    // Is user authenticated?
	public function isAuthenticated(): bool {
        return $this->request->getCookies()->getInt('user');
    }

    // Return user id cookie
	public function returnUserCookie(): int {
		return $this->request->getCookies()->getInt('user');
	}
}

?>
