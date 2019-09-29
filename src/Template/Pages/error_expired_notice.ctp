<?php
$this->assign('title', '権限エラー');
?>

<h4 class="text-uppercase text-danger mt-3">編集できない通知です。</h4>
<div class="text-left">
	<p class="text-muted mt-3">通知予定日を過ぎた通知に関しては編集することができません。やむを得ず変更した場合は、一度既存の通知を削除し、再度新しく通知を登録してください。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'Tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
