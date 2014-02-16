      <?
      if(is_array($this->view->events)){
      $cnt=0;
      $cnt2=0;
	  $color = 0;
      foreach($this->view->events as $event){

      if(date('Ymd')==$event['date_start'])
      $label='-today';
      elseif(date('Ymd')+1==$event['date_start'])
      $label='-tomorrow';
      else
      $label='';

      ?>
      <div class="<?=($cnt)? ' events-even ':'';?>events-li<? if ($event === end($this->view->events)) { ?> events-last <? }; ?>">
       <a href="/event/<?=$event['id'];?>/" class="e">
          <span class="i<?=$label;?>"><div></div></span>
          <span class="<?=($event['dayinweek']==6 || $event['dayinweek']==7)?'date-weekend ':'';?>date">
            <span class="day"><?=$event['dayinmonth'];?></span>
            <span class="month"><?=tools::GetMonth($event['month'],$this->registry->langid);?></span>
            <span class="weekday"><?=tools::GetDayOfWeek($event['dayinweek'],$this->registry->langid);?></span>
            <i class="i"></i>
          </span>
          <span class="poster">
              <? if($event['avatar']) { ?>
                <img src="<?=$event['avatar'];?>" alt="<?=$event['name'];?>" />
                <img src="<?=$event['avatar2'];?>" alt="<?=$event['name'];?>" class="rollover" />
                <i class="i-frame"></i>
                <!--<i class="i-popular"><b></b></i>-->
              <? } else { ?>
                <img src="/img/club/event-admin/avatars-default.jpg" alt="<?=$event['name'];?>" />
                <img src="/img/club/event-admin/avatars-default.jpg" alt="<?=$event['name'];?>" class="rollover" />
              <? } ?>
          </span>
          <? if(strlen(trim($event['name']))>0) { ?>
            <span class="title"><strong><?=$event['name'];?></strong><i class="i"></i></span>
          <?}
           if(is_array($this->view->artists[$event['itemid']])){?>
          
              <?
              $artistHTML=null;
              $supportHTML=null;
              foreach($this->view->artists[$event['itemid']] as $artist){
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
			  <span class="guests<? if(strlen(trim($event['name']))<1) { ?> top-label<? } ?>">
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
          if(strlen($event['detail_text'])>0){
          ?>
          <span class="text">
            <?
            if(strlen($event['detail_text'])>270){
            $event['detail_text']=mb_substr(strip_tags($event['detail_text']), 0, 267, 'UTF-8')."...";}
            echo $event['detail_text'];?>
          </span>
          <?}?>
          <span class="links">
            <span class="comments-link li"><span class="sep">&bull;</span> <?=$this->view->comments[$event['itemid']]['comnum'];?> <span class="new"><?=($this->view->comments[$event['itemid']]['comvisnum'])?'('.$this->view->comments[$event['itemid']]['comvisnum'].' новых)':'';?></span><i class="i"></i></span>
            <span class="likes-link li"><span class="sep">&bull;</span> <?=tools::int($this->view->rate[$event['itemid']]);?><i class="i"></i></span>
          </span>
        </a>
        <? if($event['concertua']){
         	$prottype='http://';
            if(strstr($event['concertua'],'https://')){
            $prottype='https://';
            $event['concertua']=str_replace('https://', '', $event['concertua']);
            }
            elseif(strstr($event['concertua'],'http://')){
            $event['concertua']=str_replace('http://', '', $event['concertua']);
            $prottype='http://';
            }
		?>
		<a class="concertua" href="<?=$prottype.$event['concertua'];?>" target="_blank">
            <span>Купить билет на concert.ua</span>
            <i>044 222-00-22</i>
        </a>
        <div class="concertua-after"></div>
        <?
		}
        if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0){
        ?>
        <span class="controls">
          <i class="i-add"><a href="/admin/event/"></a></i>
          <i class="i-edit"><a href="/admin/event/<?=$event['id'];?>/"></a></i>
        </span>
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
      if(tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && count($this->view->events)<1) {
      ?>
        <a class="add-some" href="/admin/event/"></a>
      <?}?>
    </div>

    <? if($this->view->take>=count($this->view->events)) { ?>
        <script type="text/javascript">
		var isLast = true;
		</script>
    <? } ?>
