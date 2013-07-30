<?php
App::uses('PackageAddOn', 'Model');

/**
 * PackageAddOn Test Case
 *
 */
class PackageAddOnTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.package_add_on'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PackageAddOn = ClassRegistry::init('PackageAddOn');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PackageAddOn);

		parent::tearDown();
	}

}
