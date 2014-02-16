<div class="widget">
    <div class="widget-header">
        <div class="widget-share">
            <input name="url" value="_share.php" type="hidden" />
            <input name="item_id" value="648" type="hidden" />
            <div class="i"></div>
            <div class="links">
                <div class="r">
                    <div class="l">
                        <ul>
                            <li class="link-twitter"><a href="http://twitter.com/home?status=ATELIER%20http%3A%2F%2Fatelier.ua%2F" rel="twitter" target="_blank"><span class="total">12</span></a></li>
                            <li class="link-facebook"><a href="http://facebook.com/sharer.php?t=ATELIER&amp;u=http%3A%2F%2Fatelier.ua%2F" rel="facebook" target="_blank"><span class="total">12</span></a></li>
                            <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2Fatelier.ua%2F" rel="vkontakte" target="_blank"><span class="total">12</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1"><?=$this->view->mainmenu;?></div>
        <div class="widget-title">
            <h2><a href="/video/"><?=$this->registry->trans['profile'];?></a></h2>
        </div>
    </div>
    <div class="widget-content widget-content-no-footer">
        <div class="widget-content-wrap">

            <? if (is_array($this->view->error)) {
                foreach ($this->view->error as $k=>$v) {
                    $errorfield[$k]='field-error ';
                }
            } ?>

            <div class="user-form-edit user-form">
              <form action="/user/updateregisterinfo/" method="post">
                <!--h1><?=$this->registry->trans['personal_details'];?></h1-->
                <div class="field">
                  <div class="label"><?=$this->registry->trans['login'];?></div>
                  <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$this->view->profile['login'];?></span></div></div></div>
                </div>

                <div class="field">
                  <div class="label"><label for="userEmail">E-mail</label></div>
                  <div class="input-text-disabled input-text"><div class="r"><div class="l"><span class="input"><?=$this->view->profile['email'];?></span></div></div></div>
                </div>

                <div class="<?=$errorfield['password_old'];?>field">
                  <div class="label"><label for="user-form-password-old"><?=$this->registry->trans['oldpassword'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l">
                    <input name="password_old" id="user-form-password-old" type="password" autocomplete="off" />
                    <? if (isset($this->view->error['password_old'])) { ?>
                      <label for="user-form-password-old" class="error"><?=$this->view->error['password_old'];?></label>
                    <? } ?>
                  </div></div></div>
                </div>

                <div class="<?=$errorfield['password'];?>field">
                  <div class="label"><label for="user-form-password"><?=$this->registry->trans['newpassword'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l">
                    <input name="password" id="user-form-password" type="password" autocomplete="off" />
                    <? if (isset($this->view->error['password'])) { ?>
                      <label for="user-form-password" class="error"><?=$this->view->error['password'];?></label>
                    <? } ?>
                  </div></div></div>
                </div>

                <div class="<?=$errorfield['password_check'];?>field-password-check field">
                  <div class="label"><label for="user-form-password-check"><?=$this->registry->trans['repeatpassword'];?></label></div>
                  <div class="input-text"><div class="r"><div class="l">
                    <input name="password_check" id="user-form-password-check" type="password" autocomplete="off" />
                    <? if(isset($this->view->error['password_check'])) { ?>
                      <label for="user-form-password-check" class="error"><?=$this->view->error['password_check'];?></label>
                    <? } ?>
                  </div></div></div>
                </div>

                <!--<div class="<?=$errorfield['country'];?>field-country field">
                  <div class="label"><label for="user-form-country">Страна проживания</label></div>
                  <div class="select">
                        <select name="country" id="user-form-country">
                      <?
                      $other=1;
                      foreach($this->view->countries as $country){
                      if($this->view->profile['countryid']==$country['id'])
                      $other=null;
                      ?>
                      <option <?=($this->view->profile['countryid']==$country['id'])?' selected="selected"':'';?> value="<?=$country['id'];?>"><?=$country['name_ru'];?></option>
                      <?}?>
                      <option <?=($other)?' selected="selected"':'';?> value="0">Другая</option>
                    </select>
                    <? if(isset($this->view->error['country'])) { ?>
                      <label for="user-form-country" class="error"><?=$this->view->error['country'];?></label>
                    <? } ?>
                  </div>
                </div>-->
               <div class="field">
                    <input name="notifyreply" value="1" id="user-form-when-reply" type="checkbox"<?=($this->view->profile['notifyreply'])?' checked="checked"':'';?>/><label for="user-form-when-reply">
                        <?
                        if($this->registry->langid==1){?>
                        Я хочу получать уведомления на почту, когда кто-то отвечает на мои комментарии
                        <?}elseif($this->registry->langid==2){?>
                        Notify me by email when someone responds to my comment
                        <?}?>
                        </label>
                </div>

                <div class="field">
                    <input name="notifycomment" value="1" id="user-form-when-comment" type="checkbox"<?=($this->view->profile['notifycomment'])?' checked="checked"':'';?>/><label for="user-form-when-comment">
                        <?
                        if($this->registry->langid==1){?>
                        Я хочу получать уведомления на почту, когда кто-то комментирует мои публикации
                        <?}elseif($this->registry->langid==2){?>
                        Notify me by email when someone comments on my publications
                        <?}?>
                        </label>
                </div>
                <div class="submit">
                  <div class="button"><div class="r"><div class="l"><button type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
                </div>

                <? if($this->view->socialaccounts){?>
                <div class="attached-accounts">
                    <h1><?=$this->registry->trans['linkedaccount'];?></h1>
                    <?
                    $socilarr=array(255=>"facebook");
                    foreach($this->view->socialaccounts as $account){
                    ?>
                    <div class="facebook">
                        <div class="button"><div class="r"><div class="l"><button type="button" class="unlink"><?=$this->registry->trans['unlink'];?></button></div></div></div>
                        <img class="avatar" src="/uploads/users/3_<?=$account['file_name'];?>" width="40" height="40" alt=""/><img class="facebook-logo" src="/img/reactor/logo-facebook.png" width="89" height="18" alt=""/><span class="status"><?=$this->registry->trans['acceptterms'];?></span>
                    </div>
                    <input type="hidden" id="facebook_id" value="<?=$account['accountid'];?>" />
                    <?}?>
                </div>
                <?}?>

                  <input type="hidden" id="is_password_exist" value="<?=$_SESSION['User']['haspassword'];?>" />

              </form>
            </div>

        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    //var userProfile = $.parseJSON('<?=$this->view->profile;?>');
</script>