<?php if (!empty($blogCategories)): ?>
	<?php $this->BcBaser->js(['admin/vendors/jquery.jstree-3.3.1/jstree.min', 'BlogCategorySort.admin/jquery.treeSort']) ?>
	<?php $this->BcBaser->css(['BlogCategorySort.admin/style']) ?>
	<?php $treeId = 'BlogCategoryTree' ?>

	<script>
		$(function () {
			$.treeSort.createTree({
				treeId: '<?php echo $treeId ?>',
				stateKey: '<?php echo $treeId . '-' . $content['Content']['entity_id'] ?>',
				ajaxMoveUrl: '<?php echo $this->BcBaser->getUrl(['action' => 'ajax_move', $content['Content']['entity_id']]) ?>',
			});
		});
	</script>


	<div id="<?php echo $treeId ?>">
		<?php $this->BcBaser->element('admin/blog_category_sort/index_list_tree', ['blogCategories', $blogCategories]) ?>
	</div>
<?php else: ?>
	<p class="no-data">データが見つかりませんでした。</p>
<?php endif; ?>
