<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiddleChaptersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiddleChaptersTable Test Case
 */
class MiddleChaptersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiddleChaptersTable
     */
    public $MiddleChapters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.middle_chapters',
        'app.big_chapters',
        'app.books',
        'app.small_chapters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MiddleChapters') ? [] : ['className' => 'App\Model\Table\MiddleChaptersTable'];
        $this->MiddleChapters = TableRegistry::get('MiddleChapters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MiddleChapters);

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
