<div class="widget">
  <div class="widget-header">
    <a class="home" href="/"></a>
    <span class="menu"><?=$this->registry->trans['menu'];?></span>
    <div class="widget-m1">
      <?=$this->view->mainmenu;?>
    </div>
    <div class="widget-title">
      <h2><?=$this->registry->trans['contacts'];?></h2>
    </div>
  </div>
  <div class="widget-content"><div class="widget-content-wrap">
    <div class="events">
      <?
      if(is_array($this->view->clients)){
      $cnt=0;
	  $cnt2=0;
      $color = 0;
      $tomorrowlangArr=array(1=>'ru',2=>'en');
      foreach($this->view->clients as $client){

      if(date('Ymd')==$client['date_start'])
      $label='-today';
      elseif(date('Ymd')+1==$client['date_start'])
      $label='-tomorrow';
      else
      $label=null;
	  if($label)
	  $tomorrowlang[$client['id']]=' class="'.$tomorrowlangArr[$this->registry->langid].$label.'"';
      ?>
      <div class="<?=($cnt)? ' events-even ':'';?>events-li<? if ($event === end($this->view->clients)) { ?> events-last <? }; ?>">
       <a href="/event/<?=$client['id'];?>/" class="e">
          <span class="poster">
              <? if($client['avatar']) { ?>
                <img src="<?=$client['avatar'];?>" alt="<?=$client['name'];?>" />
                <img src="<?=$client['avatar2'];?>" alt="<?=$client['name'];?>" class="rollover" />
                <i class="i-frame"></i>
                <!--<i class="i-popular"><b></b></i>-->
              <? } else { ?>
                <img src="/img/club/event-admin/avatars-default.jpg" alt="<?=$client['name'];?>" />
                <img src="/img/club/event-admin/avatars-default.jpg" alt="<?=$client['name'];?>" class="rollover" />
              <? } ?>
          </span>
          <? if(strlen(trim($client['name']))>0) { ?>
            <span class="title"><strong><?=$client['name'];?></strong><i class="i"></i></span>
          <?}
           if(is_array($this->view->artists[$client['itemid']])){?>
          
              <?
              $artistHTML=null;
              $supportHTML=null;
              foreach($this->view->artists[$client['itemid']] as $artist){
                  if($artist['support'])
                  $supportHTML.='<span class="li"><strong>'.$artist['name'].'</strong><i class="i"></i></span>';
                  else
                  $artistHTML.='<span class="li">
                    <strong>'.$artist['name'].'</strong>
                    <span class="label">'.$artist['comment'].'</span>
                    <i class="i"><b></b></i>
                  </span>';
              }
              if($artistHTML){?>
			  <span class="guests<? if(strlen(trim($client['name']))<1) { ?> top-label<? } ?>">
			  <span class="ul">
			  	<?=$artistHTML;?>
              </span>
			  </span>
			  <?}?>
          <? if($supportHTML){?>
          <span class="artists">
            <span class="ul">
              <?=$supportHTML;?>
            </span>
          </span>
          <?
          }
          }
          if(strlen($client['detail_text'])>0){
          ?>
          <span class="text">
            <?
            if(strlen($client['detail_text'])>270){
            $client['detail_text']=mb_substr(strip_tags($client['detail_text']), 0, 267, 'UTF-8')."...";}
            echo $client['detail_text'];?>
          </span>
          <?}?>
          
        </a>
        
        <?
		if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0){
        ?>
        <!--<span class="controls">
          <i class="i-add"><a href="/admin/event/"></a></i>
          <i class="i-edit"><a href="/admin/event/<?=$client['id'];?>/"></a></i>
        </span>-->
        <?}?>
      </div>
      <?
      $cnt++;
      if($cnt==2) {
        $cnt=0;
        $color = 1;
        } else {
        $color = 0;
        };
      $cnt2++;
	  if($cnt2==$this->view->take){
	  	break;
	  }
	  }
      }
      if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && count($this->view->clients)<1) {
      ?>
        <a class="add-some" href="/admin/event/"></a>
      <?}?>
    </div>
  </div>
  </div>
  <div class="widget-content-bot<? if ($color == 1) {?> widget-content-bot-gray<? }; ?>"></div>
  <div class="widget-footer">
    <? if(count($this->view->clients)>$this->view->take){?>
	<div class="widget-more-link">
      <form action="/events/getmore/" method="post">
        <span>загрузить ещё<i class="i-loading"></i></span>
      </form>
    </div>
	<?}?>
  </div>
</div>
