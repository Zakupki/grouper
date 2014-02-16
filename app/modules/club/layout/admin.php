<!DOCTYPE html>
<html>
<head>
  <title><?=$this->view->sitetitle;?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="tpl" content="" />
  <meta name="base" content="" />
  <meta name="lang" content="" />
  <link href="/css/club/main.css?<?=time();?>" type="text/css" rel="stylesheet" />
  <script src="/js/club/lib.js?<?=time();?>" type="text/javascript"></script>
  <!--script src="/js/club/lang-ru.js?<?=time();?>" type="text/javascript"></script-->
  <? 
  if($this->registry->langid==1){?>
  <script type="text/javascript">
    /* lang */
    var lang = {
        confirm: 'Вы уверены?',
        commentsRemoveConfirm: 'Вы уверены, что хотите удалить комментарий?',
        basicAdminTurnOnConfirm: 'Вы уверены, что хотите включить реккаунт?',
        basicAdminTurnOffConfirm: 'Вы уверены, что хотите выключить реккаунт?',
        teasersAdminRemoveConfirm: 'Вы уверены, что хотите удалить баннер?',
        eventAdminAvatarRemoveConfirm: 'Вы уверены, что хотите удалить аватар?',
        eventAdminPosterRemoveConfirm: 'Вы уверены, что хотите удалить постер?',
        eventAdminRemoveConfirm: 'Вы уверены, что хотите удалить это событие?',
        videoAdminVideoRemoveConfirm: 'Вы уверены, что хотите удалить это видео?',
        videoAdminPreviewRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
        trackAdminTrackRemoveConfirm: 'Вы уверены, что хотите удалить трек?',
        trackAdminCoverRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
        galleryAdminGalleryRemoveConfirm: 'Вы уверены, что хотите удалить галерею?',
        galleryAdminImageRemoveConfirm: 'Вы уверены, что хотите удалить фото?',
        uploadLimitExceeded: 'Ваш лимит загрузок исчерпан',
        uploadLimitFrom: 'из',
        months: [
            ['Январь', 'Января'],
            ['Февраль', 'Февраля'],
            ['Март', 'Марта'],
            ['Апрель', 'Апреля'],
            ['Май', 'Мая'],
            ['Июнь', 'Июня'],
            ['Июль', 'Июля'],
            ['Август', 'Августа'],
            ['Сентябрь', 'Сентября'],
            ['Октябрь', 'Октября'],
            ['Ноябрь', 'Ноября'],
            ['Декабрь', 'Декабря']
        ],
        weekdays: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье']
    };

    /* jQuery UI date picker */
    jQuery(function($){
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: '&#x3c;Пред',
            nextText: 'След&#x3e;',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Нед',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    });
  </script>
  <?}elseif($this->registry->langid==2){?>
   <script type="text/javascript">
    /* lang */
    var lang = {
        confirm: 'Are you sure?',
        commentsRemoveConfirm: 'Do you really want to delete the comment?',
        basicAdminTurnOnConfirm: 'Do you really want to switch reccount on?',
        basicAdminTurnOffConfirm: 'Do you really want to switch reccount on?',
        teasersAdminRemoveConfirm: 'Do you really want to delete banner?',
        eventAdminAvatarRemoveConfirm: 'Do you really want to delete avatar?',
        eventAdminPosterRemoveConfirm: 'Do you really want to delete poster?',
        eventAdminRemoveConfirm: 'Do you really want to delete event?',
        videoAdminVideoRemoveConfirm: 'Do you really want to delete this video?',
        videoAdminPreviewRemoveConfirm: 'Do you really want to delete cover?',
        trackAdminTrackRemoveConfirm: 'Do you really want to delete track?',
        trackAdminCoverRemoveConfirm: 'Do you really want to delete cover?',
        galleryAdminGalleryRemoveConfirm: 'Do you really want to delete gallery?',
        galleryAdminImageRemoveConfirm: 'Do you really want to delete photo?',
        months: [
            ['Januarry', 'Januarry'],
            ['February', 'February'],
            ['March', 'March'],
            ['April', 'April'],
            ['May', 'May'],
            ['June', 'June'],
            ['July', 'July'],
            ['August', 'August'],
            ['September', 'September'],
            ['October', 'October'],
            ['November', 'November'],
            ['December', 'December']
        ],
        weekdays: ['monday', 'tuesday', 'wednesday', 'thirthday', 'friday', 'saturday', 'sunday']
    };

    /* jQuery UI date picker */
    jQuery(function($){
        $.datepicker.regional['ru'] = {
            closeText: 'Close',
            prevText: '&#x3c;Prev',
            nextText: 'Next&#x3e;',
            currentText: 'Today',
            monthNames: ['Januarry','February','March','April','May','June', 'July','August','September','October','November','December'],
            monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'],
            dayNames: ['sunday','monday','tuesday','wednesday','thirthday','friday','saturday'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Sun','Mon','Tue','Wed','Thi','Fri','Sat'],
            weekHeader: 'Week',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    });
  </script>
  <?}?>
  <script src="/js/club/main.js?<?=time();?>" type="text/javascript"></script>
  <link href="<?=$this->view->favicon['url'];?>" rel="icon" type="image/x-icon" />
  <link href="<?=$this->view->favicon['url'];?>" rel="shortcut icon" type="image/x-icon" />
  <style type="text/css">
    .jplayer-title-sep,
    .jplayer-title-artist,
    .jplayer-time-position,
    .galleries h3 a,
    .gallery .header h1,
    .tracks h3 a,
    .event h2,
    .events .title strong,
    .widget-m1 a:hover,
    .widget-m2 a:hover,
    .widget-m2 .act,
    .widget-m2 .act a,
    .widget-m2 .act a:hover,
    .widget-title h2,
    .widget-title h2 a,
    .widget-title h2 a:hover,
    .widget-more-link:hover span,
    .place .descr h2,
    .place .descr h2 a,
    .place .descr h2 a:hover,
    .place .gallery-link h3 a,
    .place .gallery-link h3 a:hover,
    .gallery-admin .date-input-weekend,
    .teasers .jflow-pi-act span,
    .teasers .jflow-pi span:hover,
    .videos h3 a,
    .contacts .email a:hover {
        color: #<?=$this->view->sitedata['color'];?> !important;
    }
    .events .guests .i,
    .event .guests .i {
        background: url('/uploads/star/<?=$this->view->sitedata['color'];?>.png') no-repeat center center !important;
    }
    .events .poster .i-popular {
        background: url('/uploads/eventlike/<?=$this->view->sitedata['color'];?>.png') no-repeat center center !important;
    }
    .events .i-today,
    .events .i-tomorrow {
        background: url('/uploads/today/<?=$this->view->sitedata['color'];?>.png') no-repeat 0px 0px !important;
    }
    .jplayer-loaded-bar {
        background: url('/uploads/playerbar/<?=$this->view->sitedata['color'];?>.png') repeat-x bottom center !important;
    }
  </style>
</head>
<body>


<div class="layout-body">
  <div class="layout-top">
    <? if($this->view->Session->User['id']){?>
      <ul class="user-links">
      	<li class="profile-link"><a href="/user/profile/"><?=$this->registry->trans['profile'];?><i class="i"></i></a></li>
        <li class="reccount-link"><a href="/admin/reccount/"><?=$this->registry->trans['options'];?><i class="i"></i></a></li>
        <li class="design-link"><a href="/admin/design/"><?=$this->registry->trans['design'];?><i class="i"></i></a></li>
        <? if($this->registry->langid==1){?>
        <li class="notifications-link"><a href="/admin/requests"><?=$this->registry->trans['notices'];?><span class="new"><span class="r"><span class="l"><span class="text"></span></span></span></span><i class="i"></i></a></li>
        <?}?>
        <li class="sync-link"><a class="disabled"><?=$this->registry->trans['synchronization'];?><i class="i"></i></a></li>
        <li class="second-dates"><a class="disabled"><?=$this->registry->trans['seconddates'];?><i class="i"></i></a></li>
        <!--
        <li class="recard"><a href="/admin/recard/">ReCard<span class="new"><span class="r"><span class="l"><span class="text"></span></span></span></span><i class="i"></i></a></li>
        -->
        <!--<li class="base"><a class="disabled">База<i class="i"></i></a></li>-->
      <? if($_SESSION['Site']['languageid']==1){?>
		<li class="sponsors"><a href="/admin/form/"><?=$this->registry->trans['sponsors'];?><i class="i"></i></a></li>
      <?}?>  
		
      </ul>
      <div class="auth-link"><a href="/user/logout/"><i class="i-logout"></i></a></div>
    <? } ?>
  </div>

  <div class="layout-header"></div>
  <div class="layout-content">
    <div class="widgets">
      <?=$this->view->content;?>
      <div class="widgets-top"></div>
      <div class="widgets-bot"></div>
    </div>
  </div>
</div>

<? if($this->registry->hdderror == 1){ ?>
<div id="hdderror" data-hddtotal="<?=$this->registry->hddtotal;?>" data-hddlimit="<?=$this->registry->hddlimit;?>"></div>
<? } ?>

<script type="text/javascript">
    Cufon.now();
</script>

</body>
</html>