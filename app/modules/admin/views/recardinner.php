<div class="section">
						<div class="title_wrapper">
							<h2>Recard</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/recards/updaterecardinner/" method="POST" enctype="multipart/form-data" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->cardinner['id'];?>" />
														<input type="hidden" name="brandid" value="<?=$this->view->cardinner['brandid'];?>" />
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
														<div class="row">
															<label>Файл:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<? if($this->view->cardinner['url']){?>
																	<input name="current_file" type="hidden" value="<?=$this->view->cardinner['url'];?>">
																	<?}?>
																	<input name="file" type="file">
																</span>
																<? if($this->view->cardinner['url']){
																	$path_parts=pathinfo($this->view->cardinner['url']);
																	$extarr=array('jpg','jpeg','gif','png');
																	if(in_array($path_parts['extension'],$extarr))
																	echo '<img src="'.$this->view->cardinner['url'].'"/>';
																	?>
																	<br/><br/><span class="input_wrapper blank"><a target="_blank" href="<?=$this->view->cardinner['url'];?>">Скачать</a></span>
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