//first of all, set soundManager options:
soundManager.url = '/js/artist/swf/';
soundManager.debugMode = false;
soundManager.flashVersion = 9;

/* thatPlayer v0.1 */
(function(window, $, undefined){

	$.thatPlayer = function( options, element ) {
		this.$el = $(element);
		// initialize
		return this._init(options);
	};

	$.thatPlayer.defaults = {
		volume: 80,
		//autoplay upon load:
		autoplay: false,
		//auto advance to the next track:
		autoadvance: true,
		//repeat playlist:
		repeat: false,
		playlist: {},
		//title format {a} stands for artist, {t} - title:
		titleformat: '{a} - {t}',
		//strings to replace empty artist/title:
		noartist: 'Unknown Artist',
		notitle: 'Untitled'
	};
	

	$.thatPlayer.prototype = {

		//PRIVATE METHODS:
		
		_init: function( options ) {
			var TP = this;
			//merge defaults with provided options:
			TP.o = $.extend( true, {}, $.thatPlayer.defaults, options );
			//create temp var for storing volume when muted:
			TP.lastVolume = TP.o.volume;

			TP.ready = false;

			//check if the document already has the player markup:
			if(!TP.$el.find('.thatplayer-container').length){
				TP._generateMarkup();
			}
			
			//define controls DOM elements:
			TP.controls = {
				playpause: TP.$el.find('.tp-playpause'),
				stop: TP.$el.find('.tp-stop'),
				previous: TP.$el.find('.tp-previous'),
				next: TP.$el.find('.tp-next'),
				repeat: TP.$el.find('.tp-repeat'),
				buffer: TP.$el.find('.tp-buffer-bar'),
				progress: TP.$el.find('.tp-progress'),
				currentTime: TP.$el.find('.tp-current-time'),
				duration: TP.$el.find('.tp-duration'),
				volume: TP.$el.find('.tp-volume-bar'),
				mute: TP.$el.find('.tp-mute'),
				title: TP.$el.find('.tp-title'),
				download: TP.$el.find('.download')
			}

			//wait until soundManager is ready:
			soundManager.onready(function(){

				//init events / controls / indicators/
				TP._initEvents();

				TP._initPlaylist();

			});
			
			//something went wrong with soundManager:
			soundManager.ontimeout(function(){
				TP._error('SoundManager init timeout.');
			});
			
		},
		
		//init events / controls / indicators. should be called once upon player init:
		_initEvents: function(){
			var TP = this;

		////init sliders:
			//progress slider:
			TP.controls.progress.slider({
				max: 10000,
				value: 0
			}).bind('slide', function(event, ui){
				// try to jump to some position:
				return TP._setPosition(ui.value*100/TP.controls.progress.slider('option', 'max'));
			});
			
			//volume slider:
			TP.controls.volume.slider({
				value: TP.o.volume
			}).bind('slide slidechange', function(event, ui){
				//change volume:
				if(TP.sound.muted && TP.muted !== true){
					//user just pressed mute button, and it reset slider to 0. so now we set player muted flag and return false:
					TP.muted = true;
					return false;
				} else if(TP.muted){
					//sound is muted, flag is set - so unmute and tell we're changed volume:
					TP._unmute(ui.value);
				} else {
					//generic behaviour:
					TP._setVolume(ui.value);
				}
			});		

		//init buttons:
			TP.controls.mute.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._toggleMute();
			});
			
			TP.controls.playpause.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._togglePause();
			});
			
			TP.controls.stop.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._stop();
			});

			TP.controls.previous.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._goPrev();
			});

			TP.controls.next.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._goNext(true);
			});

			//update repeat button state according to options:
			if(TP.o.repeat === true){
				TP.controls.repeat.addClass('on');
			} else {
				TP.controls.repeat.removeClass('on');
			}
			
			TP.controls.repeat.bind('click.thatplayer', function(e){
				e.preventDefault();
				TP._toggleRepeat();
			});
		},
		
		//init playlist and load first track:
		_initPlaylist: function(){
			var TP = this;
			
			//reset position display:
			TP._resetBuffering();
			TP._updateProgress();
							
			//load first track:
			if(TP.o.playlist.length){
				if(TP._loadTrack(0) == false){
					// ERROR: broken playlist item
					TP._error('Broken playlist item (0).');
					return false;
				}
			} else {
				// ERROR: empty playlist
				TP._error('Playlist is empty.');
				return false;
			}

			if(TP.sound){
				//load was succesfull - we're ready:
				TP.ready = true;
				//play it right away if autoplay is set:
				if(TP.o.autoplay === true) TP._play();
			}
		},
		
		//function to append player markup into the element we're being attached to:
		_generateMarkup: function(){
			var TP = this;
			var markup = [
				'<div class="thatplayer-container">',
				'	<div class="tp-type-single">',
				'		<div class="tp-gui tp-interface">',
				'			<div class="extras-wrap"><a class="share" href="#"></a><a class="download off" href="#"></a></div>',
				'			<div class="progress-wrap">',
				'				<div class="tp-title"></div>',
				'				<div class="tp-time-holder"><div class="tp-current-time">0:00</div><span> / </span><div class="tp-duration">0:00</div></div>',
				'				<div class="tp-progress"><div class="tp-seek-bar"><div class="tp-buffer-bar"></div><div class="tp-play-bar"></div></div></div>',
				'			</div>',
				'			<div class="controls-wrap">',
				'				<div class="volume-wrap">',
				'					<div class="tp-volume-bar"><div class="tp-volume-bar-value"></div></div>',
				'					<a href="#" class="tp-mute" tabindex="1" title="mute">mute</a>',
				'				</div>',
				'				<ul class="tp-controls">',
				'					<li><a href="#" class="tp-playpause" tabindex="1">play</a></li>',
				'					<li><a href="#" class="tp-stop" tabindex="1">stop</a></li>',
				'					<li><a href="#" class="tp-previous" tabindex="1">previous</a></li>',
				'					<li><a href="#" class="tp-next" tabindex="1">next</a></li>',
				'					<li><a href="#" class="tp-repeat" tabindex="1" title="repeat">repeat</a></li>',
				'				</ul>',
				'			</div>',
				'		</div>',
				'	</div>',
				'</div>'
			].join('\n');
			TP.$el.append(markup);			
			return true;
		},
		
		//load track and update track title display:
		_loadTrack: function(tracknum){
			var TP = this,
					track = TP.o.playlist[tracknum];
			if(track === undefined || track === null || typeof track !== 'object' || $.isEmptyObject(track)) return false;
			//save the current track number:
			TP.currentTrack = tracknum;
			if(TP.o.playlist.length <= tracknum + 1 && TP.o.repeat !== true){
				TP.controls.next.addClass('off');
			} else {
				TP.controls.next.removeClass('off');
			}
			if(tracknum == 0){
				TP.controls.previous.addClass('off');
			} else {
				TP.controls.previous.removeClass('off');
			}
			
			TP._loadSound(track.url);
			//update title display using the title format from options:
			TP.controls.title.html( TP.o.titleformat.replace('{a}', '<span class="artist colored">' + (track.artist ? track.artist : TP.o.noartist) + '</span>').replace('{t}', '<span class="title">' + (track.title ? track.title : TP.o.notitle) + '</span>') );
			//update download button:
			if(track.download == 1){
				TP.controls.download.attr('href', track.download_url).removeClass('off').bind('click', function() {
                    return true;
                });
			} else {
				TP.controls.download.removeAttr('href').addClass('off');
			}
		},
		
		//load sound file and create soundManager sound object:
		_loadSound: function(url){
			var TP = this;
			//create or reuse sound for current track:
			TP.sound = soundManager.createSound({
				id: 'audio' + TP.currentTrack,
				url: url,
				volume: TP.o.volume,
				autoPlay: false,
				multiShot: false,
				whileloading: function(){ TP._updateBuffering(); },
				whileplaying: function(){ TP._updateProgress(); },
				onfinish: function(){ TP._onFinish(); }
			});

		},

		_goToTrack: function(tracknum){
			var TP = this,
					wasPlaying = TP.playing,
					wasPaused = TP.paused;
			TP._stop();
			TP.sound.unload();
			if(TP._loadTrack(tracknum) == false){
				// ERROR: broken playlist item
				TP._error('Broken playlist item (tracknum).');
				return false;
			}
			//stop track to reset to initial position:
			TP._stop();
			TP._resetBuffering();
			//restore playing state:
			if(wasPlaying === true && wasPaused !== true){
				TP._play();
			}
			//restore mute state:
			if(TP.muted === true){
				TP.sound.mute();
			}
		},
		
		_goNext: function(manual){
			var TP = this;
			if(TP.ready){
				if(TP.currentTrack >= TP.o.playlist.length-1){
					//it was the last track on list. what we gonna do?
					if(TP.o.repeat === true){
						//repeat is set to true - let's go to the first one:
						TP._goToTrack(0);
					} else {
						//well, looks like it's done - stop unless user clicked the next button:
						if(manual !== true) TP._stop();				
					}
				} else {
					//nice! we have some more tracks to play, let's go to the next one:
					TP._goToTrack(TP.currentTrack + 1);
				}
			}
		},
		
		_goPrev: function(){
			var TP = this;
			if(TP.ready){
				if(TP.currentTrack > 0){
					TP._goToTrack(TP.currentTrack - 1);
				}
			}
		},
		
		_play: function(){
			var TP = this;
			if(TP.ready){
				TP.sound.play();
				TP.playing = true;
				TP.controls.playpause.addClass('pause');
			}
		},
		
		_pause: function(){
			var TP = this;
			if(TP.ready){
				TP.sound.pause();
				TP.paused = true;
				TP.controls.playpause.removeClass('pause');
			}
		},
		
		_resume: function(){
			var TP = this;
			if(TP.ready){
				TP.sound.resume();
				TP.paused = false;
				TP.controls.playpause.addClass('pause');
			}
		},
		
		_togglePause: function(){
			var TP = this;
			if(TP.ready){
				if(TP.playing === true){
					if(TP.paused === true){
						TP._resume();
					} else {
						TP._pause();
					}
				} else {
					TP._play();
				}
			}
		},
		
		_setVolume: function(vol){
			var TP = this;
			TP.o.volume = vol;
			if(TP.ready && TP.muted !== true){
				TP.sound.setVolume(vol);
			}
		},
		
		_mute: function(){
			var TP = this;
			if(TP.ready){
				//remember volume in temp variable:
				TP.lastVolume = TP.o.volume;
				TP.sound.mute();
				TP.controls.mute.addClass('on');
				//turn down volume slider (it will also set muted flag for us):
				TP.controls.volume.slider('option', 'value', 0);
			}
		},

		_unmute: function(byvolume){
			var TP = this;
			if(TP.ready){
				TP.sound.unmute();
				TP.controls.mute.removeClass('on');
				TP.muted = false;
				//check if call originated from unmute button:
				if(byvolume === undefined || byvolume === null){
					//restore previous volume:
					TP.controls.volume.slider('option', 'value', TP.lastVolume);
				} else {
					//unmuted by volume slider, store temp volume:
					TP._setVolume(byvolume);
				}
			}
		},

		_toggleMute: function(){
			var TP = this;
			if(TP.ready){
				if(TP.sound.muted){
					TP._unmute();
				} else {
					TP._mute();
				}
			}
		},

		_toggleRepeat: function(){
			var TP = this;
			if(TP.o.repeat === true){
				TP.o.repeat = false;
				TP.controls.repeat.removeClass('on');
				//disable 'next' button if we're at the last track:
				if(TP.currentTrack >= TP.o.playlist.length - 1){
					TP.controls.next.addClass('off');
				}
			} else {
				TP.o.repeat = true;
				TP.controls.repeat.addClass('on');
				TP.controls.next.removeClass('off');
			}
		},
		
		_stop: function(){
			var TP = this;
			if(TP.ready){
				TP.sound.stop();
				TP.sound.setPosition(0);
				TP.playing = false;
				TP.paused = false;
				TP._updateProgress();
			}
			TP.controls.playpause.removeClass('pause');
		},
		
		//function called on finish of every track. decide to stop/next/etc.:
		_onFinish: function(){
			var TP = this;
			if(TP.o.autoadvance === true){
				//autoadvance is set to true - go to the next track
				TP._goNext();
			} else {
				TP._stop();
			}
		},
		
		//jump to specified position of track in percents:
		_setPosition: function(percent){
			var TP = this;
			if(TP.ready){
				//calculate overall duration taking into account buffering:

				//check if we're still buffering and restrict position to already buffered:
				var loaded_percent = (TP.sound.bytesLoaded / TP.sound.bytesTotal) * 100;
				if(percent > loaded_percent){
					percent = loaded_percent;
				}
				var duration = TP.sound.durationEstimate,
						soundpos = Math.round(duration*percent/100);
				//jump to position (only if already playing):
				if(TP.sound.playState > 0){
					TP.sound.setPosition(soundpos);
				//else return false so the slider stays still:
				} else return false;
			}
		},
		
		//reset buffering bar:
		_resetBuffering: function(){
			var TP = this;
			TP.controls.buffer.css({width: 0});
		},
		
		//updates buffering bar:
		_updateBuffering: function(){
			var TP = this;
			var loaded_percent = (TP.sound.bytesLoaded / TP.sound.bytesTotal) * 100;
			TP.controls.buffer.css({width: loaded_percent + '%'});
		},
		
		//updates position progress bar and time display:
		_updateProgress: function(){
			var TP = this;
			var position_percent = TP.sound ? (TP.sound.position / TP.sound.durationEstimate) * 100 : 0,
					position_time = TP.sound ? TP.sound.position : 0,
					duration_time = TP.sound ? TP.sound.durationEstimate : 0;
			TP.controls.progress.slider('option', 'value', position_percent*100);
			TP.controls.currentTime.text(TP._toTime(position_time));
			TP.controls.duration.text(TP._toTime(duration_time));
		},
		
		//convert ms value to mm:ss string:
		_toTime: function(ms){
			var TP = this,
					s = Math.floor(ms/1000);
			if(isNaN(s)) s = 0;
			return Math.floor(s/60) + ':' + TP._padNum(s % 60, 2);
			return s;
		},
		
		//pad number with zeroes to given length:
		_padNum: function(number, length){
			var str = '' + number;
			while (str.length < length) str = '0' + str;
			return str;
		},
		
		//output error:
		_error: function(msg){
			console.log('thatPlayer Error: ' + msg);
		},

		//stops playback and destroys all currently loaded sounds:
		_destroyPlaylist: function(){
			var TP = this;
			TP._stop();
			TP._unmute();
			for(var s in TP.o.playlist){
				soundManager.destroySound('audio' + s);
			}
			TP.o.playlist = {};
		},
		
		//PUBLIC METHODS:
		
		//reload playlist:
		playlist: function(playlist, autoplay){
			var TP = this;
			TP._destroyPlaylist();
			TP.ready = false;
			TP.o = $.extend(true, {}, TP.o, {
				playlist: playlist,
				autoplay: autoplay
			});
			TP._initPlaylist();
		},

        pause: function(){
            var TP = this;
            TP._pause();
        },

        resume: function(){
            var TP = this;
            TP._resume();
        }
	};

	$.fn.thatplayer = function(options) {
		if (typeof options === 'string') {
			//first argument is a string - assume we're calling some method:
			var args = Array.prototype.slice.call(arguments, 1);
			//for each element in selection:
			this.each(function() {
				//find thatplayer instance:
				var instance = $.data(this, 'thatplayer');
				if (!instance) {
					return;
				}
				//check if the prototype has function with such name, and if the function isn't private:
				if (!$.isFunction(instance[options]) || options.charAt(0) === "_") {
					return;
				}
				//call the method:
				instance[options].apply(instance, args);
			});
		} else {
			//options appear to be empty or an object - let's init:
			this.each(function() {
				//check if we're already there:
				var instance = $.data( this, 'thatplayer' );
				if(!instance) {
					//nope - attach new instance to the element:
					$.data(this, 'thatplayer', new $.thatPlayer(options, this));
				}
			});
		}
		return this;
	};

})(window, jQuery);