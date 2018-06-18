<?php
if (getVersion() >= 4.1) {
	$linkText = $this->BcBaser->getImg('admin/btn_sort.png', ['alt' => '並び替え', 'class' => 'btn']) . '並び替え';
} else {
	$linkText = $this->BcBaser->getImg('admin/btn_sort.png', ['alt' => '並び替え', 'class' => 'btn']);
}
$sortLink = $this->BcBaser->getLink($linkText, ['plugin' => 'blog_category_sort', 'controller' => 'blog_category_sort', 'action' => 'index', $blogContent['BlogContent']['id']]);
?>
<script>
	$(function () {
		$('#ListTable th > .firstChild').append('<?php echo $sortLink ?>');
	});
</script>
