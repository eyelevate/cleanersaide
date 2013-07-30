<?php
App::uses('Reservation', 'Model');

/**
 * Reservation Test Case
 *
 */
class ReservationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.reservation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Reservation = ClassRegistry::init('Reservation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Reservation);

		parent::tearDown();
	}

}
