<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BigChaptersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BigChaptersTable Test Case
 */
class BigChaptersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BigChaptersTable
     */
    public $BigChapters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.big_chapters',
        'app.books',
        'app.middle_chapters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('BigChapters') ? [] : ['className' => 'App\Model\Table\BigChaptersTable'];
        $this->BigChapters = TableRegistry::get('BigChapters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BigChapters);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
