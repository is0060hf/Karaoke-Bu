<?php
$this->assign('title', '権限エラー');
?>

<h4 class="text-uppercase text-danger mt-3">認証エラーが発生しました</h4>
<div class="text-left">
	<p class="text-muted mt-3">認証処理中に予期しないエラーが発生しました。5分程時間をおいて再度認証URLをクリックしてください。</p>
	<p class="text-muted">同様のエラーが何度も発生する場合は、お手数ですがお問い合わせフォームよりご連絡ください。</p>
</div>
<?= $this->Html->link("ホームへ戻る", ['controller' => 'tops',
	'action' => 'index'], ['class' => 'btn btn-info btn-block mt-3']); ?>
</div>
