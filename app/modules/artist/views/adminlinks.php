<!-- content (begin) -->
<div class="g-content">
    <div class="b-links">
        <i><?=$this->registry->trans['view'];?>:</i>
        <ul class="b-options">
            <li><label><input class="show-news" type="radio" name="extra-item"> <?=$this->registry->trans['display_news'];?></label></li>
            <li><label><input class="show-nothing" type="radio" name="extra-item" checked> <?=$this->registry->trans['display_none'];?></label></li>
            <li><label><input class="show-tweet" type="radio" name="extra-item"> <?=$this->registry->trans['display_tweet'];?></label></li>
        </ul>
        <div class="b-social-services">
            <ul></ul>
        </div>
        <i><?=$this->registry->trans['acc_links'];?>:</i>
        <ul class="b-accounts">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox" /> <?=$this->registry->trans['hide'];?></label>
                    <span class="delete"><?=$this->registry->trans['delete'];?></span>
                    <div class="draggable-area"></div>
                </div>
                <div class="input"><input class="url" type="text" value="" /></div>
            </li>
        </ul>
        <div class="b-button-set">
            <button class="save-items"><?=$this->registry->trans['save'];?></button>
            <button class="add-item"><?=$this->registry->trans['add'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    var socialServices = $.parseJSON('<?=$this->view->sociallist;?>');
</script>
