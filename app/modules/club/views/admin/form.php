<div class="widget-last widget-admin widget">
    <div class="widget-header">
        <a class="home" href="/"></a>
        <span class="menu"><?=$this->registry->trans['menu'];?></span>
        <div class="widget-m1">
            <?=$this->view->mainmenu;?>
        </div>
        <div class="widget-title">
            <h2><a href="#"><?=$this->registry->trans['form'];?></a></h2>
        </div>
    </div>
    <div class="widget-content-no-footer widget-content">
        <div class="widget-content-wrap">

            <div class="anketa-admin">
                <form action="/admin/updateform/" method="post">
                	<?
					if($this->view->form['id']>0){
					?>
					<input type="hidden" name="id" value="<?=$this->view->form['id'];?>"/>
					<?}?>
                    <div class="b-column-left">
                        <h2>Заполните анкету заведения!</h2>
                        <p>Заполнение анкеты является обязательным условием для авторизации в системе. С её помощью вы сможете наладить коммуникацию со спонсором и подобрать бренд для вашей аудитории.</p>
                    </div>

                    <div class="b-column-right">
                        <h2>1. Контактная информация</h2>
                        <div class="field">
                            <div class="label"><label>Имя, Фамилия контактного лица</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-large" name="name" value="<?=$this->view->form['name'];?>" type="text" />
                            </div></div></div>
                        </div>
                        <div class="field field-fl field-mar">
                            <div class="label"><label>E-mail</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="email" value="<?=$this->view->form['email'];?>" type="text" />
                            </div></div></div>
                        </div>
                        <div class="field field-fl">
                            <div class="label"><label>Номер мобильного телефона</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="phone" value="<?=$this->view->form['phone'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>2. Укажите торговые марки,<br />
                            с которыми Вы работаете в эксклюзиве</h2>
                        <div class="field brands">
                            <div class="label"><label>Торговые марки, компании</label></div>
                            <ul class="jlist">
                                <?
                                $cnt=0;
                                if(count($this->view->form['brandlist'])>0){
                                	foreach($this->view->form['brandlist'] as $brand){
                                	?>
	                                <li class="disabled">
	                                <div class="input-text"><div class="r"><div class="l"><input name="brandname[<?=$cnt;?>]" type="text" value="<?=$brand['name'];?>" disabled="disabled" /></div></div></div>
	                                <div class="remove-link"><span>Удалить<i class="i"></i></span></div>
	                                </li>
                                     <input type="hidden" name="brandid[<?=$cnt;?>]" value="<?=$brand['id'];?>">
                                <?	$cnt++;
									}
								}?>
									<li class="placeholder">
	                                <div class="input-text"><div class="r"><div class="l"><input name="brandname[<?=$cnt;?>]" type="text" /></div></div></div>
	                                <div class="remove-link"><span>Удалить<i class="i"></i></span></div>
	                                </li>
                            </ul>
                        </div>

                        <h2>3. Укажите стоимость в меню следующих позиций:</h2>
                        <div class="field field-fl field-mar">
                            <div class="label"><label>Эспрессо (грн. за 1 чашку)</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="espresso" value="<?=$this->view->form['espresso'];?>" type="text" />
                            </div></div></div>
                        </div>
                        <div class="field field-fl">
                            <div class="label"><label>Коктейль Мохито (грн. за 1 штуку)</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="mohito" value="<?=$this->view->form['mohito'];?>" type="text" />
                            </div></div></div>
                        </div>
                        <div class="field field-fl field-mar">
                            <div class="label"><label>Коктейль ЛонгАйленд (грн. за 1 штуку)</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="longisland" value="<?=$this->view->form['longisland'];?>" type="text" />
                            </div></div></div>
                        </div>
                        <div class="field field-fl">
                            <div class="label"><label>Вода Бонаква (грн. за бут. 0,5л.)</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-medium" name="bonaqua" value="<?=$this->view->form['bonaqua'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>4. Укажите средний возраст посетителей</h2>
                        <div class="field">
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-small check-is-integer" name="age" value="<?=$this->view->form['age'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>5.Укажите направление музыки,<br />
                            которая играет в Вашем заведении</h2>
                        <div class="field">
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-large" name="music" value="<?=$this->view->form['music'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>6. Количество барных стоек</h2>
                        <div class="field">
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-small check-is-integer" name="bar" value="<?=$this->view->form['bar'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>7. Количество посещений за неделю</h2>
                        <div class="field">
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-small check-is-integer" name="visits" value="<?=$this->view->form['visits'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>8. Есть ли счетчик посетителей?</h2>
                        <div class="field">
                            <div class="label"><label>если да - укажите марку счетчика</label></div>
                            <div class="input-text"><div class="r"><div class="l">
                                <input name="visitorscounter" type="text" value="<?=$this->view->form['visitorscounter'];?>" />
                            </div></div></div>
                        </div>
                        <h2>9. Количество плазм в заведении</h2>
                        <div class="field">
                            <div class="input-text"><div class="r"><div class="l">
                                <input class="input-small check-is-integer" name="plazma" value="<?=$this->view->form['plazma'];?>" type="text" />
                            </div></div></div>
                        </div>

                        <h2>10. Описать возможности in-door</h2>
                        <div class="field-message field">
                            <div class="textarea">
                                <textarea name="extradescription"><?=$this->view->form['extradescription'];?></textarea>
                                <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
                            </div>
                        </div>

                    </div>
                    <div class="submit">
                        <div class="button"><div class="r"><div class="l"><button type="submit">Save</button></div></div></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="widget-content-bot"></div>
</div>

<script type="text/javascript">
    $('.check-is-integer').each(function() {
        $(this).keypress(function(event) {
            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
                return true;
            }
            else if ( key < 48 || key > 57 ) {
                return false;
            }
            else return true;
        });
    })
</script>