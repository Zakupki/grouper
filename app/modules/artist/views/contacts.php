<h2><?=$this->view->pagetitle;?></h2>
<div class="b-container">
    <ul class="b-slider">
        <li class="contacts-item">
            <?
            $cnt=1;
            $tcnt=1;
            foreach($this->view->contactlist as $contacts){?>
            <div class="contact-wrap">
                 <span class="name"><?=$contacts['name'];?></span>
                 <?if($contacts['phone']){?>
				 <span class="phone"><?=$contacts['phone'];?></span>
				 <?}?>
				 <a href="mailto:<?=$contacts['email'];?>"><?=$contacts['email'];?></a>
            </div>
			<?
            if($cnt==2 && $tcnt<count($this->view->contactlist)){
            $cnt=0;
            ?>
        </li><li class="contacts-item">
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