jQuery(document).ready(function($) {
	// Automatically make Popup links active
	var popupPath = 'a[href*="' + window.location.hostname + '/popup"]';
	$(popupPath).each(function() {
		$(this).magnificPopup({type:'iframe'});
	});
})