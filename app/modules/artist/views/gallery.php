<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->gallerytype);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="gallery-item">
           <?
           $cnt=1;
           $tcnt=1;
           foreach($this->view->gallerytype as $type){?><a href="/gallery/<?=$type['id'];?>/">
                <div class="image"><img width="220" height="100" src="<?=$type['preview'];?>" alt="<?=$type['name'];?>" /></div>
                <?=$type['name'];?> <span>(<?=$type['cnt'];?>)</span>
            </a><?
            if($cnt==2 && $tcnt<count($this->view->gallerytype)){
            $cnt=0;
            ?>
        	</li><li class="gallery-item">
            <?
            }
            $tcnt++;
            $cnt++;
            }?>
        </li>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');
    
    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;

    $('.gallery-item a').click(function(event) {
        event.preventDefault();
        $.history.load($(this).attr('href'));
    });
});
</script>