<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SourceCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SourceCodesTable Test Case
 */
class SourceCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SourceCodesTable
     */
    public $SourceCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.source_codes',
        'app.projects',
        'app.statuses',
        'app.studies',
        'app.users',
        'app.small_chapters',
        'app.middle_chapters',
        'app.big_chapters',
        'app.books',
        'app.analyses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SourceCodes') ? [] : ['className' => 'App\Model\Table\SourceCodesTable'];
        $this->SourceCodes = TableRegistry::get('SourceCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SourceCodes);

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
