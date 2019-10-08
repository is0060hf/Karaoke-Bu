<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TeamPosts Model
 *
 * @property \App\Model\Table\TermsTable&\Cake\ORM\Association\BelongsTo $Terms
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TeamPostCommentsTable&\Cake\ORM\Association\HasMany $TeamPostComments
 * @property \App\Model\Table\TeamPostImagesTable&\Cake\ORM\Association\HasMany $TeamPostImages
 *
 * @method \App\Model\Entity\TeamPost get($primaryKey, $options = [])
 * @method \App\Model\Entity\TeamPost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TeamPost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TeamPost|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamPost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamPost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TeamPost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TeamPost findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamPostsTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('team_posts');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Terms', ['foreignKey' => 'term_id',
			'joinType' => 'INNER']);
		$this->belongsTo('Users', ['foreignKey' => 'user_id',
			'joinType' => 'INNER']);
		$this->hasMany('TeamPostComments', ['foreignKey' => 'team_post_id']);
		$this->hasMany('TeamPostImages', ['foreignKey' => 'team_post_id']);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator->integer('id')->allowEmptyString('id', null, 'create');

		$validator->integer('viewing_auth_range')->requirePresence('viewing_auth_range', 'create')
			->notEmptyString('viewing_auth_range');

		$validator->integer('comment_auth_range')->requirePresence('comment_auth_range', 'create')
			->notEmptyString('comment_auth_range');

		$validator->scalar('title')->maxLength('title', 256)->requirePresence('title', 'create')->notEmptyString('title');

		$validator->scalar('context')->maxLength('context', 4294967295)->requirePresence('context', 'create')
			->notEmptyString('context');

		$validator->dateTime('open_date')->allowEmptyDateTime('open_date');

		$validator->integer('state')->requirePresence('state', 'create')->notEmptyString('state');

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
		$rules->add($rules->existsIn(['term_id'], 'Terms'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));

		return $rules;
	}
}
