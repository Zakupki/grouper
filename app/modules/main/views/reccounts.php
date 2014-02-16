<h1><?=$this->registry->trans['reccounts'];?></h1>

<div class="teasers">
<?
	if(!$_SESSION['User']['currencylocal'])
	$_SESSION['User']['currencylocal']='грн';
    /*$this->view->print_r($this->view->sitetypes);*/
    $cnt=1;;
    foreach($this->view->sitetypes as $kay=>$value){
    
    if(is_array($this->view->sitetypes[$kay]['subcats']) && $value['data']['active']=="Y"){

    $active='';
    if($cnt===1)
    $active='teaser-act ';
    
    if($value['data']['parentid']==null){
    $teaserHTML.=<<<OUT
        <div class="{$active}teaser" id="content-teaser{$cnt}">
          <a href="/reccounts/#content{$cnt}" id="content{$cnt}">
OUT;
    $scnt=1;
    $kcnt=1;
    if(is_array($this->view->sitetypes[$kay]))
        $s_teaserHTML='';
    $ss_teaserHTML='';
    $siteKindHTML='';
    
    $siteKindHTML='<div class="row">';
    foreach($this->view->sitetypes[$kay]['subcats'] as $skey=>$svalue){
      $display_s='';
      if($scnt==1)
      $display_s=' style="display: block;"';
      
      $s_teaserHTML.=<<<OUT
          <span class="title title-kind"{$display_s}>{$svalue['name']}</span>
OUT;
      $display_ss='';
      if($scnt==1)
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
      if($scnt==1)
      $checkedkind=' checked="checked"';
      $siteKindHTML.=<<<OUT
          <div class="input-radio">
            <input name="kind" id="kind{$kay}{$svalue['id']}" value="{$svalue['id']}" type="radio"{$checkedkind} />
            <label for="kind{$kay}{$svalue['id']}">{$svalue['name']}</label>
          </div>
OUT;
    $kcnt++;
    $scnt++;
    }

    $siteKindHTML.=<<<OUT
        </div>
OUT;
    }
    
    $teaserHTML.=<<<OUT
        {$s_teaserHTML}
        <span class="text">{$value['data']['preview_text']}</span>
        {$ss_teaserHTML}
        <i class="i-act"></i>
OUT;
    $teaserHTML.=<<<OUT
          </a>  
        </div>
        <div class="br"></div>
OUT;
    $teaserCdisplay='';
    if($cnt==1)
    $teaserCdisplay='teaser-content-act ';
    if (!$this->view->Session->User['id']) {
        $buyButtonClass = 'auth-popup-link';
    }
	else{
		$submiton='type="submit"';
	}
				  $discountHTML=null;
				  if($this->view->discount>0)
				  $discountHTML='
				      <span class="full"><span>'.$this->view->price.'</span> '.$_SESSION['User']['currencylocal'].'</span>
              <span class="discount">'.strtolower($this->registry->trans['discount']).' <span>'.$this->view->discount.'%</span></span>
          ';
                  
	
    $teasercontentHTML.=<<<OUT
        <div class="{$teaserCdisplay}teaser-content" id="content-item{$cnt}">
          <form action="/reccounts/buy/" method="post">
            <input name="userid" value="{$this->view->userid}" type="hidden" />
            <input name="free_url" value="/reccounts/free/" type="hidden" />
            <input name="balance_url" value="/user/checkbalance/" type="hidden" />
            <input name="deposit_url" value="/cabinet/deposit/" type="hidden" />
            <input name="period_max" value="36" type="hidden" />
            <input name="period_current" value="12" type="hidden" />
            <input name="quota_max" value="100" type="hidden" />
            <input name="quota_current" value="10" type="hidden" />
            <input name="price" value="8.3333333333333333" type="hidden" />
            <input name="final_cost" value="{$this->view->discountprice}" type="hidden" />
            <input name="discount" value="{$this->view->discount}" type="hidden" />
            <div class="settings-buy settings rc">
              <div class="fieldset-kind fieldset-first fieldset">
                <div class="help-link"><a href="/help/?id=1" target="_blank"><img src="/img/reactor/px.gif" alt="" /></a></div>
                {$siteKindHTML}
              </div>
              <div class="fieldset-period fieldset-even fieldset">
                <div class="title">{$this->registry->trans['periodofwork']}:</div>            
                <div class="field">
                  <div class="label"><label for="settings-period">{$this->registry->trans['add']}</label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="period" id="settings-period" value="0" maxlength="2" type="text" /></div></div></div>
                </div>
                <div class="field">
                  <div class="label">{$this->registry->trans['total']}</div>
                  <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input">12</span></div></div></div>
                </div>               
              </div>
              <div class="fieldset-quota fieldset">
                <div class="title">Дисковое пространство (ГБ):</div>
                <div class="field-quota field">
                  <div class="label"><label for="settings-quota">{$this->registry->trans['add']}</label></div>
                  <div class="input-text"><div class="r"><div class="l"><input name="quota" id="settings-quota" value="0" maxlength="3" type="text" /></div></div></div>
                </div>
                <div class="field">
                  <div class="label">{$this->registry->trans['total']}</div>
                  <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input">10</span></div></div></div>
                </div>              
              </div>
              <div class="fieldset-submit fieldset-even fieldset">
                <div class="cost" style="display: block;">
                  {$discountHTML}
        				  <span class="final"><span>20</span> UAH</span>
                </div>
                <div class="button"><div class="r"><div class="l"><button type="submit" class="{$buyButtonClass}">{$this->registry->trans['buy']}</button></div> </div></div>
              </div>
              <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
            </div>
            <!--<div class="settings-free settings rc">
              <div class="fieldset-free fieldset-submit fieldset-first fieldset">
                <div class="text">Вы можете взять данный Реккаунт<br />бесплатно на 90 дней.</div>
                <div class="button"><div class="r"><div class="l"><button {$submiton} class="{$buyButtonClass}">Взять на 90 дней</button></div> </div></div>
              </div>
              <div class="rc-lt"></div><div class="rc-rt"></div><div class="rc-rb"></div><div class="rc-lb"></div>
            </div>-->
          </form>

<!--
          <ul class="demo-links">
            <li><a href="http://youtu.be/orH2dP3jLPo" rel="popup:#contentManagementVideo" target="_blank">Управление контентом (видео)</a></li>
          </ul>
-->
          <div class="popup-src" id="contentManagementVideo">
            <object width="640" height="360"><param name="movie" value="http://www.youtube.com/v/orH2dP3jLPo?version=3&amp;hl=ru_RU&amp;rel=0&amp;hd=1&amp;autoplay=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/orH2dP3jLPo?version=3&amp;hl=ru_RU&amp;rel=0&amp;hd=1&amp;autoplay=1" type="application/x-shockwave-flash" width="640" height="360" allowscriptaccess="always" allowfullscreen="true"></embed></object>
          </div>
        </div>
OUT;
    }
    else
    {
    $soon='';
    if($value['data']['active']=="N")
    $soon='<i class="i-soon"></i>';

    $display_s='';
    if($scnt==1)
    $display_s=' style="display: block;"';

    $display_ss='';
    if($scnt==1)
    $display_ss=' style="display: block;"';
    
    $active='';
    if($cnt===1)
    $active='teaser-act ';

    $teaserHTML.=<<<OUT
        <div class="{$active}teaser" id="content-teaser{$cnt}">
          <a href="/reccounts/#content{$cnt}" id="content{$cnt}">
            <span class="title"{$display_s} id="content-title{$cnt}">{$value['data']['name']}</span>
            <span class="text">{$value['data']['preview_text']}</span>
            <i class="i-{$value['data']['code']}"{$display_ss}></i>
            {$soon}
            <i class="i-act"></i>
          </a>
        </div>
        <div class="br"></div>
OUT;
    $teaserCactive='';
    if($cnt==1)
    $teaserCactive='teaser-content-act ';

    $teasercontentHTML.=<<<OUT
        <div class="{$teaserCactive}teaser-content" id="content-item{$cnt}">
          <div class="html">
            <p>{$value['data']['detail_text']}</p>
          </div>
        </div>
OUT;
  }
  $cnt++;
  }
  
  ?>
  
<?=$teasercontentHTML;?>

<?=$teaserHTML;?>

</div>