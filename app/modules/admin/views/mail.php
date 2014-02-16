<div class="section table_section">
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
												
												<form action="#">
												<fieldset>
												<div class="table_wrapper">
													<div class="table_wrapper_inner">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														<tr>
															<th style="width: 36px;">Id</th>
															<th>Тема</th>
															<th style="width: 96px;">Actions</th>
														</tr>
														<? if(is_array($this->view->mailist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->mailist as $mail){
														if($cnt==2)
														$cnt=0;
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$mail['id'];?></td>
															<td><a class="product_name" href="/admin/mail/<?=$mail['id'];?>/"><?=$mail['subject'];?></a></td>
															<td>
															
																<div class="actions_menu">
																	<ul>
																		
																		<li><a class="edit" href="/admin/mail/<?=$mail['id'];?>/">Edit</a></li>
																	</ul>
																</div>
															</td>
														</tr>
														<?
														$cnt++;
														}
														}?>
														
														
														
														
													</tbody></table>
													</div>
												</div>
												<div class="table_menu">
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