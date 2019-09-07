<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $login_name
 * @property string $password
 * @property string $nick_name
 * @property string $mail_address
 * @property string $introduction
 * @property int $role
 * @property bool $official_flg
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\EventComment[] $event_comments
 * @property \App\Model\Entity\EventEntry[] $event_entries
 * @property \App\Model\Entity\Event[] $events
 * @property \App\Model\Entity\TeamPost[] $team_posts
 * @property \App\Model\Entity\TeamUserLink[] $team_user_links
 */
class User extends Entity
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
    protected $_accessible = [
        'login_name' => true,
        'password' => true,
        'nick_name' => true,
        'mail_address' => true,
        'introduction' => true,
        'role' => true,
        'official_flg' => true,
        'created' => true,
        'modified' => true,
        'event_comments' => true,
        'event_entries' => true,
        'events' => true,
        'team_posts' => true,
        'team_user_links' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
