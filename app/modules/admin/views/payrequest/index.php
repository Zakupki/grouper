<div class="section table_section">
    <!--[if !IE]>start title wrapper<![endif]-->
    <div class="title_wrapper">
        <h2>Вывод денег</h2>
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
                                                    <th>Фамилия/Имя</th>
                                                    <th>Id пользователя</th>
                                                    <th>email</th>
                                                    <th>Аккаунт</th>
                                                    <th>Сумма</th>
                                                    <th>Доступно</th>
                                                    <th>Комментарий</th>
                                                    <th>Дата запроса</th>
                                                    <th style="width: 120px;">Статус</th>
                                                </tr>
                                                <? if(is_array($this->view->list['list'])){
                                                    $linecss=array(0=>'first', 1=>'second');
                                                    $cnt=0;
                                                    foreach($this->view->list['list'] as $row){
                                                        if($cnt==2)
                                                            $cnt=0;
                                                        $row['balance']=$this->view->list['balances'][$row['userid']]-$this->view->list['reserved'][$row['userid']];
                                                        ?>
                                                        <tr class="<?=$linecss[$cnt];?>">
                                                            <td><?=$row['id'];?></td>
                                                            <td><?=$row['firstname'];?> <?=$row['name'];?></td>
                                                            <td><?=$row['userid'];?></td>
                                                            <td><?=$row['email'];?></td>
                                                            <td><?=$row['account'];?></td>
                                                            <td><?=$row['value'];?></td>
                                                            <td><?=$row['balance'];?></td>
                                                            <td><?=$row['detail_text'];?></td>
                                                            <td><?=$row['date_create'];?></td>
                                                            <td><?
                                                                if($row['confirm']){
                                                                    echo 'выполнено';
                                                                }else{
                                                                    if($row['balance']<$row['value']){
                                                                        echo 'не хватает средств';
                                                                    }else
                                                                        echo '<a href="/admin/payrequest/?confirm='.$row['id'].'"/>подтвердить</a>';
                                                                };?>
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