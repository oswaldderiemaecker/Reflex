<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());

		$this->call('GET', '/auth/login');

        $this->assertEquals(200, $response->getStatusCode());

        $this->visit('/')
            ->see('Qué es Réflex 360°?');

        $this->visit('/auth/login')
            ->see('Iniciar Sesión');
	}
}
