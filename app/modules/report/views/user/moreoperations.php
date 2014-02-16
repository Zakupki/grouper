                <?
                $total=0;
                foreach($this->view->operations['operations'] as $operation){
                $total++;    
                if($operation['value']>0)
                $class='in';
                elseif($operation['value']<1)
                $class='out';
                ?>
                <div class="item <?=$class;?> clearfix<?=(!$this->view->operations['hasmore'])?' last':'';?>">
                    <div class="c type"></div>
                    <div class="c date"><?=tools::GetDate($operation['date_create'],$this->registry->langid);?> / <?=tools::GetTime($operation['date_create']);?></div>
                    <div class="c description"><?=$operation['name'];?> 
                    <?
                    if($operation['publicid']){?>
                    <a class="info" href="/user/getrequestinfo/?requestid=<?=$operation['publicgroupid'];?>&requesttype=3">P<?=$operation['publicid'];?></a>    
                    <?}?>
                    <?
                    if($operation['groupid']){?>
                     в <a target="_blank" href="<?=$operation['groupurl'];?>">G<?=$operation['groupid'];?></a>    
                    <?}?>    
                    </div>
                    <div class="c amount"><?=$operation['value'];?></div>
                    <div class="c balance"><?=$operation['balance'];?></div>
                </div>
                <?}?>