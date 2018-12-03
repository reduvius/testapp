<?php

namespace Testapp\Utils;

class DependencyInjector {
	private $dependencies = [];

	// Set new dependency
	public function set(string $name, $object) {
		$this->dependencies[$name] = $object;
	}

	// Get dependency from $dependencies array
	public function get(string $name) {
		if (!isset($this->dependencies[$name])) {
		    throw new \Exception(
		        $name . ' dependency not found.'
		    );
		}
		return $this->dependencies[$name];
	}
}

?>
