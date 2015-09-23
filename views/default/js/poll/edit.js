elgg.provide('elgg.poll');

elgg.poll.init_edit = function() {
	$(document).on('click', '.poll-edit-answers-icon .elgg-icon-delete', function() {
		$(this).parents('li').remove();		
	});
	
	$('.poll-edit-answers').sortable({
		handle: '.elgg-icon-drag-arrow', 
		items: '> li:not(.poll-edit-answers-blank)', 
	});
	
	$('.poll-edit-answers-blank input').focus(function() {
		$blank = $(this).parents('.poll-edit-answers-blank');
		$clone = $blank.clone(true);
		
		$clone.find('input[name^="answers"]').each(function() {
			var index = $blank.data().index + 1;

			$(this).attr('name', $(this).attr('name').replace($(this).attr('name').match(/\[[0-9]+\]/), '[' + index + ']'));
			$clone.data('index', index);    
		});
		$blank.after($clone);
		$blank.removeClass('poll-edit-answers-blank');
	});
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.poll.init_edit);
