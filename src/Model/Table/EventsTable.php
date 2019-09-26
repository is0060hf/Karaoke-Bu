<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\EventCommentsTable&\Cake\ORM\Association\HasMany $EventComments
 * @property \App\Model\Table\EventEntriesTable&\Cake\ORM\Association\HasMany $EventEntries
 *
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventsTable extends Table
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

		$this->setTable('events');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', ['foreignKey' => 'user_id', 'joinType' => 'INNER']);
		$this->hasMany('EventComments', ['foreignKey' => 'event_id']);
		$this->hasMany('EventEntries', ['foreignKey' => 'event_id']);
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

		$validator->scalar('title')->maxLength('title', 256)->requirePresence('title', 'create')->notEmptyString('title');

		$validator->scalar('body')->maxLength('body', 4294967295)->requirePresence('body', 'create')
			->notEmptyString('body');

		$validator->scalar('entry_template')->maxLength('entry_template', 4294967295)->allowEmptyString('entry_template');

		$validator->scalar('drink')->maxLength('drink', 64)->allowEmptyString('drink');

		$validator->scalar('food')->maxLength('food', 64)->allowEmptyString('food');

		$validator->dateTime('start_time')->requirePresence('start_time', 'create')->notEmptyDateTime('start_time');

		$validator->dateTime('end_time')->requirePresence('end_time', 'create')->notEmptyDateTime('end_time');

		$validator->integer('budget')->requirePresence('budget', 'create')->notEmptyString('budget');

		$validator->dateTime('deadline')->requirePresence('deadline', 'create')->notEmptyDateTime('deadline');

		$validator->dateTime('entry_date')->requirePresence('entry_date', 'create')->notEmptyDateTime('entry_date');

		$validator->integer('limited_range')->requirePresence('limited_range', 'create')->notEmptyString('limited_range');

		$validator->integer('number_of_people')->requirePresence('number_of_people', 'create')
			->notEmptyString('number_of_people');

		$validator->integer('region')->requirePresence('region', 'create')->notEmptyString('region');

		$validator->integer('prefecture')->requirePresence('prefecture', 'create')->notEmptyString('prefecture');

		$validator->scalar('phone_number')->maxLength('phone_number', 64)->requirePresence('phone_number', 'create')
			->notEmptyString('phone_number');

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
		$rules->add($rules->existsIn(['user_id'], 'Users'));

		return $rules;
	}
}
