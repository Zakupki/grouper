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
            <h2><a href="/video/"><?=$this->registry->trans['profile'];?></a></h2>
        </div>
    </div>
    <div class="widget-content widget-content-no-footer">
        <div class="widget-content-wrap">
            <div class="user-profile-edit">
                <form action="/user/updateprofile/" method="post">
                    <div class="cover-field field">
                        <div class="cover-input-default cover-input">
                            <span class="img"><img src="" alt="" /></span>
                            <span class="upload-link"><span><input name="cover" id="upload-user-avatar" type="file" /></span><i class="i"></i></span>
                            <span class="remove-link"><i class="i"></i></span>
                            <i class="i-frame"></i>
                        </div>
                    </div>

                    <div class="fields">
                        <div style="margin: -16px 0 0;">
                            <i><?=$this->registry->trans['displayname'];?></i>
                            <div class="input-text"><div class="r"><div class="l"><input class="visible-name" value="" type="text" /></div></div></div>
                        </div>

                        <div>
                            <i><?=$this->registry->trans['aboutyou'];?></i>
                            <textarea class="user-description"></textarea>
                        </div>

                        <div class="links">
                            <i><?=$this->registry->trans['socialprofiles'];?></i>
                            <ul class="jlist">
                                <li class="placeholder">
                                    <div class="input-text"><div class="r"><div class="l"><input name="" type="text" /></div></div></div>
                                    <div class="remove-link"><span><?=$this->registry->trans['deletelink'];?><i class="i"></i></span></div>
                                    <div class="handle"></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="submit">
                        <div class="button"><div class="r"><div class="l"><button class="submit" type="submit"><?=$this->registry->trans['save'];?></button></div></div></div>
                        <a href="/user/registerinfo"><div class="button"><div class="r"><div class="l"><span><?=$this->registry->trans['personal_details'];?></span></div></div></div></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    var userProfile = $.parseJSON('<?=$this->view->profile;?>');
</script>