<!DOCTYPE html>
<html>
<head>
    <title><?=$this->view->sitename;?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/js/artist/admin/jquery.js"></script>
    <script type="text/javascript" src="/js/artist/jquery.ui.custom.min.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/soundmanager2.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/jquery.thatplayer.js?<?=time();?>"></script>
    <style type="text/css">
        .colored {
            color: #<?=$this->view->color;?> !important;
        }
        .tp-buffer-bar {
            background: url('/uploads/playerbar/<?=$this->view->color;?>.png') 0 -5px repeat-x !important;
        }

        html,
        body {
            height:100%;
            margin:0;
            padding:0;
        }
        body {
            min-height:100%;
            font: 12px Arial;
            background:#FFF;
        }
        .b-header {
            position:relative;
            height:360px;
            overflow: hidden;
            background:#E2E2E2;
        }
            .b-header .b-logo {
                z-index: 100;
                position:absolute;
                top:36px;
                left:42px;
            }
        .b-header .bg {
            position:absolute;
            top:-9999px;
            left:-9999px;
        }
        .b-tracks {
            margin:0;
            padding:0;
            list-style:none;
            background:url('/img/artist/bg-fb-iframe-tracks.png') repeat top left;
            -moz-box-shadow:inset 0 0 15px #000;
            -webkit-box-shadow:inset 0 0 15px #000;
            box-shadow:inset 0 0 15px #000;
        }
            .b-tracks li {
                height:40px;
                margin:0;
                padding:10px 30px;
                border-top:1px solid #484848;
                border-bottom:1px solid #000;
            }
            .b-tracks li:first-child {
                border-top:none;
            }
            .b-tracks li:hover {
                background:url('/img/artist/bg-fb-track-hover.png') repeat top left;
            }
                .b-tracks li .play {
                    float:left;
                    display:block;
                    vertical-align:top;
                    width:40px;
                    height:40px;
                    cursor:pointer;
                }
                .b-tracks li .hidden {
                    display: none;
                }
                .b-tracks li .description {
                    float:left;
                    display:block;
                    vertical-align:top;
                    margin:0 0 0 20px;
                    -moz-text-shadow:0px -1px 0px #000;
                    -webkit-text-shadow:0px -1px 0px #000;
                    text-shadow:0px -1px 0px #000;
                }
                    .b-tracks li .description div {
                        padding: 0 0 4px 0;
                    }
                    .b-tracks li .description .title {
                        color:#FFF;
                    }
                    .b-tracks li .description i {
                        float: left;
                        display: block;
                        font-size:11px;
                        color:#999;
                    }
                    .b-tracks li .description .style,
                    .b-tracks li .description .date {
                        margin: 0 5px 0 0;
                        padding: 0 5px 0 0;
                        /*background:url('/img/artist/bg-fb-track-separator.png') no-repeat center right;*/
                    }
                .b-tracks li .social {
                    display: none;
                    float: right;
                    height: 20px;
                    padding: 10px 0 0;
                }
                .b-tracks li:hover .social {
                    display: block;
                }
                    .b-tracks li .social a {
                        float: left;
                        display: block;
                        width: 20px;
                        height: 20px;
                        margin: 0 0 0 5px;
                    }
        .b-footer {
            height:40px;
            padding: 20px 0 0;
        }
            .b-footer .link-left {
                float:left;
                display:block;
                color: #000;
                text-decoration: none;
            }
            .b-footer .link-right {
                float:right;
                display:block;
                padding: 0 0 0 10px;
                color: #000;
                text-decoration: none;
            }
            .b-footer .copyright {
                float:right;
                display:block;
                margin: -3px 0 0;
                padding: 3px 10px 3px 0;
                border-right: 1px solid #CCC;
                color: #666;
            }




        /* player (begin) */
        .g-player-wrap {
            position: relative;
            height:60px;
            padding: 0 30px;
            overflow:hidden;
            background:url('/img/artist/bg-player.png') repeat-x center left;
        }
        .g-player-overlay {
            position: absolute;
            z-index: 100;
            top:0;
            left:0;
            bottom:0;
            right:0;
            background: #282828;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
            filter: alpha(opacity=70);
            -moz-opacity: 0.7;
            opacity: 0.7;
        }
        .g-player {
            width:100%;
            height:60px;
            margin:0 auto;
            -moz-text-shadow:0px -1px 0px #000;
            -webkit-text-shadow:0px -1px 0px #000;
            text-shadow:0px -1px 0px #000;
        }
        .thatplayer-container {
        	font-size: 11px;
        	font-family: arial, sans-serif;
        	line-height: 15px;
        	color: #fff;
        	position:relative;
        }
        .thatplayer-container {
        	width: 100%;
        }
        .tp-interface {
        	position: relative;
        	width:100%;
        }
        .thatplayer-container .tp-interface {
        	height:60px;
        }
        .tp-interface a:focus{
        	outline: none;
        }
        .thatplayer-container .extras-wrap{
        	position: absolute;
        	top: 0;
        	left: 0;
        	width: 80px;
        	height: 60px;
        }
        .thatplayer-container a.download {
        	background: url("/img/artist/player-download.png") top center no-repeat;
        	display: block;
        	height: 24px;
        	text-indent: -9000px;
        	width: 19px;
        	margin-left: 6px;
        }
        .thatplayer-container a.download.off {
        	background: url("/img/artist/player-download.png") bottom center no-repeat;
            cursor: default;
        }
        .thatplayer-container .progress-wrap{
        	height: 60px;
        	margin: 0 120px 0 62px;
        	position: relative;
        }
        .thatplayer-container .volume-wrap{
        	margin-left: 18px;
        	position: absolute;
        	right: 0;
        	top: 18px;
        	width: 80px;
        }
        .thatplayer-container .controls-wrap{
        	left: 0;
        	position: absolute;
        	top: 0;
        	height: 60px;
        	width: 40px;
        }
        .tp-controls-holder {
        	clear: both;
        	width:440px;
        	margin:0 auto;
        	position: relative;
        	overflow:hidden;
        	top:-8px; /* This negative value depends on the size of the text in tp-currentTime and tp-duration */
        }
        .thatplayer-container ul.tp-controls {
        	height: 42px;
        	padding: 18px 0 0;
        	width: 60px;
        	list-style-type:none;
        	margin:0;
        	overflow:hidden;
        }
        .thatplayer-container ul.tp-controls li {
        	display:inline;
        	float: left;
        }
        .thatplayer-container ul.tp-controls a {
        	display:block;
        	overflow:hidden;
        	text-indent:-9999px;
        }
        a.tp-playpause {
        	height:25px;
        }
        a.tp-playpause {
        	background: url('/img/artist/player-controls.png') 0 0 no-repeat;
        	width:19px;
        }
        a.tp-playpause:hover {
        }
        a.tp-playpause:active {
        }
        a.tp-playpause.pause {
        	background-position: 0 -25px;
        	width:19px;
        }
        a.tp-playpause.pause:hover {
        }
        a.tp-playpause.pause:active{
        }
        .tp-progress {
        	background: url("/img/artist/player-progress.png") 0 0 repeat-x;
        }
        .thatplayer-container .tp-progress {
        	position: absolute;
        	top:35px;
        	height:5px;
        }
        .thatplayer-container .tp-progress {
        	left:0px;
        	width:100%;
        }
        .tp-seek-bar {
        	background: url("/img/artist/player-progress.png") 0 0 repeat-x;
        	height:100%;
        	cursor: pointer;
        }
        .tp-play-bar,
        .tp-buffer-bar {
        	width:0px;
        	height:100%;
        }
        .tp-buffer-bar {
        	background: url("/img/artist/player-progress.png") 0 -5px repeat-x ;
        }
        .tp-seeking-bg {
        	background: url("/img/artist/reactor.seeking.gif");
        }
        a.tp-mute,
        a.tp-mute.on,
        a.tp-volume-max {
        	display: block;
        	text-indent: -9000px;
        	width:12px;
        	height:12px;
        }
        .thatplayer-container a.tp-mute{
        	margin: 13px 0 0 -20px;
        }
        a.tp-mute {
        	background: url("/img/artist/player-mute.png") 0 0 no-repeat;
        }
        a.tp-mute:hover {
        	background: url("/img/artist/player-mute.png") 0 0 no-repeat;
        }
        a.tp-mute.on {
        	background: url("/img/artist/player-mute.png") 0 -12px no-repeat;
        }
        a.tp-mute.on:hover {
        	background: url("/img/artist/player-mute.png") 0 -12px no-repeat;
        }
        .thatplayer-container .tp-volume-bar {
        	float: right;
        	background: url("/img/artist/player-volumebg.png") 2px 0 no-repeat;
        	width: 85px;
        	height: 28px;
        	margin: 0;
        	padding: 16px 0 0;
        	cursor: pointer;
        }
        .tp-interface .ui-slider-handle{
        	display: block;
        	position: absolute;
        	top: -4px;
        	width: 9px;
        	height: 15px;
        	background: url("/img/artist/player-handle.png") center 2px no-repeat;
        	margin-left: -5px;
        }
        .tp-interface .tp-volume-bar .ui-slider-handle{
        	top: 13px;
        }
        .thatplayer-container .tp-time-holder {
        	position:absolute;
        	top: 15px;
        	right: 0;
        }
        .tp-current-time,
        .tp-duration,
        .tp-time-holder span {
        	float: left;
        	display:inline;
        }
        .tp-current-time {
        	margin-right: 3px;
        }
        .tp-duration {
        	margin-left: 3px;
        }
        .tp-title {
        	width:100%;
        	padding: 15px 0 0;
        	font-size: 11px;
        }
        /* player (end) */
    </style>
