<h2><?=$this->view->pagetitle;?><sup><?=count($this->view->radioshowtype);?></sup></h2>
<div class="b-container">
    <ul class="b-slider">
        <? foreach($this->view->radioshowtype as $tadioshowtype){?>
            <li class="radioshows-item">
                <a class="inner-link" href="/radioshow/<?=$tadioshowtype['id'];?>/"><img src="<?=$tadioshowtype['url'];?>" alt="" /></a>
                <div class="details">
                    <a class="inner-link" href="/radioshow/<?=$tadioshowtype['id'];?>/"><h5><?=$tadioshowtype['name'];?> <sup class="new"><?=$tadioshowtype['cnt'];?></sup></h5></a>
                    <p>
                    	<?
						if($tadioshowtype['link']){
						?>
						<a class="station" target="_blank" href="<?=$tadioshowtype['link'];?>"><?=$tadioshowtype['station'];?></a>
						<?	
						}
						else
                    	echo $tadioshowtype['station'];
						?>
					</p>
                    <p><?=$tadioshowtype['time'];?></p>
                </div>
            </li>
        <?}?>
    </ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    (contentBlock.height() > 260) || (contentBlock.height() == 0) ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
    
    $('.radioshows-item .inner-link').click(function(event) {
        event.preventDefault();
        $.history.load($(this).attr('href'));
    });
});
</script>