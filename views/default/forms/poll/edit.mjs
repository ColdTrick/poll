import 'jquery';
import 'jquery-ui';
import system_messages from 'elgg/system_messages';
import i18n from 'elgg/i18n'


$(document).on('click', '.poll-edit-answers-icon .elgg-icon-delete', function() {
	$(this).parents('li').remove();
});

$('.poll-edit-answers').sortable({
	handle: '.elgg-icon-drag-arrow',
	items: '> li:not(.poll-edit-answers-blank)',
});

$('.poll-edit-answers-blank input').focus(function() {
	var $blank = $(this).parents('.poll-edit-answers-blank');
	var $clone = $blank.clone(true);
	
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

$(document).on('submit', '.elgg-form-poll-edit', function() {
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
	
	system_messages.error(i18n.echo('poll:edit:error:answer_count'));
	
	return false;
});

$.extend($.datepicker, {_checkOffset: function(inst, offset, isFixed) {
	var dpWidth = inst.dpDiv.outerWidth();
	var dpHeight = inst.dpDiv.outerHeight();
	var inputWidth = inst.input ? inst.input.outerWidth() : 0;
	var inputHeight = inst.input ? inst.input.outerHeight() : 0;
	var viewWidth = document.documentElement.clientWidth + (isFixed ? 0 : $(document).scrollLeft());
	var viewHeight = document.documentElement.clientHeight + (isFixed ? 0 : $(document).scrollTop());

	offset.left -= (this._get(inst, 'isRTL') ? (dpWidth - inputWidth) : 0);
	offset.left -= (isFixed && offset.left == inst.input.offset().left) ? $(document).scrollLeft() : 0;
	offset.top -= (isFixed && offset.top == (inst.input.offset().top + inputHeight)) ? $(document).scrollTop() : 0;

	// now check if datepicker is showing outside window viewport - move to a better place if so.
	offset.left -= Math.min(offset.left, (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ? Math.abs(offset.left + dpWidth - viewWidth) : 0);
	offset.top -= Math.abs(dpHeight + inputHeight);

	return offset;
}});
