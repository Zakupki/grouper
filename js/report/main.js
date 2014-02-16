
//global vars:
var $dom = {},
		loggedIn = $('body').hasClass('logged-in'),
		ajaxHelp = '/help/',
		ajaxMoreGroups = '/groups/getmore/',
		ajaxClubsAddToFav = '/clubs/addtofav',
		ajaxGroupsAddToFav = '/groups/addtofav',
		ajaxSearchAutoComplete = 'search.php',
		ajaxClubsAutoComplete = '/clubs/findclub',
		ajaxGroupsAutoComplete = '/groups/findgroup',
		ajaxClubGraph = '/clubs/getclub/',
		ajaxEditBanner = '/banners/getbanner/',
		ajaxEditEvent = '/events/getevent/',
		ajaxEditPublic = '/public/getpublic/',
		ajaxEditRecard = '/recards/getrecard/',
		ajaxUpdateBanner = '/banners/updatebanner/',
		ajaxUpdateEvent = '/events/updateevent/',
		ajaxUpdatePublic = '/public/updatepublic/',
		ajaxUpdateRecard = '/recards/updaterecard/',
		ajaxBannersGA = '/banners/getclubga/',
		ajaxPublicGRP = '/public/getgroupgrp/',
		ajaxEventReport = '/events/geteventreport/',
		ajaxMoreEvents = '/clubs/moreevents/',
		ajaxApproveEvent = '/clubs/approveevent/',
		ajaxMorePosters = '/clubs/moreposters/',
		ajaxPosterReply = '/ajax/posterreply/',
		urlClubsList = '/clubs/',
		urlBannersList = '/banners/',
		urlEventsList = '/events/',
		urlPublicList = '/public/',
		urlRecardsList = '/recards/',
		highchartsColors = [
			'#597BA8',
			'#82A2CD',
			'#ff5500',
			'#78B27C',
			'#E7E271',
			'#F3B200',
			'#D75C56',
			'#B6D15E',
			'#74D2B2',
			'#6BC3D3'
		],
		highchartsBackground = '#e6e6e6';


//local debug:
/*
ajaxClubsAutoComplete = 'clubs_autocomplete.html';
ajaxEditBanner = '/app/modules/report/views/popups/getbanner.php';
ajaxHelp = '/app/modules/report/views/popups/help.php';
*/

//cache jquery dom objects:
function cacheDOM(){
	$dom = $.extend($dom, {
		document: $(document),
		window: $(window),
		html: $('html'),
		body: $('body'),
		htmlBody: $('html, body'),
		top: $('#top'),
		header: $('header'),
		footer: $('footer'),
		main: $('#main'),
		content: $('#content'),
		socialSide: $('#social-side')
	});
}

function unblockLinks(){
	$('a[href^=#]').unbind('.blocked');
}

//close/whatever by click outside:
$.fn.outsider = function(fn){
	return this.each(function(){
		var $el = $(this);

		if($el.data('outsider')){
			return;
		}
		$el.data('outsider', true);

		$('html').bind('click.outsider', function(){
			if(typeof fn == 'function'){
				fn.call($el);
			}
		});
		$el.bind('click.outsider', function(e){
				e.stopPropagation();				
		});	
	});
}

//footer country select:
function doCountrySelect(){
	var $cs = $dom.footer.find('.country-select'),
			$c = $cs.find('.country'),
			$s = $cs.find('.select'),
			speed = 100;
	$c.bind('click', function(e){
		e.preventDefault();
		if($s.hasClass('open')){
			$s.stop().fadeOut(speed, function(){ $s.removeClass('open')});
		} else {
			$s.stop().fadeIn(speed, function(){ $s.addClass('open')});
		}
	});
	$s.outsider(function(){
		if($s.hasClass('open')){
			$s.stop().fadeOut(speed, function(){ $s.removeClass('open')});
		}
	});
}

$.fn.share = function(o){
	o = $.extend({
		speed: 100
	}, o);
	return this.each(function(){
		var $el = $(this),
				$open = $el.find('a.open'),
				$popup = $el.find('.popup'),
				$links = $popup.find('a');
		if(!$open.length || !$popup.length){
			return;
		}
		$open.bind('click', function(e){
			e.preventDefault();
			if($popup.hasClass('open')){
				$popup.stop().fadeOut(o.speed, function(){ $popup.removeClass('open')});
			} else {
				$popup.stop().fadeIn(o.speed, function(){ $popup.addClass('open')});
			}
		});
		$popup.outsider(function(){
			if($popup.hasClass('open')){
				$popup.stop().fadeOut(o.speed, function(){ $popup.removeClass('open')});
			}		
		});
		$links.bind('click', function(){
			var $count = $(this).find('.count'),
					count = parseInt($count.text());
			$count.text(1*count+1);
		});
	});
}

function doShares(){
	$dom.footer.find('.share').share();
}

//set resize handler:
function doResizeHandler(){
	$dom.window.smartresize(resizeActions);
	resizeActions();
}

//all actions to call on resize:
function resizeActions(){
	doHeightAdjust();
	checkSocialSide();
}

function doHeightAdjust(){
		var $cw = $dom.content.find('.centerwrap'),
				hw = $dom.window.height(),
				hh = $dom.top.outerHeight() + $dom.header.outerHeight(),
				hf = $dom.footer.outerHeight(),
				hc = $dom.content.outerHeight(),
				hcw = $cw.outerHeight(),
				cp = hc - $dom.content.height(),
				cww = $cw.outerWidth(),
				d = hw - hh - hf; //delta: window height - header - footer
		if(d > hc){
			$dom.content.height(d - cp).css('position', 'relative');
			//center content vertically for error and enter pages:
			$('body.error, body.enter').each(function(){
				$cw.css({
					position: 'absolute',
					top: '50%',
					left: '50%',
					margin: '-' + hcw/2 + 'px 0 0 -' + cww/2 + 'px'
				});
			});
		}
}


//social sidebar show/hide:
function checkSocialSide(){
	var v = $dom.socialSide.is(':visible'),
			speed = 100;
	if($dom.window.width() < 1060 || $dom.main.outerHeight() < 400){
		if(v){
			$dom.socialSide.fadeOut(speed);
		}
	} else{
		if(!v){
			$dom.socialSide.fadeIn(speed);
		}
	}
}


//style scrollbars (for select box):
$.fn.doNanoScroll = function(){
	return this.each(function(){
		var $el = $(this),
				$ik_inner = $el.closest('.ik_select_list_inner');
		if($ik_inner.css('overflow') == 'auto'){
			if($el.data('hasnanoscroll') !== true){
				$el.wrap('<div class="nano"><div class="content">');
				$el.data('hasnanoscroll', true);
			}
			$el.closest('.nano').nanoScroller();
		} else {
			if($el.data('hasnanoscroll') == true){
				$el.closest('.nano').nanoScroller({stop: true});	
			}			
		}
	});
}


//style select boxes:
function doSelectBoxes(){
	$('select:not(.custom)').ikSelect({
		autoWidth: false,
		ddFullWidth: false
	}).bind('showBlock', function(){
		$('.ik_select_list_inner > ul').doNanoScroll();
	});
}


$.fn.popUpAction = function(o){
	var $p = $(this).eq(0),
			ftime = 100,
			fotime = 100;
	o = $.extend({
		type: 0,
		ajaxUrl: ''
	}, o);
	if($p.length){
		var pid = $p.attr('id');
		$p.modal({
			zIndex: 100,
			fixed: false,
			autoResize: false,
			overlayClose: true,
			opacity: 30,
			persist: true,
			containerId: 'simplemodal-container-' + o.type,
			onOpen: function (dialog) {					
				dialog.overlay.height($(window).height()).fadeIn(ftime, function () {
					dialog.container.wrapInner('<div class="content">').show().css('opacity', '0');

					//this one is run when popup content is ready:
					function popupShowActions(){
						dialog.data.show();
						dialog.container.css('height', 'auto');
						$.modal.setPosition();
						dialog.container.animate({'opacity': 1}, ftime);
						dialog.overlay.bind('touchmove.modal', function(e){
							e.preventDefault();
							e.stopPropagation();
						});
						dialog.data.find('a.ok').bind('click', function(e){
							e.preventDefault();
							$.modal.close();
						});
						if(typeof o.afterShow == 'function'){
							o.afterShow.call(dialog);
						}
						$dom.window.trigger('popupShow');
					}

					//load via ajax or not:
					if(o.ajaxUrl == ''){
						popupShowActions();
					} else {
						$.ajax({
							type: 'GET',
							url: o.ajaxUrl,
							data: {
								id: o.id
							},
							success: function(data){
								dialog.data.html(data);
								popupShowActions();
							}
						});		
					}							

				});
			},
			onClose: function(dialog){
				dialog.container.add(dialog.overlay).fadeOut(fotime).promise().done(function(){
					$.modal.close();
					$dom.window.trigger('modal-closed');
				});
			}
		});
	}
}


$.fn.popup = function(o){
	return this.each(function(){
		var $a = $(this);
		$a.bind('click', function(e){
			e.preventDefault();
			if(typeof o.beforeShowLoading == 'function'){
				o.beforeShowLoading.call($a);
			}
			$('<div class="popup-src" id="popup-container-'+o.id+'" />').popUpAction($.extend({
				ajaxUrl: $a.attr('href'),
				type: 3
			}, o));
		});
	});
}

function confirmAction(o){
	var o = $.extend({
				text: '',
				callback: function(){},
				cancel: function(){},
				el: $(window),
				alert: false,
				style: {}
			}, o);
			$confirm = $('<div id="confirm-popup" class="clearfix"><h2></h2>' + (o.alert !== true ? '<a class="ir cancel" href="#"></a>' : '') + '<a class="ir ok" href="#"></a></div>'),
			ftime = 50;

	if(typeof o.text == 'object'){
		$(o.text).appendTo($confirm.find('h2'));
	} else {
		$confirm.find('h2').html(o.text);
	}
	$confirm.modal({
		zIndex: 100,
		fixed: false,
		autoResize: false,
		overlayClose: true,
		opacity: 30,
		persist: true,
		containerId: 'simplemodal-container-confirm',
		containerCss: o.style !== {} ? o.style : '',
		onOpen: function(dialog){
			dialog.overlay.height($(window).height()).fadeIn(ftime, function(){
				dialog.container.wrapInner('<div class="content">').show().css('opacity', '0');
				dialog.data.show();
				dialog.container.css('height', 'auto');
				$.modal.setPosition();
				dialog.container.animate({'opacity': 1}, ftime);
				dialog.overlay.bind('touchmove.modal', function(e){
					e.preventDefault();
					e.stopPropagation();
				});
				dialog.data.find('.ok').bind('click', function(e){
					e.preventDefault();
					$.modal.close();
					if(typeof o.callback == 'function'){
						o.callback.call(o.el);
					}
				});
				dialog.data.find('.cancel').bind('click', function(e){
					e.preventDefault();
					$.modal.close();
					if(typeof o.cancel == 'function'){
						o.cancel.call(o.el);
					}
				});				
			});
		},
		onClose: function(dialog){
			$.modal.close();
			if(typeof o.close == 'function'){
				o.close.call(o.el);
			}
		}
	});
}

$.fn.confirm = function(callback){
	return this.each(function(){
		$(this).unbind('.confirm').bind('click.confirm', function(e){
			e.preventDefault();
			confirmAction({
				text: lang.confirm,
				callback: callback,
				el: $(this)
			});
		});
	});
}

