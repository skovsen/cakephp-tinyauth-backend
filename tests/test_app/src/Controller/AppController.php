<?php

namespace TestApp\Controller;

use Cake\Controller\Controller;

/**
 * Fake AppController for Integration tests.
 */
class AppController extends Controller {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Flash');
	}

}
