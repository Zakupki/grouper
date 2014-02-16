<!-- submenu (begin) -->
<div class="g-submenu-slim"></div>
<!-- submenu (end) -->

<!-- content (begin) -->
<div class="g-content">
    <div class="b-contacts">

        <a class="add-contact" href="#"><?=$this->registry->trans['addcontact'];?></a>

        <i class="b-label-name"><?=$this->registry->trans['title'];?></i><i class="b-label-phone"><?=$this->registry->trans['phone'];?></i><i class="b-label-email">E-mail</i>
        <ul class="b-items">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="draggable-area"></div>
                </div>

                <input class="name" type="text" value="" /><input class="phone" type="text" value="" /><input class="email" type="text" value="" />
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
    var contactsJsonList = $.parseJSON('<?=$this->view->contacts;?>'),
        contactsList = $('.b-items').sortable(),
        savingButton = $('.b-button-set .save'),
        labelName = $('.b-label-name'),
        labelPhone = $('.b-label-phone'),
        labelEmail = $('.b-label-email');

    $('.add-contact').click(function(event) {
        event.preventDefault();

        disableSave(false);
        addContact();
    });

    
    function addContact(id, name, email, phone, active) {
        var newContact = contactsList.find('.hidden').clone().removeClass('hidden').insertBefore(contactsList.find('li:first-child'));

        id ? newContact.data('id', id) : 0;

        newContact.find('.name').val(name);
        newContact.find('.phone').val(email);
        newContact.find('.email').val(phone);

        active == 0 ? newContact.find('.hide-item').attr('checked', 'checked') : 0;

        newContact.find('.delete-item').click(function(event) {
            event.preventDefault();

            contactsJsonList.deleted ? 0 : contactsJsonList.deleted = {};

            contactsJsonList.deleted[id] = id;

            newContact.remove();
        });
    };


    // Disabling saving controls
    function disableSave(disablingParam) {
        if (disablingParam) {
            savingButton.hide();
            labelName.hide();
            labelPhone.hide();
            labelEmail.hide();

        } else {
            savingButton.show();
            labelName.show();
            labelPhone.show();
            labelEmail.show();
        };
    };


    function validateContactsInputs() {
        return true;
    };

    
    savingButton.click(function() {
        if (!validateContactsInputs()) {
            return false;
        };

        $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body');
        $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');

        contactsJsonList.contacts = [];

        contactsList.find('li:visible').each(function(i) {
            contactsJsonList.contacts[i] = {};
            contactsJsonList.contacts[i].id = $(this).data('id') ? $(this).data('id') : null;
            contactsJsonList.contacts[i].name = $(this).find('.name').val();
            contactsJsonList.contacts[i].phone = $(this).find('.phone').val();
            contactsJsonList.contacts[i].email = $(this).find('.email').val();
            contactsJsonList.contacts[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
        });

        contactsJsonList.contacts.reverse();

        $.ajax({
            type: 'POST',
            url: '/admin/updatecontacts/',
            data: 'data=' + $.toJSON(contactsJsonList),
            success: function(response) {
                contactsJsonList = $.parseJSON(response);
                contactsJsonList.errorid ? errorPopup(contactsJsonList.errormessage) : init();

                $('.g-loader').remove();
                $('.g-overlay').remove();
            }
         });
    });


    // Interface init
    function init() {
        contactsList.find('li:visible').remove();

        if (contactsJsonList.contacts) {
            disableSave(false);

            $.each(contactsJsonList.contacts, function(i, item) {
                addContact(item.id, item.name, item.phone, item.email, item.active)
            });

        } else {
            disableSave(true);

        };
    };

    init();
});
</script>