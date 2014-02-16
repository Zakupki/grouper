<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Карты клубов</h2>
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
												
												<form action="/admin/recards/updatecardlist/" method="post">
													<input type="hidden" name="pageid" value="<?=$this->registry->rewrites[1];?>"/>
												<fieldset>
												<!--[if !IE]>start table_wrapper<![endif]-->
												<div class="table_wrapper">
													<div class="table_wrapper_inner">
													<table cellpadding="0" cellspacing="0" width="100%">
														<tbody>
														<tr>
															<th style="width: 36px;">Id</th>
															<th>Клуб</th>
															<th>Название</th>
															<th>Домен</th>
															<th>Статус</th>
															<td style="width: 26px;">
														</tr>
														
														<?if(is_array($this->view->cardlist)){
														$statusarr=array(1=>'Готово к отправке',2=>'Рассматривается клубом',3=>'Принято клубом',4=>'Отклонено клубом');	
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->cardlist as $card){
														if($cnt==2)
														$cnt=0;
														if($card['domain'])
														$card['domain']='<a target="_blank" href="http://'.$card['domain'].'/">http://'.$card['domain'].'</a>';
														else
														$card['domain']='<a target="_blank" href="http://r'.$card['id'].'.reactor.ua/">http://r'.$card['id'].'.reactor.ua</a>';
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$card['id'];?></td>
															<td><a class="product_name" href="/admin/card/<?=$card['id'];?>/"><?=$card['sitename'];?></a></td>
															<td><a class="product_name" href="/admin/card/<?=$card['id'];?>/"><?=$card['name'];?></a></td>
															<td><?=$card['domain'];?></td>
															<td><?=$statusarr[$card['status']];?></td>
															<td>
																<div class="actions">
																	<ul>
																		<? if($card['status']==1){?>
																		<li><input class="radio" name="send[<?=$card['id'];?>]" type="checkbox" value="<?=$card['id'];?>" /></li>
																		<?}?>
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
												<!--[if !IE]>end table_wrapper<![endif]-->
												
												<!--[if !IE]>start table menu<![endif]-->
												<div class="table_menu">
													
													<!--<ul class="left">
														<li><a href="#" class="button add_new"><span><span>ADD NEW</span></span></a></li>
													</ul>-->
													<ul class="right">
														<!--
														<li><a href="#" class="button check_all"><span><span>CHECK ALL</span></span></a></li>
														<li><a href="#" class="button uncheck_all"><span><span>UNCHECK ALL</span></span></a></li>-->
														
														<li><button type="submit"">Отправить</button></li>
													</ul>
													
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