<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Team Entity
 *
 * @property int $id
 * @property string $team_name
 * @property string|null $introduction
 * @property string|null $cover_image_path
 * @property string|null $icon_image_path
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\TeamUserLink[] $team_user_links
 */
class Team extends Entity
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
        'team_name' => true,
        'introduction' => true,
        'cover_image_path' => true,
        'icon_image_path' => true,
        'created' => true,
        'modified' => true,
        'team_user_links' => true
    ];
}
