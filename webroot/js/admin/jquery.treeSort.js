(function($){
	$.treeSort = {

		jsTree: null,
		treeDom: null,

		config: {
			treeId: 'treeSort',
			stateKey: 'treeSort',
			ajaxMoveUrl: null,
		},

		createTree: function(config) {
			if (config) {
				$.extend($.treeSort.config, config);
			}

			$.treeSort.treeDom = $('#' + $.treeSort.config.treeId);

			$.treeSort.treeDom.jstree({
				'core': {
					'themes': {
						'name': 'proton',
						'stripes': true,
						'variant': 'large',
					},
					'check_callback' : true,
				},
				'plugins': [
					'dnd',
					'state',
					'wholerow',
				],
				'dnd': {
					'large_drop_target': true,
				},
				'state': {
					'key': $.treeSort.config.stateKey,
				},
			}).bind('move_node.jstree', $.treeSort.move);
			$.treeSort.jsTree = $.treeSort.treeDom.jstree(true);
		},

		move: function(e, data) {
			var id = data.node.data.jstree.id;
			var nextNode = $.treeSort.jsTree.get_node($.treeSort.jsTree.get_next_dom(data.node, true));
			var prevNode = $.treeSort.jsTree.get_node($.treeSort.jsTree.get_prev_dom(data.node, true));
			var parentNode = $.treeSort.jsTree.get_node(data.node.parent);

			// 移動先の、次の要素・前の要素・親要素のいずれかをanchorとして取得
			if (nextNode) {
				var anchorId = nextNode.data.jstree.id;
				var anchorPosition = 'below';
			} else if (prevNode) {
				var anchorId = prevNode.data.jstree.id;
				var anchorPosition = 'above';
			} else {
				if (data.node.parent === '#') {
					var anchorId = null;
				} else {
					var anchorId = parentNode.data.jstree.id;
				}
				var anchorPosition = 'parent';
				$.treeSort.jsTree.open_node(parentNode);
			}

			$.bcToken.check(function(){
				return $.ajax({
					url: $.treeSort.config.ajaxMoveUrl,
					type: 'POST',
					cache: false,
					data: {
						id: id,
						anchorId: anchorId,
						anchorPosition: anchorPosition,
						_Token: {
							key: $.bcToken.key
						}
					},
					dataType: 'json',
					beforeSend: function () {
						$.bcUtil.hideMessage();
						$.bcUtil.showLoader();
					},
					success: function (result) {
						$.bcUtil.hideLoader();
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						$.bcUtil.showAjaxError('並び替えに失敗しました。');
					},
				});
			});
		},
	};

})(jQuery);
