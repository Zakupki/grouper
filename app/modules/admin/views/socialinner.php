<div class="section">
						<div class="title_wrapper">
							<h2>Сети</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/social/updatesocialinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->social['id'];?>" />
														<div class="forms">
														<div class="row">
														<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->social['name'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
														<label>Url:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="url" value="<?=$this->view->social['url'];?>" type="text"/></span>
															</div>
														</div>
														<div class="row">
															<label>Маленькая картинка:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->social['preview']){?>
																	<img width="20" height="20" src="<?=$this->view->social['preview'];?>"/>
																	<input name="previewid" type="hidden" value="<?=$this->view->social['previewid'];?>">
																	<input name="preview" type="hidden" value="<?=$this->view->social['preview'];?>">
																	<?}?>
																	<input name="small_image" type="file"></span>
															</div>
														</div>
														<div class="row">
															<label>Большая картинка:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->social['detail']){?>
																	<img width="40" height="40" src="<?=$this->view->social['detail'];?>"/>
																	<input name="detailid" type="hidden" value="<?=$this->view->social['detailid'];?>">
																	<input name="detail" type="hidden" value="<?=$this->view->social['detail'];?>">
																	<?}?>
																	<input name="big_image" type="file"></span>
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