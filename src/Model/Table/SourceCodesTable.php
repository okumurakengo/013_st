<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SourceCodes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $SourceCodes
 * @property \Cake\ORM\Association\HasMany $Analyses
 * @property \Cake\ORM\Association\HasMany $SourceCodes
 *
 * @method \App\Model\Entity\SourceCode get($primaryKey, $options = [])
 * @method \App\Model\Entity\SourceCode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SourceCode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SourceCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SourceCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SourceCode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SourceCode findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SourceCodesTable extends Table
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

        $this->table('source_codes');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SourceCodes', [
            'foreignKey' => 'source_code_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Analyses', [
            'foreignKey' => 'source_code_id'
        ]);
        $this->hasMany('SourceCodes', [
            'foreignKey' => 'source_code_id'
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
            ->boolean('directory_flg')
            ->requirePresence('directory_flg', 'create')
            ->notEmpty('directory_flg');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('code');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['source_code_id'], 'SourceCodes'));

        return $rules;
    }
}
