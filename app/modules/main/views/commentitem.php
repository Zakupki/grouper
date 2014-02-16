		<div class="<?=($this->view->curlev==5 && $this->view->comlevelnum>5)?'collapsed ':'';?><?=($this->view->last)?>ti">
          <div class="branch"></div>
          <div class="<?=($this->view->children)?'has-reply  ':'';?><?=($this->view->commentitem['pro'])?'pro ':'';?>content">
            <div class="userpic"><a href="#"><img src="/img/reactor/content/comments-tree_userpic.gif" alt="" width="40" height="40" /></a></div>
            <div class="author">
              <div class="user"><a href="/user/<?=$this->view->commentitem['login'];?>/"><?=$this->view->commentitem['login'];?><i class="i"></i><i class="i-pro"></i></a></div>
              <div class="date"><?=tools::getDate($this->view->commentitem['date_create']);?> <?=tools::getTime($this->view->commentitem['date_create']);?></div>
              <?
			  if(tools::int($_SESSION['User']['id'])==$this->view->innernews['userid']){?>
			  <div class="remove"><a href="/comments/remove/?remove=<?=$this->view->commentitem['id'];?>"><i class="i"></i></a></div>
              <?}
			  if(tools::int($_SESSION['User']['id'])==$this->view->innernews['userid'] && $this->view->commentitem['pro']){?>
			  <div class="love"><a href="#"><i class="i"></i></a></div>
			  <?}?>
            </div>
            <div class="text">
              <p><?=$this->view->commentitem['preview_text'];?></span></p>
            </div>
            <div class="reply"><a href="/news/?reply=<?=$this->view->commentitem['id'];?>">ответить<i class="i"></i></a></div>
		  </div>
		  <?
		  if ($this->view->curlev==5 && $this->view->comlevelnum>5){?>
		  <div class="expand">
              <i class="i"></i>
              <i class="i-root"></i>
          </div>
		  <?
		  }
		  if($this->view->children && $this->view->comlevelnum>$this->view->curlev)
		  echo $this->view->commentreeitems;
		  ?>
        </div>