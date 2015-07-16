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

		$this->assertResponseOk();

		$response = $this->call('GET', '/frontend/home');

		$this->assertEquals(401, $response->getStatusCode());

	}

}
