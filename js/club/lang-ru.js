/* lang */
var lang = {
    confirm: 'Вы уверены?',
    commentsRemoveConfirm: 'Вы уверены, что хотите удалить комментарий?',
    basicAdminTurnOnConfirm: 'Вы уверены, что хотите включить реккаунт?',
    basicAdminTurnOffConfirm: 'Вы уверены, что хотите выключить реккаунт?',
    teasersAdminRemoveConfirm: 'Вы уверены, что хотите удалить баннер?',
    eventAdminAvatarRemoveConfirm: 'Вы уверены, что хотите удалить аватар?',
    eventAdminPosterRemoveConfirm: 'Вы уверены, что хотите удалить постер?',
    eventAdminRemoveConfirm: 'Вы уверены, что хотите удалить это событие?',
    videoAdminVideoRemoveConfirm: 'Вы уверены, что хотите удалить это видео?',
    videoAdminPreviewRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
    trackAdminTrackRemoveConfirm: 'Вы уверены, что хотите удалить трек?',
    trackAdminCoverRemoveConfirm: 'Вы уверены, что хотите удалить обложку?',
    galleryAdminGalleryRemoveConfirm: 'Вы уверены, что хотите удалить галерею?',
    galleryAdminImageRemoveConfirm: 'Вы уверены, что хотите удалить фото?',
    uploadLimitExceeded: 'Ваш лимит загрузок исчерпан',
    uploadLimitFrom: 'из',
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
    weekdays: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье']
};

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