$(function () {
    var $itemsIndexView = $('.js-masonry-indexView');

    $itemsIndexView.imagesLoaded(function () {
        $itemsIndexView.masonry({
            itemSelector: '.js-item',
            columnWidth: 305,
            fitWidth: true,
        });
    });
});

$(function () {
    var $tagsSearchView = $('.js-masonry-tagsSearchView');

    $tagsSearchView.imagesLoaded(function () {
        $tagsSearchView.masonry({
            itemSelector: '.js-item',
            columnWidth: 305,
            // fitWidth: true,
        });
    });
});
