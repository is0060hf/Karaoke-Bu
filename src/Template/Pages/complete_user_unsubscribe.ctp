<?php
$this->assign('title', '退会処理完了');
?>

<h4 class="text-uppercase text-danger mt-3">ユーザーの退会処理が完了しました。</h4>
<div class="text-left">
	<p class="text-muted mt-3">ユーザーの退会処理が無事に完了致しました。</p>
	<p class="text-muted">またのご利用を心よりお待ちしております。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
