$(function(){
    var audiopath = "/uploads/sites/2/mp3/";

    // Playlist
    var playlistData = [
        {
            artist:'Twin Shadow',
            title:'Slow',
            url: audiopath+'537126079b218d4976dfbf8fdd3e6b15.mp3'
        },
        {
            artist:'Kavinsky',
            title:'Testarossa Autodrive (SebastiAn Remix)',
            url: audiopath+'9e0a2a1f72cd950de21ab9d85b2cf034.mp3'
        }
    ];
    
    // Player init
    $('.g-player').thatplayer({
        playlist: playlistData,
        volume: 100,
        autoplay: false
    });
    
    // Playlist changing example
    //$('.g-player').thatplayer('playlist', playlist2, true);
});

