<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TeamPostImage Entity
 *
 * @property int $id
 * @property int $team_post_id
 * @property string $image_path
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\TeamPost $team_post
 */
class TeamPostImage extends Entity {
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['team_post_id' => true,
		'image_path' => true,
		'created' => true,
		'modified' => true,
		'team_post' => true];
}
