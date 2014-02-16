<div class="user-wrap">

  <div class="h1">
    <h1><?=$this->registry->trans['user_profile'];?>: <?=$this->view->profile['displayname'];?><?=($this->view->profile['pro'])?'<i class="i-pro"></i>':'';?></h1>
    <!--<div class="ref"><a href="#" target="_blank">www.projectname.ua<i class="i"></i></a></div>-->
  </div>

  <div class="profile">

    <? if ($this->view->profile['url']) { ?>
      <div class="image"><img src="<?=$this->view->profile['url'];?>" alt="" /></div>
    <? } else { ?>
      <div class="image-na image"></div>
    <? } ?>

    <div class="content">

      <? if ($this->view->profile['preview_text']) { ?>
        <div class="text">
          <?=$this->view->profile['preview_text'];?>
        </div>
        <div class="hr"></div>
      <? } ?>
  
      <ul class="refs">
      	<? 
		if($this->view->profile['website']){
		$this->view->profile['website']=str_replace('https://', '', $this->view->profile['website']);
		$this->view->profile['website']=str_replace('http://', '', $this->view->profile['website']);
		$prottype='http://';
		?>
		<li><a href="<?=$prottype;?><?=$this->view->profile['website'];?>" target="_blank"><?=$this->view->profile['website'];?><i class="i" style="background-image: url(/img/reactor/link.png);"></i></a></li>
      	<?
		}
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
        <li><a href="<?=$prottype;?><?=$social['url'];?>" target="_blank"><?=$social['url'];?><i class="i" style="background-image: url(<?=$social['img'];?>);"></i></a></li>
      	<?}}?>
	  </ul>
  
    </div>

  </div>

  <!--<?=$this->view->banner;?>-->

</div>