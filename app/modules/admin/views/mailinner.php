<div class="section">
						<div class="title_wrapper">
							<h2>Рассылки</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<div class="section_content">
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<form action="/admin/mail/updatemailinner/" method="POST" id="mailform" class="search_form general_form">
													<fieldset>
														<input type="hidden" name="id" value="<?=$this->view->mailinner['id'];?>" />
														<div class="forms">
														<div class="row">
															<label>Тема:</label>
															<div class="inputs">
																<span class="input_wrapper"><input class="text" name="subject" value="<?=$this->view->mailinner['subject'];?>" type="text" /></span>
															</div>
														</div>
														<div class="row">
															<label>Кому:</label>
															<div class="inputs">
																<ul class="inline">
																	<li><input class="radio" name="send" value="1" type="radio" /> всем пользователям</li>
																	<li><input class="radio" name="send" value="2" type="radio" /> владельцам сайтов артистов</li>
																	<li><input class="radio" name="send" value="3" type="radio" /> владельцам сайтов клубов</li>
																	<li><input class="radio" name="send" value="4" type="radio" /> только обычным пользователям</li>
																</ul>
																
															</div>
														</div>
														<div class="row">
															<label>Текст письма:</label>
															<div class="inputs">
																<span class="input_wrapper textarea_wrapper">
																	<textarea name="detail_text" class="text"><?=$this->view->mailinner['detail_text'];?></textarea>
																</span>
															</div>
														</div>
														<script>
															$(document).ready(function(){
																$('#sendmail').click(function(event){
																	event.preventDefault();
																	$('#mailform').attr('action', '/admin/mail/sendmail/');
																	$('#mailform').submit();
																})
															});
														</script>
														<div class="row">
															<div class="buttons">
																<ul>
																	<li><span class="button send_form_btn"><span><span>Сохранить</span></span><input name="" type="submit" /></span></li>
																	<li><span class="button orange_btn"><span><span>Отправить</span></span><input id="sendmail" name="" type="submit" /></span></li>
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