<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TeamUserLinks Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TeamsTable&\Cake\ORM\Association\BelongsTo $Teams
 *
 * @method \App\Model\Entity\TeamUserLink get($primaryKey, $options = [])
 * @method \App\Model\Entity\TeamUserLink newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TeamUserLink[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TeamUserLink|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamUserLink saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamUserLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TeamUserLink[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TeamUserLink findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamUserLinksTable extends Table
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

		$this->setTable('team_user_links');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', ['foreignKey' => 'user_id', 'joinType' => 'INNER']);
		$this->belongsTo('Teams', ['foreignKey' => 'team_id', 'joinType' => 'INNER']);
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

		$validator->integer('status')->requirePresence('status', 'create')->notEmptyString('status');

		$validator->integer('role')->requirePresence('role', 'create')->notEmptyString('role');

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
		$rules->add($rules->existsIn(['team_id'], 'Teams'));

		return $rules;
	}
}
