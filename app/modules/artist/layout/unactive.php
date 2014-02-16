<!DOCTYPE html>
<html>
<head>
    <title>Reactor</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/js/artist/admin/jquery.js"></script>
    <style type="text/css">
        body,
        html {
            margin: 0;
            padding: 0;
            font: 12px Arial;
            color: #999;
        }
        .g-background {
            position: absolute;
            z-index:0;
            top:0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow:hidden;
        }
            .g-background > img {
                position:absolute;
                top:-9999px;
                left:-9999px;
            }
        .g-grid-overlay {
            position:absolute;
            z-index:10;
            top:0;
            right:0;
            bottom:0;
            left:0;
            background:url('/img/artist/bg-grid-overlay.png') repeat top left;
        }
        .b-login-box-overlay {
            position:absolute;
            z-index:100;
            top:50%;
            left:50%;
            width: 490px;
            height: 230px;
            margin: -115px 0 0 -245px;
             -moz-border-radius:13px;
            -webkit-border-radius:13px;
            border-radius:13px;
            background: #000;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
            filter: alpha(opacity=40);
            -moz-opacity: 0.4;
            opacity: 0.4;
        }
        .b-login-box {
            position:absolute;
            z-index:100;
            top:50%;
            left:50%;
            width:420px;
            margin: -100px 0 0 -230px;
            padding:20px 20px 10px;
            -moz-border-radius:4px;
            -webkit-border-radius:4px;
            border-radius:4px;
            background:#E6E6E6;
        }
            .b-login-box h1 {
                margin: 0 0 13px;
                text-align: center;
                font-weight: normal;
                text-shadow: 0 1px 0  #FFF;
                color: #333;
            }
            .b-login-box .forgot-password {
                text-decoration: underline;
                color:#000;
            }
            .b-login-box .close {
                float:right;
                display:block;
                height:17px;
                width:17px;
                background:url('/img/artist/bg-login-popup-close.png') no-repeat center center;
                text-indent:-9999px;
                outline: 0;
            }
            .b-login-box .login-form {
                padding:10px 0 0;
            }
                .b-login-box .login-form .login-caption {
                    display:inline-block;
                    width:215px;
                    padding:0 0 8px;
                    font-size:11px;
                    color:#666;
                }
                .b-login-box .login-form .password-caption {
                    display:inline-block;
                    width:205px;
                    padding:0 0 8px;
                    font-size:11px;
                    color:#666;
                }
                .b-login-box .login-form .login {
                    width:185px;
                    margin:0 10px 0 0;
                    padding:10px;
                    border:0;
                    -moz-border-radius:4px;
                    -webkit-border-radius:4px;
                    border-radius:4px;
                    -moz-box-shadow: 0px -1px 0px #7D7D7D;
                    -webkit-box-shadow: 0px -1px 0px #7D7D7D;
                    box-shadow: 0px -1px 0px #7D7D7D;
                }
                .b-login-box .login-form .password {
                    width:185px;
                    padding:10px;
                    border:0;
                    -moz-border-radius:4px;
                    -webkit-border-radius:4px;
                    border-radius:4px;
                    -moz-box-shadow: 0px -1px 0px #7D7D7D;
                    -webkit-box-shadow: 0px -1px 0px #7D7D7D;
                    box-shadow: 0px -1px 0px #7D7D7D;
                }
                .b-login-box .login-form .button-set {
                    height:40px;
                    overflow:hidden;
                    padding:16px 0 0;
                }
                    .b-login-box .login-form .button-set .submit {
                        float:right;
                        padding:8px 35px 9px;
                        border:0;
                        background:url('/img/artist/bg-login-box-submit.png') repeat-x center left;
                        -moz-border-radius:4px;
                        -webkit-border-radius:4px;
                        border-radius:4px;
                        -moz-text-shadow:0px -1px 0px #000;
                        -webkit-text-shadow:0px -1px 0px #000;
                        text-shadow:0px -1px 0px #000;
                        -moz-box-shadow:0px 1px 2px #3F3F3F;
                        -webkit-box-shadow:0px 1px 2px #3F3F3F;
                        box-shadow:0px 1px 2px #3F3F3F;
                        color:#FFF;
                        cursor:pointer;
                    }
                    .b-login-box .login-form .button-set .remember-me {
                        clear:left;
                        float:left;
                        padding:0 0 7px;
                        color:#333;
                    }
                        .b-login-box .login-form .button-set .remember-me input {
                            margin:0 0 1px;
                            padding:0;
                            vertical-align:bottom;
                        }
                    .b-login-box .login-form .button-set .alert {
                        clear:left;
                        float:left;
                        font-style:italic;
                        color:#C00;
                    }
    </style>
</head>
<body>

<div class="g-background">
    <img src="<?=$this->view->pagebg;?>" />
</div>
<div class="g-grid-overlay"></div>
<div class="b-login-box-overlay"></div>
<div class="b-login-box">
    <h1>Сайт временно не работает</h1>

    <form class="login-form" action="/user/login/" method="post">
    	<input id="token" name="token" type="hidden" value="<?=$this->view->token;?>"><i class="login-caption">Email</i><i class="password-caption">Password</i>
        <input class="login" name="email" type="text"><input class="password" name="password" type="password">
        <div class="button-set">
            <input class="submit" type="submit" value="Вход">
            <label class="remember-me" for=""><input type="checkbox" name="remember" /> Оставаться в системе</label>
            <span class="alert"></span>
        </div>
    </form>
</div>

<script type="text/javascript">
    (function($){
        $.fn.scalable = function(o){
            o = $.extend({
                speed: 'normal'
            }, o || {});

            return this.each(function(){
                var canvas = this,
                    $images = $('img:first', this);

                $images.each(function(i){
                    if (this.complete) {
                        parse(this);
                    } else {
                        this.onload = function(){
                            parse(this);
                        };
                    }
                });

                function parse(image) {
                    var $image = $(image),
                        ratio = image.clientWidth / image.clientHeight;

                    scale(image, ratio);
                    $(window).resize(function(){
                        scale(image, ratio);
                    });

                    $image.hide().css({'left': '50%', 'top': '50%'}).fadeIn(o.speed);
                }

                function scale(image, ratio) {
                    if (canvas.clientHeight * ratio > canvas.clientWidth) {
                        image.style.width = 'auto';
                        image.style.height = '100%';
                    } else {
                        image.style.width = '100%';
                        image.style.height = 'auto';
                    }

                    image.style.marginLeft = -image.clientWidth / 2 + 'px';
                    image.style.marginTop = -image.clientHeight / 2 + 'px';
                }
            });
        };
    }) (jQuery);

    $().ready(function() {
        $('.g-background').scalable();

        $('.login-form').find(':submit').click(function(event) {
            event.preventDefault();

            var loginForm = $('.login-form'),
                rememberMe = loginForm.find('.remember-me input').attr('checked') ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '/user/login/',
                data: 'data={"token":"' + $('#token').val() + '", "email":"' + loginForm.find('.login').val() + '", "password":"' + loginForm.find('.password').val() + '", "action":1, "remember":' + rememberMe + '}',
                success: function(response) {
                    loginResponse = $.parseJSON(response);

                    $('#token').val(loginResponse.token);

                    loginResponse.error ? loginForm.find('.alert').html(loginResponse.status) : document.location.href = '/';
                }
            });
        });
    });
</script>
</body>
</html>