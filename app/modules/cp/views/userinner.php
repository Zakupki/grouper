<div class="section">
						<div class="title_wrapper">
							<h2>Пользователи</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/users/updateuserinner/" method="POST" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->userinner['id'];?>" />
														<div class="forms">
														<div class="row">
															<label>Логин:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="login" value="<?=$this->view->userinner['login'];?>" type="text" <?=($this->view->userinner['id'])?'disabled="disabled"':'';?> /></span>
															</div>
														</div>
														<? if($this->view->userinner['id']<1){?>
														<div class="row">
															<label>Email:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="email" value="" type="text" /></span>
															</div>
														</div>
														<div class="row">
															<label>Password:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="password" value="" type="text" /></span>
															</div>
														</div>
														<div class="row">
															<label>Password again:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="passwordagain" value="" type="text" /></span>
															</div>
														</div>
														<?}?>
														<div class="row">
															<label>Рекомендовать: </label>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="checkbox" name="recommend" value="1" <?=($this->view->userinner['recommend'])?'checked="checked"':'';?> type="checkbox" /></li>
																</ul>
															</div>
														</div>
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