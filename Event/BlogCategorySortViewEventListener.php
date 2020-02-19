<?php

class BlogCategorySortViewEventListener extends BcViewEventListener {

	public $events = [
		'Blog.BlogCategories.afterElement',
	];

	public function blogBlogCategoriesAfterElement(CakeEvent $event) {
		$View = $event->subject();

		if (!BcUtil::isAdminSystem()) {
			return;
		}

		if ($View->adminTheme === 'admin-third') {
			if ($event->data['name'] !== 'header') {
				return;
			}

			$View->BcAdmin->addAdminMainBodyHeaderLinks([
				'url' => ['plugin' => 'blog_category_sort', 'controller' => 'blog_category_sort',
					'action' => 'index', $View->passedArgs[0]],
				'title' => __d('baser', '並び替え'),
			]);
		} else {
			if ($event->data['name'] !== 'submenu') {
				return;
			}
			echo $View->element('BlogCategorySort.admin/blog_category_sort/link');
		}
	}

}
