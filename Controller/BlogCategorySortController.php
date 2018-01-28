<?php

class BlogCategorySortController extends AppController {

	public $uses = ['Blog.BlogCategory'];
	public $components = ['BcAuth', 'BcAuthConfigure', 'BcContents' => ['type' => 'Blog.BlogContent']];
	public $subMenuElements = ['BlogCategorySort.index'];

	public function admin_index($blogContentId) {
		$content = $this->BcContents->getContent($blogContentId);

		$blogCategories = $this->BlogCategory->find('threaded',[
			'order' => ['BlogCategory.lft'],
			'conditions' => ['BlogCategory.blog_content_id' => $blogContentId],
			'recursive' => -1
		]);

		$this->set('content', $content);
		$this->set('blogCategories', $blogCategories);

		$this->pageTitle = '[' . $content['Content']['title'] . '] カテゴリ並び替え';
	}

	public function admin_ajax_move() {
		$this->autoRender = false;

		$this->BlogCategory->Behaviors->load('BlogCategorySort.TreeSort');

		$result = $this->BlogCategory->move(
			$this->request->data['id'],
			$this->request->data['anchorId'],
			$this->request->data['anchorPosition']
		);

		if ($result) {
			return true;
		} else {
			$this->ajaxError(500, 'データ保存中にエラーが発生しました。');
		}
	}

}
