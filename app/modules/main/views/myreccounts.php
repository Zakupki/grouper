    <h1><?=$this->registry->trans['my_reccounts'];?></h1>
  <?
  if(count($this->view->sites)<1){?>
  <p><?=$this->registry->trans['noreccounts'];?></p>
  <?}?>

    <div class="teasers">
  
      <?
    function getDirectorySize($path)
{
  $totalsize = 0;
  $totalcount = 0;
  $dircount = 0;
  if ($handle = opendir ($path))
  {
    while (false !== ($file = readdir($handle)))
    {
      $nextpath = $path . '/' . $file;
      if ($file != '.' && $file != '..' && !is_link ($nextpath))
      {
        if (is_dir ($nextpath))
        {
          $dircount++;
          $result = getDirectorySize($nextpath);
          $totalsize += $result['size'];
          $totalcount += $result['count'];
          $dircount += $result['dircount'];
        }
        elseif (is_file ($nextpath))
        {
          $totalsize += filesize ($nextpath);
          $totalcount++;
        }
      }
    }
  }
  closedir ($handle);
  $total['size'] = $totalsize;
  $total['count'] = $totalcount;
  $total['dircount'] = $dircount;
  return $total;
}

function sizeFormat($size)
{
    if($size<1024)
    {
        return $size." КБ";
    //return 0;
    }
    else if($size<(1024*1024))
    {
        $size=round($size/1024,1);
        return $size." КБ";
    }
    else if($size<(1024*1024*1024))
    {
        $size=round($size/(1024*1024),1);
        return $size." МБ";
    }
    else
    {
        $size=round($size/(1024*1024*1024),1);
        return $size." ГБ";
    }

}  
    
    $cnt=1;
    //print_r($this->view->sites);
    foreach($this->view->sites as $site){
      if($site['id']<1)
    continue;
      
      #SITEKIND
      $scnt=1;
      $kcnt=1;
      //if(is_array($this->view->sitetypes[$kay]))
          $s_teaserHTML='';
      $ss_teaserHTML='';
      $siteKindHTML='';
      $siteKindHTML='<div class="row">';
      foreach($this->view->sitetypes[$site['parentsitetypeid']]['subcats'] as $skey=>$svalue){
      $display_s='';
      if($svalue['id']==$site['sitetypeid'])
      $display_s=' style="display: block;"';
      
      $s_teaserHTML.=<<<OUT
      <span class="title title-kind"{$display_s}>{$svalue['name']}</span>
OUT;
      $display_ss='';
      if($svalue['id']==$site['sitetypeid'])
      $display_ss=' style="display: block;"';
      
      $ss_teaserHTML.=<<<OUT
      <i class="i-{$svalue['code']} i-kind"{$display_ss}></i>
OUT;
      
      if($kcnt==3){
      $siteKindHTML.=<<<OUT
      </div>
      <div class="br"></div>
      <div class="row">
OUT;
      $kcnt=1;
      }
      
      $checkedkind='';
      if($svalue['id']==$site['sitetypeid'])
      $checkedkind=' checked="checked" ';
      $siteKindHTML.=<<<OUT
        <div class="input-radio">
          <input name="kind" id="kind{$site['id']}{$svalue['id']}" value="{$svalue['id']}" type="radio"{$checkedkind}/>
          <label for="kind{$site['id']}{$svalue['id']}"> {$svalue['name']}</label>
        </div>
OUT;
      $kcnt++;
      $scnt++;
          }
      $siteKindHTML.=<<<OUT
          </div>
OUT;
    if($cnt==1){
    $display=' style="display: block;"';
    $teaserAct='teaser-act ';
    }
    else
    {
    $display='';
    $teaserAct='';
    
    /*function format_bytes($bytes) {
       if ($bytes < 1024) return $bytes.' B';
       elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
       elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
       elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
       else return round($bytes / 1099511627776, 2).' TB';
    }*/
    
    }
    $filespace=getDirectorySize($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$site['id'].'/');
    ?>
    <div class="<?=$teaserAct;?>teaser" id="content-teaser<?=$site['id'];?>">
        <a href="/cabinet/myreccounts/#content<?=$site['id'];?>" id="content<?=$site['id'];?>">
          <span class="title" id="content-title<?=$site['id'];?>"><?=$site['title'];?></span>
          <span class="text">
            <span><?=$this->registry->trans['used'];?> <em><?=sizeFormat($filespace['size']);?></em> <?=$this->registry->trans['of'];?> <em><?=$this->view->sitedisc[$site['id']];?> <?=$this->registry->trans['gb'];?></em></span>
            <span><?=$this->registry->trans['till'];?> <?=$this->view->Tools->GetDate($site['date_end'],$this->registry->langid);?><?=($this->view->Tools->GetDate($site['date_end'])!='сегодня')?'':'';?></span>
          </span>
      <?=$ss_teaserHTML;?>
          <!--<i class="i-dj i-kind" style="display: block;"></i>
          <i class="i-musician i-kind"></i>
          <i class="i-vocalist i-kind"></i>
          <i class="i-band i-kind"></i>-->
          <i class="i-act"></i>
        </a>
      </div>

    <?
    if($cnt==1)
    $teaserContentAct='teaser-content-act ';
    else
    $teaserContentAct='';
    ?>
      <div class="<?=$teaserContentAct;?>teaser-content" id="content-item<?=$site['id'];?>">
  
  <?
  if($site['confirmed']==1){?> 
        <div class="settings-buy settings rc">
          <div class="fieldset-account fieldset-first fieldset">
            <div class="link"><a href="http://r<?=$site['id'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?>" target="_blank">r<?=$site['id'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?></a></div>
            <div class="id">
              <div class="num">r<?=$site['id'];?></div>
              <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
            </div>
          </div>
          <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
        </div>

        <div class="settings-transfer settings rc">
          <div class="fieldset-transfer-cancel fieldset-transfer fieldset-first fieldset">
            <form action="/cabinet/canceltransfer/" method="post">
              <input name="siteid" value="<?=$site['id'];?>" type="hidden" />
              <input name="senderid" value="<?=$_SESSION['User']['id'];?>" type="hidden" />
              <input name="transferid" value="<?=$site['transferid'];?>" type="hidden" />
              <div class="title">
                <h3>До передачи реккаунта осталось: <?=tools::int($site['time_left']);?> <?=tools::word_render('час','часа','часов',tools::int($site['time_left']));?></h3>
                <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
              </div>
              <div class="toggle-expanded toggle"><i class="i"></i></div>
              <div class="content" style="display: block;">
                <div class="content-wrap">
                  <div class="row">
                    <!--<div class="field">
                      <div class="label"><label for="transfer-login<?=$site['id'];?>">Имя пользователя</label></div>
                      <div class="input-text-disabled input-text"><div class="r"><div class="l"><input name="login" id="transfer-login<?=$site['id'];?>" value="<?=$site['receiverlogin'];?>" type="text" class="required" readonly="readonly" /></div></div></div>
                    </div>-->
                    <div class="field">
                      <div class="label"><label for="transfer-email<?=$site['id'];?>">E-mail пользователя</label></div>
                      <div class="input-text-disabled input-text"><div class="r"><div class="l"><input name="email" id="transfer-email<?=$site['id'];?>" value="<?=$site['receiveremail'];?>" type="text" class="email required" readonly="readonly" /></div></div></div>
                    </div>
                  </div>
                  <div class="submit">
                    <div class="button"><div class="r"><div class="l"><button type="submit">Отменить передачу</button></div></div></div>
                  </div>
                </div>
              </div>
            </form>    
          </div>
          <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
        </div>
    <div class="br"></div>
<?}else{
	if($site['free']){
	$inputperiod=12;
	$inputquota=10;
	}
	else{
	$inputperiod=0;
	$inputquota=0;
	}
	?>

        <form action="/cabinet/prolong/" method="post">
          <input name="userid" value="<?=$_SESSION['User']['id'];?>" type="hidden" />
    	  <input name="siteid" value="<?=$site['id'];?>" type="hidden" />
          <input name="balance_url" value="/user/checkbalance/" type="hidden" />
          <input name="deposit_url" value="/cabinet/deposit/" type="hidden" />
          <input name="period_max" value="36" type="hidden" />
          <input name="quota_max" value="100" type="hidden" />
          <input name="price" value="16.66666666666667" type="hidden" />
          <input name="final_cost" value="0" type="hidden" />
          <input name="discount" value="<?=$this->view->discount;?>" type="hidden" />
          <? if ($site['free']) { ?>
            <input name="free" value="1" type="hidden" />
            <input name="period_current" value="0" type="hidden" />
            <input name="quota_current" value="0" type="hidden" />
          <? } else { ?>
            <input name="period_current" value="<?=$site['time_left'];?>" type="hidden" />
            <input name="quota_current" value="<?=$this->view->sitedisc[$site['id']];?>" type="hidden" />
          <? } ?>


    		  <div class="settings-add settings rc">
            <div class="fieldset-account fieldset-first fieldset">
              <div class="link"><a href="http://r<?=$site['id'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?>" target="_blank">r<?=$site['id'];?>.<?=str_replace('www.','',$_SERVER['HTTP_HOST']);?></a></div>
              <div class="id">
                <div class="num">r<?=$site['id'];?></div>
                <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
              </div>
            </div>
            <div class="fieldset-period fieldset-even fieldset">
              <div class="title">
                <h3><?=$this->registry->trans['periodofwork'];?>:</h3>
              </div>
              <div class="field-period field">
                <div class="label"><label for="buy-period<?=$site['id'];?>"><?=$this->registry->trans['add'];?></label></div>
                <? if($site['free']){?>
				<div class="input-text-disabled input-text"><div class="r"><div class="l">
                  <div class="input"><?=$inputperiod;?></div>
                  <input name="period" value="<?=$inputperiod;?>" type="hidden" />
                </div></div></div>
				<?}else{?>
				<div class="input-text"><div class="r"><div class="l"><input name="period" id="buy-period<?=$site['id'];?>" value="<?=$inputperiod;?>" maxlength="2" type="text" class="required" /></div></div></div>
				<?}?>
              </div>
              <?
              if ($site['time_left'] < 2)
              $warnleft='field-warning ';
              else
              $warnleft='';
              if($site['time_left']<1)
			  $site['time_left']='0';
			  
			  if($site['free'])
			  $site['time_left']='0';
			  
			  ?>
              <div class="<?=$warnleft;?>field">
                <div class="label"><?=$this->registry->trans['left'];?></div>
                <div class="input-text-disabled input-text"><div class="r"><div class="l"><div class="input"><?=$site['time_left'];?></div></div></div></div>
              </div>            
            </div>
            <div class="fieldset-quota fieldset">
              <div class="title">
                <h3><?=$this->registry->trans['gb'];?>:</h3>
                <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
              </div>
              <div class="field-quota field">
                <div class="label"><label for="buy-quota<?=$site['id'];?>"><?=$this->registry->trans['add'];?></label></div>
                <? if($site['free']){?>
				<div class="input-text-disabled input-text"><div class="r"><div class="l">
                  <div class="input"><?=$inputquota;?></div>
                  <input name="quota" value="<?=$inputquota;?>" type="hidden" />
                </div></div></div>
				<?}else{?>
				 <div class="input-text"><div class="r"><div class="l"><input name="quota" id="buy-quota<?=$site['id'];?>" value="<?=$inputquota;?>" maxlength="3" type="text" class="required" /></div></div></div>
				<?}?>
              </div>
              <div class="<?=((tools::int($this->view->sitedisc[$site['id']])-round($filespace['size']/(1024*1024*1024),1))<5)?'field-warning':'';?> field">
                <div class="label"><?=$this->registry->trans['left'];?></div>
        <!--PHP_ROUND_HALF_DOWN-->
                <div class="input-text-disabled input-text"><div class="r"><div class="l"><div class="input"><?=round(tools::int($this->view->sitedisc[$site['id']])-($filespace['size']/(1024*1024*1024)),1);?></div></div></div></div>
              </div>            
              <div class="field">
                <div class="label"><?=$this->registry->trans['total'];?></div>
                <div class="input-text-disabled input-text"><div class="r"><div class="l"><div class="input"><?=tools::int($this->view->sitedisc[$site['id']]);?></div></div></div></div>
              </div>            
            </div>
            <div class="fieldset-submit fieldset-even fieldset">
              <div class="cost">
<!--
                если скидка = 0, то эти елементы не выводим
                <span class="full"><span>0</span> <?=$_SESSION['User']['currencylocal'];?></span>
                <span class="discount">скидка <span>0%</span></span>
-->
                <span class="full"><span>0</span> <?=$_SESSION['User']['currencylocal'];?></span>
                <span class="discount">скидка <span><?=$this->view->discount;?>%</span></span>
                <span class="final"><span>0</span> <?=$_SESSION['User']['currencylocal'];?></span>
              </div>
              <div class="button"><div class="r"><div class="l"><button><?=$this->registry->trans['prolong'];?></button></div> </div></div>
            </div>
            <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
          </div>
        </form>

        <div class="settings-kind settings rc">
          <div class="fieldset-kind fieldset-first fieldset">
            <form action="/cabinet/setkind/" method="post">
              <input type="hidden" name="siteid" value="<?=$site['id'];?>"/>
              <div class="title">
                <h3><?=$this->registry->trans['mystatus'];?> &mdash; <?=$site['sitetypename'];?></h3>
                <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
              </div>
              <div class="toggle"><i class="i"></i></div>
              <div class="content">
                <div class="content-wrap">
                  <?=$siteKindHTML;?>
                  <div class="submit">
                    <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['changestatus'];?></button></div></div></div>
                  </div>
                </div>
              </div>
            </form>    
          </div>
          <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
        </div>
		
		<? if(!$site['free']){?>
        <div class="settings-transfer settings rc">
          <div class="fieldset-transfer fieldset-first fieldset">
            <form action="/cabinet/transfer/" method="post">
              <input name="siteid" value="<?=$site['id'];?>" type="hidden" />
              <div class="title">
                <h3><?=$this->registry->trans['transferreccount'];?></h3>
                <div class="help-link"><a href="/help/" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
              </div>
              <div class="toggle"><i class="i"></i></div>
              <div class="content">
                <div class="content-wrap">
                  <div class="row">
                    <!--<div class="field">
                      <div class="label"><label for="transfer-login<?=$site['id'];?>"><?=$this->registry->trans['login'];?></label></div>
                      <div class="input-text"><div class="r"><div class="l"><input name="login" id="transfer-login<?=$site['id'];?>" type="text" class="required" /></div></div></div>
                    </div>-->
                    <div class="field">
                      <div class="label"><label for="transfer-email<?=$site['id'];?>">E-mail</label></div>
                      <div class="input-text"><div class="r"><div class="l"><input name="email" id="transfer-email<?=$site['id'];?>" type="text" class="email required" /></div></div></div>
                    </div>
                  </div>
                  <div class="submit">
                    <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['transferreccount'];?></button></div></div></div>
                  </div>
                </div>
              </div>
            </form>    
          </div>
          <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
        </div>
		<?}?>

      
  <?
  }
  $cnt++;
  ?>
    </div>

      <div class="br"></div>
  <?
  
  
  }?>

    </div>