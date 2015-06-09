var ls = ls || {};
ls.plugin = ls.plugin || {};



ls.plugin.payment = (function ($) {
	
	this.processing = function() {
		ls.ajax.load(aRouter['payment']+'ajax-processing/', {payment_id: $('#payment_id').val(), payment_type: $('#payment-area').find('input[name="payment-type"]:checked').val()}, function(result) {
			$('#payment-redirect-form-area').html(result.sFormText);
			$('#payment-area').hide();
			$('#payment-redirect').show();
			$('#payment-redirect-form').submit();
		});
	};
	
	return this;
}).call(ls.plugin.payment || {},jQuery);