</head>
<body>

<!-- header (begin) -->
<div class="b-header">
    <a target="_blank" href="http://<?=$_SERVER['HTTP_HOST'];?>/" class="b-logo"><img src="<?=$this->view->logo[url];?>" alt=""/></a>
    <img class="bg" src="<?=$this->view->pagebg;?>" align="right" alt="" />
</div>
<!-- header (end) -->

<!-- player (begin) -->
<div class="g-player-wrap">
    <div class="g-player">
        <div class="thatplayer-container">
            <div class="tp-type-single">
                <div class="tp-gui tp-interface">
                    <div class="controls-wrap">
                        <ul class="tp-controls">
                            <li><a href="#" class="tp-playpause" tabindex="1">play</a></li>
                            <li><a class="download off" href="#"></a></li>
                        </ul>
                    </div>
                    <div class="progress-wrap">
                        <div class="tp-title"></div>
                        <div class="tp-time-holder" >
                            <div class="tp-current-time colored">0:00</div><span> / </span><div class="tp-duration">0:00</div>
                        </div>
                        <div class="tp-progress">
                            <div class="tp-seek-bar">
                                <div class="tp-buffer-bar"></div>
                                <div class="tp-play-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="volume-wrap">
                        <div class="tp-volume-bar">
                            <div class="tp-volume-bar-value"></div>
                        </div>
                        <a href="#" class="tp-mute" tabindex="1" title="mute">mute</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- player (end) -->

