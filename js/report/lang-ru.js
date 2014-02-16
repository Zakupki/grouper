var lang = {
	confirm: 'Вы уверены?',
	clubAddToFav: 'Добавить клуб в список<br>«Избранные заведения»',
	clubRemoveFromFav: 'Убрать клуб из списка<br>«Избранные заведения»',
	groupAddToFav: 'Добавить группу в список<br>«Избранные группы»',
	groupRemoveFromFav: 'Убрать группу из списка<br>«Избранные группы»',
	months: [
		['Январь', 'Января'],
		['Февраль', 'Февраля'],
		['Март', 'Марта'],
		['Апрель', 'Апреля'],
		['Май', 'Мая'],
		['Июнь', 'Июня'],
		['Июль', 'Июля'],
		['Август', 'Августа'],
		['Сентябрь', 'Сентября'],
		['Октябрь', 'Октября'],
		['Ноябрь', 'Ноября'],
		['Декабрь', 'Декабря']
	],
	weekdays: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'],
	errors:{
		requiredFields: 'Заполните обязательные поля',
		passwordsDoNotMatch: 'Пароли не совпадают'
	}
};

$.extend($.validator.messages, {
		required: 'Это поле является обязательным для заполнения.',
		remote: 'Пожалуйста, укажите другое значение для этого поля.',
		email: 'Пожалуйста, укажите правильный адрес E-mail.',
		url: 'Пожалуйста, укажите правильный URL.',
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


/* jQuery UI date picker */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Нед',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});


$.datepicker.regional['ru'] = {
	closeText: 'Закрыть',
	prevText: '<Пред',
	nextText: 'След>',
	currentText: 'Сегодня',
	monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
	'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
	'Июл','Авг','Сен','Окт','Ноя','Дек'],
	dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	weekHeader: 'Не',
	dateFormat: 'dd.mm.yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['ru']);


$.timepicker.regional['ru'] = {
	timeOnlyTitle: 'Выберите время',
	timeText: 'Время',
	hourText: 'Часы',
	minuteText: 'Минуты',
	secondText: 'Секунды',
	millisecText: 'Миллисекунды',
	timezoneText: 'Часовой пояс',
	currentText: 'Сейчас',
	closeText: 'OK',
	timeFormat: 'HH:mm',
	amNames: ['AM', 'A'],
	pmNames: ['PM', 'P'],
	isRTL: false
};
$.timepicker.setDefaults($.timepicker.regional['ru']);
