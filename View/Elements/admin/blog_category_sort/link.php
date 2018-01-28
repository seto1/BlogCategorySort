<script>
	$(function () {
		$('#ListTable th > .firstChild').append('<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_sort.png', ['width' => 65, 'height' => 14, 'alt' => '並び替え', 'class' => 'btn']), ['plugin' => 'blog_category_sort', 'controller' => 'blog_category_sort', 'action' => 'index', $blogContent['BlogContent']['id']]) ?>');
	});
</script>
