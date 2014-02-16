    <h1>Cобытиe</h1>

    <div class="event">
      <input name="place_love_url" value="_places_love.php" type="hidden" />
      <div class="sidebar">
        <div class="date-weekend date">
          <div class="day">31</div>
          <div class="month">июнь</div>
          <div class="weekday">Суббота</div>
          <div class="i"></div>
          <div class="i-tomorrow"></div>
        </div>
		<? if($this->view->eventinner['data']['poster']){?>
        <div class="poster"><img src="<?=$this->view->eventinner['data']['poster'];?>" alt="" /></div>
      	<?}?>
	  </div>
      <div class="descr">
        <div class="place-info">
          <input name="place_id" value="1" type="hidden" />
          <div class="place-love-link"><i class="i"></i></div>
          <div class="place-title">
            <a href="#">
              <strong><?=$this->view->eventinner['data']['sitename'];?></strong>
              <span class="place-logo">
                <img src="/img/reparty/uploads/events_logo.gif" alt="" />
                <img src="/img/reparty/uploads/events_logo_rollover.gif" alt="" class="rollover" />
                <i class="i"></i>
              </span>
            </a>
          </div>
          <div class="place-loved"><div>234</div></div>
          <div class="place-location"><a href="<?=$this->view->eventinner['data']['maplink'];?>" target="_blank"><?=$this->view->eventinner['data']['address'];?><i class="i"></i></a></div>
        </div>
        <div class="event-info">
          <? if($this->view->eventinner['data']['name']){?>
		  <div class="title">
            <h2><?=$this->view->eventinner['data']['name'];?></h2>
            <div class="i"></div>
          </div>
		  <?}
		  if(is_array($this->view->eventinner['artists'])){
			$artistHTML=null;
			$supportHTML=null;
			foreach($this->view->eventinner['artists'] as $artist){
			 if($artist['support'])
			  $supportHTML.='<li><strong>'.$artist['name'].'</strong><i class="i"></i></li>';
			 else
			  $artistHTML.='
			  <li>
	          <strong>'.$artist['name'].'</strong>
	          <span class="label">'.$artist['comment'].'</span>
	          <i class="i"></i>
	          </li>';
		  }
		  if($artistHTML){
		  ?>
          <div class="guests">
            <ul>
              <?=$artistHTML;?>
            </ul>
          </div>
		  <?
		  }
		  if($supportHTML){
		  ?>
          <div class="artists">
            <ul>
              <?=$supportHTML;?>
            </ul>
          </div>
		  <?
		  }
		  }?>
		  <? if($this->view->eventinner['data']['detail_text']){?>
          <div class="text">
            <p><?=$this->view->eventinner['data']['detail_text'];?></p>
          </div>
		  <?}?>
          <ul class="links">
            <li><a href="#">http://www.beatport.com/release/we-play-house/680654<i class="i" style="background-image: url(/img/reparty/uploads/event_links_beatport.png);"></i></a></li>
            <li><a href="#">http://r43.tish.ua<i class="i-reccount i"></i></a></li>
          </ul>
        </div>
      </div>
    </div>



