<h1><?=$this->registry->trans['releases'];?></h1>
<div class="post-wrap">
  <div class="post" rel="<?=$this->view->releasetype['itemid'];?>">
    <div class="release">
      <div class="image">
        <img src="<?=$this->view->releasetype['url'];?>" alt="userpic1big" width="220" height="220" />
        <?if($this->view->releasetype['fresh']){?>
          <i class="i-new"></i>
        <?}?>
      </div>
      <table class="descr">
      <tr>
        <td class="title">
          <h2><strong><?=$this->view->releasetype['author'];?>&nbsp;<span>&ndash;</span>&nbsp;</strong><em><?=$this->view->releasetype['name'];?></em></h2>
          <div class="author">
          	<?
			if($this->view->releasetype['domain'])
			$this->view->releasetype['siteurl']='http://'.$this->view->releasetype['domain'];
			else
			$this->view->releasetype['siteurl']='http://r'.$this->view->releasetype['siteid'].'.'.str_replace('www.','',$_SERVER['HTTP_HOST']).'/';
			?>
            <div class="user"><a href="<?=$this->view->releasetype['siteurl'];?>"><?=$this->view->releasetype['sitename'];?><i class="i-dj"></i></a></div>
            <div class="date"><?=tools::GetDate($this->view->releasetype['date_start'],$this->registry->langid);?></div>
          </div>
          <div class="label"><?=$this->view->releasetype['label'];?></div>
        </td>
      </tr>
      <tr>
        <td class="links">
          <ul>
          <?
            if(is_array($this->view->releaselinks))
              foreach($this->view->releaselinks as $link) { ?>
            <li>
              <a href="<?=$link['url'];?>" target="_blank">
                <?
                  if(strlen($link['url'])>58)
                    $link['url']=substr($link['url'], 0, 55)."...";
                ?>
                <?=$link['url'];?>
                <? if($link['fileurl']){?>
                  <i class="i" style="background-image: url(<?=$link['fileurl'];?>);"></i>
                <? } else { ?>
                  <i class="i-link i"></i>
                <? } ?>
              </a>
            </li>
            <? } if($this->view->releasetype['domain']) { ?>
              <li><a href="http://<?=$this->view->releasetype['domain'];?>/" target="_blank">http://<?=$this->view->releasetype['domain'];?><i class="i-reccount i"></i></a></li>
            <? } else { ?>
              <li><a href="http://r<?=$this->view->releasetype['siteid'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?>/" target="_blank">http://r<?=$this->view->releasetype['siteid'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?><i class="i-reccount i"></i></a></li>
            <? } ?>
          </ul>
        </td>
      </tr>
      </table>
    </div>

    <div class="post-content">
    <? if(strlen($this->view->releasetype['pressrelease'])>0){?>
      <div class="title">
        <h2><?=$this->view->releasetype['pressrelease'];?></h2>
      </div>
    <?}?>        

      <div class="text">
        <? if(strlen($this->view->releasetype['preview_text'])>0){?>
    <p><?=stripslashes($this->view->releasetype['preview_text']);?></p>
        <?}?>
    <? if($this->view->releasetype['incut']>0){?>
      <?
      if(is_array($this->view->incuts)){
        $qcnt=1;
        foreach($this->view->incuts as $quoted){
          if($quoted['quote']>0 && $quoted['deleted']){
          	$proSTR=null;
			if($quoted['pro'])
			$proSTR='<i class="i"></i><i class="i-pro"></i>';
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
               <div class="quotes-user quotes-user-pro"><a href="/users/'.$quoted['login'].'/">'.$quoted['displayname'].''.$proSTR.'</a></div>
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
        <? if(strlen($this->view->releasetype['detail_text'])>0){?>
    <p><?=$this->view->releasetype['detail_text'];?></p>
    <?} }?>
    </div>
    </div>

<? if (count($this->view->releasetracks) > 0) { ?>

    <div class="post-extra">
      <div class="r">
        <div class="l">
          <div class="content">

            <ul class="media">
              
        <?
        $cnt=1;
        foreach($this->view->releasetracks as $track){
        if($cnt==count($this->view->releasetracks))
        $lasttrack=' class="last"';
        ?>
              <li<?=$lasttrack;?>>
                  <span class="image"><img src="<?=$this->view->releasetype['url2'];?>" alt="news-open_media" width="40" height="40" /><i class="i-play"></i></span>
                  <span class="title">
                    <span class="artist"><?=$track['author'];?><em>&nbsp;&ndash;&nbsp;</em></span>
                    <span class="name"><?=$track['name'];?> 
          <?if($track['remix']){?>
          (<?=$track['remix'];?>)
          <?}?>
          </span>
                    <?
          if($track['promocut']){?>
          <i class="i-promocut"></i>
          <?}?>
                  </span>
                  <span class="info">
                    <?if($track['musictypes']){?>
          <span class="style"><?=implode(',',$track['musictypes']);?></span>
          <?}?>
                    <span class="date"><?=tools::GetDate($this->view->releasetype['date_start'],$this->registry->langid);?></span>
                    <span class="label"><?=$this->view->releasetype['label'];?></span>
                  </span>

              </li>
        <?
        $lasttrack='';
        $cnt++;
        }
		?>
      
      </ul>
<script type="text/javascript">
var playlist = [
        <? $cnt = 1; foreach($this->view->releasetracks as $track) {
        	if(!$track['mp3'] && $track['stream']){
			$track['mp3']=$track['stream'].tools::getStreamParam($track['socialid']);
			}
			?>
        {
            artist: '<?=tools::tojs($track['author']);?>',
            name: '<?=tools::tojs($track['name']);?><? if ($track['remix']) { ?> (<?=tools::tojs($track['remix']);?>)<? } ?>',
            url: '<?=$track['mp3'];?>',
            download: <?=$track['download'];?>
        }<? echo $cnt < count($this->view->releasetracks) ? ',' : ''; $cnt++;} ?>
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
  <input name="comments_url" value="/comments/showrelease/?id=<?=$this->view->releasetype['itemid'];?>" type="hidden" />
  <div class="loading"><i class="i"></i></div>
</div>