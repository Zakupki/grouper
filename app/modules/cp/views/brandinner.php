<div class="section">
						<div class="title_wrapper">
							<h2>Бренд</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/brands/updatebrandinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->brandinner['id'];?>" />
														<? if($this->view->brandinner['userid']>0){?>
														<input type="hidden" name="current_userid" value="<?=$this->view->brandinner['userid'];?>" />
														<?}?>
														<div class="forms">
														<div class="row">
															<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->brandinner['name'];?>" type="text" </></span>
															</div>
														</div>
														<div class="row">
															<label>Поддомен:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="code" value="<?=$this->view->brandinner['urlcode'];?>" type="text" /></span>
															</div>
														</div>
														<div class="row">
															<label>Logo:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->brandinner['url']){?>
																	<input name="current_file" type="hidden" value="<?=$this->view->brandinner['url'];?>">
																	<?}?>
																	<input name="file" type="file">
																</span>
																<? if($this->view->brandinner['url']){?>
																	<img src="<?=$this->view->brandinner['url'];?>"/>
																<?}?>
															</div>
														</div>
														<div class="row">
															<label>Тип пользователя:</label>
															<div class="inputs">
																<ul class="inline">
																	<li> <input class="radio" name="usertype" checked="checked" id="usertype1" value="1" type="radio"> зарегистрированый</li>
																</ul>
																<ul class="inline">
																	<li> <input class="radio" name="usertype" value="2"  id="usertype2" type="radio"> новый</li>
																</ul>
															</div>
														</div>
														 
														<div class="parent_row" id="old_user" >
															<div class="row">
																<label>Пользователь:</label>
																<div class="inputs">
																	<span class="input_wrapper blank">
																		<select name="userid">
																			<option></option>
																			<? foreach($this->view->userlist as $user){?>
																			<option<?=($user['id']==$this->view->brandinner['userid'])?' selected=selected':'';?> value="<?=$user['id'];?>"><?=$user['email'];?></option>
																			<?}?>
																		</select>
																	</span>
																</div>
															</div>
														</div>
														
														<div class="parent_row" id="new_user" style="display:none;">
															<div class="row">
																<label>Email:</label>
																<div class="inputs">
																	<span class="input_wrapper"><input class="text" name="email" value="" type="text" /></span>
																</div>
															</div>
														</div>
														<!--
														<div class="row">
																													<label>Р РµРєРѕРјРµРЅРґРѕРІР°С‚СЊ: </label>
																													<div class="inputs">
																														<ul class="inline">
																															<li><input class="checkbox" name="recommend" value="1" <?=($this->view->brandinner['recommend'])?'checked="checked"':'';?> type="checkbox" /></li>
																														</ul>
																													</div>
																												</div>-->
														
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