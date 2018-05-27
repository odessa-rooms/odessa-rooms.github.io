(function ( $, x5engine ) {
	var x = x5engine,
		s = x.settings,
		p = s.currentPath,
		b = x.boot;

	b.push(function () {
		x.setupDateTime();
		x.imAccess.showLogout();
		x.utils.autoHeight();
		x.cart.ui.updateWidget();
		x.imGrid.init();
	});
	b.push(function () {
		x.menu({
			target: '#imMnMn',
			showCurrent: false,
			verticalScroll: false,
			orientation: 'vertical',
			menuHeight: 28,
			menuWidth: 140,
			submenuHeight: 23,
			submenuWidth: 180,
			opacity: 1.000,
			type: 'singleColumn',
			alignment: 'left',
			effect: 'none'
		});
	});
	b.push(function () { x.utils.imPreloadImages([p + 'menu/index_h.png',p + 'menu/page-4_h.png',p + 'menu/--------_h.png',p + 'menu/page-5_h.png',p + 'menu/page-22_h.png',p + 'menu/----_h.png',p + 'menu/--------------_h.png',p + 'menu/page-35_h.png',p + 'menu/page-36_h.png',p + 'menu/page-40_h.png',p + 'menu/sub.png',p + 'menu/sub_h.png',p + 'menu/sub_f.png',p + 'menu/sub_m.png',p + 'menu/sub_l.png',p + 'menu/sub_f_h.png',p + 'menu/sub_m_h.png',p + 'menu/sub_l_h.png', p + 'res/imLoad.gif', p + 'res/imClose.png']); });

	// ShowBox
	$.extend(s.imShowBox, {
		'effect' : 'move',
		'shadow' : '3px 3px 10px 0px #808080',
		'background' : '#000000',
		'borderWidth' : {
			'top': 1,
			'right': 1,
			'bottom': 1,
			'left': 1
		},
		'borderRadius' : '5px 5px 5px 5px',
		'borderColor' : '#000000 #000000 #000000 #000000',
		'textColor' : '#000000',
		'fontFamily' : 'Tahoma',
		'fontStyle' : 'normal',
		'fontWeight' : 'normal',
		'fontSize' : '9pt',
		'textAlignment' : 'left',
		'boxColor' : '#FFFFFF',
		'opacity' : 0.700,
		'radialBg' : true // Works only in Mozilla Firefox and Google Chrome
	});

	// PopUp
	$.extend(s.imPopUp, {
		'effect' : 'move',
		'width' : 500,
		'shadow' : '3px 3px 10px 0px #808080',
		'background' : '#000000',
		'borderRadius' : 10,
		'textColor' : '#000000',
		'boxColor' : '#FFFFFF',
		'opacity' : 0.700
	});

	// Tip
	$.extend(s.imTip, {
		'borderRadius' : 5,
		'arrow' : true,
		'position' : 'bottom',
		'effect' : 'none',
		'showTail' : true
	});

	// Captcha
	var codes = s.imCaptcha.offlineCodes;
	s.loaded = true;
})( _jq, x5engine );