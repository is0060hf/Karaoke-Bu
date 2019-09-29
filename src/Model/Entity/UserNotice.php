<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserNotice Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $context
 * @property bool $important_flg
 * @property int $user_id
 * @property int $notice_level
 * @property \Cake\I18n\FrozenTime $send_date
 * @property string|null $icon_image_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\UserNoticeFlag[] $user_notice_flags
 */
class UserNotice extends Entity {
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['title' => true,
		'context' => true,
		'important_flg' => true,
		'user_id' => true,
		'notice_level' => true,
		'send_date' => true,
		'icon_image_path' => true,
		'created' => true,
		'modified' => true,
		'user' => true,
		'user_notice_flags' => true];
}
