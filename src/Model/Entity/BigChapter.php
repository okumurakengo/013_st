<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BigChapter Entity
 *
 * @property int $id
 * @property int $book_id
 * @property string $title
 * @property int $display_order
 * @property bool $select_flg
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Book $book
 * @property \App\Model\Entity\MiddleChapter[] $middle_chapters
 */
class BigChapter extends Entity
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
