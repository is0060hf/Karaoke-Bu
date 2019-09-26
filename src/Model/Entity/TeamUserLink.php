<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TeamUserLink Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $team_id
 * @property int $status
 * @property int $role
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Team $team
 */
class TeamUserLink extends Entity {
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['user_id' => true,
		'team_id' => true,
		'status' => true,
		'role' => true,
		'created' => true,
		'modified' => true,
		'user' => true,
		'team' => true];
}
