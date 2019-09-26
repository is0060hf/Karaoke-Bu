<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Store Entity
 *
 * @property int $id
 * @property string $store_name
 * @property string $store_url
 * @property string $region
 * @property string $prefecture
 * @property int|null $owner_user
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\StoreImage[] $store_images
 */
class Store extends Entity
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
	protected $_accessible = ['store_name' => true, 'store_url' => true, 'region' => true, 'prefecture' => true, 'owner_user' => true, 'created' => true, 'modified' => true, 'store_images' => true];
}