//popups:
function doPopups(){
	//help:
	$dom.html.on('click', 'a.help', function(e){
		e.preventDefault();
		var $a = $(this),
				href = $a.attr('href'),
				id = href.split('-')[href.split('-').length-1],
				o = {
					type: 1,
					ajaxUrl: ajaxHelp,
					id: id
				};

		//empty link?
		if(isNaN(id)){
			return;
		}

		if($a.closest('.popup-src').length){
			//it's inside a popup:
			var $target = $('<div class="minihelp" id="minihelp-'+id+'">');
			if($target.length){
				$.ajax({
					type: 'GET',
					url: ajaxHelp,
					data: {
						id: id
					},
					success: function(data){
						$target.html(data).insertAfter($a).prepend('<a class="close" />').css({
							top: $a.position().top + 20,
							left: $a.position().left - 100
						}).fadeIn(100).outsider(function(){
							$target.stop().fadeOut(100, function(){ $target.remove(); });
						}).find('a.close').bind('click', function(e){
							e.preventDefault();
							$target.stop().fadeOut(100, function(){ $target.remove(); });
						});
					}
				});
			}
		} else{
			$('<div class="popup-src help" id="help-'+id+'" />').popUpAction(o);
		}
	});


	//other popups:
	$('a.popup').bind('click', function(e){
		var $el = $(this),
				href = $el.attr('href'),
				o = {
					type: null,
					ajaxUrl: ''
				};
		if($el.hasClass('help') || $el.hasClass('form')){
			o.type = 1;
		} else {
			o.type = 2;
		}
		e.preventDefault();
		$target = $(href);
		if($target.length && href !== '#new-banner' && href !== '#new-event' && href !== '#new-public' && href !== '#new-recard'){
			if($el.closest('.popup-src').length){
				if($el.hasClass('active')){
					return false;
				}
				$.modal.close();
				$dom.window.one('modal-closed', function(){
					$target.popUpAction(o);	
				});
			} else {
				$target.popUpAction(o);
			}
		}
	});
}


//search autocomplete:
function doSearchAutoComplete(){
	$('.top-search .query').autocomplete({
		source: ajaxSearchAutoComplete,
		open: function(event, ui){
			var top = $('.ui-autocomplete').css('top');
			$('.ui-autocomplete').css('top', parseInt(top) + 5 + 'px');
		}
	});
}


$.fn.slides = function(o){
	o = $.extend({
		viewSelector: '.view',
		itemSelector: 'li',
		speed: 300,
		easing: 'easeInOutQuad',
		auto: true,
		autoTime: 4000
	}, o);
	return this.each(function(){
		var $el = $(this),
				$items = $el.find('li'),
				total = $items.length;

		if(total < 2) return;

		var $view = $el.find('.view'),
				$ul = $el.find('.view ul'),
				itemWidth = $items.eq(0).width(),
				$prev = $('<a class="ir prev" href="#" />').appendTo($view),
				$next = $('<a class="ir next" href="#" />').appendTo($view),
				$pager = $('<div class="pager" />').appendTo($el),
				pagerContent = '',
				index = 0,
				auto = o.auto, timer;

		for(var i = 0; i < total; i++){
			pagerContent += '<a class="ir page" href="#'+i+'">'+i+'</a>';
		}

		$pager.html(pagerContent);
		$ul.width(itemWidth * total);
		
		function prev(){
			if(index > 0){
				go(index - 1);
			} else {
				go(total - 1);
			}
		}

		function next(){
			if(index < total - 1){
				go(index + 1);
			} else {
				go(0);
			}
		}
		
		function go(i){
			$ul.stop().animate({
				'margin-left': 0 - itemWidth * i + 'px'
			}, o.speed, o.easing);
			index = i;
			$pager.find('a').eq(i).addClass('active').siblings().removeClass('active');
			if(auto) timer = setTimeout(next, o.autoTime);
		}

		$prev.bind('click', function(e){
			e.preventDefault();
			auto = false;
			clearTimeout(timer);
			prev();
		})

		$next.bind('click', function(e){
			e.preventDefault();
			auto = false;
			clearTimeout(timer);
			next();
		})

		$pager.find('a').bind('click', function(e){
			e.preventDefault();
			auto = false;
			clearTimeout(timer);
			go($(this).index());
		})

		go(0);

	});
}


$.fn.uploadWidget = function(){
	return this.each(function(){
		var $el = $(this),
				$attach = $el.find('.attach'),
				$label = $el.find('.label'),
				$labelHtml = $label.html(),
				$inputClone = $el.find('.file-input').clone(),
				$remove = $el.find('.remove'),
				$form = $el.closest('form'),
				$fileurl = $form.find('input[name=fileurl]').eq(0),
				$filename = $form.find('input[name=filename]').eq(0),
				$deletefile = $('<input>').attr({
					type: 'hidden',
					name: 'deletefile',
					value: $fileurl.val()
				}),
				hasFile = false,
				hasDeleteFile = false;
		
		function getNiceName(pathname){
			var maxlen = 35,
					valArray = pathname.split('\\'),
					filename = valArray[valArray.length-1];
			if(filename.length >= maxlen+3) filename = filename.substr(0,maxlen-13)+'...'+filename.substr(filename.length-10, 10);
			return filename;
		}
		if($fileurl.length && $fileurl.val() !== '' && $filename.length && $filename.val() !== ''){
			$label.html('<a href="' + $fileurl.val() + '" target="_blank">' + getNiceName($filename.val()) + '</a>' + '<a class="ir remove" href="#"></a>');
			hasFile = true;
		}
		$el.on('change', '.file-input', function(){
			$label.html(getNiceName($(this).val()) + '<a class="ir remove" href="#"></a>');
			if(hasFile === true && hasDeleteFile !== true){
				$deletefile.appendTo($el);
				hasDeleteFile = false;
			}
		});
		$el.on('click', '.attach', function(e){
			e.preventDefault();
			$el.find('.file-input').trigger('click');
		});
		$el.on('click', '.remove', function(e){
			e.preventDefault();
			$el.find('.file-input').replaceWith($inputClone.clone());
			$label.html($labelHtml);
			if(hasFile === true && hasDeleteFile !== true){
				$deletefile.appendTo($el);
				hasDeleteFile = true;
			}
		});
	});
}

/*
feedback:
*/
function doFeedback(){
	$('.form-feedback .upload.widget').uploadWidget();
}



