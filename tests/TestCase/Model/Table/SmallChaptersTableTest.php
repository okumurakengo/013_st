<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmallChaptersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmallChaptersTable Test Case
 */
class SmallChaptersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SmallChaptersTable
     */
    public $SmallChapters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.small_chapters',
        'app.middle_chapters',
        'app.big_chapters',
        'app.books',
        'app.studies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SmallChapters') ? [] : ['className' => 'App\Model\Table\SmallChaptersTable'];
        $this->SmallChapters = TableRegistry::get('SmallChapters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmallChapters);

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
