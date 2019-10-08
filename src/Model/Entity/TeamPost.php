<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TeamPost Entity
 *
 * @property int $id
 * @property int $term_id
 * @property int $user_id
 * @property int $viewing_auth_range
 * @property int $comment_auth_range
 * @property string $title
 * @property string $context
 * @property \Cake\I18n\FrozenTime|null $open_date
 * @property int $state
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Term $term
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\TeamPostComment[] $team_post_comments
 * @property \App\Model\Entity\TeamPostImage[] $team_post_images
 */
class TeamPost extends Entity {
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['term_id' => true,
		'user_id' => true,
		'viewing_auth_range' => true,
		'comment_auth_range' => true,
		'title' => true,
		'context' => true,
		'open_date' => true,
		'state' => true,
		'created' => true,
		'modified' => true,
		'term' => true,
		'user' => true,
		'team_post_comments' => true,
		'team_post_images' => true];
}
