<div class="widget-last widget-admin widget">
    <div class="widget-header">
        <a class="home" href="/"></a>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1">
            <?=$this->view->mainmenu;?>
        </div>
        <div class="widget-title">
            <h2>ReCard</h2>
        </div>
    </div>
    <div class="widget-content-no-footer widget-content">
        <div class="widget-content-wrap">

            <div class="recard-admin">
                <!--<div class="button create-card"><div class="r"><div class="l"><button type="submit">Создать карту</button></div></div></div>-->

                <table class="recard-list">
                    <tr>
                        <th width="240">Название<span class="help"></span></th>
                        <th>Всего<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>Погашено<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>% Погашенных<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>Активных<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>Просрочено<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>Пользователей<a class="icon-help help-link" href="/help/?id=0"></a></th>
                        <th>Цена за единицу<a class="icon-help help-link" href="/help/?id=0"></a></th>
                    </tr>
                    <?
					$cnt=0;
					foreach($this->view->cards as $card){
					?>
                    <tr<?=($cnt)?'':' style="border-top:none;"';?> rel="<?=$card['id'];?>" class="item<?=($card['new']==1)?' unread':'';?>">
                        <td><a class="download-card" href="#"></a><a class="edit-recard" href="/admin/getrecard/?id=<?=$card['id'];?>"><?=$card['name'];?></a></td>
                        <td><?=($card['TotalCoupon'])?$card['TotalCoupon']:0;?></td>
                        <td><?=($card['CouponsRedempt'])?$card['CouponsRedempt']:0;?></td>
                        <td><?=($card['RedemptionRatio'])?$card['RedemptionRatio']:'0%';?></td>
                        <td><?=($card['ActiveCoupons'])?$card['ActiveCoupons']:0;?></td>
                        <td><?=($card['CouponsExpired'])?$card['CouponsExpired']:0;?></td>
                        <td><?=($card['ParticipantsCount'])?$card['ParticipantsCount']:0;?></td>
                        <td><?=($card['price'])?$card['price']:0;?></td>
                    </tr>
					<?
					$cnt++;
					}?>
                </table>


                
            </div>

        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>

