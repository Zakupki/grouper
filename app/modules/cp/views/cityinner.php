<div class="section">
						<div class="title_wrapper">
							<h2>Города</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/geo/updatecityinner/" method="POST" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->cityinner['id'];?>" />
														<div class="forms">
														<div class="row">
															<label>Название:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="name" value="<?=$this->view->cityinner['name'];?>" type="text" /></span>
															</div>
														</div>
														<div class="row">
															<label>Страна:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select name="countryid">
																		<option></option>
																		<? foreach($this->view->country as $country){?>
																		<option<?=($country['id']==$this->view->cityinner['countryid'])?' selected=selected':'';?> value="<?=$country['id'];?>"><?=$country['name'];?></option>
																		<?}?>
																	</select>
																</span>
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