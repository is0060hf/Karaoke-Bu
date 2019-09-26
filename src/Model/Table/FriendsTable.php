<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Friends Model
 *
 * @method \App\Model\Entity\Friend get($primaryKey, $options = [])
 * @method \App\Model\Entity\Friend newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Friend[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Friend|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Friend saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Friend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Friend[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Friend findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FriendsTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('friends');
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

		$validator->integer('src_friend')->requirePresence('src_friend', 'create')->notEmptyString('src_friend');

		$validator->integer('dest_friend')->requirePresence('dest_friend', 'create')->notEmptyString('dest_friend');

		return $validator;
	}
}
