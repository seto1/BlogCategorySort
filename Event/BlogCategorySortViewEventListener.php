<?php

class BlogCategorySortViewEventListener extends BcViewEventListener {

	public $events = [
		'Blog.BlogCategories.afterElement',
	];

	public function blogBlogCategoriesAfterElement(CakeEvent $event) {
		if (!BcUtil::isAdminSystem() || $event->data['name'] != 'submenu') {
			return;
		}

		$View = $event->subject();
		echo $View->element('BlogCategorySort.admin/blog_category_sort/link');
	}

}
