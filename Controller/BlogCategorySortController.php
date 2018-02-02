<?php

class BlogCategorySortController extends AppController {

	public $uses = ['Blog.BlogCategory'];
	public $components = ['BcAuth', 'BcAuthConfigure', 'BcContents' => ['type' => 'Blog.BlogContent']];
	public $subMenuElements = ['BlogCategorySort.index'];

	public function admin_index($blogContentId) {
		if ($this->BlogCategory->verify() !== true) {
			clearAllCache();
			$this->BlogCategory->recover();
			$this->setMessage('ツリー構造の整合性にエラーがあったため再構築しました。', true);
		}
		
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
		if(!$this->request->is('ajax')) {
			$this->ajaxError(500, '無効な処理です。');
		}

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
