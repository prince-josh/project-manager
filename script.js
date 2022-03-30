$('.update-slider1').hide();
$('.update-slider2').hide();
$('.update-slider3').hide();
$('document').ready(function () {
       
        $('.update-toggler1').click(function () {
            $('.update-slider1').toggle(500);
        })

        $('.update-toggler2').click(function () {
            $('.update-slider2').toggle(500);
        })

        $('.update-toggler3').click(function () {
            $('.update-slider3').toggle(500);
        })
    });