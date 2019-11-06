<?php
namespace TinyAuthBackend\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use TinyAuthBackend\Model\Entity\AllowRule;
use TinyAuthBackend\Model\Table\AllowRulesTable;

/**
 * TinyAuthBackend\Model\Table\TinyAuthAllowRulesTable Test Case
 */
class AllowRulesTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \TinyAuthBackend\Model\Table\AllowRulesTable
	 */
	public $AllowRules;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'plugin.TinyAuthBackend.TinyAuthAllowRules'
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('AllowRules') ? [] : ['className' => AllowRulesTable::class];
		$this->AllowRules = TableRegistry::getTableLocator()->get('AllowRules', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->AllowRules);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testSave() {
		$data = [
			'type' => AllowRule::TYPE_ALLOW,
			'path' => 'Foo::*',
		];
		$allowRule = $this->AllowRules->newEntity($data);

		$result = $this->AllowRules->save($allowRule);
		$this->assertTrue(!empty($result), print_r($allowRule->getErrors(), true));
		$this->assertInstanceOf(AllowRule::class, $result);
	}

	/**
	 * @return void
	 */
	public function testSaveAutoInflected() {
		$data = [
			'type' => AllowRule::TYPE_ALLOW,
			'path' => 'MyVendor/MyPlugin.my_prefix/my_sub_prefix/MyController::myAction',
		];
		$allowRule = $this->AllowRules->newEntity($data);

		$result = $this->AllowRules->save($allowRule);
		$this->assertTrue(!empty($result), print_r($allowRule->getErrors(), true));
		$this->assertInstanceOf(AllowRule::class, $result);

		$expected = 'MyVendor/MyPlugin.MyPrefix/MySubPrefix/MyController::myAction';
		$this->assertSame($expected, $result->path);
	}

}
