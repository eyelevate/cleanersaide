<?php
/**
 * HotelRoomFixture
 *
 */
class HotelRoomFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'images' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'occupancy_base' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'occupancy_max' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'plus_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '11,2'),
		'valid_start' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'valid_end' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'net' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '11,2'),
		'tax_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '9,4'),
		'room_fee' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '11,2'),
		'payable' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '11,2'),
		'markup' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '9,2'),
		'exchange_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '9,2'),
		'sale' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '11,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'hotel_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'images' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'occupancy_base' => 1,
			'occupancy_max' => 1,
			'plus_fee' => 1,
			'valid_start' => '2012-10-31 15:06:30',
			'valid_end' => '2012-10-31 15:06:30',
			'net' => 1,
			'tax_rate' => 1,
			'room_fee' => 1,
			'payable' => 1,
			'markup' => 1,
			'exchange_rate' => 1,
			'sale' => 1
		),
	);

}
