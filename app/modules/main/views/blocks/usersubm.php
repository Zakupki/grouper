<div class="m2">
  <ul>
    <li<?=($this->registry->action=='profile')?' class="act"':'';?>><span class="a"><a href="/cabinet/profile/"><span class="title"><?=$this->registry->trans['profile'];?></span></a></span></li>
    <li<?=($this->registry->action=='editprofile')?' class="act"':'';?>><span class="a"><a href="/cabinet/editprofile/"><span class="title"><?=$this->registry->trans['edit'];?> <?=strtolower($this->registry->trans['profile']);?></span></a></span></li>
    <li class="last<?=($this->registry->action=='registerinfo')?' act':'';?>"><span class="a"><a href="/cabinet/registerinfo/"><span class="title"><?=$this->registry->trans['personal_data'];?></span></a></span></li>
  </ul>
</div>