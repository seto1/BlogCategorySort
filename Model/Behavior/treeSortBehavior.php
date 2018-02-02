<?php

App::uses('TreeBehavior', 'Model/Behavior');

class TreeSortBehavior extends TreeBehavior {

/**
 * Tree Behavior構造内のデータを移動する
 *
 * anchorId、anchorPositionを元に移動
 * - anchorPositionがaboveの場合はanchorIdの下へ移動
 * - belowの場合は上へ移動
 * - parentの場合は親の変更のみ行う
 *
 * @param $Model
 * @param $id
 * @param $anchorId
 * @param $anchorPosition above|below|parent
 * @return array|false
 */
	public function move(Model $Model, $id, $anchorId, $anchorPosition) {
		// 移動するデータの情報を取得
		$data = $Model->find('first', [
			'conditions' => ['id' => $id],
			'recursive' => -1
		]);
		if (! $data) {
			return false;
		}

		// $anchorPositionがparentの場合は親を変更して終了
		if ($anchorPosition == 'parent') {
			if ($data[$Model->name]['parent_id'] == $anchorId) {
				return false;
			}
			return $Model->save([$Model->name => [
				'id' => $id,
				'parent_id' => $anchorId,
			]], false);
		}

		// 移動先の基準となるデータの情報を取得
		$anchorData = $Model->find('first', [
			'conditions' => ['id' => $anchorId],
			'recursive' => -1
		]);
		if (! $anchorData) {
			return false;
		}

		// 親を変更
		if ($data[$Model->name]['parent_id'] != $anchorData[$Model->name]['parent_id']) {
			$data = $Model->save([$Model->name => [
				'id' => $id,
				'parent_id' => $anchorData[$Model->name]['parent_id'],
			]], false);
		}

		$anchorSort = $this->getOrderSameParent($Model, $anchorId, $anchorData[$Model->name]['parent_id']);
		$currentSort = $this->getOrderSameParent($Model, $id, $anchorData[$Model->name]['parent_id']);

		// オフセットを計算して移動
		if ($anchorPosition == 'below') {
			$offset = $anchorSort - $currentSort;
			if ($offset > 0) {
				$offset -= 1;
			}
		} elseif ($anchorPosition == 'above') {
			$offset = $anchorSort - $currentSort;
			if ($offset < 0) {
				$offset += 1;
			}
		}

		return $this->moveOffset($Model, $id, $offset);
	}

/**
 * 同じ階層における並び順を取得
 *
 * @param $Model
 * @param $id
 * @param $parentId
 * @return int|false
 */
	public function getOrderSameParent(Model $Model, $id, $parentId) {
		$dataList = $Model->find('all', [
			'order' => 'lft',
			'conditions' => ['parent_id' => $parentId],
			'recursive' => -1
		]);

		$order = null;
		if ($dataList) {
			foreach ($dataList as $key => $data) {
				if ($id == $data[$Model->name]['id']) {
					$order = $key + 1;
					break;
				}
			}
		} else {
			return false;
		}

		return $order;
	}

/**
 * オフセットを元にデータを移動する
 *
 * @param $Model
 * @param $id
 * @param $offset
 * @return array|false
 */
	public function moveOffset(Model $Model, $id, $offset) {
		if ($offset > 0) {
			return $Model->moveDown($id, abs($offset));
		} elseif($offset < 0) {
			return $Model->moveUp($id, abs($offset));
		}

		return true;
	}
}
