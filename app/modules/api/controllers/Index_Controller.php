<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Index_Controller Extends Base_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}

        function indexAction() {
        	echo '
        	<h3>Запрос клубов</h3>
        	<br/>
        	формат запроса - GET
        	<br/>
        	формат ответа - JSON
        	<br/>
        	URL - http://api.reactor.ua/clubs/?start=1&take=10&cityid=1&countryid=1
        	<br/>
        	start - начало выборки
        	<br/>
        	take - количество выдачи (максимально 20 клубов)
			<br/>
			cityid - id города
        	<br/>
        	countryid - id страны
        	';
        }
}
?>