<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnalysesFixture
 *
 */
class AnalysesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'ユーザーID', 'precision' => null, 'autoIncrement' => null],
        'source_code_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'ソースコードID', 'precision' => null, 'autoIncrement' => null],
        'status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => 'ステータスID', 'precision' => null, 'autoIncrement' => null],
        'content' => ['type' => 'string', 'length' => 3000, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '内容', 'precision' => null, 'fixed' => null],
        'display_order' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '表示順', 'precision' => null, 'autoIncrement' => null],
        'select_flg' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '有効フラグ', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '作成日', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '変更日', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'source_code_id' => 1,
            'status_id' => 1,
            'content' => 'Lorem ipsum dolor sit amet',
            'display_order' => 1,
            'select_flg' => 1,
            'created' => '2017-05-05 03:23:19',
            'modified' => '2017-05-05 03:23:19'
        ],
    ];
}
