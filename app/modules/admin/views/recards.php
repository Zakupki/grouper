<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Recard</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<!--[if !IE]>end title wrapper<![endif]-->
						<!--[if !IE]>start section content<![endif]-->
						<div class="section_content">
							<!--[if !IE]>start section content top<![endif]-->
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												
												<form action="#">
												<fieldset>
												<!--[if !IE]>start table_wrapper<![endif]-->
												<div class="table_wrapper">
													<div class="table_wrapper_inner">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														<tr>
															<th style="width: 36px;">Id</th>
															<th style="width: 15px;">&nbsp;</th>
															<th>Название</th>
															<th>Бренд</th>
															<th>Email</th>
															<th>Телефон</th>
														</tr>
														
														<? if(is_array($this->view->cardlist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->cardlist as $card){
														if($cnt==2)
														$cnt=0;
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$card['id'];?></td>
															<td>
																<div style="width: 15px;" class="actions">
																	<ul>
																		<li><a class="action1" href="/admin/recards/<?=$card['id'];?>/">1</a></li>
																		<!--<li><a class="action2" href="#">2</a></li>
																		<li><a class="action3" href="#">3</a></li>
																		<li><a class="action4" href="#">4</a></li>
																		<li><input class="radio" name="" type="checkbox" value="" /></li>-->
																	</ul>
																</div>
															</td>
															<td><a class="product_name" href="/admin/recard/<?=$card['id'];?>/"><?=$card['name'];?></a></td>
															<td><?=$card['brandname'];?></td>
															<td><?=$card['email'];?></td>
															<td><?=$card['phone'];?></td>
															
														</tr>
														<?
														$cnt++;
														}
														}?>
														
														
														
														
													</tbody></table>
													</div>
												</div>
												<!--[if !IE]>end table_wrapper<![endif]-->
												
												<!--[if !IE]>start table menu<![endif]-->
												<div class="table_menu">
													<!--
													<ul class="left">
														<li><a href="#" class="button add_new"><span><span>ADD NEW</span></span></a></li>
													</ul>
													<ul class="right">
														<li><a href="#" class="button check_all"><span><span>CHECK ALL</span></span></a></li>
														<li><a href="#" class="button uncheck_all"><span><span>UNCHECK ALL</span></span></a></li>
														<li><span class="button approve"><span><span>APPROVE</span></span></span></li>
													</ul>
													-->
												</div>
												<!--[if !IE]>end table menu<![endif]-->
												
												
												</fieldset>
												</form>
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--[if !IE]>end section content top<![endif]-->
							<!--[if !IE]>start section content bottom<![endif]-->
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
							<!--[if !IE]>end section content bottom<![endif]-->
							
						</div>
						<!--[if !IE]>end section content<![endif]-->
					</div>