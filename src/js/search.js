jQuery(document).on('ready', function () {
	jQuery('form.yw-search-form').on('submit', function () {
		var form        = jQuery(this);
		var data        = form.serialize();
		var button      = form.find('[type="submit"]');
		var ajaxResults = form.parent().find('.yw-search-results');

		button.attr('disabled', true).addClass('disabled');
		ajaxResults.hide();

		jQuery.ajax({
			url    : yw_ajaxurl,
			type   : 'POST',
			data   : data,
			success: function (output) {
				button.attr('disabled', false).removeClass('disabled');

				if (output.data.html) {
					ajaxResults.html(output.data.html).show();
				}
			},
			error  : function () {
				button.attr('disabled', false).removeClass('disabled');
			}
		});
		return false;
	});
});
