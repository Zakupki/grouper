<div class="widget-last widget-admin widget">
    <div class="widget-header">
        <a class="home" href="/"></a>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1">
            <?=$this->view->mainmenu;?>
        </div>
        <div class="widget-title">
            <h2>Заявки</h2>
        </div>
    </div>
    <div class="widget-content-no-footer widget-content">
        <div class="widget-content-wrap">
            <div class="requests-admin">
                <table>
                    <tr>
                        <th>Бренд</th>
                        <th>Тип</th>
                        <th>Дата реализации</th>
                        <!--<th>Охват</th>-->
                        <th>Сделка (план)</th>
                        <th>Сделка (факт)</th>
						<th>Отчеты</th>
                        <th></th>
                    </tr>
                    <? foreach($this->view->requests as $request){?>
                        <tr class="item<?=($request['new']==1)?' unread':'';?>" data-type="<?=$request['requesttype'];?>" data-id="<?=$request['requestid'];?>">
                            <td class="c brand"><?=$request['brandname'];?></td>
                            <td class="c type">
                                <a class="request-type" href="/admin/getrequestinfo/?requestid=<?=$request['requestid'];?>&requesttype=<?=$request['requesttype'];?>"><?=$request['requesttypename'];?></a>
                            </td>
                            <td class="c date"><?=tools::getDate($request['date_start']);?></td>
                            <!--<td>2356</td>-->
                            <? if($request['requesttype']==2){?>
							<td></td>
                            <td></td>
							<?}else{?>
							<td>0</td>
                            <td>0</td>
							<?}?>
                            <td class="c report">
                                <? 
								if($request['status']==3 && $request['passed'] && $request['requesttype']!=2 && $request['requesttype']!=1){
									if($request['hasreport']){
									?>
									<a class="report" href="/admin/makereport/?requestid=<?=$request['requestid'];?>&requesttype=<?=$request['requesttype'];?>">редактировать отчёт</a>
									<?}else{?>
									<a class="report" href="/admin/makereport/?requestid=<?=$request['requestid'];?>&requesttype=<?=$request['requesttype'];?>">создать отчёт</a>
									<?}?>
								<?}elseif($request['requesttype']==2){?>
									<a class="report" href="/admin/makereport/?requestid=<?=$request['requestid'];?>&requesttype=<?=$request['requesttype'];?>">
                                    <? if($request['hasreport']){?>
                                        редактировать предложение
                                    <?}else{?>
                                        отправить предложение
                                    <?}?>
                                    </a>
								<?}?>
                            </td>
							<td class="c confirm">
								<?
								if($request['requesttype']!=2){
									switch ($request['status']) {
									    case 3:
									         ?>
											принято
											<?
									        break;
									    case 4:
									        ?>
											отклонено
											<?
									        break;
										default:
									        if(!$request['passed']){
											?>
											<a class="confirm" href="#">принять</a>&nbsp;/&nbsp;<a class="decline" href="#">отклонить</a>
											<?
											}
									        break;
									}
								}
								?>
                            </td>
                        </tr>
                    <?}?>
                </table>
            </div>

        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>
