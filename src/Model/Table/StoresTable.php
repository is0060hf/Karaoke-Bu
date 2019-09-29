<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stores Model
 *
 * @property \App\Model\Table\StoreImagesTable&\Cake\ORM\Association\HasMany $StoreImages
 *
 * @method \App\Model\Entity\Store get($primaryKey, $options = [])
 * @method \App\Model\Entity\Store newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Store[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Store|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Store saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Store patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Store[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Store findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('stores');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->hasMany('StoreImages', ['foreignKey' => 'store_id']);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator->integer('id')->allowEmptyString('id', null, 'create');

		$validator->scalar('store_name')->maxLength('store_name', 256)->requirePresence('store_name', 'create')
			->notEmptyString('store_name');

		$validator->scalar('store_url')->maxLength('store_url', 512)->requirePresence('store_url', 'create')
			->notEmptyString('store_url');

		$validator->scalar('region')->maxLength('region', 64)->requirePresence('region', 'create')
			->notEmptyString('region');

		$validator->scalar('prefecture')->maxLength('prefecture', 32)->requirePresence('prefecture', 'create')
			->notEmptyString('prefecture');

		$validator->integer('owner_user')->allowEmptyString('owner_user');

		return $validator;
	}
}
