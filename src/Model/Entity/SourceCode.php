<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SourceCode Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $source_code_id
 * @property bool $directory_flg
 * @property string $name
 * @property string $code
 * @property int $display_order
 * @property bool $select_flg
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\SourceCode[] $source_codes
 * @property \App\Model\Entity\Analysis[] $analyses
 */
class SourceCode extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
