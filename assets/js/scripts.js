jQuery(document).ready(function($) {
	// Open iFrame in Lightbox
	$('.lightbox-iframe').each(function() {
		var $this = $(this).find('a');
		var _href = $this.attr('href');
		$this.attr('href', _href + '?iframe=true');
	});
})