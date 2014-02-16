<h2><?=$this->view->pagetitle;?></h2>
<div class="b-container">
    <ul class="b-slider">
		<?
		$sep=' ';
		$counttext=70;
		$this->view->about=str_replace('&nbsp;',' ',$this->view->about);
		$this->view->about=strip_tags($this->view->about);
		$words = explode($sep, $this->view->about);
		//tools::print_r($words);
		//echo count($words);
		$blocknum=ceil(count($words)/$counttext);
		for($i = 0; $i < $blocknum; $i++){
			?>
			<li class="contacts-item">
            	<?=join($sep, array_slice($words, $i*$counttext, $counttext));?>
        	</li>
			<?
		}
		?>
	</ul>
</div>
<div class="b-pager"></div>

<script type="text/javascript">
$().ready(function() {
    var contentBlock =  $('.g-content');

    contentBlock.height() > 260 || contentBlock.height() == 0 ? contentBlock.delay(100).animate({height: 260}, 500) : 0;
});
</script>