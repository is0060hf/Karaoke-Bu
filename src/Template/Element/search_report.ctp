<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$cstList = TableRegistry::get('Customers')->find()->all();
$userList = TableRegistry::get('Users')->find()->all();
$voucherList = TableRegistry::get('Vouchers')->find()->all();

$customersNameList = [];
$customersNameList[''] = '未選択';
$usersNameList = [];
$usersNameList[''] = '未選択';
$deliveryDestinationList = [];
$deliveryDestinationList[''] = '未選択';
$cargoDestinationList = [];

foreach ($voucherList as $vItem) {
	if ($vItem->delivery_dest != '') {
		$deliveryDestinationList[$vItem->delivery_dest] = $vItem->delivery_dest;
	}
}
foreach ($cstList as $cst) {
	if ($cst->customers_name != '') {
		$customersNameList[$cst->customers_name] = $cst->customers_name;
	}
}
foreach ($userList as $usr) {
	if ($usr->username != '') {
		$usersNameList[$usr->username] = $usr->username;
	}
}

foreach ($voucherList as $voucher) {
	$deliveryList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
	foreach ($deliveryList as $deliveryElement) {
		if ($deliveryElement->delivery_dest != '') {
			$cargoDestinationList[$deliveryElement->destination] = $deliveryElement->destination;
		}
	}
}

//フォームテンプレートを取得
$form_template = Configure::read("form_template");
?>

<?= $this->Form->create(null, array('templates' => $form_template,
	'type' => 'get',
	'idPrefix' => 'search_form',
	'name' => 'search_form')); ?>

<legend><?= __('帳票生成') ?></legend>
<p class="form-paragraph">帳票の作成に使用する伝票を選択してください。</p>

<!--検索条件の項目-->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="text-center">
					<p class="form-paragraph">伝票を検索するための条件を入力してください。</p>
				</div>

				<?php
				echo $this->Form->control('deliveryman_name', array('label' => array('text' => '配達員名',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'select',
					'options' => $usersNameList,
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい配達員の名前を入力してください。',
						'select_toggle' => 'select2'),
					'value' => $this->request->getQuery('deliveryman_name'),
					'class' => 'form-control select2'
					// inputタグのクラス名
				));

				echo $this->Form->control('customers_name', array('label' => array('text' => '得意先',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'select',
					'options' => $customersNameList,
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい得意先を入力してください。',
						'select_toggle' => 'select2'),
					'value' => $this->request->getQuery('customers_name'),
					'class' => 'form-control select2'
					// inputタグのクラス名
				));

				echo $this->Form->control('cargo_dest[]', array('label' => array('text' => '納品先',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'select',
					'options' => $cargoDestinationList,
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい得意先を入力してください。',
						'multiple' => 'multiple'),
					'value' => $this->request->getQuery('cargo_dest'),
					'class' => 'form-control select2'
					// inputタグのクラス名
				));

				echo $this->Form->control('delivery_dest', array('label' => array('text' => '積込先',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'select',
					'options' => $deliveryDestinationList,
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい積込先の名称を入力してください。',
						'select_toggle' => 'select2'),
					'value' => $this->request->getQuery('delivery_dest'),
					'class' => 'form-control select2'
					// inputタグのクラス名
				));

				echo $this->Form->control('upper_created', array('label' => array('text' => '作成日（いつから）',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'text',
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい伝票作成日(上限)を入力してください。(例：2000/01/01)',
						'data_mask_format' => '0000/00/00',
						'data_toggle' => 'input-mask',
						'max_length' => '10'),
					'value' => $this->request->getQuery('upper_created'),
					'class' => 'form-control',
					// inputタグのクラス名
				));

				echo $this->Form->control('under_created', array('label' => array('text' => '作成日（いつまで）',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'type' => 'text',
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい伝票作成日(下限)を入力してください。(例：2000/02/01)',
						'data_mask_format' => '0000/00/00',
						'data_toggle' => 'input-mask',
						'max_length' => '10'),
					'value' => $this->request->getQuery('under_created'),
					'class' => 'form-control',
					// inputタグのクラス名
				));

				echo $this->Form->control('appendix', array('label' => array('text' => '備考',
					// labelで出力するテキスト
					'class' => 'col-form-label'
					// labelタグのクラス名
				),
					'templateVars' => array('div_class' => 'form-group row',
						'div_tooltip' => 'tooltip',
						'div_tooltip_placement' => 'top',
						'div_tooltip_title' => '絞り込みたい備考を入力してください。部分一致で検索されます。'),
					'value' => $this->request->getQuery('appendix'),
					'class' => 'form-control',
					// inputタグのクラス名
					'rows' => '3'));
				?>

				<div class="row my-2">
					<div class="col-12 text-center">
						<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
										onclick="clearSearchElementsInSeikyuu();document.search_form.submit();">
							<i class="fe-edit"></i>
							<span>検索条件クリア</span>
						</button>
						<button class="btn btn-primary mr-3" type="submit" name="submit_btn" value="search">
							<i class="fe-edit"></i>
							<span>検索</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->Form->end(); ?>
