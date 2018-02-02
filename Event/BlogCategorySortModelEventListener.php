<?php

class BlogCategorySortModelEventListener extends BcModelEventListener {

	public $events = [
		'Blog.BlogCategory.afterSave',
		'Blog.BlogCategory.beforeSave',
	];


	public function blogBlogCategoryBeforeSave(CakeEvent $event) {
		clearAllCache();
		return true;
	}

	public function blogBlogCategoryAfterSave(CakeEvent $event) {
		clearAllCache();
	}

}
