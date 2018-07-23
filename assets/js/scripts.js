jQuery(document).ready(function($) {
	$('.rm-popup-link a, a.rm-popup-link').magnificPopup({
	  type: 'inline',
	  src: $(this).attr('href'),
	  mainClass: 'mfp-with-zoom',
	  removalDelay: 300,
	});
});