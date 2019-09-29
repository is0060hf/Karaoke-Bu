<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserChats Model
 *
 * @method \App\Model\Entity\UserChat get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserChat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserChat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserChat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserChat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserChat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserChat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserChat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserChatsTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('user_chats');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator->integer('id')->allowEmptyString('id', null, 'create');

		$validator->integer('src_user')->requirePresence('src_user', 'create')->notEmptyString('src_user');

		$validator->integer('dest_user')->requirePresence('dest_user', 'create')->notEmptyString('dest_user');

		$validator->scalar('context')->maxLength('context', 256)->requirePresence('context', 'create')
			->notEmptyString('context');

		return $validator;
	}
}