/*
home:
*/
function doHome(){
	function goToInstruments(){
		$dom.htmlBody.stop().animate({
				scrollTop: $('div.instruments').offset().top - 60
			}, 300, 'easeInOutQuad');
	}

	var hash = window.location.hash;
	if(hash.match(/^#instruments/)){
		setTimeout(function(){goToInstruments();}, 200);
	}	

	$('header a[href=#instruments]').bind('click', function(e){
		e.preventDefault();
		goToInstruments();
	});
	$('.home .slides').slides();
}

/*
groups global:
*/

$.fn.groupFavAction = function(o){
	var $favCount = $('#top .favorities .count');

	o = $.extend({
		itemSelector: '.group'
	}, o);

	return this.each(function(){
		var $a = $(this),
				id = $a.closest(o.itemSelector).attr('rel')
				action = $a.hasClass('active') ? 'remove' : 'add';
		if(loggedIn !== true){
			$dom.top.find('a[href=#form-login]').click();
			return;
		}
		if(parseInt(id) > 0){
			$.confirm({
				content: action == 'add' ? lang.groupAddToFav : lang.groupRemoveFromFav,
				ok: function(){
					$.ajax({
						type: 'GET',
						url: ajaxGroupsAddToFav,
						data: {
							action: action,
							id: id
						},
						success: function(data){
							var favCount = parseInt($favCount.text());
							$favCount.text(action == 'add' ? favCount + 1 : favCount - 1);
							if(action == 'add'){
								$a.addClass('active');
							} else {
								$a.removeClass('active');
								if($a.closest('.groups.widget').data('listtype') == '3'){
									$a.closest('.group').remove();
								}
							}
						}					
					});
				},
				el: $a
			})			
		}
	});
}

function doEventsOffers(){
	$.fn.eventsOffers = function(){
		return this.each(function(){
			var $root = $(this),
					$eoList = $root.find('.eo-dates-list'),
					$listActions = $root.find('.list-actions'),
					$more = $listActions.find('.more'),
					perpage = $root.data('perpage') || 20,
					typeid = $root.data('typeid') || 2,
					state = {
						start: $eoList.find('.eo-date:not(.duplicate)').length,
						take: perpage,
						type: typeid
					};

			function fixGuestBorders(){
				$eoList.find('.guest').each(function(){
					var $guest = $(this);
					if($guest.position().left == 0){
						$guest.addClass('first-child');
					}
				});
			}

			function checkLast(){
				if($eoList.find('.eo-date.last').length){
					$listActions.hide();
				} else {
					$listActions.show();
				}
			}

			fixGuestBorders();
			checkLast();

			function getEventsOffers(rData, mode){
				$.ajax({
					type: 'GET',
					url: ajaxMoreEvents,
					data: rData,
					success: function(data){
						var $data = $(data);
						if(!$data.find('li')){
							return false;
						}
						if(mode == 'append'){
							$data.appendTo($eoList);
						} else {
							$eoList.html(data);
						}
						state = rData;
						state.start = $eoList.find('.eo-date:not(.duplicate)').length;
						
						fixGuestBorders();
						checkLast();

					}
				});

			}
			
			$eoList.on('click', '.club-title .star', function(e){
				e.preventDefault();
				$(this).clubFavAction({
					itemSelector: '.club-title'
				});
			});

			$more.bind('click', function(e){
				e.preventDefault();
				getEventsOffers({
					start: state.start,
					take: state.take,
					type: state.type
				}, 'append');
			});

		});
	}
	$('.events-offers').eventsOffers();
}

function doPosters(){
	$.fn.posters = function(){
		return this.each(function(){
			var $root = $(this),
					$postersList = $root.find('.posters-list'),
					$listActions = $root.find('.list-actions'),
					$more = $listActions.find('.more'),
					$editPosterContainer = $('#edit-poster'),
					perpage = $root.data('perpage') || 20,
					state = {
						start: $postersList.find('.poster').length,
						take: perpage,
					},
					fadeSpeed = 100;

			//actions on hover:
			$postersList.on('mouseenter.hl', '.poster', function(){
				$(this).find('.actions').stop().fadeIn(fadeSpeed);
			}).on('mouseleave.hl', '.poster', function(){
				$(this).find('.actions').stop().fadeOut(fadeSpeed);
			}).on('click', '.actions .edit', function(e){
				e.preventDefault();
				var $poster = $(this).closest('.poster');
				$editPosterContainer.popUpAction({
					type: 2,
					posterId: $(this).closest('.poster').attr('rel'),
					afterShow: function(){
						var $popup = this.data,
								$form = $popup.find('form');
						$popup.find('.contact-field .txt').html($poster.find('.data .contact').html());
						$popup.find('.subject-field .txt').html($poster.find('.data .subject').html());
						$form.find('input[name=eventid]').val($poster.attr('rel'));
						$form.find('input[name=posterid]').val($poster.data('posterid'));
						$form.validate({
							ignore: [],
							errorContainer: $('.error-message'),
							submitHandler: function(){
								$form.ajaxSubmit({
									beforeSubmit: function(){
										$form.find('a.submit').addClass('disabled');
									},
									success: function(response, status, xhr, $form){
										window.location.reload();
									}
								});
							}
						});

					}
				});
			}).on('click', '.actions .approve', function(e){
				e.preventDefault();
				approvePoster($(this).closest('.poster').attr('rel'));
			});

			function approvePoster(id){
				var $poster = $postersList.find('.poster[rel='+id+']'),
						isApproved = $poster.hasClass('approved');

				$.ajax({
					type: 'get',
					url: ajaxApproveEvent,
					data: {
						id: id,
						action: isApproved ? 2 : 1
					},
					success: function(data){
						if(data == 1){
							$poster.addClass('approved');
						} else {
							$poster.removeClass('approved');	
						}				
					}
				});

			}
			
			function checkLast(){
				if($postersList.find('.poster.last').length){
					$listActions.hide();
				} else {
					$listActions.show();
				}
			}

			checkLast();

			function getPosters(rData, mode){
				var $list = $postersList,
						itemSelector = '.poster';
				$.ajax({
					type: 'GET',
					url: ajaxMorePosters,
					data: rData,
					success: function(data){
						var $data = $(data);
						if(!$data.find('li')){
							return false;
						}
						if(mode == 'append'){
							$data.appendTo($list);
						} else {
							$eoList.html(data);
						}
						checkLast();
						state = rData;
						state.start = $list.find(itemSelector).length;
					}
				});
			}

			$more.bind('click', function(e){
				e.preventDefault();
				getPosters({
					start: state.start,
					take: state.take,
					type: state.type
				}, 'append');
			});

			$postersList.find('.poster a.img').fancybox({
				margin: 105,
				padding: 0,
				speedIn: 100,
				speedOut: 100,
				changeSpeed: 100,
				changeFade: 100,
				overlayColor: '#000',
				overlayOpacity: .7,
				centerOnScroll: true
			});

		});
	}
	$('.widget.posters').posters();
}

function doGroups(){
	
	$.fn.groups = function(){
		return this.each(function(){
			var $root = $(this),
					$groupsFilter = $root.find('.groups-filter'),
					$citySelect = $groupsFilter.find('.city-select select'),
					$groupsList = $root.find('.groups-list'),
					$listActions = $root.find('.list-actions'),
					$more = $listActions.find('a.more'),
					perpage = $root.data('perpage') || 50,
					userid = $root.data('userid') || 0,
					listtype = $root.data('listtype') || 1,
					state = {
						groupsubject: 0,
						start: $groupsList.find('.group').length,
						sort: '',
						dir: 'desc',
						take: perpage,
						listtype: listtype
					}
					if($root.hasClass('user-groups')){
						state.userid = userid;
					};
			
			function getgroups(rData, mode){
				$.ajax({
					type: 'GET',
					url: ajaxMoreGroups,
					data: rData,
					success: function(data){
						var $data = $(data);
						if(!$data.find('li')){
							return false;
						}
						if(mode == 'append'){
							$data.appendTo($groupsList);
						} else {
							$groupsList.html(data);
						}
						state = rData;
						state.start = $groupsList.find('.group').length;
						
						if(state.sort){
							var sortClass = '';
							if(state.sort == 'age'){
								sortClass = 'age';
							} else if(state.sort == 'price'){
								sortClass = 'price';
							} else if(state.sort == 'contactprice'){
								sortClass = 'contactprice';
							} else if(state.sort == 'refusal'){
								sortClass = 'refusal';
							} else if(state.sort == 'likes'){
								sortClass = 'grp-followers';
							}
							$groupsFilter.find('.sort').removeClass('active asc desc');
							var $sort = $groupsFilter.find('.'+sortClass+' .sort');
							$sort.addClass('active');
							if(state.dir == 'asc'){
								$sort.removeClass('desc').addClass('asc');
							} else {
								$sort.removeClass('asc').addClass('desc');
							}
						}

						if($groupsList.find('.group.last').length){
							$listActions.hide();
						} else {
							$listActions.show();
						}

					}
				});
			}

			$more.bind('click', function(e){
				e.preventDefault();
				getgroups($.extend(state,{
					take: perpage
				}), 'append');
			});

			$groupsFilter.find('.sort').bind('click', function(e){
				e.preventDefault();
				var $a = $(this),
						$col = $a.closest('.col'),
						mysort = '';
				if($col.hasClass('age')){
					mysort = 'age';
				} else if($col.hasClass('price')){
					mysort = 'price';
				} else if($col.hasClass('contactprice')){
					mysort = 'contactprice';
				} else if($col.hasClass('refusal')){
					mysort = 'refusal';
				} else if($col.hasClass('grp-followers')){
					mysort = 'likes';
				}
				state.sort = mysort;
				state.start = 0;
				state.take = $groupsList.find('.group').length;
				state.dir = $a.hasClass('desc') ? 'asc' : 'desc';
				getgroups(state);
			});

			$citySelect.bind('change', function(e){
				state.groupsubject = $(this).val();
				state.start = 0;
				getgroups(state);
			});




			$('.groups-list').on('mouseenter.hl', '.group.user-group', function(){
				$(this).find('.overlay').stop().fadeIn(100);
			}).on('mouseleave.hl', '.group', function(){
				$(this).find('.overlay').stop().fadeOut(100);
			}).on('click', '.actions .delete:not(.disabled)', function(e){
				e.preventDefault();
				$.confirm({
					content: 'Вы действительно хотите удалить группу?',
					ok: function(){
						$(this).deleteMe({
							itemSelector: '.group',
							url: '/groups/update/',
							success: function(){
								window.location.reload();
							}
						});
					},
					el: $(this)
				});
			});


			//hover highlighting + fav action:
			$groupsList.on('mouseenter.hl', '.hl', function(){
				$(this).closest('.group').find('.logo').addClass('hover');
			}).on('mouseleave.hl', '.hl', function(){
				$(this).closest('.group').find('.logo').removeClass('hover');
			}).on('click', '.star', function(e){
				e.preventDefault();
				$(this).groupFavAction();
			});

		});
	}

	$('.widget.groups').groups();

}


/*
datepicker:
*/


function formatYearString(year){
	return year;
}

jQuery.extend(jQuery.datepicker, {
	_checkOffset: function(inst, offset, isFixed) {
		var $field = inst.input.closest('.date-field');
		if(!$field.length){
			return offset;
		}
		var $icon = $field.find('.icon');
		if(!$icon.length){
			return offset;
		}
		var fl = $field.offset().left,
				ft = $field.offset().top,
				il = $icon.offset().left,
				fw = $field.width(),
				fh = $field.height();
		offset.top = ft;
		offset.left = fl + 15;
		return offset;
	}
});


$.fn.dateField = function(o){
	return this.each(function(){		
		var $root = $(this),
				$input = $root.find('.date-input'),
				$day = $root.find('.date-display .day'),
				$month = $root.find('.date-display .month'),
				$year = $root.find('.date-display .year'),
				$time = $root.find('.date-display .time'),
				$icon = $('<span class="icon" />').appendTo($root.find('.date-display')),
				withTime = $root.hasClass('with-time'),
				cT = new Date(),
				initTime = '00:00';

		cT.setDate(cT.getDate() + 1);

		var cDay = cT.getDate(),
				cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
				cYear = cT.getFullYear();

		if($input.val() == ''){
			$input.val(cYear + '-' + cMonth + '-' + cDay + (withTime ? ' ' + initTime : ''));
			$day.html(cDay);
			$month.html(lang.months[cT.getMonth()][1]);
			$year.html(formatYearString(cYear));
			if(withTime){
				$time.html(initTime);
			}
		} else {
			var s = $input.val();
			if(withTime){
				var datetimearray = s.split(' ');
				s = datetimearray[0];
				$time.html(datetimearray[1]);
			}

			var datearray = s.substr(0, 10).split('-');
			$day.html(datearray[2]);
			$month.html(lang.months[parseInt(datearray[1])-1][1]);
			$year.html(formatYearString(datearray[0]));
		}

		var dpDefaults = {
			duration: 100,
			prevText: '',
			nextText: '',
			minDate: '0',
			dateFormat: 'yy-mm-dd',
			onSelect: function(dateText, inst) {
				var i = inst.inst !== undefined ? inst.inst : inst;
				$day.html(i.currentDay);
				$month.html(lang.months[i.currentMonth][1]);
				$year.html(i.currentYear);
				if(inst.formattedTime !== undefined){
					$time.html(inst.formattedTime);
				}
			},
			beforeShow: function(){
				$input.addClass('datepicker-open');
			},
			onClose: function(){
				$input.removeClass('datepicker-open');					
			}
		};

		if(withTime){
			$input.datetimepicker($.extend(true, dpDefaults, {
				timeFormat: 'HH:00'
			}, o));
		} else {
			$input.datepicker($.extend(true, dpDefaults, o));
		}

		$root.bind('mousedown', function(e){
		}).bind('mouseup', function(){
			if(!$input.hasClass('datepicker-open')){
				$input.datepicker('show');
			} else {
				$input.datepicker('hide');
			}
		});
		$dom.document.bind('keydown', function(e){
			if(e.keyCode === 27){
				$input.datepicker('hide');
			}
		});
	});
}


//date range select:
$.fn.dateRange = function(){
	return this.each(function(){
		var dateDelimiter = '-',
				$el = $(this),
				$inputFrom = $el.find('.date-from .date-input'),
				$inputTo = $el.find('.date-to .date-input'),
				$dayTo = $el.find('.date-to .date-display .day'),
				$monthTo = $el.find('.date-to .date-display .month'),
				$yearTo = $el.find('.date-to .date-display .year'),
				cT = new Date(),
				cDay = String(cT.getDate()).length < 2 ? '0' + cT.getDate() : cT.getDate(),
				cMonth = String(cT.getMonth() + 1).length < 2 ? '0' + (cT.getMonth() + 1) : (cT.getMonth() + 1),
				cYear = cT.getFullYear();

		function dateDiff(){
			var df = $inputFrom.val().substr(0, 10).split(dateDelimiter),
					dt = $inputTo.val().substr(0, 10).split(dateDelimiter),
					dateFrom = new Date(df[0], df[1]-1, df[2]),
					dateTo = new Date(dt[0], dt[1]-1, dt[2]),
					day=1000*60*60*24;
			return Math.round((dateTo.getTime()-dateFrom.getTime())/day);
		}

		function setDateToRange(){
			var df = $inputFrom.val().substr(0,10).split(dateDelimiter),
					dt = $inputTo.val().substr(0,10).split(dateDelimiter);
			$inputTo.datepicker('option', 'minDate', $inputFrom.val().substr(0,10));
			var dd = dateDiff();
			if(dd <= 0){
				$inputTo.datepicker('setDate', $inputFrom.val().substr(0,10));
				$dayTo.html(df[2]);
				$monthTo.html(lang.months[df[1]-1][1]);
				$yearTo.html(formatYearString(df[0]));
			}
		}

		$el.find('.date-field').dateField({
			onSelect: function(dateText, inst) {
				var i = inst.inst !== undefined ? inst.inst : inst,
						$input = i.input,
						$el2 = $input.closest('.date-field'),
						$day = $el2.find('.date-display .day'),
						$month = $el2.find('.date-display .month'),
						$year = $el2.find('.date-display .year'),
						$time = $el2.find('.date-display .time');
				$day.html(i.currentDay);
				$month.html(lang.months[i.currentMonth][1]);
				$year.html(formatYearString(i.currentYear));

				if(inst.formattedTime !== undefined){
					$time.html(inst.formattedTime);
				}

				if($input.is($inputFrom)){
					setDateToRange();
				};
				$el.data('dateDiff', dateDiff()).trigger('dateChange');
			}
		});

		setDateToRange();
		$el.data('dateDiff', dateDiff());

	});
}




/*
banners global:
*/

function doBanners(){
	var speed = 100;

	//banner actions on hover:
	$('.banners-list').on('mouseenter.hl', '.banner', function(){
		$(this).find('.actions').stop().fadeIn(speed);
	}).on('mouseleave.hl', '.banner', function(){
		$(this).find('.actions').stop().fadeOut(speed);
	});

	function popupAfterShow(id){
		var $el = $(this),
				$form = $(id + ' form'),
				$dailyCounters = $(id).find('.visits-total .co, .max-campaign-cost .co'),
				$dateRange = $(id + ' .date-range');

		$dailyCounters.each(function(){
			var $c = $(this);
			$c.data('dailyValue', $c.text());
		});
		function updateDailies(){
			var dd = parseInt($dateRange.data('dateDiff'));
			$dailyCounters.each(function(){
				var $c = $(this);
				$c.text($c.data('dailyValue')*dd);
			});
		}

		$(id + ' .clubs-filter').clubsFilterList().bind('listChange', function(){
			var $idsInput = $(this).find('.ids-input'),
					ids = $idsInput.val();
			$.ajax({
				type: 'post',
				url: ajaxBannersGA,
				data: {
					id: ids
				},
				dataType: 'json',
				success: function(response){
					var $visits = $dailyCounters.filter('.visits-total .co.count-2'),
							contactCost = $(id + ' .params .contact-cost').text(),
							$campaignCost = $dailyCounters.filter('.max-campaign-cost .co.count-2');
					$visits.data('dailyValue', 0);
					$campaignCost.data('dailyValue', 0);

					if(response && response.ga){						
						$visits.data('dailyValue', parseInt(response.ga));
						$campaignCost.data('dailyValue', Math.ceil(parseInt(response.ga) * contactCost));
					}
					
					updateDailies();
				}

			});
		});

		$(id + ' .upload.widget').uploadWidget();
		$(id + ' .date-range').dateRange().bind('dateChange', function(){
			updateDailies();
		});
		updateDailies();

		$form.validate({
			ignore: [],
			errorContainer: $('.error-message'),
			submitHandler: function(){
				$form.ajaxSubmit({
					beforeSubmit: function(){
						$form.find('a.submit').addClass('disabled');
					},
					success: function(response, status, xhr, $form){
						location.replace(urlBannersList);
					}
				});
			}
		});
	}

	$('.banners-list').on('click', '.overlay.actions a:not(.open)', function(e){
		e.preventDefault();
	});
	
	$('.banners-list').on('click', '.overlay.actions .edit:not(.disabled)', function(e){
		e.preventDefault();
		var $a = $(this),
				id = $a.closest('.banner').attr('rel');

		if($a.hasClass('disabled')) return false;

		if(parseInt(id) > 0){
			var $popup = $('<div class="popup-src edit-banner" id="edit-banner-'+id+'" />');
			$popup.popUpAction({
				type: 2,
				ajaxUrl: ajaxEditBanner,
				id: id,
				afterShow: function(){
					popupAfterShow('#edit-banner-'+id);
				}
			});
		}
	});

	$('.banners-list .overlay.actions .delete:not(.disabled)').confirm(function(){
		$(this).deleteMe({
			itemSelector: '.banner',
			url: ajaxUpdateBanner,
			success: function(){
				location.replace(urlBannersList);
			}
		});		
	});
	
	$('a[href="#new-banner"]').bind('click', function(e){
		e.preventDefault();
		$('<div class="popup-src edit-banner" id="new-banner" />').popUpAction({
			type: 2,
			ajaxUrl: ajaxEditBanner,
			afterShow: function(){
				popupAfterShow('#new-banner');
			}
		});
	});

	
	$('.edit-banner .date-range').dateRange();
	
	$('.edit-banner .upload.widget').uploadWidget();

}

$.fn.groupsCountSwitch = function(){
	return this.each(function(){
		var $el = $(this),
				$counters = $el.closest('.popup-src').find('.params .co');
		$el.unbind('.groupsCountSwitch').bind('change.groupsCountSwitch', function(){
			var val = $el.val();
			$counters.filter('.count-'+val).addClass('active').siblings().removeClass('active');
		});
		if($el.prop('checked') === true){
			$el.trigger('change');
		}
	});
}

function doGroupsCountSwitch(){
	$dom.window.bind('popupShow', function(){
		$('.popup-src form .groups-filter input[type=radio]').groupsCountSwitch();
	});
}



/*
events global:
*/

function doEvents(){
	var speed = 100;

	//event actions on hover:
	$('.events-list').on('mouseenter.hl', '.event', function(){
		$(this).find('.actions').stop().fadeIn(speed);
	}).on('mouseleave.hl', '.event', function(){
		$(this).find('.actions').stop().fadeOut(speed);
	});

	function popupAfterShow(id){
		var $el = $(this),
				$form = $(id + ' form');
		$(id + ' .upload.widget').uploadWidget();
		$(id + ' .date-field').dateField();
		$(id + ' select').ikSelect({
			autoWidth: false,
			ddFullWidth: false
		}).bind('showBlock', function(){
			$('.ik_select_list_inner > ul').doNanoScroll();
		});		
		$(id + ' .clubs-filter').clubsFilterList();
		$form.validate({
			ignore: [],
			errorContainer: $('.error-message'),
			submitHandler: function(){
				$form.ajaxSubmit({
					beforeSubmit: function(){
						$form.find('a.submit').addClass('disabled');
					},
					success: function(response, status, xhr, $form){
						location.replace(urlEventsList);
					}
				});
			}
		});
	}

	$('.events-list').on('click', '.overlay.actions a:not(.open)', function(e){
		e.preventDefault();
	});
	
	$('.events-list').on('click', '.overlay.actions .edit:not(.disabled)', function(e){
		e.preventDefault();
		var $a = $(this),
				id = $a.closest('.event').attr('rel');

		if($a.hasClass('disabled')) return false;

		if(parseInt(id) > 0){
			var $popup = $('<div class="popup-src edit-event" id="edit-event-'+id+'" />');
			$popup.popUpAction({
				type: 2,
				ajaxUrl: ajaxEditEvent,
				id: id,
				afterShow: function(){
					popupAfterShow('#edit-event-'+id);
				}
			});
		}
	});
	$('.events-list .overlay.actions .delete:not(.disabled)').confirm(function(){
		$(this).deleteMe({
			itemSelector: '.event',
			url: ajaxUpdateEvent,
			success: function(){
				location.replace(urlEventsList);
			}
		});
	});

	$('a[href="#new-event"]').bind('click', function(e){
		e.preventDefault();
		$('<div class="popup-src edit-event" id="new-event" />').popUpAction({
			type: 2,
			ajaxUrl: ajaxEditEvent,
			afterShow: function(){
				popupAfterShow('#new-event');
			}
		});
	});

	$('.event-report-list a[href="#geteventreport"]').bind('click', function(e){
		e.preventDefault();
		var id = $(this).closest('.item').attr('rel');
		$('<div class="popup-src event-offer-report" id="event-offer-report" />').popUpAction({
			type: 2,
			ajaxUrl: ajaxEventReport,
			id: id,
			afterShow: function(){
				//popupAfterShow('#new-event');
			}
		});
	});

	$('.edit-event .upload.widget').uploadWidget();

	$('.edit-event .date-field').dateField();
}




/*
public global:
*/

function doPublic(){
	var speed = 100;

	//public actions on hover:
	$('.publics-list').on('mouseenter.hl', '.public', function(){
		$(this).find('.actions').stop().fadeIn(speed);
	}).on('mouseleave.hl', '.public', function(){
		$(this).find('.actions').stop().fadeOut(speed);
	});

	function popupAfterShow(id){
		var $el = $(this),
				$form = $(id + ' form');

		$(id + ' .groups-filter').groupsFilterList().bind('listChange', function(){
			var $idsInput = $(this).find('.ids-input'),
					ids = $idsInput.val();
			$.ajax({
				type: 'post',
				url: ajaxPublicGRP,
				data: {
					id: ids
				},
				dataType: 'json',
				success: function(response){
					var $grp = $(id + ' .params .grp .co.count-2'),
							ratio = $(id + ' .params .public-ratio').text(),
							$cost = $(id + ' .params .max-campaign-cost');
					$grp.text(0);
					$cost.text(0);

					if(response && response.grp){
						var grp = parseInt(response.grp);
						$grp.text(grp);
						$cost.text(Math.ceil(grp * ratio));
					}
				}

			});
		});


		$(id + ' .upload.widget').uploadWidget();
		$(id + ' .date-field').dateField();
		$form.validate({
			ignore: [],
			errorContainer: $('.error-message'),
			submitHandler: function(){
				$form.ajaxSubmit({
					beforeSubmit: function(){
						$form.find('a.submit').addClass('disabled');
					},
					success: function(response, status, xhr, $form){
						location.replace(urlPublicList);
					}
				});
			}
		});
	}

	$('.publics-list').on('click', '.overlay.actions a:not(.open):not(.edit)', function(e){
		e.preventDefault();
	});

/*	$('.publics-list').on('click', '.overlay.actions .edit:not(.disabled)', function(e){
		e.preventDefault();
		var $a = $(this),
				id = $a.closest('.public').attr('rel');

		if($a.hasClass('disabled')) return false;

		if(parseInt(id) > 0){
			var $popup = $('<div class="popup-src edit-public" id="edit-public-'+id+'" />');
			$popup.popUpAction({
				type: 2,
				ajaxUrl: ajaxEditPublic,
				id: id,
				afterShow: function(){
					popupAfterShow('#edit-public-'+id);
				}
			});
		}
	});
*/
	$('.publics-list .overlay.actions .delete:not(.disabled)').confirm(function(){
		$(this).deleteMe({
			itemSelector: '.public',
			url: ajaxUpdatePublic,
			success: function(){
				location.replace(urlPublicList);
			}
		});
	});
	$('a[href="#new-public"]').bind('click', function(e){
		e.preventDefault();
		$('<div class="popup-src edit-public" id="new-public" />').popUpAction({
			type: 2,
			ajaxUrl: ajaxEditPublic,
			afterShow: function(){
				popupAfterShow('#new-public');
			}
		});
	});

	$('.edit-public .upload.widget').uploadWidget();

	$('.edit-public .date-field').dateField();

	$('.public-report-list').each(function(){
		$('.c.pay a').bind('click', function(e){
			e.preventDefault();
			var $a = $(this),
					price = $a.closest('.line').find('.c.price').text(),
					id = $a.data('groupid');
			$.confirm({
				content: 'Вы уверены, что хотите оплатить ' + price + ' за публикацию?',
				ok: function(){
					$.ajax({
						type: 'post',
						url: '/user/payforpost/',
						data: {
							id: id
						},
						complete: function(data){
							if(data && data.responseText){
								data = $.parseJSON(data.responseText);
								$.alert({
									content: data.status,
									close: function(){
										if(data.error == false){
											window.location.reload();
										}							
									}
								});
							}
						}
					});
				}
			});
		});
	});

}




//groups filter on recard page - "tags autocomplete":
$.fn.groupsFilterList = function(){
	return this.each(function(){
		var $el = $(this),
				$list = $el.find('.groups-filter-list'),
				$listInput = $list.find('.groups-list-input'),
				$idsInput = $list.find('.ids-input'),
				ids = [], // array of currently selected ids
				idsNames = [], // ids to names
				$radios = $el.find('.radios input'),
				groupsDelimiter = ';',
				$counters = $el.closest('form').find('.params .groups-count'),
				$groupsCount = $counters.find('.count-2'),
				$form = $el.closest('form'),
				groupsCount = 0;

		//populate arrays from input values:
		if($idsInput.val() !== ''){
			ids = $idsInput.val().split(',');
		}

		if($listInput.val() !== ''){
			var names = $listInput.val().split(groupsDelimiter);
			for(var j = 0; j < ids.length; j++){
				idsNames.push({id: ids[j], name: names[j]});
			}
		}

		function updateCount(){
			groupsCount = ids.length;
			$groupsCount.text(groupsCount);
			$el.trigger('listChange');
		}

		$radios.bind('change', function(){
			var val = $(this).val();

			if(val == '2'){
				$list.show();
				$idsInput.addClass('required');
				if(!$list.find('.tagsinput').length){
					$listInput.tagsInput({
						width: 'auto',
						delimiter: groupsDelimiter,
						defaultText: '',
						minChars: 2,
						autocomplete_url: ajaxGroupsAutoComplete,
						autocomplete: {
							//autocomplete options
							minLength: 2
						},

						onAddTag: function(tag){
							var valid = false;
							$('.ui-autocomplete a').each(function(){
								var $a = $(this),
										id = $a.closest('.ui-menu-item').data('item.autocomplete').id;
								if($a.text() == tag){
									valid = true;
									idsNames.push({id: id, name: tag});
									ids.push(id);
									$idsInput.val(ids.join());
									updateCount();
								}
							});
							if(valid !== true){
								$listInput.removeTag(tag);
							} else {
								$idsInput.removeClass('error');
							}
						},

						onRemoveTag: function(tag){
							var idrem;

							for(var i=0; i < idsNames.length; i++){
								if(idsNames[i].name == tag){
									idrem = idsNames[i].id;
								}
							}

							while (ids.indexOf(idrem) !== -1) {
								ids.splice(ids.indexOf(idrem), 1);
							}

							$idsInput.val(ids.join());
							updateCount();
						}

					});
					$ti = $list.find('.tagsinput');
					$idsInput.css({
						top: $ti.position().top-2,
						height: $ti.outerHeight(false)-8,
						width: $ti.outerWidth()-10
					});

				}
				$.modal.setPosition();
			} else {
				$list.hide();				
				$idsInput.removeClass('required');
				$.modal.setPosition();
			}
		});
	});
}


$.fn.deleteMe = function(o){
	o = $.extend({
		itemSelector: '.item',
		url: '',
		success: function(data){
			window.location.reload();
		}	
	}, o);
	var $item = $(this).closest(o.itemSelector),
			id = $item.attr('rel'),
			fileurl = $item.data('fileurl'),
			request = { delete: id };

	if(fileurl && fileurl !== ''){
		request = $.extend(request, {deletefile: fileurl});
	}

	$.ajax({
		url: o.url,
		data: request,
		success: o.success	
	});
};


/*
recard global:
*/

function doRecard(){
	var speed = 100;

	//recard actions on hover:
	$('.recards-list').on('mouseenter.hl', '.recard', function(){
		$(this).find('.actions').stop().fadeIn(speed);
	}).on('mouseleave.hl', '.recard', function(){
		$(this).find('.actions').stop().fadeOut(speed);
	});

	function popupAfterShow(id){
		var $el = $(this),
				$form = $(id + ' form');
		$(id + ' .upload.widget').uploadWidget();
		//$(id + ' .date-field').dateField();
		$(id + ' .date-range').dateRange();
		$(id + ' .clubs-filter').clubsFilterList();
		$form.validate({
			ignore: [],
			errorContainer: $('.error-message'),
			submitHandler: function(){
				$form.ajaxSubmit({
					beforeSubmit: function(){
						$form.find('a.submit').addClass('disabled');
					},
					success: function(response, status, xhr, $form){
						location.replace(urlRecardsList);
					}
				});
			}
		});
	}

	$('.recards-list').on('click', '.overlay.actions a:not(.open)', function(e){
		e.preventDefault();
	});
	
	$('.recards-list').on('click', '.overlay.actions .edit:not(.disabled)', function(e){
		e.preventDefault();
		var $a = $(this),
				id = $a.closest('.recard').attr('rel');

		if($a.hasClass('disabled')) return false;

		if(parseInt(id) > 0){
			var $popup = $('<div class="popup-src edit-recard" id="edit-recard-'+id+'" />');
			$popup.popUpAction({
				type: 2,
				ajaxUrl: ajaxEditRecard,
				id: id,
				afterShow: function(){
					popupAfterShow('#edit-recard-'+id);
				}
			});
		}
	});
	$('.recards-list .overlay.actions .delete:not(.disabled)').confirm(function(){
		$(this).deleteMe({
			itemSelector: '.recard',
			url: ajaxUpdateRecard,
			success: function(){
				location.replace(urlRecardsList);
			}			
		});
	});

	$('a[href="#new-recard"]').bind('click', function(e){
		e.preventDefault();
		$('<div class="popup-src edit-recard" id="new-recard" />').popUpAction({
			type: 2,
			ajaxUrl: ajaxEditRecard,
			afterShow: function(){
				popupAfterShow('#new-recard');
			}
		});
	});

	$('.edit-recard .upload.widget').uploadWidget();

	$('.edit-recard .date-field').dateField();


}


//serialize form data into JSON:
(function($){
$.fn.serializeJSON = function() {
    var json = {};
    jQuery.map($(this).serializeArray(), function(n, i){
        json[n['name']] = n['value'];
    });
    return json;
};
})(jQuery);


function doProfile(){
	$('.profile-form').each(function(){
		var $form = $(this).find('form').eq(0);
		$form.bind('submit', function(e){
			e.preventDefault();
			$form.ajaxSubmit({
				url: $form.attr('action'),
				type: 'post',
				data: {ajax: 1},
				complete: function(data){
					var data = $.parseJSON(data.responseText);
					if(data.error && data.error == true){
						$.alert({
							content: data.status
						});
					} else {
						$form.ajaxSubmit({
							url: $form.attr('action'),
							type: 'post',
							complete: function(data){
								var data = $.parseJSON(data.responseText);
								$.alert({
									content: data.status,
									ok: function(){
										window.location.reload();
									}
								});
							}
						});
					}
				}
			});
		})
	});
	$('.password-change-form').each(function(){
		if(window.location.href.indexOf('change=1') !== -1){
			$('#popup-password-changed').popUpAction();
		} else if(window.location.href.indexOf('change=2') !== -1){
			$('#popup-password-not-changed').popUpAction();
		}
	});
}

function doBottomListStars(){
	$('.bottom-list .item a.button.star').bind('click', function(e){
		e.preventDefault();
		$(this).clubFavAction({
			itemSelector: '.item'
		});
	});
}


$.fn.resetForm = function(){
	return this.each(function(){
		var $form = $(this);
		$form[0].reset();
		$form.find('.upload.widget .remove').click();
	});
}
$.fn.validationSetup = function(){
	return this.each(function(){
		var $form = $(this);
		$form.bind('invalid-form.validate', function(){
			if(!$form.parent().hasClass('password-create-form') && !$form.parent().hasClass('password-change-form')){
				$form.find('.error-message').html(lang.errors.requiredFields).show();
			}
		});
		var vRules = {},
				vMessages = {
					required: lang.errors.requiredFields
				},
				vErrorPlacement = function(){};
		if($form.parent().hasClass('password-create-form')){
			$form.find('.error-message').show();
			vRules = {
				'passwordrepeat': {
					equalTo: '#password-create'
				}
			};
			vMessages = {
				'password': {
					required: lang.errors.requiredFields
				},
				'passwordrepeat': {
					required: lang.errors.requiredFields,
					equalTo: lang.errors.passwordsDoNotMatch
				}
			};
			vErrorPlacement = function (error, element) {
				$('.error-message').html(error.html());
			}
		} else if($form.parent().hasClass('password-change-form')){
			$form.find('.error-message-2').show();
			vRules = {
				'passwordrepeat': {
					equalTo: '#field-new-password'
				}
			};
			vMessages = {
				'password': {
					required: lang.errors.requiredFields
				},
				'passwordrepeat': {
					required: lang.errors.requiredFields,
					equalTo: lang.errors.passwordsDoNotMatch
				}
			};
			vErrorPlacement = function (error, element) {
				$('.error-message-2').html(error.html());
			}
		}
		$form.validate({
			errorContainer: $('.error-message'+($form.parent().hasClass('password-change-form')?'-2':'')),
			errorPlacement: vErrorPlacement,
			rules: vRules,
			messages: vMessages,
			submitHandler: function(){
				if(!$form.hasClass('noajax')){
					$form.ajaxSubmit({
						dataType: 'json',
						beforeSubmit: function(){
						},
						success: function(response, status, xhr, $form){
							if (response && response.error) {
								$form.find('.error-message').html(response.status).show();
								return false;
							} else if($form.parent().hasClass('form-login')){
									$form.unbind('submit').submit();
							} else if(response && response.redirect){
								location.replace(response.redirect);
							} else {
								$form.resetForm();
								if($dom.body.find('.simplemodal-container').length > 0){								
									$.modal.close();
									$dom.window.one('modal-closed', function(){
										$('#popup-done').popUpAction({type: 0});
									});
								} else {
									$('#popup-done').popUpAction({type: 0});
								}
							}
						}
					});
				} else {
					$form.unbind('submit').submit();
				}
			}
		});
	});
}


function doForms(){
	$dom.html.on('click', 'form a.submit:not(.disabled)', function(e){
		e.preventDefault();
		var $a = $(this),
				$form = $a.closest('form');
		$form.submit();
	});

	$('form.validate').validationSetup();

}



function doEnterPage(){
	$('body.enter').each(function(){
		$('a.forgot').bind('click', function(e){
			e.preventDefault();
			$('.form-login').hide();
			$('.form-forgot').show();
		});
		$('a.login').bind('click', function(e){
			e.preventDefault();
			$('.form-forgot').hide();
			$('.form-login').show();
		});
	});
}


function noItemsAction(){
	$('.widget.recards').each(function(){
		var $items = $(this).find('.recards-list .recard');
		if($items.length < 1){
			$('header nav a[href=#new-recard]').click();
		}
	});
	$('.widget.banners').each(function(){
		var $items = $(this).find('.banners-list .banner');
		if($items.length < 1){
			$('header nav a[href=#new-banner]').click();
		}
	});
	$('.widget.publics').each(function(){
		var $this = $(this),
				$items = $this.find('.publics-list .public');
		if($items.length < 1 || $this.hasClass('create')){
			$('header nav a[href=#new-public]').click();
		}
	});

	$('.widget.events').each(function(){
		var $items = $(this).find('.events-list .event');
		if($items.length < 1){
			$('header nav a[href=#new-event]').click();
		}
	});
}

$.fn.userForm = function(){
		return this.each(function(){
				var $form = $(this),
						formAction = $form.attr('action'),
						$passwordOldInput = $('#user-form-password-old'),
						$passwordInput = $('#user-form-password'),
						$passwordCheckInput = $('#user-form-password-check');


				var validator = $form.validate({
						rules: {
								login: {
										remote: {
												url: formAction,
												type: 'post',
												data: {check: 1}
										}
								},
								email: {
										remote: {
												url: formAction,
												type: 'post',
												data: {check: 1}
										}
								},
								password_check: {
										required: function(el) {
												if ($passwordOldInput.val() || $passwordInput.val()) {
														return true;
												} else {
														return false;
												}
										},
										equalTo: '#user-form-password'
								}
						},
						highlight: function(el){
								$(el).addClass('error');
						},
						unhighlight: function(el){
								$(el).removeClass('error');
						},
						errorElement: 'em',
						submitHandler: function(form){
								$('input, button, select, textarea', $form).blur();
								$form.ajaxSubmit({
										dataType: 'json',
										beforeSubmit: function(){
											//popup
										},
										success: function(data){
												validator.resetForm();
												$.alert({
													content: data.status,
													ok: function(){
																if (data.redirect) {
																		location.replace(data.redirect);
																}
															}
												});												
										}
								});
						}
				});

		});
};


function doRegister(){
	$('.user-form-register form').userForm();
}

$.confirm = function(o){
	var o = $.extend({
		el: $(window),
		content: '',
		ok: function(){},
		cancel: function(){},
		style: {}
	}, o);
	confirmAction({
		text: o.content,
		callback: o.ok,
		cancel: o.cancel,
		el: o.el,
		style: o.style
	});
};

$.alert = function(o){
	var o = $.extend({
		el: $(window),
		content: '',
		ok: function(){},
		close: function(){},
		style: {}
	}, o);
	confirmAction({
		text: o.content,
		callback: o.ok,
		close: o.close,
		el: o.el,
		style: o.style,
		alert: true
	});
};

$.crop = function(o){
		o = $.extend({
				url: '',
				src: '',
				min: [0, 0],
				ratio: 0,
				size: 0,
				data: {},
				complete: function(){
						$.popup.close();
				}
		}, o || {});
		var img = new Image();
		img.onload = function(){
				var zoom = 1,
						min = o.min,
						imgWidth = img.width,
						imgHeight = img.height,
						maxImgWidth = document.documentElement.clientWidth - 200,
						maxImgHeight = document.documentElement.clientHeight - 255;
				if (imgWidth > maxImgWidth || imgHeight > maxImgHeight) {
						if (maxImgWidth / imgWidth < maxImgHeight / imgHeight) {
								zoom = maxImgWidth / imgWidth;
						} else {
								zoom = maxImgHeight / imgHeight;
						}
						min[0] = Math.floor(min[0] * zoom);
						min[1] = Math.floor(min[1] * zoom);
						imgWidth = Math.floor(img.width * zoom);
						imgHeight = Math.floor(img.height * zoom);
				}
				img.width = imgWidth;
				img.height = imgHeight;
				var $img = $(img),
						x = 0,
						y = 0,
						x2 = imgWidth,
						y2 = imgHeight;
				if (o.ratio) {
						var width = imgWidth,
								height = imgHeight;
						if (height * o.ratio > width) {
								height = Math.floor(width / o.ratio);
								y = Math.floor(imgHeight / 2 - height / 2);
								y2 = y + height;
						} else {
								width = Math.floor(height * o.ratio);
								x = Math.floor(imgWidth / 2 - width / 2);
								x2 = x + width;
						}
				}
				var area = [x, y, x2 - x, y2 - y];
				$img.Jcrop({
						aspectRatio: o.ratio,
						minSize: min,
						setSelect: [x, y, x2, y2],
						onSelect: function(c) {
								area = {
										x: c.x,
										y: c.y,
										width: c.w,
										height: c.h
								}
						}
				}, function() {
						area = {
								x: 0,
								y: 0,
								width: img.width,
								height: img.height
						};
				});
				$.confirm({
						content: $img,
						style: {minWidth: imgWidth + 40 + 'px'},
						ok: function(){
								$.modal.close();
	
								for (i in area) {
										area[i] = Math.floor(area[i] / zoom);
								};

								var data = {
										src: o.src,
										size: o.size,
										x: area.x,
										y: area.y,
										width: area.width,
										height: area.height
								};

								$.post(o.url, 'data=' + JSON.stringify(data), function(data) {
										if (data.error) {
												$.alert({content: data.status});
												return;
										}
										o.complete(data);
								}, 'json');

						}
				});
		};
		img.src = o.src;
};

$.fn.groupUpdate = function(){
		return this.each(function(){

				var $root = $(this),
						$form = $root.find('form').eq(0),
						$submit = $form.find('.actions .button.submit'),
						$name = $form.find('input[name=name]'),
						$url = $form.find('input[name=url]'),
						$gid = $form.find('input[name=gid]'),
						$id = $form.find('input[name=id]'),
						$groupsubjectid = $form.find('select[name=groupsubjectid]'),
						$countryid = $form.find('select[name=countryid]'),
						$code = $form.find('input[name=code]'),
						$type = $form.find('input[name=type]'),
						$accountid = $form.find('input[name=accountid]'),
						$socialid = $form.find('input[name=socialid]'),
						$age = $form.find('input[name=age]'),
						$gender = $form.find('input[name=gender]'),
						$price = $form.find('input[name=price]'),
						$pricerepost = $form.find('input[name=pricerepost]'),
						$uploadCover = $root.find('#upload-image'),
						$uploadLink = $root.find('.cover-input .upload-link'),
						$cover = $root.find('.cover-input .img img'),
						$removeCover = $root.find('.cover-input .remove-link').show(),
						remoteimage = $root.data('remoteimage'),
						old_image = remoteimage !== 1 ? $cover.attr('src') : '',
						placeholderImageUrl = '/img/reactor/profile/image-na.jpg',
						url_deleted = '';

				if($cover.attr('src') == '' || $cover.attr('src') == placeholderImageUrl){
					$removeCover.hide();
					$uploadLink.show();
				} else {
					$removeCover.show();
					$uploadLink.hide();
				}

				$uploadCover.uploadify({
						'multi': false,
						'swf': '/uploadify/uploadify32.swf',
						'uploader': '/file/uploadimage/',
						'folder': '/uploads/temp',
						'auto': true,
						'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
						'fileDesc': 'Images',
						'wmode': 'transparent',
						'hideButton': true,
						'width': 22,
						'buttonText': '',
						'onUploadSuccess': function(file, data, response) {
								if(data){
									response = $.parseJSON(data);
									if (response.error) {
											$alert({
												content: response.status
											});
											return;
									} else {
										$.crop({
												url: '/file/crop/',
												src: response.src,
												min: [50, 50],
												ratio: 1,
												size: 12,
												complete: function(data) {
													if ($cover.attr('src') != placeholderImageUrl && remoteimage !== 1) {
														url_deleted = $cover.attr('src');
													}

													$cover.attr('src', data.src);
													remoteimage = 0;
													$removeCover.show();
													$uploadLink.hide();
													$.modal.close();
												}
										});
									}
								}
						}
				});
				
				$removeCover.click(function() {
						if(remoteimage !== 1){
							url_deleted = $cover.attr('src');
						}
						$cover.attr('src', placeholderImageUrl);
						$removeCover.hide();
						$uploadLink.show();
				});

				$form.submit(function(e) {
						e.preventDefault();
						$submit.addClass('disabled');
						$.ajax({
							type: 'post',
							url: $form.attr('action'),
							dataType: 'json',
							data: {
								'name': $name.val(),
								'image': $cover.attr('src') !== placeholderImageUrl && $cover.attr('src') !== old_image ? $cover.attr('src') : '',
								'url': $url.val(),
								'gid': $gid.val(),
								'id': $id.val(),
								'groupsubjectid': $groupsubjectid.val(),
								'countryid': $countryid.val(),
								'age': $age.val(),
								'gender': $gender.val(),
								'price': $price.val(),
								'pricerepost': $pricerepost.val(),
								'code': $code.val(),
								'type': $type.val(),
								'socialid': $socialid.val(),
								'accountid': $accountid.val(),
								'url_deleted': url_deleted,
								'remoteimage': remoteimage
							},
							complete: function(){
								$submit.removeClass('disabled');
							},
							success: function(response){
								var url = $form.attr('action');
								if(response && response.id){
									$.alert({
										content: "Все данные сохранены.",
										close: function(){
											url += '?id=' + response.id;
											location.replace(url);
										}
									});
								}
							}
						});

				});

		});
};



function doCreateGroups(){
	$('.groups-create form').each(function(){
		var $form = $(this),
				formAction = $form.attr('action');

		var validator = $form.validate({
				rules: {
						url: {
								remote: {
										url: '/groups/check',
										type: 'post'
								}
						}
				},
				highlight: function(el){
						$(el).addClass('error');
				},
				unhighlight: function(el){
						$(el).removeClass('error');
				},
				errorElement: 'em',
				submitHandler: function(form){
						$form.unbind('submit').submit();
				}
		});
	});

	$('.groups-update').groupUpdate();
}



/* requestsAdmin
----------------------------------------------- */
(function($){
$.fn.requestsAdmin = function(){
		return this.each(function(){
				var $root = $(this),
						$items = $root.find('.item');

				$root.find('.c.confirm a').bind('click', function(e){
						e.preventDefault();
						var $a = $(this),
								$item = $a.closest('.item'),
								action = $a.hasClass('confirm') ? 1 : 2,
								requestid = $item.data('id'),
								requesttype = $item.data('type');

						$.confirm({
								content: lang.confirm,
								ok: function(){
										$.ajax({
												type: 'GET',
												url: '/user/updaterequest/',
												data: {
														action: action,
														requestid: requestid,
														requesttype: requesttype
												},
												success: function(response){
														var data = $.parseJSON(response);
														if(!data || !data.url){
																window.location.reload();
														} else {
																$.confirm({
																		content: data.status,
																		ok: function(){
																				location.replace(data.url); 
																		},
																		cancel: function(){
																				window.location.reload();
																		}
																});
														}
												}
										});
								}                
						});
				});

				$root.find('a.request-type').popup({
						beforeShowLoading: function(){
							var $a = $(this);
							if($a.closest('.item').hasClass('unread')){
									//o.data = {status: 2};
									$a.attr('href', $a.attr('href') + '&status=2');
							}
							$a.closest('.item').removeClass('unread');
							updateNotificationsCounter();
						},
						afterShow: function(){
						}
				});

				$root.find('a.report').popup({
						afterShow: function(){
								$('.popup-report-inner .upload.widget').uploadWidget();
								var $form = $('.popup-report-inner form');
								$form.submit(function(e){
										e.preventDefault();
										$form.ajaxSubmit({
												dataType: 'json',
												success: function(response, status, xhr, $form){
														$.modal.close();
														window.location.reload();
												}
										});
										return false;
								});
						}
				});
				
				$(document).on('submit', '.popup-report-inner form', function(e){
						e.preventDefault();
						var $form = $(this);
						$.ajax({
								type: 'post',
								url: $form.attr('action'),
								data: $form.serializeJSON(),
								success: function(){
										window.location.reload();
								}
						});
				});


		});
};
})(jQuery);


function updateNotificationsCounter(){
		var $newCounter = $('#top nav .requests-link .count');
		$.ajax({
				url: '/ajax/getunreadnotices',
				dataType: 'json',
				success: function(data){
						if(!data) return;
						var newCount = parseInt(data.notice);
						if(newCount > 0){
								$newCounter.css('display', 'inline-block').text('+'+newCount);
						} else {
								$newCounter.css('display', 'none');
						}
				}
		});
}


function doTransactionsList(){



	
	$.fn.transactions = function(){
		return this.each(function(){
			var $root = $(this),
					$transactionsFilter = $root.find('.transactions-filter'),
					$filterSelect = $transactionsFilter.find('select'),
					$transactionsList = $root.find('.transactions-list'),
					$listActions = $root.find('.list-actions'),
					$more = $listActions.find('a.more'),
					perpage = $root.data('perpage') || 50,
					state = {
						start: $transactionsList.find('.transaction').length,
						sort: '',
						take: perpage,
						operationtypeid: $filterSelect.val()
					};
			function gettransactions(rData, mode){
				$.ajax({
					type: 'GET',
					url: '/user/morebalance',
					data: rData,
					success: function(data){
						var $data = $(data);
						if(!$data.find('.item')){
							return false;
						}
						if(mode == 'append'){
							$data.appendTo($transactionsList);
						} else {
							var $input = $(data);
							$transactionsList.find('.item').remove();
							$transactionsList.append($input);
						}
						state = rData;
						state.start = $transactionsList.find('.item').length;
						
						if($transactionsList.find('.item.last').length){
							$listActions.hide();
						} else {
							$listActions.show();
						}

					}
				});
			}

			$more.bind('click', function(e){
				e.preventDefault();
				gettransactions($.extend(state,{
					take: perpage
				}), 'append');
			});

			$filterSelect.bind('change', function(e){
				state.operationtypeid = $(this).val();
				state.start = 0;
				gettransactions(state);
			});


		});
	}

	$('.widget.transactions').transactions();






	$('.transactions .balance-status').each(function(){
		var $status = $(this),
				$list = $('.transactions-list'),
				listOffsetTop = $list.offset().top;


		function adjustPosition(){
			var statusHeight = $status.height(),
					listHeight = $list.height(),
					scrollTop = $dom.window.scrollTop(),
					newTop = scrollTop < listOffsetTop ? 0 : scrollTop - listOffsetTop;

			if(newTop + statusHeight > listHeight){
				newTop = listHeight - statusHeight;
			} 

			$status.css({
				top: newTop + 'px'
			})

		}

		$dom.window.bind('scroll', adjustPosition);

	});
}

$.fn.mySlider = function(o, params){
	return this.each(function(){
		var $root = $(this),
				$range = $root.find('.range'),
				$inputBottom = $root.find('input.value-bottom'),
				$inputTop = $root.find('input.value-top'),
				units = $root.data('units'),
				min = $root.data('min'),
				max = $root.data('max'),
				bottom = $inputBottom.val(),
				top = $inputTop.val(),
				sliderDefaults = {
					range: true,
					min: min,
					max: max,
					values: [bottom, top],
					create: function(event, ui){
						updateLabels(min, max, bottom, top);
						//$root.data('manualValues', [bottom, top]);
					},
					slide: function(event, ui){
						var updateMin = $(event.target).data('slider').options.min,
								updateMax = $(event.target).data('slider').options.max;
						updateLabels(updateMin, updateMax, ui.values[0], ui.values[1]);
					},
					stop: function(event, ui){
						$root.data('manualValues', ui.values);
						var callback = o.callback || $root.data('mySlider').callback;
						if(typeof callback == 'function'){
							callback.call();
						}
					}
				};
		
		if(!$root.data('mySlider')){
			$root.append('<table class="labels-holder"><tr><td class="left-cell"></td><td align="left"><span class="label-bottom"><span class="value">'+bottom+'</span> <span class="units">'+units+'</span></span></td><td align="right"><span class="label-top"><span class="value">'+top+'</span> <span class="units">'+units+'</span></span></td><td class="right-cell"></td></tr></table>'
				+ '<span class="label-min"><span class="value">'+min+'</span> <span class="units">'+units+'</span></span><span class="label-max"><span class="value">'+max+'</span> <span class="units">'+units+'</span></span>');			
			$root.data('mySlider', o);
		}

		var $labelBottom = $root.find('.label-bottom'),
				$labelTop = $root.find('.label-top'),
				$labelMin = $root.find('.label-min'),
				$labelMax = $root.find('.label-max'),
				$labelBottomVal = $labelBottom.find('.value'),
				$labelTopVal = $labelTop.find('.value'),
				$labelMinVal = $labelMin.find('.value'),
				$labelMaxVal = $labelMax.find('.value'),
				$leftCell = $root.find('.left-cell'),
				$rightCell = $root.find('.right-cell');
		
		function updateLabels(min, max, bottom, top){
			$inputBottom.val(bottom);
			$inputTop.val(top);
			$labelBottomVal.text(bottom);
			$labelTopVal.text(top);
			$leftCell.attr('width', 100 * (bottom - min) / (max - min) + '%');
			$rightCell.attr('width',100 * (max - top) / (max - min) + '%');
		}

		if(o == 'updateMinMax'){
			var values = $range.slider('values'),
					newMin = parseInt(params.min || 0),
					newMax = parseInt(params.max || 0),
					newValues = [
						/*(values[0] > newMin ? (values[0] < newMax ? values[0] : newMax) : newMin),
						(values[1] < newMax ? (values[1] > newMin ? values[1] : newMin) : newMax)*/
						newMin, newMax
					],
					manualValues;
			if($root.data('manualValues')){
				manualValues = $root.data('manualValues');
				newValues = [
					(values[0] > newMin ? (values[0] < newMax ? values[0] : newMax) : newMin),
					(values[1] < newMax ? (values[1] > newMin ? values[1] : newMin) : newMax)
				];
				if(manualValues[0] >= newMin && manualValues[0] < newValues[0]) newValues[0] = manualValues[0];
				if(manualValues[1] <= newMax && manualValues[1] > newValues[1]) newValues[1] = manualValues[1];
			}
			$labelMinVal.text(newMin);
			$labelMaxVal.text(newMax);
			min = newMin;
			max = newMax;
			bottom = newValues[0];
			top = newValues[1];

			$range.slider('option', 'min', newMin);
			$range.slider('option', 'max', newMax);
			$range.slider('values', 0, newValues[0]);
			$range.slider('values', 1, newValues[1]);
			updateLabels(min, max, bottom, top);
		} else {
			$range.slider(sliderDefaults);			
		}

	});
}

function prettyNum(str){
	var na = '-';
	if(str + '' == 'null' || str + '' == 'Infinity' || str + '' == 'NaN'){
		return na;
	}
	return str;
}

function doAddPublic(){
	$('.add-public').each(function(){
		var $root = $(this),
				$uploadCover = $root.find('#upload-image'),
				$uploadLink = $root.find('.upload-link'),
				$cover = $root.find('.cover-input .img img'),
				$removeCover = $root.find('.cover-input .remove-link').show(),
				remoteimage = $root.data('remoteimage'),
				old_image = remoteimage !== 1 ? $cover.attr('src') : '',
				placeholderImageUrl = '/img/report/image-na-160.png',
				url_deleted = '';

		if($cover.attr('src') == '' || $cover.attr('src') == placeholderImageUrl){
			$removeCover.hide();
			$uploadLink.show();
		} else {
			$removeCover.show();
			$uploadLink.hide();			
		}

		$uploadCover.uploadify({
				'multi': false,
				'swf': '/uploadify/uploadify32.swf',
				'uploader': '/file/uploadimage/',
				'folder': '/uploads/temp',
				'auto': true,
				'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
				'fileDesc': 'Images',
				'wmode': 'transparent',
				'hideButton': true,
				'width': 22,
				'buttonText': '',
				'onUploadSuccess': function(file, data, response) {
						if(data){
							response = $.parseJSON(data);
							if (response.error) {
									$.alert({
										content: response.status
									});
									return;
							} else {
								$.crop({
										url: '/file/crop/',
										src: response.src,
										min: [50, 50],
										ratio: 1,
										size: 12,
										complete: function(data) {
											if ($cover.attr('src') != placeholderImageUrl && remoteimage !== 1) {
												url_deleted = $cover.attr('src');
											}

											$cover.attr('src', data.src);
											remoteimage = 0;
											$removeCover.show();
											$uploadLink.hide();			
											$.modal.close();
										}
								});
							}
						}
				}
		});
		
		$removeCover.click(function() {
				if(remoteimage !== 1){
					url_deleted = $cover.attr('src');
				}
				$cover.attr('src', placeholderImageUrl);
				$removeCover.hide();
				$uploadLink.show();
		});


		$('.public-switcher a').bind('click', function(e){
			e.preventDefault();
			var $a = $(this);
			if(!$a.hasClass('on')){
				$('.public-switcher a').removeClass('on');
				$a.addClass('on');
				if($a.hasClass('publication')){
					$('.publication-only').css('display', 'block');
					$('.repost-only').css('display', 'none');
					$('input.public-switch-input').val('publication').change();
				} else {
					$('.publication-only').css('display', 'none');
					$('.repost-only').css('display', 'block');
					$('input.public-switch-input').val('repost').change();
				}
			}
		});

		$('.date-field').dateField();
		$('.switchboxes input[type=checkbox]').prettyCheckboxes();
		$('.range-select .field').mySlider({
			callback: updateAjaxData
		});

		if($('.groups-filter input[value=3]').is(':checked')){
			$('.special-groups').show();
			$('.special-groups-list .item .remove').bind('click', function(){
				$(this).closest('.item').remove();
				updateAjaxData();
			});			
			$('.general-groups').hide();
		} else {
			$('.special-groups').hide();
			$('.general-groups').show();
		}


		$('.last-col .stats').each(function(){
			var $stats = $(this),
					$content = $('.col11');

			function adjustPosition(){
				var delta = $('.col11 .switched-content:visible').height() + 120,
						contentOffsetTop = $content.offset().top + delta,
						statsHeight = $stats.height(),
						contentHeight = $content.height() - delta,
						scrollTop = $dom.window.scrollTop(),
						newTop = scrollTop < contentOffsetTop ? 0 : scrollTop - contentOffsetTop;

				if(statsHeight - contentHeight > 0) return;
				
				if(newTop + statsHeight > contentHeight){
					newTop = contentHeight - statsHeight;
				} 

				$stats.css({
					top: newTop + 'px'
				})

			}

			$dom.window.bind('scroll', adjustPosition);

		});

		$.fn.getSwitchboxesArray = function(){
			var array = []
			$(this).find('input:checked').each(function(){
				array.push($(this).val());
			});
			return array;
		}

		$.fn.redrawSwitchboxes = function(data, active){
			var $field = $(this);
			$field.html('');
			$.each(data, function(index, value){
				$field.append('<label><input type="checkbox" value="' + value.id + '"' + ($.inArray(value.id, active) !== -1 ? ' checked' : '') + '>' + value.name + ' (' + value.cnt + ')</label> ');
			});
			$field.find('input').prettyCheckboxes();
		}

		function addSpecialGroup(o){
			if($.inArray(parseInt(o.id), getSpecialGroups()) > -1) return;

			var $list = $('.special-groups-list'),
					$item = $('<div class="item" data-id="'+o.id+'"><a class="link '+(o.network || 'vk')+'" href="'+(o.url || '')+'" target="_blank">'+o.title+'</a><a class="remove"></a></div>').appendTo($list);
			$item.find('.remove').bind('click', function(){
				$item.remove();
				updateAjaxData();
			});
		}

		function getSpecialGroups(){
			var $list = $('.special-groups-list'),
					groups = [];
			$list.find('.item').each(function(){
				groups.push($(this).data('id'));
			});
			return groups;
		}

		var ajaxData = {};
		function updateAjaxData(updateFilters){
			var publicData = $.isPlainObject(updateFilters) ? updateFilters : false;
			ajaxData = {
				id: $('.public-id-input').val(),
				type: publicData && publicData.type ? publicData.type : $('.publication.switch').hasClass('on') ? 'publication' : 'repost',
				publictypeid: publicData && publicData.publictypeid ? publicData.publictypeid : $('.publication.switch').hasClass('on') ? '1' : '2',
				date: $('.dates .date-input').val(),
				publication: $('.field.publication textarea').val(),
				url: $('.field.url input').val(),
				groupsFilter: publicData && publicData.groupsFilter ? publicData.groupsFilter : $('.groups-filter input:checked').val(),
				specialGroups: getSpecialGroups(),
				topics: publicData && publicData.topics ? publicData.topics : $('.field.topics').getSwitchboxesArray(),			
				countries: publicData && publicData.countries ? publicData.countries : $('.field.countries').getSwitchboxesArray(),
				genderFilter: publicData && publicData.genderFilter ? publicData.genderFilter : $('.field.gender-filter input:checked').val(),
				ageRange: $('.field.age-range').data('manualValues') ? $('.field.age-range .ui-slider').slider('values') : undefined,
				priceRange: $('.field.price-range').data('manualValues') ? $('.field.price-range .ui-slider').slider('values') : undefined,
				repostPriceRange: $('.field.repost-price-range').data('manualValues') ? $('.field.repost-price-range .ui-slider').slider('values') : undefined,
				subscribersRange: $('.field.subscribers-range').data('manualValues') ? $('.field.subscribers-range .ui-slider').slider('values') : undefined,
				'image': $cover.attr('src') !== placeholderImageUrl && $cover.attr('src') !== old_image ? $cover.attr('src') : '',
				'url_deleted': url_deleted,
				'remoteimage': remoteimage
			};

			$root.data('ajaxdata', ajaxData);

			if(publicData && publicData.publictypeid){
				var $a = $('.public-switcher a.' + (publicData.publictypeid == '1' ? 'publication' : 'repost'));
				if(!$a.hasClass('on')){
					$('.public-switcher a').removeClass('on');
					$a.addClass('on');
					if($a.hasClass('publication')){
						$('.publication-only').css('display', 'block');
						$('.repost-only').css('display', 'none');
						$('input.public-switch-input').val('publication');
					} else {
						$('.publication-only').css('display', 'none');
						$('.repost-only').css('display', 'block');
						$('input.public-switch-input').val('repost');
					}
				}
			}

			if(ajaxData.groupsFilter == '3'){
				$('.special-groups').show();
				$('.general-groups').hide();
			} else {
				$('.special-groups').hide();
				$('.general-groups').show();
			}

			if(updateFilters !== false){
				$.ajax({
					type: 'post',
					url: '/public/filter',
					data: publicData ? publicData : ajaxData,
					complete: function(data){
						var data = $.parseJSON(data.responseText),
								contactPrice = (data.priceRange.pricetotal / data.subscribersRange.statstotal).toFixed(4);
						$root.data('balance', data.priceRange.balance);
						$root.data('pricetotal', data.priceRange.pricetotal);
						$('.groups-filter .allgroups-count').text(prettyNum(data.allgroups));
						$('.groups-filter .favgroups-count').text(prettyNum(data.favgroups));
						$('.stats .groups-count').text($('.groups-filter input:checked').val() !== '3' ? $('.groups-filter input:checked').closest('label').find('.count').text() : $('.special-groups-list .item').length);
						$('.stats .max-campaign-cost').text(prettyNum(data.priceRange.pricetotal));
						$('.stats .balance').text(prettyNum(data.priceRange.balance));
						if(parseInt(Math.ceil(data.priceRange.pricetotal)) > data.priceRange.balance){
							$('.stats .max-campaign-cost').addClass('red');
						} else {
							$('.stats .max-campaign-cost').removeClass('red');							
						}
						$('.stats .subscribers-count').text(prettyNum(data.subscribersRange.statstotal));
						$('.stats .potential-contacts-count').text(prettyNum(Math.floor(data.subscribersRange.statstotal * $('.stats .ratio').text())));
						$('.stats .contact-price').text(prettyNum(contactPrice));
						$('.gender-filter .gender-all .count').text($('.stats .groups-count').text());
						$('.gender-filter .gender-male .count').text(prettyNum(data.genderFilter.male));
						$('.gender-filter .gender-female .count').text(prettyNum(data.genderFilter.female));
						if(data.genderFilter.male == '0'){
							$('.gender-filter .gender-male').hide();
						} else {
							$('.gender-filter .gender-male').show();						
						}
						if(data.genderFilter.female == '0'){
							$('.gender-filter .gender-female').hide();
						} else {
							$('.gender-filter .gender-female').show();						
						}
						$('.field.topics').redrawSwitchboxes(data.topics, ajaxData.topics);
						$('.field.countries').redrawSwitchboxes(data.countries, ajaxData.countries);
						$('.age-range').mySlider('updateMinMax',{
							min: data.ageRange.agemin,
							max: data.ageRange.agemax
						});
						$('.price-range').mySlider('updateMinMax',{
							min: data.priceRange.pricemin,
							max: data.priceRange.pricemax
						});
						$('.subscribers-range').mySlider('updateMinMax',{
							min: data.subscribersRange.statsmin,
							max: data.subscribersRange.statsmax
						});
					}
				});
			}
		}

		$root.find('.special-group-input').autocomplete({
			source: '/groups/findgroup',
			select: function(event,ui){
				addSpecialGroup({
					id: ui.item.id,
					title: ui.item.label,
					url: ui.item.url
				});
				$(this).val('');
				updateAjaxData();
				return false;
			}
		});

		$root.on('change', 'input', updateAjaxData);
		if(typeof publicData !== 'undefined'){
			updateAjaxData(publicData);
		}
		$dom.html.off('click', 'form a.submit:not(.disabled)');
		$dom.html.on('click', 'form a.submit:not(.disabled)', function(e){
			e.preventDefault();
			updateAjaxData(false);
			var error = false;
			if(parseInt($root.data('balance')) < parseInt(Math.ceil($('.stats .max-campaign-cost').text()))){
				error = true;
				$.alert({
					content: 'На вашем счету недостаточно средств.'
				});
			}

			if(ajaxData.groupsFilter == '3' && $('.special-groups-list .item').length < 1){
				error = true;
				$('.special-group-input').addClass('error').bind('focus change keyup', function(){
					$(this).removeClass('error');
				});
			}

			if(error) return false;
			$.ajax({
				type: 'post',
				url: '/public/updatepublic/',
				data: ajaxData,
				complete: function(data){
					var data = $.parseJSON(data.responseText);
					if(data == null) return;
					if(data.error && data.error !== 'false'){
						$.alert({
							content: data.status
						});
					} else if(data.url && data.url !== ''){
						window.location.replace(data.url);
					}
				}
			});
		});
	});
}

function doWithdrawForm(){
	$('#content .withdraw form').each(function(){
		var $form = $(this),
				$paymentInputs = $('input[name=paytypeid]');
		$paymentInputs.bind('click change', function(){
			var val = $paymentInputs.filter(':checked').val();
			if(val !== '1'){
				$('.field.wallet-number .label-1').hide();
				$('.field.wallet-number .label-2').show();
			} else {
				$('.field.wallet-number .label-2').hide();
				$('.field.wallet-number .label-1').show();
			}
		}).change();
		$form.bind('submit', function(){
			var sum = $('.field.sum input').val(),
					available = $('.balance-status .available .value').text();
			
			if($('input[name=account]').val() == '' || sum == '' || isNaN(sum) || !$('.i-agree input:checked').length){
				return false;
			} else if(parseFloat(sum) > parseFloat(available)){
				$.alert({
					content: 'У вас на счету недостаточно средств.'
				});
			} else {
				$form.ajaxSubmit({
					success: function(data){
						if(data){
							data = $.parseJSON(data);
							if(data.error == false){
								$.alert({
									content: data.status,
									close: function(){
										window.location.reload();
									}
								})
							} else {
								$.alert({
									content: data.status
								})
							}
						}
					}
				});
			}
			return false;
		});
	});
}


function doIndicators(){
	$.ajax({
		url: '/index/indicators',
		complete: function(data){
			if(data && data.responseText){
				data = $.parseJSON(data.responseText);
				$('#top nav .favorities .count').text(data.favourites);
				$('#top nav .requests-link .count').text(data.requests);
				$('footer .groups .count').text(data.groups);
			}
		}
	})
}

function doAccountsList(){
	$('.accounts-list').each(function(){
		var $root = $(this);
		$root.on('click', 'a.remove', function(e){
			e.preventDefault();
			var $a = $(this),
					id = $a.closest('li').data('id');
			$.confirm({
				content: 'Вы действительно хотите отключить аккаунт?',
				ok: function(){
					$.ajax({
						url: '/social/disconnect/?id='+id,
						success: function(){
							window.location.reload();
						}
					});
				}
			})
		})
	});
}

$.fn.superTabs = function(o){
	return this.each(function(){
		var $root = $(this),
				$nav = $root.find('.tabs-nav'),
				$content = $root.find('.tabs-content'),
				$links = $nav.find('a.tab'),
				$activeLink = $links.filter('.active').eq(0),
				$panes = $content.find('.tab-pane');

		$links.bind('click', function(e){
			e.preventDefault();
			var $a = $(this),
					href = $a.attr('href'),
					$pane = $content.find(href);
			if(!$pane.length) return;
			$links.removeClass('active');
			$a.addClass('active');
			$panes.hide();
			$pane.show();
			if(o.onLoad && typeof o.onLoad == 'function'){
				o.onLoad.call($pane);
			}
		});
		if(!$activeLink.length) $activeLink = $links.eq(0);
		$activeLink.click();
	});
}


function barChart(data, title, percents){
    var bar_arr = [];
    var bar_categories = [];
    for (var c=0; c < data.length; c++){
        bar_arr.push(data[c][1]);
        bar_categories.push(data[c][0]);
    }

    var config = {
        chart: {
            type: 'bar',
		        backgroundColor: highchartsBackground
        },
        colors: highchartsColors,
        title: {
            text: ''
        },
        xAxis: {
            categories: bar_categories
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                },
                borderColor: highchartsBackground
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: title,
            data: bar_arr
        }],
        credits: {
            enabled: false
        }
    };
    if (percents){
        config['tooltip'] = {};
        config['tooltip']['pointFormat'] = '<b>{point.y:.0f}%</b>';
        config['plotOptions']['bar']['dataLabels']['format'] = '{y:.0f}%';
        config['plotOptions']['bar']['dataLabels']['crop'] = false;
        // config['plotOptions']['bar']['dataLabels']['inside'] = true;
        // config['plotOptions']['bar']['dataLabels']['overflow'] = 'none';
        // config['plotOptions']['bar']['dataLabels']['color'] = 'white';
    }
    return config;
}

