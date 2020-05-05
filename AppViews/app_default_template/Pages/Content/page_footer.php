<!-- Lightslider -->
<script src="/Public/InsideAdmin/inside_admin_template/js/lightslider/js/lightslider.js"></script>
<!-- Lightgallery -->
<script src="/Public/InsideAdmin/inside_admin_template/js/lightGallery/dist/js/lightgallery.min.js"></script>
<script src="/Public/InsideAdmin/inside_admin_template/js/lightGallery/dist/js/lg-video.min.js"></script>

<script type="text/javascript">(function() {
        if (window.pluso)if (typeof window.pluso.start == "function") return;
        if (window.ifpluso==undefined) { window.ifpluso = 1;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
            var h=d[g]('body')[0];
            h.appendChild(s);
        }})();
</script>


<script>
    $('#comment_post').on('click', function(){


        if ($('#comment').val() == '') {
            $('#comment').addClass('red_border');
            $('.comment_msg').removeClass('green');
            $('.comment_msg').addClass('red');
            $('.comment_msg').html('Комментарий не может быть пустым!');
            setTimeout(function() {
                $('.comment_msg').html('');
            }, 5000);
        }
        else {
            var options = {
                url: "/info/ajax_add_comment/",
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == "success") {

                        $('.comment_msg').removeClass('red');
                        $('.comment_msg').addClass('green');
                        $('.comment_msg').html(obj.message);
                        //$('#comment_post').hide();
                    } else {
                        $('.comment_msg').removeClass('green');
                        $('.comment_msg').addClass('red');
                        $('.comment_msg').html(obj.message);

                    }

                    setTimeout(function() {
                        $('.comment_msg').html('');
                    }, 5000);
                }
            };
            $("#comment_form").ajaxSubmit(options);
        }
    });

    $(document).ready(function() {
        $("#lightSlider").lightSlider({
            adaptiveHeight:true,
            enableDrag: false,
            pager: false,
            prevHtml: '<i aria-hidden="true" style="font-size: 40px; color: black;" class="ion-android-arrow-back"></i>',
            nextHtml: '<i aria-hidden="true" style="font-size: 40px; color: black;" class="ion-android-arrow-forward"></i>'
        });

        $('#lightSlider').lightGallery({
            thumbnail:true,
            animateThumb: false,
            showThumbByDefault: false
        });
    });
</script>