<?php
App::uses('HotelRoom', 'Model');

/**
 * HotelRoom Test Case
 *
 */
class HotelRoomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.hotel_room',
		'app.hotel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->HotelRoom = ClassRegistry::init('HotelRoom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->HotelRoom);

		parent::tearDown();
	}

}
