<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->newslist['news']);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <? foreach($this->view->newslist['news'] as $news){?><li class="news-item">
            <a href="http://<?=MAIN_HOST;?>/new/<?=$news['itemid'];?>/" target="_blank">
            	<h3>
            		 <?
		             if(strlen($news['name'])>50){
		             $news['name']=mb_substr(strip_tags($news['name']), 0, 47, 'UTF-8')."...";}
		             echo $news['name'];
		             ?>
				</h3>
			</a>
            <p>
                <?
				$news['preview_text']=strip_tags($news['preview_text']);
                if(strlen($news['preview_text'])>250){
                $news['preview_text']=mb_substr($news['preview_text'], 0, 247, 'UTF-8')."...";}
                echo $news['preview_text'];
                ?>
            </p>
            <span class="comments"><?=$this->view->newslist['comments'][$news['itemid']]['comnum'];?></span><span class="likes"><?=tools::int($this->view->newslist['rate'][$news['itemid']]);?></span><span class="date"><?=tools::GetDate($news['date_start']);?></span>
        </li><?}?>
</ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
});
</script>