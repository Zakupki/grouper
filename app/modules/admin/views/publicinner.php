<div class="section table_section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Группы запроса</h2>
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
														<tbody><tr>
															<th style="width: 36px;">Id</th>
															<th>Название</th>
															<th>E-mail</th>
                                                            <th style="width: 100px;">Цена</th>
                                                            <th>Отчет</th>
															<th style="width: 100px;">Статус</th>
															<th style="width: 40px;">Оплачено</th>
														</tr>
														<? if(is_array($this->view->groups)){
														$linecss=array(0=>'first', 1=>'second');
                                                        $statusArr=array(1=>'Новый', 2=>'Отклоненный', 3=>'Принятый');
                                                        $stateArr=array(0=>'Нет', 1=>'Да');
														$cnt=0;
														foreach($this->view->groups as $group){
														?>
                                                        <tr class="<?=$linecss[$cnt];?>">
															<td><?=$group['id'];?></td>
                                                            <td><?=$group['name'];?></td>
															<td><?=$group['email'];?></td>
                                                            <td><?=$group['price'];?></td>
                                                            <td><?=(strlen($group['link'])>0)?'<a href="">'.$group['link'].'</a>':'';?></td>
                                                            <td><?=$statusArr[$group['status']];?></td>
															<td><?=$stateArr[$group['payed']];?></td>
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
												<?=$this->view->pager;?>

												<div class="table_menu">
													
													<!--<ul class="left">
														<li><a href="/admin/user/" class="button add_new"><span><span>ADD NEW</span></span></a></li>
													</ul>-->

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