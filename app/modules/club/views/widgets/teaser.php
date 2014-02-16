<? if (count($this->view->teaserlist)>0 || $_SESSION['User']['id']==$_SESSION['Site']['userid']) { ?>
    <div class="teasers<?=(count($this->view->teaserlist) < 1)?' empty':'';?>">
        <div class="jflow">
            <div class="jflow-list">
            	<? foreach($this->view->teaserlist as $teaser) {
            		$prottype='http://';
                    if (strstr($teaser['link'],'https://')) {
                        $prottype='https://';
                        $teaser['link']=str_replace('https://', '', $teaser['link']);
                    } elseif(strstr($teaser['link'],'http://')){
                        $teaser['link']=str_replace('http://', '', $teaser['link']);
                        $prottype='http://';
                    } ?>
                    <div class="jflow-li<?=($teaser['brand'])?' brand':'';?>" <?=($teaser['brand'])?' data-token="123321"':'';?> rel="<?=$teaser['id'];?>"><a<?=($teaser['brand'])?' target="_blank"':'';?> href="<?=$prottype;?><?=$teaser['link'];?>"><img src="<?=$teaser['url'];?>" alt="<?=$teaser['url'];?>" /></a></div>
                <? } ?>
            </div>
            <div class="jflow-prev"></div>
            <div class="jflow-next"></div>
        </div>
        <div class="jflow-pager"></div>
        <? if (count($this->view->teaserlist) && !$this->registry->pastevents && $this->view->inevent) { ?>
            <div class="widget-m2">
                <div<?=($this->registry->routername=='eventpast')?' class="act"':'';?>><a href="/events/"><?=$this->registry->trans['coming'];?><?=($this->registry->routername=='eventpast' || $this->registry->oldevent)?'':'<i class="i-pointer"></i>';?></a></div>
                <div class="last<?=($this->registry->routername=='eventpast')?'':' act';?>"><a href="/events/past/"><?=$this->registry->trans['past'];?><?=($this->registry->routername=='eventpast' || $this->registry->oldevent)?'<i class="i-pointer"></i>':'';?></a></div>
            </div>
        <? }
        if (tools::int($_SESSION['User']['id'])==tools::int($_SESSION['Site']['userid']) && tools::int($_SESSION['User']['id'])>0) { ?>
            <div class="controls">
                <i class="i-add"><a href="/admin/teasers/" class="big-tooltip-inside tooltiptop"><div class="tooltip_description"><?=$this->registry->trans['addbanner'];?></div></a></i>
                <i class="i-edit"><a href="/admin/teasers/" class="big-tooltip-inside tooltiptop"><div class="tooltip_description"><?=$this->registry->trans['editbanner'];?></div></a></i>
            </div>
        <? } ?>
    </div>
<? } ?>