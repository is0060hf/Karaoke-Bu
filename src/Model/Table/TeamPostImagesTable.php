<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TeamPostImages Model
 *
 * @property \App\Model\Table\TeamPostsTable&\Cake\ORM\Association\BelongsTo $TeamPosts
 *
 * @method \App\Model\Entity\TeamPostImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\TeamPostImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TeamPostImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TeamPostImage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamPostImage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamPostImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TeamPostImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TeamPostImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamPostImagesTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('team_post_images');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('TeamPosts', ['foreignKey' => 'team_post_id',
			'joinType' => 'INNER']);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator->integer('id')->allowEmptyString('id', null, 'create');

		$validator->scalar('image_path')->maxLength('image_path', 256)->requirePresence('image_path', 'create')
			->notEmptyFile('image_path');

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->existsIn(['team_post_id'], 'TeamPosts'));

		return $rules;
	}
}
