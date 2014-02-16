<h1>Новости</h1>

<div class="post-wrap">


  <div class="post">
    <div class="photos">
      <? if (count($this->view->images) > 0) { ?>
        <div class="jswap image">
        <?
          $cnt=1;
          foreach ($this->view->images as $pic) {
        ?>
            <div class="jswap-li<?=($cnt==1)?'-act jswap-li':'';?>"><img src="<?=$pic;?>" alt="" width="580" height="220" /></div>
        <?
            $cnt++;
          }
        ?>
        </div>
      <? } 
	  if($this->view->innernews['video']){
	  	$youid=tools::youtube_id_from_url($this->view->innernews['video']);
		$url = $this->view->innernews['video'];
		$youObj=json_decode(file_get_contents(sprintf('http://www.youtube.com/oembed?url=%s&format=json', urlencode($url))));
	  ?>
      <div class="link"><a href="http://youtu.be/<?=$youid;?>" target="_blank" rel="popup:#video1">Видео<i class="i-video"></i></a></div>
      <div class="popup-src" id="video1">
        <object width="<?=$youObj->width;?>" height="<?=$youObj->height;?>"><param name="movie" value="http://www.youtube.com/v/<?=$youid;?>?version=3&amp;hl=ru_RU&amp;rel=0&amp;hd=1&amp;autoplay=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?=$youid;?>?version=3&amp;hl=ru_RU&amp;rel=0&amp;hd=1&amp;autoplay=1" type="application/x-shockwave-flash" width="<?=$youObj->width;?>" height="<?=$youObj->height;?>" allowscriptaccess="always" allowfullscreen="true"></embed></object>
      </div>
	  <?}?>
      <? if (count($this->view->images) > 0) { ?>
        <div class="jswap-pager"></div>
      <? } ?>
    </div>
  

    <div class="post-content">
			<?
			if($this->view->innernews['domain'])
			$this->view->innernews['siteurl']='http://'.$this->view->innernews['domain'];
			else
			$this->view->innernews['siteurl']='http://r'.$this->view->innernews['siteid'].'.'.str_replace('www.','',$_SERVER['HTTP_HOST']).'/';
			?>
      <div class="author">
        <div class="user"><a href="<?=$this->view->innernews['siteurl'];?>"><?=$this->view->innernews['sitename'];?><i class="i-dj"></i></a></div>
        <div class="date"><?=tools::GetDate($this->view->innernews['date_start']);?></div>
      </div>

      <div class="title">
       <h2><?=$this->view->innernews['name'];?></h2>
    </div>        

      <div class="text">
        <? if(strlen($this->view->innernews['preview_text'])>0){?>
    <p><?=$this->view->innernews['preview_text'];?></p>
        <?}?>
    <? if($this->view->innernews['incut']>0){?>
    
      <?
      if(is_array($this->view->incuts)){
        $qcnt=1;
        foreach($this->view->incuts as $quoted){
          if($quoted['quote']>0 && $quoted['deleted']){
            if($qcnt==1)
            $firstquote=" style='display:block'";
            else
            $firstquote='';
            if($quoted['file_name'])
              $userpic='<div class="quotes-userpic"><a href="/users/'.$quoted['login'].'/"><img src="/uploads/users/2_'.$quoted['file_name'].'" alt="" /></a></div>';
            else
              $userpic='<div class="quotes-userpic-na quotes-userpic"><a href="/users/'.$quoted['login'].'/"></a></div>';
            
            $quotedStr.='
            <div class="quotes-ci"'.$firstquote.'>
               '.$userpic.'
               <div class="quotes-text"><a href="#comment'.$quoted['id'].'">'.$quoted['preview_text'].'</a></div>
               <div class="quotes-user quotes-user-pro"><a href="/users/'.$quoted['login'].'/">'.$quoted['displayname'].'<i class="i"></i><i class="i-pro"></i></a></div>
            </div>';
          $qcnt++;
          }
           }
      }
    if($quotedStr){?>
    <div class="quotes">
      <div class="quotes2">
      <?=$quotedStr;?>
      </div>
    </div>
    <?}?>
        <? if(strlen($this->view->innernews['detail_text'])>0){?>
    <p><?=$this->view->innernews['detail_text'];?></p>
    <?} }?>
    </div>

    </div>


<? if (count($this->view->tags) > 0 || count($this->view->tracks) > 0) { ?>

    <div class="post-extra">
      <div class="r">
        <div class="l">
          <div class="content">
      <?
      if(count($this->view->tags)>0){?>
            <ul class="tags">
              <?
        $cnt=1;
        foreach($this->view->tags as $tag){?>
        <li<?=($cnt==count($this->view->tags))?' class="last"':'';?>><a href="/news/?tag=<?=$tag['id'];?>"><span><?=$tag['name'];?></span> (<?=$tag['cnt'];?>)</a></li>
        <?
        $cnt++;
        }?>
      </ul>
      <? if(count($this->view->tracks)>0){
	  ?>
	  <div class="hr"></div>
      <?}
	  }?>
      <ul class="media">
              
        <?
        $cnt=1;
        foreach($this->view->tracks as $track){
	        if($cnt==count($this->view->tracks))
	        $lasttrack=' class="last"';
        ?>
              <li<?=$lasttrack;?>>
                  <span class="image"><img src="<?=$track['cover'];?>" alt="news-open_media" width="40" height="40" /><i class="i-play"></i></span>
                  <span class="title">
	                  <span class="artist"><?=$track['author'];?><em>&nbsp;&ndash;&nbsp;</em></span>
	                  <span class="name"><?=$track['name'];?> 
				          <? if($track['remix']){?>
				          (<?=$track['remix'];?>)
				          <?}?>
	          		  </span>
	                  <?
				          if($track['promocut']){?>
				          <i class="i-promocut"></i>
				          <?}?>
                  </span>
                  <span class="info">
	                    <? if($track['musictypes']){?>
				        <span class="style"><?=implode(',',$track['musictypes']);?></span>
				        <?}?>
                    <span class="date"><?=tools::GetDate($track['date_start']);?></span>
                    <span class="label"><?=$track['label'];?></span>
                  </span>
              </li>
        <?
        $lasttrack='';
        $cnt++;
        }?>
      
      </ul>

<script type="text/javascript">
var playlist = [
        <? $cnt = 1; foreach($this->view->tracks as $track) { ?>
        {
            artist: '<?=addslashes($track['author']);?>',
            name: '<?=addslashes($track['name']);?><? if ($track['remix']) { ?> (<?=addslashes($track['remix']);?>)<? } ?>',
            url: '<?=$track['mp3'];?>',
            download: <?=$track['download'];?>
        }<? echo $cnt < count($this->view->tracks) ? ',' : ''; $cnt++;} ?>
    ];
</script>

          </div>
        </div>
      </div>  
      <div class="rt"><div class="lt"></div></div>
      <div class="rb"><div class="lb"></div></div>
    </div>

<? } ?>

  </div>

  <?=$this->view->popularnews;?>

</div>


<div class="comments">
  <input name="comments_url" value="/comments/shownews/?id=<?=$this->view->innernews['itemid'];?>" type="hidden" />
  <div class="loading"><i class="i"></i></div>
</div>