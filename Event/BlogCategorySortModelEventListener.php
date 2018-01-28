<?php

class BlogCategorySortModelEventListener extends BcModelEventListener {

	public $events = [
		'Blog.BlogCategory.beforeSave',
	];

	public function blogBlogCategoryBeforeSave(CakeEvent $event) {
		clearAllCache();
		return true;
	}

}
