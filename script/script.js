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
        pauseOnHover: true,
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


    // Small carousel with manual navigation using arrow controls
    $('.small-carousel-slide').slick({
        infinite: true,
        slidesToShow: 1, // Set to 6 to scroll 6 images at a time
        slidesToScroll: 1, // Set to 6 to scroll 6 images at a time
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        centerMode: false,
        variableWidth: true,
        pauseOnHover: false,
        pauseOnFocus: false,
        pauseOnDotsHover: false,
    });

    //1
    $('#slideprev-1').on('click', function(){
        $('#slide-1').slick('slickPrev');
    });

    $('#slidenext-1').on('click', function(){
        $('#slide-1').slick('slickNext');
    });

    //2
    $('#slideprev-2').on('click', function(){
        $('#slide-2').slick('slickPrev');
    });

    $('#slidenext-2').on('click', function(){
        $('#slide-2').slick('slickNext');
    });

    //3
    $('#slideprev-3').on('click', function(){
        $('#slide-3').slick('slickPrev');
    });

    $('#slidenext-3').on('click', function(){
        $('#slide-3').slick('slickNext');
    });

    //4
    $('#slideprev-4').on('click', function(){
        $('#slide-4').slick('slickPrev');
    });

    $('#slidenext-4').on('click', function(){
        $('#slide-4').slick('slickNext');
    });

    //5
    $('#slideprev-5').on('click', function(){
        $('#slide-5').slick('slickPrev');
    });

    $('#slidenext-5').on('click', function(){
        $('#slide-5').slick('slickNext');
    });

    //6
    $('#slideprev-6').on('click', function(){
        $('#slide-6').slick('slickPrev');
    });

    $('#slidenext-6').on('click', function(){
        $('#slide-6').slick('slickNext');
    });

    //7
    $('#slideprev-7').on('click', function(){
        $('#slide-7').slick('slickPrev');
    });

    $('#slidenext-7').on('click', function(){
        $('#slide-7').slick('slickNext');
    });

});

