<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Study Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $small_chapter_id
 * @property int $status_id
 * @property string $content
 * @property string $memo
 * @property int $display_order
 * @property bool $select_flg
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\SmallChapter $small_chapter
 * @property \App\Model\Entity\Status $status
 */
class Study extends Entity
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
