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
		
		var index = 1;
		
		$clone.find('input[name^="answers"]').each(function() {
			index = $blank.data().index + 1;

			$(this).attr('name', $(this).attr('name').replace($(this).attr('name').match(/\[[0-9]+\]/), '[' + index + ']'));
			$clone.data('index', index);    
		});
		
		// generate internal name value
		$blank.find('.elgg-input-text[name="answers[' + (index - 1) + '][name]"]').val('answer_' + Date.now());
		
		$blank.after($clone);
		$blank.removeClass('poll-edit-answers-blank');
	});
	
	$('.elgg-form-poll-edit').submit(function() {
		// Prevent form submit if there are not at least 2 answers
		
		var count = 0;
		$(this).find('.poll-edit-answers [name$="][label]"]').each(function(index, elem) {
			if ($(elem).val()) {
				count++;
			}
		});
		
		if (count > 1) {
			return;
		}
		
		elgg.system_message(elgg.echo('poll:edit:error:answer_count'));
		
		return false;
	});
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.poll.init_edit);
