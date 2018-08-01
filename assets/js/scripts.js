jQuery(document).ready(function($) {
	$('.rm-popup-link a, a.rm-popup-link').magnificPopup({
		callbacks: {
			open: function() {
				var target = $($.magnificPopup.instance.currItem.src);
				var popupSize = 'rm-popup--' + target.attr('data-rmpu-size');
				target.parents('.mfp-content').addClass(popupSize);
			}
		},
	  type: 'inline',
	  src: $(this).attr('href'),
	  mainClass: 'mfp-with-zoom',
	  removalDelay: 300,
	  enableEscapeKey: false,
		closeOnBgClick: false
	});

	// Check for global popup
	var rmpuGlobalExists = false;
	if ($('.rm-popup[data-rmpu-global="true"]').length > 0) {
		rmpuGlobalExists = true;
	}

	// Do each popup
	$('.rm-popup').each(function() {
		var elm = $(this);
		var elmID = $(this).attr('id');
		var popupID = elm.attr('data-rmpu-cookie');
		var display = elm.attr('data-rmpu-display').split(' ');
		var delay = elm.attr('data-rmpu-delay') * 1000;
		var dismiss = elm.attr('data-rmpu-dismiss');
		var isGlobal = elm.attr('data-rmpu-global');
		var isAuto = false;
		for (var i = 0; i < display.length; i++) {
			if ('auto' === display[i]) {
				isAuto = true;
				break;
			}
		}
		if (true === isAuto) {
			if (true === rmpuGlobalExists) {
				// Has Global, only pop global
				if ('true' === isGlobal) {
					if ('closed' !== Cookies.get(popupID)) {
						setTimeout(function() {
							if ('user' === dismiss) {
								$.magnificPopup.open({
									callbacks: {
										open: function() {
											var target = $($.magnificPopup.instance.currItem.src);
											var popupSize = 'rm-popup--' + target.attr('data-rmpu-size');
											target.parents('.mfp-content').addClass(popupSize);
										}
									},
									items: {
										src: $('#' + elmID)
									},
									type: 'inline',
								  mainClass: 'mfp-with-zoom',
								  removalDelay: 300,
								  modal: true
								});
							} else {
								$.magnificPopup.open({
									callbacks: {
										open: function() {
											var target = $($.magnificPopup.instance.currItem.src);
											var popupSize = 'rm-popup--' + target.attr('data-rmpu-size');
											target.parents('.mfp-content').addClass(popupSize);
										}
									},
									items: {
										src: $('#' + elmID),
									},
									type: 'inline',
								  mainClass: 'mfp-with-zoom',
								  removalDelay: 300,
								  enableEscapeKey: false,
								  closeOnBgClick: false
								});
							}
						}, delay);
					} else {
						// If cookie is set, set rmpuGobalExists to false
						rmpuGlobalExists = false;
					}
				}
			} else {
				// No Global, pop attached
				// need to check for popup cookie
				if ('closed' !== Cookies.get(popupID)) {
					setTimeout(function() {
						if ('user' === dismiss) {
								$.magnificPopup.open({
									callbacks: {
										open: function() {
											var target = $($.magnificPopup.instance.currItem.src);
											var popupSize = 'rm-popup--' + target.attr('data-rmpu-size');
											target.parents('.mfp-content').addClass(popupSize);
										}
									},
									items: {
										src: $('#' + elmID),
									},
									type: 'inline',
								  mainClass: 'mfp-with-zoom',
								  removalDelay: 300,
								  modal: true
								});
							} else {
								$.magnificPopup.open({
									callbacks: {
										open: function() {
											var target = $($.magnificPopup.instance.currItem.src);
											var popupSize = 'rm-popup--' + target.attr('data-rmpu-size');
											target.parents('.mfp-content').addClass(popupSize);
										}
									},
									items: {
										src: $('#' + elmID)
									},
									type: 'inline',
								  mainClass: 'mfp-with-zoom',
								  removalDelay: 300,
								  enableEscapeKey: false,
								  closeOnBgClick: false
								});
							}
					}, delay);
				}
			}
		}
	});

	// Close Logic
	$('.rm-popup[data-rmpu-dismiss="close"]').on('click', '.mfp-close', function() {
		var target = $(this).parents('.rm-popup');
		var popupDismiss = $(target).attr('data-rmpu-dismiss');
		var popupDisplay = $(target).attr('data-rmpu-display').split(' ');
		rm_popup_isAuto = false;
		for (var i = 0; i < popupDisplay.length; i++) {
			if ('auto' === popupDisplay[i]) {
				rm_popup_isAuto = true;
				break;
			}
		}
		if ('close' === popupDismiss && true === rm_popup_isAuto) {
			var popupName = $(target).attr('data-rmpu-cookie');
			var popupExp = $(target).attr('data-rmpu-freq');
			Cookies.set(popupName, 'closed', {expires: parseInt(popupExp)});
		}
	});

});