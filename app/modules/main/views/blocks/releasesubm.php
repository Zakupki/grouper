<div class="m2">
  <ul>
    <li<?=(!$this->registry->routername || $this->registry->routername=='index' || $this->registry->routername=='releasetype' || $this->registry->routername=='releasetype2')?' class="act"':'';?>><span class="a"><a href="/releases/"><?=$this->registry->trans['recommended'];?></a></span></li>
    <li class="last<?=($this->view->registry->routername=='releaseslatest' || $this->view->registry->routername=='releaseslatestinner' || $this->view->registry->routername=='releaseslatest2')?' act':'';?>">
      <span class="a">
        <a href="/releases/latest/">
          <span class="title"><?=$this->registry->trans['latest'];?></span>
          <? if($this->view->newitemnum>0){?>
		  <span class="new"><span class="r"><span class="l"><span class="text">+<?=$this->view->newitemnum;?></span></span></span></span>
		  <?}?>
        </a>
      </span>
    </li>
  </ul>
</div>