<!-- tracks (begin) -->
<ul class="b-tracks">
    <?
	$cnt=0;
	foreach($this->view->playertracks as $track){
		if(strlen($track['remix'])>1)
		$track['remix']=' ('.$track['remix'].')';
		$jsonArr[].="{
				artist:'".$track['author']."',
                title:'".addslashes($track['name']).$track['remix']."',
                url: '".$track['url']."',
                download_url: '/file/getmp3/?f=".$track['mp3id']."',
                download: ".tools::int($track['download'])."
				}";
		
	$cnt++;
	?>
	<li>
        <img class="play" src="<?=$track['cover'];?>" width="40" height="40" alt="Play" />
        <div class="description colored">
            <div><span class="artist"><?=$track['author'];?></span> - <span class="title"><?=$track['name'];?><?=$track['remix'];?></span> <!--<img src="/img/artist/bg-release-promocut.png" width="37" height="9" alt=""/>--></div>
            <!--i class="style">House, Tech-house</i-->
            <i class="date"><?=$track['date_start'];?></i>
            <!--i class="label colored">Noir Music</i-->
        </div>
        <div class="hidden">
            <span class="url"><?=$track['url'];?></span>
            <span class="download_url">/file/getmp3/?f=<?=$track['mp3id'];?></span>
            <span class="download"><?=$track['download'];?></span>
        </div>
        <!--div class="social">
            <a href="http://www.beatport.com/artist/tish/129954" style="background-image: url(/uploads/social/beatport.png)" target="_blank"></a>
            <a href="http://www.facebook.com/tishdj" style="background-image: url(/uploads/social/fb.png)" target="_blank"></a>
            <a href="https://plus.google.com/u/0/112246481901251647926/posts" style="background-image: url(/uploads/social/google.png)" target="_blank"></a>
            <a href="http://www.youtube.com/user/tishukraine/videos" style="background-image: url(/uploads/social/youtube.png)" target="_blank"></a>
            <a href="http://www.facebook.com/tishdj" style="background-image: url(/uploads/social/fb.png)" target="_blank"></a>
            <a href="http://www.beatport.com/artist/tish/129954" style="background-image: url(/uploads/social/beatport.png)" target="_blank"></a>
        </div-->
    </li>
	<?}?>
</ul>
<!-- tracks (end) -->

<!-- footer (begin) -->
<div class="b-footer">
    <a href="http://reactor.ua" class="link-right" target="_blank">reactor.ua</a>
    <span class="copyright">© 2011 Reactor-Pro™</span>
    <a href="http://<?=$_SERVER['HTTP_HOST'];?>/" class="link-left" target="_blank"><?=$_SERVER['HTTP_HOST'];?></a>
</div>
<!-- footer (end) -->

<script type="text/javascript">
    $(function() {
        var playlistData = [
            <?=implode(',',$jsonArr);?>
        ];


        $('.g-player').thatplayer({
            playlist: playlistData,
            volume: 80,
            autoplay: false
        });


        $('.b-tracks .play').click(function() {
            var $track = $(this).parent(),
                trackToPlay = [{
                    artist: $track.find('.artist').html(),
                    title: $track.find('.title').html(),
                    url: $track.find('.hidden .url').html(),
                    download: $track.find('.hidden .download').html(),
                    download_url: $track.find('.hidden .download_url').html().replace(/\&amp;/g,'&')
                }];

            $('.g-player').thatplayer('playlist', trackToPlay, true);
        });

        
        $('.b-header .bg').load(function() {
            var $bgImage = $(this),
                $canvas = $bgImage.parent();

            if ($bgImage.width() / $bgImage.height() > $canvas.width() / $canvas.height()) {
                $bgImage.css({
                    'width': 'auto',
                    'height': '100%'
                });

            } else {
                $bgImage.css({
                    'width': '100%',
                    'height': 'auto'
                });
            };

            $bgImage.hide().css({
                'left': '50%',
                'top': '50%',
                'margin-left': -$bgImage.width() / 2 + 'px',
                'margin-top': -$bgImage.height() / 2 + 'px'
            }).show();
        });
    });
</script>

</body>
</html>