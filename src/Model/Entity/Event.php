<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property string|null $entry_template
 * @property string|null $drink
 * @property string|null $food
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $end_time
 * @property int $budget
 * @property \Cake\I18n\FrozenTime $deadline
 * @property \Cake\I18n\FrozenTime $entry_date
 * @property int $limited_range
 * @property int $number_of_people
 * @property int $region
 * @property int $prefecture
 * @property string $phone_number
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\EventComment[] $event_comments
 * @property \App\Model\Entity\EventEntry[] $event_entries
 */
class Event extends Entity
{
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['user_id' => true, 'title' => true, 'body' => true, 'entry_template' => true, 'drink' => true, 'food' => true, 'start_time' => true, 'end_time' => true, 'budget' => true, 'deadline' => true, 'entry_date' => true, 'limited_range' => true, 'number_of_people' => true, 'region' => true, 'prefecture' => true, 'phone_number' => true, 'created' => true, 'modified' => true, 'user' => true, 'event_comments' => true, 'event_entries' => true];
}
