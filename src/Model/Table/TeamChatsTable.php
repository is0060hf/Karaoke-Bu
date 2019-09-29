<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TeamChats Model
 *
 * @method \App\Model\Entity\TeamChat get($primaryKey, $options = [])
 * @method \App\Model\Entity\TeamChat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TeamChat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TeamChat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamChat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamChat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TeamChat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TeamChat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamChatsTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('team_chats');
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

		$validator->integer('dest_team')->requirePresence('dest_team', 'create')->notEmptyString('dest_team');

		$validator->scalar('context')->maxLength('context', 256)->requirePresence('context', 'create')
			->notEmptyString('context');

		return $validator;
	}
}
