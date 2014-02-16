<? if(is_array($this->view->newsline)){?>
<div class="news-feed">
        <div class="h"><div><a href="/news/">Новости</a></div></div>
        <ul>
          <? 
		  $cnt=1;
		  foreach($this->view->newsline as $news){?>
		  <li <?=($cnt==1)?'style="display: block;"':'';?>><a href="/new/<?=$news['itemid'];?>/"><?=$news['name'];?></a></li>
          <?
		  $cnt++;
		  }?>
		</ul>
</div>
<?}?>