<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->giglist);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="gigs-item">
            <?
            $cnt=1;
            $tcnt=1;
            foreach($this->view->giglist as $gig){?>
             <div class="gigs-item-wrap">
                <span class="date"><?=$gig['date_start'];?></span><span class="place"><?=$gig['place'];?></span><span class="city"><?=$gig['city'];?></span>
            </div>
            <?
            if($cnt==3 && $tcnt<count($this->view->giglist)){
            $cnt=0;
            ?>
        </li><li class="gigs-item">
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