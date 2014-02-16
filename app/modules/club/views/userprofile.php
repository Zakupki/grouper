<div class="widget">
    <div class="widget-header">
        <div class="widget-share">
            <input name="url" value="_share.php" type="hidden" />
            <input name="item_id" value="648" type="hidden" />
            <div class="i"></div>
            <div class="links">
                <div class="r">
                    <div class="l">
                        <ul>
            <li class="link-twitter"><a href="http://twitter.com/home?status=<?=urlencode($_SESSION['Site']['name']);?>%20http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="twitter" target="_blank"><span class="total"><?=tools::getTwCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-facebook"><a href="http://facebook.com/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?>" rel="facebook" target="_blank"><span class="total"><?=tools::getFbCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="vkontakte" target="_blank"><span class="total"><?=tools::getVkCount($_SERVER['HTTP_HOST']);?></span></a></li>
          </ul>
                    </div>
                </div>
            </div>
        </div>
        <span class="menu">Меню</span>
        <div class="widget-m1">
            <div><a href="/">Main</a></div><div><a href="/events/">События</a></div><div><a href="/place/">Заведение</a></div><div><a href="/gallery/">Галерея</a></div><div><a href="/video/">Видео</a></div><div><a href="/music/">Музыка</a></div>    </div>
        <div class="widget-title">
            <h2>Профиль</h2>
        </div>
    </div>
    <div class="widget-content widget-content-no-footer">
        <div class="widget-content-wrap">
            <div class="user-profile">
                <div class="user-avatar">
                    <img src="<?=$this->view->profile['url'];?>" width="220" height="220" alt="" />
                </div>

                <h2><?=$this->view->profile['displayname'];?></h2>
                <div class="user-description"><?=$this->view->profile['preview_text'];?></div>
        <?        
		if(is_array($this->view->profile['socilalist']))
		foreach($this->view->profile['socilalist'] as $social){
		if($social['active']){
		$prottype='http://';
		if(strstr($social['url'],'https://')){
		$prottype='https://';
		$social['url']=str_replace('https://', '', $social['url']);
		}
		elseif(strstr($social['url'],'http://')){
		$social['url']=str_replace('http://', '', $social['url']);
		$prottype='http://';
		}
		?>
        <a href="<?=$prottype;?><?=$social['url'];?>" target="_blank" class="social-link" style="background-image:url('<?=$social['img'];?>');"><?=$social['url'];?></a>
      	<?}}	
		?>    
				<div class="button-set">
                    <? if($this->view->profile['id']==$_SESSION['User']['id'] && $_SESSION['User']['id']>0){ ?>
					<div class="button"><div class="r"><div class="l"><button type="submit">Редактировать</button></div></div></div>
					<? } ?>
                </div>
		    </div>
        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>