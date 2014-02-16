<div class="section">
						<div class="title_wrapper">
							<h2>Сайты</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/sites/updatesiteinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->siteinner['id'];?>" />
														<input type="hidden" name="userid" value="<?=$this->view->siteinner['userid'];?>" />
														<? if($this->view->siteinner['sitetypeid']==7){?>
														<input type="hidden" name="sitetypeid" value="<?=$this->view->siteinner['sitetypeid'];?>" />
														<?}?>
														<div class="forms">
														<div class="row">
															<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->siteinner['name'];?>" type="text"/></span>
															</div>
														</div>
														<? if($this->view->siteinner['sitetypeid']==7){?>
														<div class="row">
															<label>Город:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select name="cityid">
																		<option></option>
																		<? foreach($this->view->city as $city){?>
																		<option<?=($city['id']==$this->view->siteinner['cityid'])?' selected=selected':'';?> value="<?=$city['id'];?>"><?=$city['name'];?></option>
																		<?}?>
																	</select>
																</span>
															</div>
														</div>
														<?
														}?>
														<div class="row">
															<label>Рекомендовать: </label>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="checkbox" name="recommend" value="1" <?=($this->view->siteinner['recommend'])?'checked="checked"':'';?> type="checkbox" /></li>
																</ul>
															</div>
														</div>
														<? if($this->view->siteinner['sitetypeid']==7){?>
														<div class="row">
															<label>Лого:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->siteinner['logo']){?>
																	<img width="120" height="120" src="<?=$this->view->siteinner['logo'];?>"/>
																	<input name="logoid" type="hidden" value="<?=$this->view->siteinner['logoid'];?>">
																	<input name="logo" type="hidden" value="<?=$this->view->siteinner['logo'];?>">
																	<?}?>
																	<input name="logo_image" type="file"></span>
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
														
														
														
														</div>
														
													</fieldset>
													
													
													
													
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
							
						</div>
					</div>