    <h1>Места в моем регионе</h1>

    <div class="places">
      <input name="love_url" value="_places_love.php" type="hidden" />
      <input name="more_url" value="_places_more.php" type="hidden" />
      <input name="more_offset" value="10" type="hidden" />

      <div class="places-list">

        <?
		$cnt=0;
		foreach($this->view->places as $place){?>
		<div class="places-li">
          <input name="id" value="1" type="hidden" />
          <div class="h">
            <div class="love-link"><i class="i"></i></div>
            <div class="title">
              <a href="/place/<?=$place['id'];?>/">
                <strong><?=$place['name'];?></strong>
                <span class="logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="loved"><div>234</div></div>
          </div>
          <? if($place['address']){?>
		  <div class="location"><a href="<?=$place['maplink'];?>" target="_blank"><?=$place['address'];?><i class="i"></i></a></div>
          <?}?>
		  <ul class="contacts">
            <li class="site"><a href="#" target="_blank">www.krishamira.ru</a></li>
            <li class="email"><a href="mailto:nfo@krishamira.ru">nfo@krishamira.ru</a></li>
            <li class="last phone">+7 845 2323233</li>
          </ul>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>
		<?
		$cnt++;
		if($cnt==2){
			echo '<div class="places-br"></div>';
			$cnt=0;
		}
		}?>

        <!--<div class="places-li">
          <input name="id" value="2" type="hidden" />
          <div class="h">
            <div class="love-link"><i class="i"></i></div>
            <div class="title">
              <a href="#">
                <strong>Арма 17</strong>
                <span class="logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="loved"><div>234</div></div>
          </div>
          <div class="location"><a href="#" target="_blank">Москва, ул. Академика Королева, 13<i class="i"></i></a></div>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>

        <div class="places-br"></div>

        <div class="places-li">
          <input name="id" value="3" type="hidden" />
          <div class="h">
            <div class="love-link"><i class="i"></i></div>
            <div class="title">
              <a href="#">
                <strong>Арма 17</strong>
                <span class="logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="loved"><div>234</div></div>
          </div>
          <ul class="contacts">
            <li class="site"><a href="#" target="_blank">www.krishamira.ru</a></li>
            <li class="email"><a href="mailto:nfo@krishamira.ru">nfo@krishamira.ru</a></li>
            <li class="last phone">+7 845 2323233</li>
          </ul>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>

        <div class="places-li">
          <input name="id" value="4" type="hidden" />
          <div class="h">
            <div class="love-link"><i class="i"></i></div>
            <div class="title">
              <a href="#">
                <strong>Арма 17</strong>
                <span class="logo">
                  <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                  <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                  <i class="i"></i>
                </span>
              </a>
            </div>
            <div class="loved"><div>234</div></div>
          </div>
          <div class="location"><a href="#" target="_blank">Москва, ул. Академика Королева, 13<i class="i"></i></a></div>
          <ul class="contacts">
            <li class="site"><a href="#" target="_blank">www.krishamira.ru</a></li>
            <li class="email"><a href="mailto:nfo@krishamira.ru">nfo@krishamira.ru</a></li>
            <li class="last phone">+7 845 2323233</li>
          </ul>
          <ul class="links">
            <li class="commented"><a href="#"><span class="sep">&bull;</span> 12 <span class="new">(3 новых)</span><i class="i"></i></a></li>
            <li class="liked"><a href="#"><span class="sep">&bull;</span> 12<i class="i"></i></a></li>
          </ul>
        </div>

        <div class="places-br"></div>-->
       

      </div>

      <div class="more">
        <div class="hr2"><i></i></div>
        <div class="more-link">
          <div>
            <span>загрузить ещё</span>
            <i class="loading"></i>
          </div>
        </div>
      </div>

    </div>