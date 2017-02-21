<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmallChapters Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MiddleChapters
 * @property \Cake\ORM\Association\HasMany $Studies
 *
 * @method \App\Model\Entity\SmallChapter get($primaryKey, $options = [])
 * @method \App\Model\Entity\SmallChapter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SmallChapter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SmallChapter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SmallChapter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SmallChapter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SmallChapter findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SmallChaptersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('small_chapters');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MiddleChapters', [
            'foreignKey' => 'middle_chapter_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Studies', [
            'foreignKey' => 'small_chapter_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->integer('display_order')
            ->requirePresence('display_order', 'create')
            ->notEmpty('display_order');

        $validator
            ->boolean('select_flg')
            ->requirePresence('select_flg', 'create')
            ->notEmpty('select_flg');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['middle_chapter_id'], 'MiddleChapters'));

        return $rules;
    }
}
