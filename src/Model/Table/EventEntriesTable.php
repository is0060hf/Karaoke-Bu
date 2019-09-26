<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventEntries Model
 *
 * @property \App\Model\Table\EventsTable&\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EventEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventEntry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventEntry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventEntry findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventEntriesTable extends Table
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

		$this->setTable('event_entries');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Events', ['foreignKey' => 'event_id', 'joinType' => 'INNER']);
		$this->belongsTo('Users', ['foreignKey' => 'user_id', 'joinType' => 'INNER']);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator)
	{
		$validator->integer('id')->allowEmptyString('id', null, 'create');

		$validator->scalar('introduction')->maxLength('introduction', 256)->requirePresence('introduction', 'create')
			->notEmptyString('introduction');

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
		$rules->add($rules->existsIn(['event_id'], 'Events'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));

		return $rules;
	}
}
