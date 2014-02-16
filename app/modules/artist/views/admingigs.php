<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-gigs">

        <a class="add-gig" href="#"><?=$this->registry->trans['addevent'];?></a>

        <i class="b-label-place"><?=$this->registry->trans['place'];?></i><i class="b-label-city"><?=$this->registry->trans['country'];?>, <?=strtolower($this->registry->trans['city']);?></i>

        <ul class="b-giglist">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a>
                </div>

                <div class="date">
                    <a href="#" class="picker"><?=$this->registry->trans['date'];?></a>
                    <input type="text" class="datepicker with-bg" value="" readonly="readonly" />
                </div><input class="place" type="text" value="" />
                <input class="city" type="text" value="" />
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
$().ready(function() {
    var gigsJsonList = $.parseJSON('<?=$this->view->giglist;?>'),
        gigsList = $('.b-giglist'),
        savingButton = $('.b-button-set .save'),
        labelPlace = $('.b-label-place'),
        labelCity = $('.b-label-city'),
        existingItemDeleted = 0;

    
    // Adding new gig container
    $('.add-gig').click(function(event) {
        event.preventDefault();

        var todaysDate = new Date(),
        gigMonth = ((todaysDate.getMonth() + '').length == 1) ? ('0' + (todaysDate.getMonth() + 1 + '')) : (todaysDate.getMonth() + 1),
        gigFullDate = todaysDate.getDate() + '.' + gigMonth + '.' + todaysDate.getFullYear();

        disableSave(false);
        addGig(null, gigFullDate, '', '', 1);
    });


    // Adding existing event
    function addGig(id, date, city, place, active) {
        var newGigContainer = gigsList.find('.hidden').clone().removeClass('hidden').insertBefore(gigsList.find('li:first-child'));

        id ? newGigContainer.data('id', id) : 0;

        newGigContainer.find('.datepicker').val(date);
        newGigContainer.find('.city').val(city);
        newGigContainer.find('.place').val(place);

        (active == 0) ? newGigContainer.find('.hide-item').attr('checked', 'checked') : 0;

        newGigContainer.find('.delete-item').click(function(event) {
            event.preventDefault();
            newGigContainer.remove();

            if (gigsList.find('li:visible').length == 0) {
                labelPlace.hide();
                labelCity.hide();
            };

            id || gigsList.find('li:visible').data('id') ? existingItemDeleted = 1 : 0;
            existingItemDeleted == 0 && gigsList.find('li:visible').length == 0 ? savingButton.hide() : 0;
        });

        calendarInit(newGigContainer);
    };

    
    // Disabling saving controls
    function disableSave(disablingParam) {
        if (disablingParam) {
            savingButton.hide();
            labelPlace.hide();
            labelCity.hide();

        } else {
            savingButton.show();
            labelPlace.show();
            labelCity.show();
        };
    };


     // Calendar
    function calendarInit(calendarContainer) {
        var dateToPick = calendarContainer.find('.datepicker'),
            anotherPickerTriggerButton = calendarContainer.find('.picker')
    
        dateToPick.datepicker({
            dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            firstDay:1,
            dateFormat: 'dd.mm.yy'
        });

        anotherPickerTriggerButton.click(function(event) {
            event.preventDefault;
            dateToPick.datepicker('show');
        });
    };


    // JSON saving
    savingButton.click(function() {
        if (!validateGigsInputs()) {
            return false;
        };

        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        gigsJsonList.gigs = [];

        gigsList.find('li:visible').each(function(i) {
            gigsJsonList.gigs[i] = {};
            gigsJsonList.gigs[i].id = $(this).data('id') ? $(this).data('id') : null;
            gigsJsonList.gigs[i].date_start = $(this).find('.datepicker').val();
            gigsJsonList.gigs[i].city = secureString($(this).find('.city').val());
            gigsJsonList.gigs[i].place = secureString($(this).find('.place').val());
            gigsJsonList.gigs[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
        });

        gigsJsonList.gigs.reverse();

        $.ajax({
            type: 'POST',
            url: '/admin/updategigs/',
            data: 'data=' + $.toJSON(gigsJsonList),
            success: function(response) {
                gigsJsonList = $.parseJSON(response);
                gigsJsonList.errorid ? errorPopup(gigsJsonList.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });


    // Validating gigs inputs
    function validateGigsInputs() {
        var isValid = true;
        
        gigsList.find('li:visible').each(function(i) {
            var gigCity = $(this).find('.city'),
                gigPlace = $(this).find('.place');

            if ((gigCity.val() == '') && (gigPlace.val() == '')) {
                isValid = false;
                gigCity.css('background-color', '#FF8989');
                gigPlace.css('background-color', '#FF8989');
            };
        });
        
        return isValid;
    };
    

    // Interface init
    function init() {
        existingItemDeleted = 0;
        
        if (gigsJsonList.gigs) {
            disableSave(false);
            gigsList.find('li:visible').remove();

            $.each(gigsJsonList.gigs, function(i, item) {
                addGig(item.id, item.date_start, item.city, item.place, item.active)
            });

        } else {
            disableSave(true);
        };
    };

    
    init();
});
</script>