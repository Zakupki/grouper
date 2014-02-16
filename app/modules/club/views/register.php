<div class="widget-admin widget">
    <div class="widget-header">
        <div class="widget-share">
            <input name="url" value="_share.php" type="hidden" />
            <input name="item_id" value="648" type="hidden" />
            <div class="i"></div>
            <div class="links">
                <div class="r">
                    <div class="l">
                        <ul>
            <li class="link-twitter"><a href="http://twitter.com/home?status=<?=urlencode($_SESSION['Site']['name']);?>%20http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="twitter" target="_blank"><span class="total"><?=tools::getTwCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-facebook"><a href="http://facebook.com/sharer.php?u=<?=$_SERVER['HTTP_HOST'];?>" rel="facebook" target="_blank"><span class="total"><?=tools::getFbCount($_SERVER['HTTP_HOST']);?></span></a></li>
            <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F<?=$_SERVER['HTTP_HOST'];?>%2F" rel="vkontakte" target="_blank"><span class="total"><?=tools::getVkCount($_SERVER['HTTP_HOST']);?></span></a></li>
          </ul>
                    </div>
                </div>
            </div>
        </div>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1"><?=$this->view->mainmenu;?></div>
		<div class="widget-title">
            <h2><a href="/video/"><?=$this->registry->trans['registration'];?></a></h2>
        </div>
    </div>
    <div class="widget-content widget-content-no-footer">
        <div class="widget-content-wrap" style="margin-bottom: -10px;">

            <div class="user-form-register user-form">
                <form action="/register/" method="post" autocomplete="off">
                    <div class="facebook-login">
                        <?=$this->registry->trans['loginwith'];?>:
                        <a class="button-facebook" href="http://reactor-pro.com/facebook/connect2/?url=<?=urlencode($_SERVER['HTTP_HOST']);?>&sescode=<?=$_SESSION['sescode'];?>"></a>
                    </div>
                    <input name="makeregister" value="1" type="hidden" />

                    <div class="fields-wrap">
                        <div class="field">
                            <div class="label"><label for="user-form-login" style="margin:0 0 -3px;"><?=$this->registry->trans['displayname'];?></label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input name="login" value="" id="user-form-login" type="text" class="login required" />
                            </div></div></div>
                        </div>

                        <div class="field">
                            <div class="label"><label for="user-form-email">E-mail</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input name="email" value="" id="user-form-email" type="text" class="email required" />
                            </div></div></div>
                        </div>

                        <div class="field">
                            <div class="label"><label for="user-form-password"><?=$this->registry->trans['password'];?></label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input name="password" id="user-form-password" type="password" class="required" />
                            </div></div></div>
                        </div>

                        <div class="field-password-check field">
                            <div class="label"><label for="user-form-password-check"><?=$this->registry->trans['passwordagain'];?></label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input name="password_check" id="user-form-password-check" type="password" class="required" />
                            </div></div></div>
                        </div>

                        <div class="field-country field">
                            <div class="label"><label for="user-form-country"><?=$this->registry->trans['country'];?></label></div>
                            <div class="select">
                                <select name="country" id="user-form-country">
                                      <?
									  $other=1;
									  foreach($this->view->countries as $country){
									  if(apache_note("GEOIP_COUNTRY_CODE")==$country['code'])
									  $other=null;
									  ?>
									  <option <?=(apache_note("GEOIP_COUNTRY_CODE")==$country['code'])?' selected="selected"':'';?> value="<?=$country['id'];?>"><?=$country['name_ru'];?></option>
									  <?}?>
									  <option <?=($other)?' selected="selected"':'';?> value="0"><?=$this->registry->trans['other'];?></option>
                                </select>
                            </div>
                        </div>

                        <div class="field-agree field">
                            <div class="input-checkbox">
                                <input name="agree" value="1" id="user-form-agree" type="checkbox" class="required" />
                                <label for="user-form-agree">
                                	<?
									if($this->registry->langid==1){?>
			                        Я принимаю <a target="_blank">пользовательское соглашение сайта Reactor PRO</a> (soon)
			                        <?}elseif($this->registry->langid==2){?>
			                        I accept <a target="_blank">User Agreement</a> (soon)
			                        <?}?>	
								</label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="input-checkbox">
                                <input name="notifyreply" value="1" id="user-form-when-reply" type="checkbox" />
                                <label for="user-form-when-reply">
                                	<?
			                        if($this->registry->langid==1){?>
			                        Я хочу получать уведомления на почту, когда кто-то отвечает на мои комментарии
			                        <?}elseif($this->registry->langid==2){?>
			                        I want to be notified by email when someone responds to my comment
			                        <?}?>
								</label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="input-checkbox">
                                <input name="notifycomment" value="1" id="user-form-when-comment" type="checkbox" />
                                <label for="user-form-when-comment">
								 <?
		                        if($this->registry->langid==1){?>
		                        Я хочу получать уведомления на почту, когда кто-то комментирует мои публикации
		                        <?}elseif($this->registry->langid==2){?>
		                        I want to be notified by email when someone comments on my publications
		                        <?}?>
								</label>
                            </div>
                        </div>
                    </div>

                    <div class="submit">
                        <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['registration'];?></button></div></div></div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="widget-content-bot"></div>
</div>