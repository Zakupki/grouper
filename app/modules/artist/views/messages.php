<!-- content (begin) -->
<div class="g-content">
    <div class="b-notifications">
        <table class="notifications">
            <tr>
              <th class="num">№</th>
              <th class="date"><?=$this->registry->trans['date'];?> / <?=strtolower($this->registry->trans['date']);?></th>
              <th class="message">
                <span class="title"><?=$this->registry->trans['message'];?></span>
                <span class="note">
                	<? if($this->Session->Site['languageid']==1){?>
                	Кликните по сообщению, чтобы пометить его как «Прочитанное»
                	<?}else{?>
                		Click on the message to make it read
                	<?}?>
                	<i class="i"></i>
                </span>
              </th>
            </tr>
			<?
			$cnt=count($this->view->messages);
			foreach ($this->view->messages as $message) {
			    if($message['new']==1) {
			?>
			<tr class="new">
			  <td class="num"><a href="/user/readmessage/?id=<?=$message['id'];?>"><?=$cnt;?></a></td>
			  <td class="date"><a href="/user/readmessage/?id=<?=$message['id'];?>">12.01.11 / 12:30</a></td>
			  <td class="message"><a href="/user/readmessage/?id=<?=$message['id'];?>"><?=$message['detail_text'];?></a></td>
			</tr>
			<? } else { ?>
			<tr>
			  <td class="num"><a href="/user/readmessage/?id=<?=$message['id'];?>"><?=$cnt;?></a></td>
			  <td class="date"><a href="/user/readmessage/?id=<?=$message['id'];?>">12.01.11 / 12:30</a></td>
			  <td class="message"><a href="/user/readmessage/?id=<?=$message['id'];?>"><?=$message['detail_text'];?></a></td>
			</tr>
			<?
			    }
			$cnt--;
			}
			?>
        </table>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    (function($){
    $.fn.notifications = function(){
        var $link = $('.g-header .notifications'),
            $counter = $link.find('.counter');

        return this.each(function() {
            $(this).find('tr').each(function(){
                var $tr = $(this);

                $tr.find('a').click(function(e){
                    e.preventDefault();
                    $.getJSON($tr.hasClass('new') ? this.href : this.href + '\u0026new=1', function(data){
                        if (data.success) {
                            if (data.counter > 0) {
                                $link.addClass('notifications-new').removeClass('link-notifications');
                                $counter.html('(' + data.counter + ')');
                            } else {
                                $link.addClass('notifications').removeClass('notifications-new');
                                $counter.html('');
                            }
                            $tr.toggleClass('new');
                        }
                    });
                });
            });
        });
    };
    })(jQuery);

    $('.g-content .notifications').notifications();
</script>