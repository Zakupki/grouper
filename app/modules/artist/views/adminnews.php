<!-- submenu (begin) -->
    <div class="g-submenu-slim"></div>
<!-- submenu (end) -->
	
<!-- content (begin) -->
<div class="g-content">
    <div class="b-news-edit">
        <a class="add-news" href="#"><?=$this->registry->trans['add'];?> <?=$this->registry->trans['new'];?></a>

        <ul class="b-news">
            <li class="hidden">
                <div class="options">
                    <label><input class="hide-item" type="checkbox"> <?=$this->registry->trans['hide'];?></label><a href="#" class="delete-item"><?=$this->registry->trans['delete'];?></a><div class="separator"></div><a href="#" class="edit-item"><?=$this->registry->trans['edit'];?></a>
                </div>
                <a href="#"><img class="preview" src="/img/artist/admin/icon-news-default.jpg" width="40" height="40" /></a><div class="description">
                    <div class="title"></div>
                    <div class="date"></div>
                </div>
            </li>
        </ul>

        <div class="b-button-set">
            <button class="save-news"><?=$this->registry->trans['save'];?></button>
        </div>
    </div>
</div>
<!-- content (end)-->

<script type="text/javascript">
    var news = $.parseJSON('<?=$this->view->newslist;?>'),
        newsContainer = $('.b-news-edit .b-news'),
        saveButton = $('.save-news');
    
    $('.b-news-edit .add-news').click(function(event) {
        event.preventDefault();
        window.location = '/admin/addnews/';
    });
    

    
    function addNewsItem(id, itemid, name, langid, active, date_start, incut, url) {
        var newsItem = newsContainer.find('.hidden').clone().removeClass('hidden').appendTo(newsContainer);
        
        newsItem.data('id', id);
        newsItem.data('itemid', itemid);
        newsItem.data('langid', langid);
        newsItem.data('incut', incut);

        if (name.length > 80) {
            newsItem.find('.title').html(name.substr(0, 80) + '...');
        } else {
            newsItem.find('.title').html(name);
        };
        newsItem.find('.date').html(date_start);
        newsItem.find('.preview').attr('src', url);
        newsItem.find('.preview').parent().attr('href', '/admin/news/' +itemid);
        newsItem.find('.edit-item').attr('href', '/admin/news/' +itemid);
        newsItem.find('.delete-item').click(function(event) {
            event.preventDefault();

            if (id) {
                news.deleted ? 0 : news.deleted = {};
                news.deleted[id] = {};
                news.deleted[id].itemid = itemid;
            };
            
            newsItem.remove();
        });
        
        active == '0' ? newsItem.find('.hide-item').attr('checked', 'checked') : 0;
    };
    
    saveButton.click(function() {
        var overlay = $('<div></div>').addClass('g-overlay').height($(document).height()).appendTo('body'),
            loader = $('<div></div>').addClass('g-loader').css({'top' : $(document).height() / 2 - 20}).appendTo('body');
        
        news.news = {};
        newsContainer.find('li:visible').each(function(i) {
            news.news[i] = {};
            news.news[i].id = $(this).data('id');
            news.news[i].itemid = $(this).data('itemid');
            news.news[i].langid = $(this).data('langid');
            news.news[i].preview = secureString($(this).find('.title').html());
            news.news[i].active = $(this).find('.hide-item').attr('checked') ? 0 : 1;
        });

        $.ajax({
            type: 'POST',
            url: '/admin/updatenews/',
            data: 'data=' + $.toJSON(news),
            success: function(response){
                news = $.parseJSON(response);
                news.errorid ? errorPopup(news.errormessage) : init()
                
                overlay.remove();
                loader.remove();
            }
        });
    });
    
    function init() {
        newsContainer.find('li:visible').remove();
        
        if (news.news) {
            saveButton.show();

            $.each(news.news, function(i, item) {
                addNewsItem(item.id, item.itemid, item.name, item.langid, item.active, item.date_start, item.incut, item.url);
            });
        } else {
            saveButton.hide();
        };
    };
    
    init();
</script>