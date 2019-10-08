<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StoreImage Entity
 *
 * @property int $id
 * @property int $store_id
 * @property string $image_path
 * @property string|null $image_name
 * @property string|null $image_ext
 * @property string|null $image_type
 * @property float|null $image_size
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
		'image_name' => true,
		'image_ext' => true,
		'image_type' => true,
		'image_size' => true,
		'created' => true,
		'modified' => true,
		'store' => true];
}
