<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StoreImage Entity
 *
 * @property int $id
 * @property int $store_id
 * @property string $image_path
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Store $store
 */
class StoreImage extends Entity {
	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = ['store_id' => true,
		'image_path' => true,
		'created' => true,
		'modified' => true,
		'store' => true];
}
