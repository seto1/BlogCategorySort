<tr>
	<th><?php echo strip_tags($content['Content']['title']) ?>管理メニュー</th>
	<td>
		<ul class="cleafix">
			<li><?php $this->BcBaser->link(strip_tags($content['Content']['title']) . '設定', ['plugin' => 'blog', 'controller' => 'blog_contents', 'action' => 'edit', $content['Content']['entity_id']]) ?></li>
			<li><?php $this->BcBaser->link('記事一覧', ['plugin' => 'blog', 'controller' => 'blog_posts', 'action' => 'index', $content['Content']['entity_id']]) ?></li>
			<li><?php $this->BcBaser->link('記事新規追加', ['plugin' => 'blog', 'controller' => 'blog_posts', 'action' => 'add', $content['Content']['entity_id']]) ?></li>
			<li><?php $this->BcBaser->link('カテゴリ一覧', ['plugin' => 'blog', 'controller' => 'blog_categories', 'action' => 'index', $content['Content']['entity_id']]) ?></li>
			<li><?php $this->BcBaser->link('カテゴリ新規追加', ['plugin' => 'blog', 'controller' => 'blog_categories', 'action' => 'add', $content['Content']['entity_id']]) ?></li>
			<li><?php $this->BcBaser->link('タグ一覧', ['plugin' => 'blog', 'controller' => 'blog_tags', 'action' => 'index']) ?></li>
			<li><?php $this->BcBaser->link('タグ新規追加', ['plugin' => 'blog', 'controller' => 'blog_tags', 'action' => 'add']) ?></li>
			<li><?php $this->BcBaser->link('コメント一覧', ['plugin' => 'blog', 'controller' => 'blog_comments', 'action' => 'index', $content['Content']['entity_id']]) ?></li>
		</ul>
	</td>
</tr>
