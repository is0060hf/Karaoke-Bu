<?php
$this->assign('title', 'ユーザー認証完了');
?>

<h4 class="text-uppercase text-danger mt-3">ユーザー認証が完了しました。</h4>
<div class="text-left">
	<p class="text-muted mt-3">ご登録頂きましたユーザーの有効化作業が完了致しました。</p>
	<p class="text-muted">ホームへ戻りログインをしてください。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
