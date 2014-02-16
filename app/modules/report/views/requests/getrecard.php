<div class="popup-new-card">
	<form action="/admin/updaterecard/" class="new-card-form disabled" method="post">
        <? if($this->view->recardinner['id']){?>
		<input name="id" type="hidden" value="<?=$this->view->recardinner['id'];?>" >
		<?}?>
		<? if($this->view->recardinner['fileurl']){?>
		<input name="fileurl" type="hidden" value="<?=$this->view->recardinner['fileurl'];?>" >
		<?}?>
		<? if($this->view->recardinner['filename']){?>
		<input name="filename" type="hidden" value="<?=$this->view->recardinner['filename'];?>" >
		<?}?>
        <h2><?=($this->view->recardinner['id'])?'Просмотр карты':'Новая карта';?></h2>
        <div class="field-date field">
            <div class="label"><label>Начало</label></div>
            <div class="date-input">
                <input name="dateFrom" id="recard-date-start" value="<?=$this->view->recardinner['date_start'];?>" type="hidden" />
                <?
                $this->view->recardinner['date_start']=explode('.', $this->view->recardinner['date_start']);
                ?>
                <span class="day"><?=$this->view->recardinner['date_start'][0];?></span>
                <span class="month"><?=tools::GetMonth($this->view->recardinner['date_start'][1]);?></span>
                <span class="year"><?=$this->view->recardinner['date_start'][2];?></span>
            </div>
        </div>
        <div class="field-date field">
            <div class="label"><label>Конец</label></div>
            <div class="date-input">
                <input name="dateTo" id="recard-date-end" value="<?=$this->view->recardinner['date_end'];?>" type="hidden" />
                <?
                $this->view->recardinner['date_end']=explode('.', $this->view->recardinner['date_end']);
                ?>
                <span class="day"><?=$this->view->recardinner['date_end'][0];?></span>
                <span class="month"><?=tools::GetMonth($this->view->recardinner['date_end'][1]);?></span>
                <span class="year"><?=$this->view->recardinner['date_end'][2];?></span>
            </div>
        </div>

        <div class="field-card-name field">
            <div class="label"><label>Название карты</label></div>
            <div class="input-text"><div class="r"><div class="l"><input name="title" class="card-name" type="text"<?=$disabled;?> class="required" value="<?=$this->view->recardinner['name'];?>"></div></div></div>
        </div>

        <div class="field-message field">
            <div class="label"><label>Описание</label></div>
            <div class="textarea">
                <textarea name="desc"><?=$this->view->recardinner['detail_text'];?></textarea>
                <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
            </div>
        </div>

        <div class="button-set">
            <div class="upload widget">
                <input type="file" name="file" class="file-input">
                <div class="button button-attach"><div class="r"><div class="l">
                    <div style="overflow: hidden; width:35px; height:35px; margin:0 -20px 0 0; background:url('/img/club/icons/icon-attach-file.png') no-repeat center center;">
                    </div>
                </div></div></div>
                <span class="filename"></span>
            </div>

            <div class="button button-submit"><div class="r"><div class="l"><button type="submit"><?=($this->view->recardinner['id'])?'Редактировать':'Создать карту';?></button></div></div></div>
        </div>
    </form>
</div>
