<!-- submenu (begin) -->
<ul class="g-submenu">
    <?if($this->registry->action=='menu'){?>
        <li class="current"><div><?=$this->registry->trans['menu'];?></div></li>
    <?}else{?>
        <li><a href="/reccount/menu/"><?=$this->registry->trans['menu'];?></a></li>
    <?}?>
    <?if($this->registry->action=='links'){?>
        <li class="current"><div><?=$this->registry->trans['links'];?></div></li>
    <?}else{?>
        <li><a href="/reccount/links/"><?=$this->registry->trans['links'];?></a></li>
    <?}?>
     <?if($this->registry->action=='url'){?>
        <li class="current"><div><?=$this->registry->trans['domain'];?></div></li>
    <?}else{?>
        <li><a href="/reccount/url/"><?=$this->registry->trans['domain'];?></a></li>
    <?}?>
    <?if($this->registry->action=='title'){?>
        <li class="current"><div><?=$this->registry->trans['project'];?></div></li>
    <?}else{?>
        <li><a href="/reccount/title/"><?=$this->registry->trans['project'];?></a></li>
    <?}?>
    <?if($this->registry->action=='tracklist'){?>
        <li class="current"><div><?=$this->registry->trans['playlist'];?></div></li>
    <?}else{?>
        <li><a href="/reccount/tracklist/"><?=$this->registry->trans['playlist'];?></a></li>
    <?}?>
    <li class="reccount-switcher last"><a href="#"><?=$this->registry->trans['onoff'];?></a></li>
</ul>
<!-- submenu (end) -->