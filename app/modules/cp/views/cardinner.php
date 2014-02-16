<div class="section">
						<div class="title_wrapper">
							<h2>Карта клуба</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/recards/updateclubscardinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->cardinner['id'];?>" />
														<input type="hidden" name="brandid" value="<?=$this->view->cardinner['brandid'];?>" />
														<input type="hidden" name="siteid" value="<?=$this->view->cardinner['siteid'];?>" />
														<input type="hidden" name="recardid" value="<?=$this->view->cardinner['recardid'];?>" />
														<input type="hidden" name="oldstatus" value="<?=tools::int($this->view->cardinner['status']);?>" />
														<? if($this->view->cardinner['cardid']){?>
														<input type="hidden" name="cardid" value="<?=$this->view->cardinner['cardid'];?>" />
														<?}?>
														<div class="forms">
														<div class="row">
															<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->cardinner['name'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
															<label>Дата начала:</label>
															<div class="inputs">
																<span class="input_wrapper medium_input"><input class="text" name="date_start" value="<?=$this->view->cardinner['date_start'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
															<label>Дата окончания:</label>
															<div class="inputs">
																<span class="input_wrapper medium_input"><input class="text" name="date_end" value="<?=$this->view->cardinner['date_end'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
															<label>Бренд:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" disabled="dissabled"name="brand" value="<?=$this->view->cardinner['brand'];?>" type="text"/></span>
															</div>
														</div>
														<? if($this->view->cardinner['cardid'] && tools::int($this->view->cardinner['status'])==3){?>
														<div class="row">
															<label>Yocardid:</label>
															<div class="inputs">
																<span class="input_wrapper medium_input"><input class="text" name="yocardid" value="<?=$this->view->cardinner['yocardid'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
															<label>Цена:</label>
															<div class="inputs">
																<span class="input_wrapper medium_input"><input class="text" name="price" value="<?=$this->view->cardinner['price'];?>" type="text"/></span>
															</div>
														</div>
														<?}?>
															
														<div class="row">
															<label>Файл:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																<? if($this->view->cardinner['url']){	$path_parts=pathinfo($this->view->cardinner['url']);
																	$extarr=array('jpg','jpeg','gif','png');
																	?>
																	<input name="file_oldname" type="hidden" value="<?=$this->view->cardinner['file_oldname'];?>">
																	<input name="current_file" type="hidden" value="<?=$this->view->cardinner['url'];?>">
																	<?}?>
																	<input name="file" type="file">
																</span>
																<?
																if(in_array($path_parts['extension'],$extarr))
																echo '<img src="'.$this->view->cardinner['url'].'"/>';
																if($this->view->cardinner['url']){?>
																	<br/><span class="input_wrapper blank"><a target="_blank" href="<?=$this->view->cardinner['url'];?>">Скачать</a></span>
																<?}?>		
															</div>
														</div>
														
														</div>
														<div class="row">
															<label>Текст:</label>
															<div class="inputs">
																<span class="input_wrapper textarea_wrapper">
																	<textarea name="detail_text" class="text"><?=$this->view->cardinner['detail_text'];?></textarea>
																</span>
															</div>
														</div>
														<? if(tools::int($this->view->cardinner['status'])<2){?>
														<div class="row">
															<label>Готово к отправке: </label>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="checkbox" name="status" value="1"<?=($this->view->cardinner['status']==1)?' checked="checked"':'';?> type="checkbox" /></li>
																</ul>
															</div>
														</div>
														<?}?>
														<div class="row">
															<div class="buttons">
																<ul>
																	<li><span class="button send_form_btn"><span><span>Сохранить</span></span><input name="" type="submit" /></span></li>
																	<li><span class="button cancel_btn"><span><span>Отмена</span></span><input name="" type="submit" /></span></li>
																</ul>
															</div>
														</div>
														
													
													</fieldset>
												</form>
												<? if(tools::int($this->view->cardinner['status'])==2){?>
												<ul class="system_messages">
														<li class="yellow"><span class="ico"></span><strong class="system_title">Заявка находится на рассмотрении у клуба.</strong></li>
												</ul>
												<?}?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
							
						</div>
					</div>