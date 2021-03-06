var lang = {
    accountActivated: 'Вы успешно активировали свою учётную запись.',
    transferConfirm: 'Вы уверены, что хотите передать этот реккаунт другому пользователю?',
    transferCancelConfirm: 'Вы уверены, что хотите отменить передачу этого реккаунта другому пользователю?',
};



/* Validator
----------------------------------------------- */
$.extend($.validator.messages, {
		required: 'Это поле является обязательным для заполнения.',
		remote: 'Пожалуйста, укажите другое значение для этого поля.',
		email: 'Пожалуйста, укажите правильный адрес E-mail.',
		url: 'Пожалуйста, укажите пправильный URL.',
		date: 'Пожалуйста, укажите правильную дату',
		dateISO: 'Пожалуйста, укажите правильную дату в формате ISO.',
		number: 'Пожалуйста, укажите правильный номер.',
		digits: 'Пожалуйста, укажите только цифры.',
		creditcard: 'Пожалуйста, укажите правильный номер кредитной карты.',
		equalTo: 'Пожалуйста, укажите значение повторно.',
		accept: 'Пожалуйста, укажите правильное расширение файла.',
		maxlength: $.validator.format('Пожалуйста, введите не более {0} символов.'),
		minlength: $.validator.format('Пожалуйста, введите не менее {0} символов.'),
		rangelength: $.validator.format('Пожалуйста, введите значение длинной не менее {0} и не более {1} символов.'),
		range: $.validator.format('Пожалуйста, введите значение не менее {0} и не более {1}.'),
		max: $.validator.format('Пожалуйста, введите значение не более {0}'),
		min: $.validator.format('Пожалуйста, введите значение не менее {0}'),
		latnum: 'Пожалуйста, используйте только латиницу и цифры'
});