<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnalysesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnalysesTable Test Case
 */
class AnalysesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnalysesTable
     */
    public $Analyses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.analyses',
        'app.users',
        'app.studies',
        'app.small_chapters',
        'app.middle_chapters',
        'app.big_chapters',
        'app.books',
        'app.statuses',
        'app.source_codes',
        'app.projects',
        'app.folders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Analyses') ? [] : ['className' => 'App\Model\Table\AnalysesTable'];
        $this->Analyses = TableRegistry::get('Analyses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Analyses);

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