function pieChart(source_data, title){
	var config = {
        chart: {
		        backgroundColor: highchartsBackground,
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        colors: highchartsColors,
        title: {
            text: title
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.0f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true,
                borderColor: highchartsBackground                
            }
        },
        series: [{
            type: 'pie',
            data: source_data
        }],
        credits: {
            enabled: false
        }
    };
  return config;
}
function lineDateChart(source_data, title, yaxis_text, type) {
    var series = [];
    var data;

    if (source_data.length > 0 && source_data[0].title) {
        for (var i = 0; i < source_data.length; i++) {
            data = [];
            for (v in source_data[i].values){
                var date = source_data[i].values[v][0];
                data.push([
                    moment.utc(date).valueOf(),
                    source_data[i].values[v][1]
                ]);
            }

            series.push({name: source_data[i].title, data: data});
        }
    } else {
        series = source_data;
    }
    var colors = highchartsColors.slice(0);
    colors.splice(1, 1);
    var config = {
        chart: {
            type: 'spline',
		        backgroundColor: highchartsBackground
        },
        colors: colors,
        title: {
            text: title
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        yAxis: {
            title: {
                text: yaxis_text ? yaxis_text : 'Человек'
            },
            type: type ? type : 'linear'
        },
        series: series,
        credits: {
            enabled: false
        }
    };

    if (type != 'logarithmic'){
        config['yAxis']['min'] = 0
    }
    return config;
}

function doGroupInner(){

	$('.tabs').superTabs({
		onLoad: function(){
			if(graphData == undefined) return;
			var $root = $(this);
			if($root.is('#tab-coverage')){
				if(graphData.ages !== undefined){
					$('#age-chart').empty().highcharts(barChart(graphData.ages, 'Возраст', true));	
				}
				if(graphData.sex !== undefined){
					$('#sex-chart').empty().highcharts(pieChart(graphData.sex, 'Пол'));
				}
				if(graphData.cities !== undefined){
					$('#cities-chart').empty().highcharts(barChart(graphData.cities, 'География', true));
				}
      } else if($root.is('#tab-visits')){
      	if(graphData.visits !== undefined){
      		$('#visitors-chart').empty().highcharts(lineDateChart(graphData.visits));
      	}
			} else if($root.is('#tab-reach')){
      	if(graphData.reach !== undefined){
      		$('#reach-chart').empty().highcharts(lineDateChart(graphData.reach));
      	}
			}
		}
	});
}

$(function(){
	cacheDOM();
	doIndicators();
	doResizeHandler();
	doCountrySelect();
	doShares();
	doSelectBoxes();
	doPopups();
	doGroupsCountSwitch();
	doSearchAutoComplete();
	doEnterPage();
	doHome();
	doFeedback();
	doGroups();
	doBanners();
	doEvents();
	doEventsOffers();
	doPosters();
	doPublic();
	doRecard();
	doProfile();
	doBottomListStars();
	doForms();
	doRegister();
	doCreateGroups();
	doAddPublic();
	noItemsAction();
	$('.requests-admin').requestsAdmin();
	doTransactionsList();
	doWithdrawForm();
	doAccountsList();
	unblockLinks();
	doGroupInner();
});
