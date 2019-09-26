<?php
$this->assign('title', 'ユーザー登録完了');
?>

<h4 class="text-uppercase text-danger mt-3">ユーザー登録が完了しました。</h4>
<div class="text-left">
	<p class="text-muted mt-3">ご登録いただいたメールアドレス宛に確認メールが送信されました。</p>
	<p class="text-muted">ご登録のユーザーはまだ有効化が完了しておりません。お送りしたメールに記載の確認URLを押下することでユーザーを有効化することができます。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
