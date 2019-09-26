<?php
$this->assign('title', '権限エラー');
?>

<h4 class="text-uppercase text-danger mt-3">権限エラーが発生しました。</h4>
<div class="text-left">
	<p class="text-muted mt-3">ご指定頂きました操作は、現在ログインしているユーザーでは実行権限がございません。恐れ入りますが、トップ画面より再度やり直してください。</p>
	<p class="text-muted">同様の現象が連続して発生する場合には、お手数おかけいたしますがお問い合わせフォームよりご連絡ください。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'Tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
