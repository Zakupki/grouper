<!-- content (begin) -->
<div class="g-content">
    <div class="b-menu-customization">
        <?
        $classArr = array(1=>'first', 2=>'second', 3=>'third');
        $lcnt=1;
        foreach($this->view->langlist as $lang){
            ?><i class="<?=$classArr[$lcnt];?>-lang-title"><?=$lang['name'];?></i><?
            $lcnt++;
        }
        ?><i class="url">URL</i><i class="template-title"><?=$this->registry->trans['template'];?> <!--img src="/img/artist/admin/icon-question-mark.png" width="15" height="15" alt="Help" /--></i>

        <ul class="b-menu-items">
            <li class="hidden">
                <div class="draggable-area"></div><a class="delete-item" href="#"><?=$this->registry->trans['delete'];?></a><!--a class="duplicate-item" href="#">Дублировать шаблон</a--><label class="hidden-item"><input type="checkbox" /> <?=$this->registry->trans['hide'];?></label><input class="text-input lang-first" type="text" /><!--input class="text-input lang-second" type="text" /><input class="text-input lang-third" type="text" /--><input class="text-input url" type="text" /><span class="template"><b></b><!--span>?</span--></span>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save-items"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    var customizedMenuItemsList = '<?=$this->view->menulist;?>';
</script>