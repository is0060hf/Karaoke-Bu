<div class="Page navigation mt-4">
	<ul class="pagination justify-content-center">
		<?= $this->Paginator->first('<< '.__('最初')); ?>
		<?= $this->Paginator->prev('< '.__('前へ')); ?>
		<?= $this->Paginator->numbers(); ?>
		<?= $this->Paginator->next(__('次へ').' >'); ?>
		<?= $this->Paginator->last(__('最後').' >>'); ?>
	</ul>
	<p class="text-center"><?= $this->Paginator->counter(['format' => __('【{{page}}】ページ中【{{pages}}】ページ目を表示')]) ?></p>
</div>
