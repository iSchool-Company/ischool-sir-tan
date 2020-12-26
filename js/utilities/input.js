function showResult(
	inputType,
	hasError,
	messageBlock
) {
	inputType.parents('.has-feedback').addClass(hasError ? 'has-error' : 'has-success');
	inputType.parents('.has-feedback').removeClass(hasError ? 'has-success' : 'has-error');
	inputType.parents('.has-feedback').find('.form-control-feedback').addClass(hasError ? 'glyphicon-remove' : 'glyphicon-ok');
	inputType.parents('.has-feedback').find('.form-control-feedback').removeClass(hasError ? 'glyphicon-ok' : 'glyphicon-remove');
	inputType.parents('.has-feedback').find('.help-block').html(messageBlock);
}

function clearResult(
	inputType,
	messageBlock
) {
	inputType.parents('.has-feedback').removeClass('has-success has-error');
	inputType.parents('.has-feedback').find('.form-control-feedback').removeClass('glyphicon-ok glyphicon-remove');
	inputType.parents('.has-feedback').find('.help-block').html(messageBlock == undefined ? '' : messageBlock);
	inputType.val('');

	if (inputType.is('select')) {
		inputType.find('option:not(:disabled)').first().prop('selected', true);
	}
}