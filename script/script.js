$(document).ready(function(){
    // Large carousel with continuous auto-scrolling
    $('.carousel-slide').slick({
        infinite: true,
        slidesToShow: 3, // Set to 6 to scroll 6 images at a time
        slidesToScroll: 1, // Set to 6 to scroll 6 images at a time
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        centerMode: true,
        variableWidth: true,
        pauseOnHover: false,
        pauseOnFocus: false,
        pauseOnDotsHover: false,
    });

    // Small carousel with manual navigation using arrow controls
    $('.small-carousel-slide').slick({
        infinite: true,
        slidesToShow: 5, // Set to 6 to scroll 6 images at a time
        slidesToScroll: 5, // Set to 6 to scroll 6 images at a time
        arrows: false,
        variableWidth: true,
        pauseOnHover: false,
        pauseOnFocus: false,
        pauseOnDotsHover: false,
    });

    // Add click event listeners for arrow controls
    $('.carousel-prev').on('click', function(){
        $('.carousel-slide').slick('slickPrev');
    });

    $('.carousel-next').on('click', function(){
        $('.carousel-slide').slick('slickNext');
    });

    $('.small-carousel-prev').on('click', function(){
        $('.small-carousel-slide').slick('slickPrev');
    });

    $('.small-carousel-next').on('click', function(){
        $('.small-carousel-slide').slick('slickNext');
    });
});

