<ul>
	<?php foreach ($blogCategories as $data): ?>
		<li id="BlogCategory-node-<?php echo $data['BlogCategory']['id'] ?>"
			data-jstree='{
				"icon": "<?php echo $this->BcBaser->getUrl('/img/admin/icon_folder.png', true) ?>",
				"id": <?php echo $data['BlogCategory']['id'] ?>
			}'>
			<?php $this->BcBaser->link(strip_tags(h($data['BlogCategory']['title'])), ['plugin' => 'blog', 'controller' => 'blog_categories', 'action' => 'edit', $content['Content']['entity_id'], $data['BlogCategory']['id']]) ?>
			<?php if(!empty($data['children'])): ?>
				<?php $this->BcBaser->element('admin/blog_category_sort/index_list_tree', ['blogCategories' => $data['children']]) ?>
			<?php endif ?>
		</li>
	<?php endforeach; ?>
</ul>