<div class="comments">

  <div class="comments-header">
    <h2>Комментарии:</h2>

    <div class="post-share">
      <input name="url" value="/_share.php" type="hidden">
      <input name="itemid" value="461" type="hidden">
      <div class="title i"></div>
      <div class="links">
        <div class="r">
          <div class="l">
            <ul>
              <li class="link-twitter"><a href="http://twitter.com/home?status=ATELIER%20http%3A%2F%2Fatelier.ua%2F" rel="twitter" target="_blank"><span class="total">12</span></a></li>
              <li class="link-facebook"><a href="http://facebook.com/sharer.php?t=ATELIER&amp;u=http%3A%2F%2Fatelier.ua%2F" rel="facebook" target="_blank"><span class="total">12</span></a></li>
              <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2Fatelier.ua%2F" rel="vkontakte" target="_blank"><span class="total">12</span></a></li>
              <li class="link-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2Fatelier.ua%2F" rel="gplus" target="_blank"><span class="total">12</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="post-rate">
      <input name="url" value="/comments/rate/" type="hidden">
      <input name="total_rate" value="0" type="hidden">
      <input name="current_rate" value="" type="hidden">
      <input name="itemid" value="461" type="hidden">
          <div class="title">Рейтинг <span class="total">(0)</span> &nbsp;<a href="_help.php" target="_blank" class="help-link"><img src="img/px.gif" alt=""></a></div>
              <div class="auth-popup-link like-link"><i class="i"></i></div>
        <div class="auth-popup-link dislike-link"><i class="i"></i></div>
          </div>
  </div>

  <div class="comments-tree">
    <input name="remove_url" value="/comments/remove/" type="hidden">
    <input name="quote_url" value="/comments/like/" type="hidden" /> 
    <input name="quote_url" value="/comments/quote/" type="hidden">
    <input name="unquote_url" value="/comments/unquote/" type="hidden">
    
    <div class="ti" id="comment187">
        <input name="userid" value="30" type="hidden">
      
      <div class="content-pro content">
              <div class="userpic"><a href="/users/orange/"><img src="/img/reparty/uploads/comments_userpic_orange.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/orange/">orange<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">07 февраля 2012 15:10</div>
                
              </div>
              <div class="text">
                <p>1  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div>
      </div><div class="ti" id="comment">
              
              <div class="content-has-reply content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div><div class="ti-last ti" id="comment">
              <div class="branch-removed branch"></div>
              <div class="content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div>
    </div>
    </div>
    <div class="ti" id="comment189">
        <input name="userid" value="40" type="hidden">
      
      <div class="content-has-reply content-pro content">
              <div class="userpic"><a href="/users/fester/"><img src="/img/reparty/uploads/comments_userpic_fester.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/fester/">fester<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">07 февраля 2012 15:48</div>
                
              </div>
              <div class="text">
                <p>123  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div><div class="ti-last ti" id="comment">
              <div class="branch-removed branch"></div>
              <div class="content-has-reply content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div>
    <div class="ti-last ti" id="comment209">
        <input name="userid" value="40" type="hidden">
      <div class="branch"></div>
      <div class="content-has-reply content-pro content">
              <div class="userpic"><a href="/users/fester/"><img src="/img/reparty/uploads/comments_userpic_fester.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/fester/">fester<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">09 февраля 2012 12:42</div>
                
              </div>
              <div class="text">
                <p>444  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div>
    <div class="ti-last ti" id="comment210">
        <input name="userid" value="40" type="hidden">
      <div class="branch"></div>
      <div class="content-pro content">
              <div class="userpic"><a href="/users/fester/"><img src="/img/reparty/uploads/comments_userpic_fester.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/fester/">fester<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">09 февраля 2012 14:18</div>
                
              </div>
              <div class="text">
                <p>123  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div>
      </div>
      </div>
    </div>
      </div><div class="ti" id="comment">
              
              <div class="content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div>
    </div>
    <div class="ti" id="comment207">
        <input name="userid" value="40" type="hidden">
      
      <div class="content-has-reply content-pro content">
              <div class="userpic"><a href="/users/fester/"><img src="/img/reparty/uploads/comments_userpic_fester.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/fester/">fester<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">09 февраля 2012 11:44</div>
                
              </div>
              <div class="text">
                <p>133  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div><div class="ti-last ti" id="comment">
              <div class="branch-removed branch"></div>
              <div class="content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div>
    </div>
      </div>
    <div class="ti" id="comment212">
        <input name="userid" value="40" type="hidden">
      
      <div class="content-pro content">
              <div class="userpic"><a href="/users/fester/"><img src="/img/reparty/uploads/comments_userpic_fester.jpg" alt=""></a></div>
              <div class="author">
                <div class="user-link-pro user-link"><a href="/users/fester/">fester<i class="i"></i><i class="i-pro"></i></a></div>
                <div class="date">09 февраля 2012 19:14</div>
                
              </div>
              <div class="text">
                <p>Глава государства подчеркнул, что дипломатам приходится работать в условиях стремительно меняющегося мира, и его пируэты требуют постоянного анализа. «Необходим постоянный анализ ситуации происходящего на международной арене, прогнозирование развития событий, а также понимание того, что происходит внутри страны», — заявил президент.  
          </p>
              </div>
              <div class="reply-link"><span>ответить<i class="i"></i></span></div>
            </div>
      </div><div class="ti-last ti" id="comment">
              
              <div class="content-pro content-removed content">
                <div class="text-removed text">Комментарий удален</div>
              </div>
    </div>  </div>

  <div class="comments-add">
    <div class="add-link"><span>Добавить комментарий</span></div>
    <div class="comments-form">
      <form action="/comments/addcomment/" method="post" enctype="multipart/form-data" novalidate="novalidate">
        <input name="parent_id" value="0" type="hidden">
        <input name="itemid" value="461" type="hidden">
        <input name="siteid" value="45" type="hidden">
        <input name="datatype" value="releases" type="hidden">
        <div class="field-message field">
          <label for="comments-form-message" class="placeholder">Сообщение</label>
          <div class="textarea">
            <textarea name="message" id="comments-form-message" cols="" rows="" title="Сообщение" class="required placeholder">Сообщение</textarea>
            <div class="input-file">
              <div class="pick">
                <div class="browse-link"><i class="i"></i></div>
                <div class="title">Прикрепить файл (до 1 МБ) <a href="_help.php" target="_blank" class="help-link"><img src="img/px.gif" alt=""></a></div>
                <div class="input"><input name="attach" type="file"></div>
              </div>
              <div class="hidden info">
                <div class="name"></div>
                <div class="clear-link"><i class="i"></i></div>
              </div>
            </div>
            <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
          </div>
        </div>
        <div class="submit">
          <div class="note">Специалисты определяли оптимальное соотношение компонентов и температуру.</div>
                      <div class="button"><div class="r"><div class="l"><button type="button" class="auth-popup-link">Добавить</button></div></div></div>
                  </div>
      </form>
    </div>
  </div>

</div>