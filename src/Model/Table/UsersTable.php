<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\EventCommentsTable&\Cake\ORM\Association\HasMany $EventComments
 * @property \App\Model\Table\EventEntriesTable&\Cake\ORM\Association\HasMany $EventEntries
 * @property \App\Model\Table\EventsTable&\Cake\ORM\Association\HasMany $Events
 * @property \App\Model\Table\TeamPostsTable&\Cake\ORM\Association\HasMany $TeamPosts
 * @property \App\Model\Table\TeamUserLinksTable&\Cake\ORM\Association\HasMany $TeamUserLinks
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

		$this->setTable('users');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->hasMany('EventComments', ['foreignKey' => 'user_id']);
		$this->hasMany('EventEntries', ['foreignKey' => 'user_id']);
		$this->hasMany('Events', ['foreignKey' => 'user_id']);
		$this->hasMany('TeamPosts', ['foreignKey' => 'user_id']);
		$this->hasMany('TeamUserLinks', ['foreignKey' => 'user_id']);
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

		$validator->scalar('login_name')->maxLength('login_name', 32)->requirePresence('login_name', 'create')
			->notEmptyString('login_name')->add('login_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator->scalar('password')->maxLength('password', 256)->requirePresence('password', 'create')
			->notEmptyString('password');

		$validator->scalar('nick_name')->maxLength('nick_name', 64)->requirePresence('nick_name', 'create')
			->notEmptyString('nick_name')->add('nick_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

		$validator->scalar('mail_address')->maxLength('mail_address', 256)->requirePresence('mail_address', 'create')
			->notEmptyString('mail_address');

		$validator->scalar('introduction')->maxLength('introduction', 128)->requirePresence('introduction', 'create')
			->notEmptyString('introduction');

		$validator->integer('role')->notEmptyString('role');

		$validator->boolean('official_flg')->notEmptyString('official_flg');

		$validator->boolean('auth_flg')->notEmptyString('auth_flg');

		$validator->scalar('uuid')->maxLength('uuid', 256)->allowEmptyString('uuid');

		$validator->scalar('icon_image_path')->maxLength('icon_image_path', 512)->allowEmptyFile('icon_image_path');

		$validator->scalar('cover_image_path')->maxLength('cover_image_path', 512)->allowEmptyFile('cover_image_path');

		$validator->integer('region')->allowEmptyString('region');

		$validator->integer('prefecture')->allowEmptyString('prefecture');

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
		$rules->add($rules->isUnique(['login_name']));
		$rules->add($rules->isUnique(['nick_name']));

		return $rules;
	}
}
