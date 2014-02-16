<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Сайты</h2>
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
															<th></th>
															<th>Название</th>
															<? if($this->registry->action=='club'){?>
															<th>Город</th>
															<th>Анкета</th>
															<?}?>
															<th>Автор</th>
															<th>Email</th>
															<th>Тип</th>
															<th>Домен</th>
															<th style="width: 90px;">Рекомендуемый</th>
														</tr>
														
														<? if(is_array($this->view->sitelist)){
														$linecss=array(0=>'first', 1=>'second');
														$cnt=0;
														foreach($this->view->sitelist as $site){
														if($cnt==2)
														$cnt=0;
														if($site['domain'])
														$site['domain']='<a target="_blank" href="http://'.$site['domain'].'/">http://'.$site['domain'].'</a>';
														else
														$site['domain']='<a target="_blank" href="http://r'.$site['id'].'.reactor.ua/">http://r'.$site['id'].'.reactor.ua</a>';
														if($site['url'])
														$site['url']='<a class="product_thumb" href="/admin/site/'.$site['id'].'/"><img src="'.$site['url'].'"/></a>';
														?>
														<tr class="<?=$linecss[$cnt];?>">
															<td><?=$site['id'];?></td>
															<td class="photo"><?=$site['url'];?></td>
															<td><a class="product_name" href="/admin/site/<?=$site['id'];?>/"><?=$site['name'];?></a></td>
															<? if($this->registry->action=='club'){?>
															<td><?=$site['cityname'];?></td>
															<td><? if($site['formid']>0){?><span class="approved">&nbsp;</span><?}?></td>
															<?}?>
															<td><a href="/admin/user/<?=$site['userid'];?>/"><?=$site['login'];?></a></td>
															<td><?=$site['email'];?></td>
															<td><?=$site['sitetype'];?></td>
															<td><?=$site['domain'];?></td>
															<td><? if($site['recommend']){?><span class="approved">&nbsp;</span><?}?></td>
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
													
													<ul class="left">
														<li><a href="/admin/site/?type=<?=$this->registry->action;?>" class="button add_new"><span><span>Добавить</span></span></a></li>
													</ul>
													<!--
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