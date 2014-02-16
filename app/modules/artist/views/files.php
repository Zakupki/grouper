<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->files);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="downloads-item">
            <?
            $cnt=1;
            $tcnt=1;
            foreach($this->view->files as $file){?>
            <a href="<?=$file['url'];?>" target="_blank" style="background-image:url(/img/artist/admin/icon-filetype-<?=$file['extension'];?>.png);"><?=$file['name'];?></a>
        	<?
            if($cnt==3 && $tcnt<count($this->view->files)){
            $cnt=0;
            ?>
        </li><li class="downloads-item">
            <?
            }
            $cnt++;
            $tcnt++;
            }
            ?>
        </li>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$(function(){
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
});
</script>