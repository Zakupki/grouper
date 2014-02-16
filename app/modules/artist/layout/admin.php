<!DOCTYPE html>
<html>
<head>
    <title><?=$this->view->sitename;?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/artist/admin/main.css?<?=time();?>" media="screen"/>
    <!--[if lte IE 8]>
        <link rel="stylesheet" type="text/css" href="/css/artist/admin/ie.css" media="screen"/>
    <![endif]-->
    <script type="text/javascript">
        var languageId  = <?=$_SESSION['Site']['languageid'];?>;
    </script>
    <script type="text/javascript" src="/js/artist/admin/jquery.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/admin/libs.js?<?=time();?>"></script>
    <script type="text/javascript" src="/uploadify/swfobject.js?<?=time();?>"></script>
    <script type="text/javascript" src="/uploadify/jquery.uploadify.v2.1.4.min.js?<?=time();?>"></script>
    <script type="text/javascript" src="/js/artist/admin/utils.js?<?=time();?>"></script>
    <link href="<?=$this->view->favicon['url'];?>" rel="icon" type="image/x-icon" />
    <link href="<?=$this->view->favicon['url'];?>" rel="shortcut icon" type="image/x-icon" />
    <!--style type="text/css">
        .b-backgrounds .b-backgrounds li .current,
        .b-previews .b-previews .current,
        .b-covers .b-covers li .current {
            border: 2px solid #<?=$this->view->color;?> !important;
        }

        .g-header .notifications-new,
        .g-header .notifications-new:hover,
        .g-header .notifications-new:visited,
        .g-submenu .current div,
        .b-edit-radioshow .radioshows li .description h3 sup,
        .b-edit-releases .releases li .description h3 span,
        .b-edit-releases .releases li .description h3 sup,
        .b-edit-releases .releases li .description .infolinks > li.label,
        .b-edit-release .b-items li .description .author,
        .b-edit-release .b-items li .description .label {
            color:#<?=$this->view->color;?> !important;
        }
    </style-->
    <script type="text/javascript">
        var isQuotaLimitReached  = 0;
    </script>
</head>
<body>

<!-- global wrapper (begin) -->
<div class="g-wrap">

    <!-- header (begin) -->
   <?if($this->view->Session->User['id']){?>
   <?
   					$cnt=1;
					foreach($this->view->mainmenu as $menu){
                    		$menucss='';
							
							if(count($this->view->mainmenu)==$cnt)
							$lastmenuli=' class="last"';
							
							if($menu['active']==0)
							$menucss=' class="unactive"';
							
                            if(str_replace('inner','',str_replace('add','',$this->registry->action))==$menu['code']){
                            $curmodule='#/'.$menu['code'];
							$mainmenustr.= '<li'.$lastmenuli.'><b></b><a href="/admin/'.$menu['code'].'/"'.$menucss.'>'.$menu['name'].'</a></li>';
							}
                            else
                            $mainmenustr.= '<li'.$lastmenuli.'><a href="/admin/'.$menu['code'].'/"'.$menucss.'>'.$menu['name'].'</a></li>';
                    $cnt++;
					}
                    ?>
    <ul class="g-header">
        <li>
            <a href="/reccount/menu/" class="reccount-settings"><?=$this->registry->trans['account_settings'];?></a>
        </li><li>
            <a href="/design/" class="design-settings"><?=$this->registry->trans['design_settings'];?></a>
        </li><li>
            <a href="/admin/messages/" class="notifications"><?=$this->registry->trans['notices'];?> <span class="counter"><? if ($this->view->messageum>0) { ?> (<?=$this->view->messageum;?>)<? } ?></span></a>
        </li><li>
            <a href="/reccount/synchro/" class="synchronization"><?=$this->registry->trans['sync'];?></a>
        </li><li>
            <a href="/<?=($curmodule)?$curmodule.'/':'';?>" class="exit-edit-mode"><?=$this->registry->trans['view_mode'];?></a>
        </li><li class="logout">
            <a href="/user/logout/" title="Logout">&nbsp;</a>
        </li>
    </ul>
	<?}?>
    <!-- header (end) -->

    <!-- navigation (begin) -->
    <div class="g-navigation">
        <ul class="b-navigation-list">
            <?=$mainmenustr;?>
        </ul>
    </div>
    <!-- navigation (end) -->
   <?=$this->view->reccountmenu;?>
   <?=$this->view->content;?>
</div>
<!-- global wrapper (end) -->

<!-- footer (begin) -->
<div class="g-footer-wrap">
    <ul class="g-footer">
        <li><a><?=$this->registry->trans['support'];?></a></li>
        <li><a><?=$this->registry->trans['faq'];?></a></li>
        <li><a><?=$this->registry->trans['feedback'];?></a></li>
        <li class="copyright"><span>&copy; Reactor</span> <a></a></li>
    </ul>
</div>
<!-- footer (end) -->

<!-- error popup (begin) -->
<div class="b-error-box">
    <a class="close" href="#">X</a>
    <span class="message"></span>
    <div class="button-set">
        <input class="submit" type="button" value="Ok">
    </div>
</div>
<!-- error popup (end) -->

<!-- limit reached alert (begin) -->
<div class="b-limit-reached-border"></div>
<div class="b-limit-reached">
    <a class="close" href="#">X</a>
    <p>У Вас недостаточно свободного места. Вы можете докупить его в разделе "Мои реккаунты".</p>
</div>
<!-- limit reached alert (end) -->

</body>
</html>