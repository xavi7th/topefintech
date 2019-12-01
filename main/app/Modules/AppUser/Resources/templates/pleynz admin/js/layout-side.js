$(function(){
	/*
	-------------------------------------------------
	    Side Menu
	-------------------------------------------------
	*/
	var sideMenu                = $('.side-menu')
		mainWrapper             = $('.wrapper-r');
	    sideMenuToggle          = $('.side-menu-toggle');
	    header              	= $('header');
	    main               		= $('main');
	    navSubItem         		= $('.sub-item');



	var mainWrapperShow = function(){
		$('.side-menu').toggleClass('open');
	    header.toggleClass('small-header');
	    $('html, body').toggleClass('overflow-hidden');
	}

	sideMenuToggle.click(function(e){
	    e.preventDefault();
	    $(this).toggleClass('closed');
	    mainWrapperShow();
	});

	
	// side menu sub
	navSubItem.find('> a').click(function(e){
	    e.preventDefault();
	    var $subMenu = $(this).next('.sub-menu');
	    if ($subMenu.length < 1)
	    return;
	    if ($subMenu.is(":visible")) {
	    $subMenu.slideUp(function(){
	      $('nav > li.active').removeClass('active');
	      console.log('1');
	    });
	    $(this).removeClass('active');
	      console.log('2');

	    return;
	    }
	    $('nav .sub-menu:visible').slideUp();
	    $('nav li > a').removeClass('active');
	    $subMenu.slideToggle(function(){
	    $('nav > li.active').removeClass('active');
	      console.log('3');
	    });
	    $(this).addClass('active');
	});



});