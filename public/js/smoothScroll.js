function scrollToElement (selector) {
    $('html, body').animate({
        scrollTop: $(selector).offset().top
    }, 1000);
};

$(document).on('click', 'a.headerArrow', function () {
    scrollToElement($(this).attr('href'));
});

$(document).on('click', 'a.footerArrow', function () {
    scrollToElement($(this).attr('href'));
});

$(document).on('click', 'a.loaderIcon', function () {
    scrollToElement($(this).attr('href'));
});