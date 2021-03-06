<?php

/**
 * Tests
 *
 * @author maxleonov <maks.leonov@gmail.com>
 * @link http://book.cakephp.org/2.0/en/development/testing.html Format
 *
 * @package ClopeClustering
 * @subpackage Test
 */

/**
 * Tests
 *
 * @package ClopeClustering
 * @subpackage Test
 */
class ClopeTest extends CakeTestCase {

	/**
	 * {@inheritdoc}
	 */
	public function setUp() {
		parent::setUp();
		$this->Clope = ClassRegistry::init('ClopeClustering.Clope');
	}

	/**
	 * Test clustering algorithm
	 */
	public function testBasicFunctionality() {
		$transactions = array(
			array('a1', 'a2', 'a3'),
			array('a1', 'a2', 'a3', 'a4'),
			array('a1', 'a2', 'a3', 'a4'),
			array('a5', 'a6', 'a7'),
			array('a5', 'a6', 'a7'),
			array('a8', 'a9', 'a10'),
			array('a8', 'a9', 'a10'),
			array('a8', 'a9', 'a10', 'a11'),
			array('a8', 'a9', 'a10', 'a12'),
		);

		$params = array(
			'repulsion' => 2.0,
		);

		$result = $this->Clope->clusterize($transactions, $params);

		$expected = array(
			(int)1 => array(
				(int)0 => array(
					(int)0 => 'a1',
					(int)1 => 'a2',
					(int)2 => 'a3'
				),
				(int)1 => array(
					(int)0 => 'a1',
					(int)1 => 'a2',
					(int)2 => 'a3',
					(int)3 => 'a4'
				),
				(int)2 => array(
					(int)0 => 'a1',
					(int)1 => 'a2',
					(int)2 => 'a3',
					(int)3 => 'a4'
				)
			),
			(int)2 => array(
				(int)3 => array(
					(int)0 => 'a5',
					(int)1 => 'a6',
					(int)2 => 'a7'
				),
				(int)4 => array(
					(int)0 => 'a5',
					(int)1 => 'a6',
					(int)2 => 'a7'
				)
			),
			(int)3 => array(
				(int)5 => array(
					(int)0 => 'a8',
					(int)1 => 'a9',
					(int)2 => 'a10'
				),
				(int)6 => array(
					(int)0 => 'a8',
					(int)1 => 'a9',
					(int)2 => 'a10'
				),
				(int)7 => array(
					(int)0 => 'a8',
					(int)1 => 'a9',
					(int)2 => 'a10',
					(int)3 => 'a11'
				),
				(int)8 => array(
					(int)0 => 'a8',
					(int)1 => 'a9',
					(int)2 => 'a10',
					(int)3 => 'a12'
				)
			)
		);

		$this->assertEqual($result, $expected);
	}

	/**
	 * Test clustering algorithm when running multiple times sequentially
	 */
	public function testExecuteMultipleTimes() {
		// 1-st execution
		$transactions = array(
			array('a1', 'a2', 'a3'),
			array('a8', 'a9', 'a10', 'a12'),
		);

		$params = array(
			'repulsion' => 2.0,
		);

		$result = $this->Clope->clusterize($transactions, $params);

		$expected = array(
			(int)1 => array(
				(int)0 => array(
					(int)0 => 'a1',
					(int)1 => 'a2',
					(int)2 => 'a3'
				)
			),
			(int)2 => array(
				(int)1 => array(
					(int)0 => 'a8',
					(int)1 => 'a9',
					(int)2 => 'a10',
					(int)3 => 'a12'
				)
			)
		);
		$this->assertEqual($result, $expected);

		// 2-nd execution
		$transactions = array(
			array('a11', 'a12', 'a13'),
			array('a18', 'a19', 'a10', 'a12'),
		);

		$params = array(
			'repulsion' => 2.0,
		);

		$result = $this->Clope->clusterize($transactions, $params);

		$expected = array(
			(int)1 => array(
				(int)0 => array(
					(int)0 => 'a11',
					(int)1 => 'a12',
					(int)2 => 'a13'
				)
			),
			(int)2 => array(
				(int)1 => array(
					(int)0 => 'a18',
					(int)1 => 'a19',
					(int)2 => 'a10',
					(int)3 => 'a12'
				)
			)
		);

		$this->assertEqual($result, $expected);

		// 3-rd execution
		$transactions = array(
			array('a11', 'a12', 'a13'),
			array('a1', 'a1', 'a10', 'a12'),
		);

		$params = array(
			'repulsion' => 2.0,
		);

		$result = $this->Clope->clusterize($transactions, $params);

		$expected = array(
			(int)1 => array(
				(int)0 => array(
					(int)0 => 'a11',
					(int)1 => 'a12',
					(int)2 => 'a13'
				)
			),
			(int)2 => array(
				(int)1 => array(
					(int)0 => 'a1',
					(int)1 => 'a1',
					(int)2 => 'a10',
					(int)3 => 'a12'
				)
			)
		);

		$this->assertEqual($result, $expected);
	}

}
