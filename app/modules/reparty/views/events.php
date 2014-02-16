    <h1>Cобытия в моем регионе</h1>

    <div class="events">
      <input name="places_love_url" value="_places_love.php" type="hidden" />
      <input name="more_url" value="_events_more.php" type="hidden" />
      <input name="more_offset" value="5" type="hidden" />
	<div class="events-list">
      <? 
	  	 $cnt=1;
		 foreach($this->view->events['events'] as $event){
       	 if(date('Ymd')==$event['date_start'])
		 $label='-today';
		 elseif(date('Ymd')+1==$event['date_start'])
		 $label='-tomorrow';
		 else
		 $label=null;
	  ?>
	  

        <div class="<?=($cnt==count($this->view->events['events']))?'events-last ':'';?>events-li">
          <div class="place-info">
            <input name="place_id" value="1" type="hidden" />
            <div class="place-love-link"><i class="i"></i></div>
            <div class="place-title">
              <a href="#">
                <strong><?=$event['sitename'];?></strong>
                <span class="place-logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="place-loved"><div>234</div></div>
            <div class="place-location"><a href="<?=$event['maplink'];?>" target="_blank"><?=$event['address'];?><i class="i"></i></a></div>
          </div>
          <div class="event-info">
            <a href="/event/<?=$event['id'];?>/">
                  <span class="<?=($event['dayinweek']==6 || $event['dayinweek']==7)?'date-weekend ':'';?>date">
                    <span class="day"><?=$event['dayinmonth'];?></span>
                    <span class="month"><?=tools::GetMonth($event['month']);?></span>
                    <span class="weekday"><?=tools::GetDayOfWeek($event['dayinweek']);?></span>
                    <i class="i"></i>
					<? if($label){?>
					<i class="i<?=$label;?>"></i>
                  	<?}?>
				  </span>
              <? if($event['avatar']){?>
			  <span class="poster">
                <img src="<?=$event['avatar'];?>" alt="" />
                <img src="<?=$event['avatar2'];?>" alt="" class="rollover" />
                <i class="i"></i>
              </span>
			  <?}?>
			  <? if($event['name']){?>
              <span class="title"><strong><?=$event['name'];?></strong><i class="i"></i></span>
               <?}
				  if(is_array($this->view->events['artists'][$event['itemid']])){?>
				  <span class="guests">
                    <span class="ul">
                      <?
					  $artistHTML='';
					  $supportHTML='';
					  foreach($this->view->events['artists'][$event['itemid']] as $artist){
						  if($artist['support'])
						  $supportHTML.='<span class="li"><strong>'.$artist['name'].'</strong><i class="i"></i></span>';
						  else
						  $artistHTML.='<span class="li">
	                        <strong>'.$artist['name'].'</strong>
	                        <span class="label">'.$artist['comment'].'</span>
	                        <i class="i"></i>
	                      </span>';
					  }
					  echo $artistHTML;
					  ?>
                    </span>
                  </span>
				  <span class="artists">
                    <span class="ul">
                      <?=$supportHTML;?>
                    </span>
                  </span>
				  <?}
				  if(strlen($event['detail_text'])>0){
				  ?>
                  <span class="text">
                  	<?
					if(strlen($event['detail_text'])>270){
                	$event['detail_text']=mb_substr(strip_tags($event['detail_text']), 0, 267, 'UTF-8')."...";}
                	echo $event['detail_text'];?>
				  </span>
				  <?}?>
            </a>
          </div>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>
		<?
		$cnt++;
		}?>
        

        

        <!--<div class="events-li">
          <div class="place-info">
            <input name="place_id" value="4" type="hidden" />
            <div class="place-love-link"><i class="i"></i></div>
            <div class="place-title">
              <a href="#">
                <strong>Арма 17</strong>
                <span class="place-logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="place-loved"><div>234</div></div>
            <div class="place-location"><a href="#" target="_blank">Москва, ул. Академика Королева, 13<i class="i"></i></a></div>
          </div>
          <div class="event-info">
            <a href="#">
              <span class="date">
                <span class="day">31</span>
                <span class="month">июнь</span>
                <span class="weekday">Понедельник</span>
                <i class="i"></i>
              </span>
              <span class="poster">
                <img src="/img/reparty/uploads/events_poster.jpg" alt="" />
                <img src="/img/reparty/uploads/events_poster_rollover.jpg" alt="" class="rollover" />
                <i class="i"></i>
              </span>
              <span class="guests">
                <span class="ul">
                  <span class="li">
                    <strong>Kollektiv Turmstrasse</strong>
                    <span class="label">Cocoon</span>
                    <i class="i"></i>
                  </span>
                  <span class="li">
                    <strong>Extrawelt</strong>
                    <span class="label">Cocoon</span>
                    <i class="i"></i>
                  </span>
                  <span class="last li">
                    <strong>Nathan Fake</strong>
                    <span class="label">Border Community</span>
                    <i class="i"></i>
                  </span>
                </span>
              </span>
            </a>
          </div>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>

        <div class="events-last events-li">
          <div class="place-info">
            <input name="place_id" value="5" type="hidden" />
            <div class="place-love-link"><i class="i"></i></div>
            <div class="place-title">
              <a href="#">
                <strong>Арма 17</strong>
                <span class="place-logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="place-loved"><div>234</div></div>
            <div class="place-location"><a href="#" target="_blank">Москва, ул. Академика Королева, 13<i class="i"></i></a></div>
          </div>
          <div class="event-info">
            <a href="#">
              <span class="date">
                <span class="day">31</span>
                <span class="month">июнь</span>
                <span class="weekday">Понедельник</span>
                <i class="i"></i>
              </span>
              <span class="poster">
                <img src="/img/reparty/uploads/events_poster.jpg" alt="" />
                <img src="/img/reparty/uploads/events_poster_rollover.jpg" alt="" class="rollover" />
                <i class="i"></i>
              </span>
              <span class="text">Steve Lawler djing live in south america at Creamfields Buenos Aires, Argentina. The tenth edition of Creamfields Buenos Aires (November 13, 2010).</span>
            </a>
          </div>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>-->

      </div>

      <div class="more">
        <div class="hr2"><i class="i"></i></div>
        <div class="more-link">
          <div>
            <span>загрузить ещё</span>
            <i class="loading"></i>
          </div>
        </div>
      </div>

    </div>