<!-- submenu (begin) -->
<ul class="g-submenu">
    <?if($this->registry->action=='background'){?>
        <li class="current"><div><?=$this->registry->trans['bg'];?></div></li>
    <?}elseif($this->registry->action=='backgroundinner'){?>
        <li class="current"><div><a href="/design/background/"><?=$this->registry->trans['bg'];?></a></div></li>
    <?}else{?>
        <li><a href="/design/background/"><?=$this->registry->trans['bg'];?></a></li>
    <?}?>
    <?if($this->registry->action=='logo'){?>
        <li class="current"><div><?=$this->registry->trans['logo'];?></div></li>
    <?}else{?>
        <li><a href="/design/logo/"><?=$this->registry->trans['logo'];?></a></li>
    <?}?>
    <?if($this->registry->action=='color'){?>
        <li class="current"><div><?=$this->registry->trans['color'];?></div></li>
    <?}else{?>
        <li><a href="/design/color/"><?=$this->registry->trans['color'];?></a></li>
    <?}?>
    <?if($this->registry->action=='preview'){?>
        <li class="current"><div><?=$this->registry->trans['pv_preview'];?></div></li>
    <?}else{?>
        <li><a href="/design/preview/"><?=$this->registry->trans['pv_preview'];?></a></li>
    <?}?>
    <?if($this->registry->action=='cover'){?>
        <li class="current"><div><?=$this->registry->trans['covers'];?></div></li>
    <?}else{?>
        <li><a href="/design/cover/"><?=$this->registry->trans['covers'];?></a></li>
    <?}?>
    <?if($this->registry->action=='favicon'){?>
        <li class="current last"><div><?=$this->registry->trans['favicon'];?></div></li>
    <?}else{?>
        <li class="last"><a href="/design/favicon/"><?=$this->registry->trans['favicon'];?></a></li>
    <?}?>
</ul>
<!-- submenu (end) -->