
<!-- Scripts Libraries-->
<script src="/Public/InsideAdmin/inside_admin_template/js/jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="/Public/InsideAdmin/inside_admin_template/js/bootstrap-3.3.7/js/bootstrap.js"></script>
<script src="/Public/InsideAdmin/inside_admin_template/js/bootstrap-select-1.12.2/bootstrap-select.js"></script>

<script src="/Public/InsideAdmin/inside_admin_template/inside/js/bootstrap-typeahead.min.js"></script>

<!-- Add timepicker -->
<script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-sliderAccess.js"></script>

<!-- Geo complete -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$GLOBALS['inside4_main_config']['Website']['google_maps_key']?>&libraries=places&language=ru&region=RU" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

<script src="/Public/InsideAdmin/inside_admin_template/inside/js/jquery.form.js"></script>
<script src="/Public/InsideAdmin/inside_admin_template/inside/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="/Public/InsideAdmin/inside_admin_template/inside/js/inside_framework.js"></script>

<!-- Code highliter -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-language_tools.js"></script>

<script src="/Public/InsideAdmin/inside_admin_template/inside/js/autosize/autosize.js" type="text/javascript"></script>

<!-- Custom Scripts files -->
<script src="/Public/InsideAdmin/inside_admin_template/js/scripts.js" type="text/javascript"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.js"></script>
-->
<script>
    $( document ).ready(function() {

        // Sidebar Menu
        var toggle = true;
        $(".sidebar-icon").on( "click", function() {
            $(".sidebar-icon .fa").toggleClass("fa fa-times fa fa-bars");
            if (toggle){
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                $("#menu span").css({"position":"relative"});
                $(".submenu_icon").removeClass("fa-angle-up").addClass("fa-angle-down");
            }else{
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $(".submenu").slideUp();
                $(".submenu_icon").removeClass("fa-angle-up").addClass("fa-angle-down");
                setTimeout(function() {
                    $("#menu span").css({"position":"absolute"});
                }, 400);
            }
            toggle = !toggle;
        });

        $(".submenu_toggle").on( "click", function() {
            $(this).parent().next().slideToggle();
            $(this).parent().find(".submenu_icon").toggleClass("fa-angle-up fa-angle-down");

        });

        // Advanced filters
        $(".filters_button").on( "click", function() {
            $(".advanced_filters").slideToggle("fast").toggleClass("overflow_hide");
        });

        $(".advanced_filters .cloce_btn").on( "click", function() {
            $(".advanced_filters").slideUp("fast");
            $('body').removeClass('overflow_hide');
        });

        $(".mob_filrer_btn").on( "click", function() {
            $(".advanced_filters").slideDown("fast");
            $('body').addClass('overflow_hide');
        });

        // Datepicker
        $(".has_datepicker").datepicker();

        $("#menu input.menu_search").on("keyup", function(e){

            if (e.keyCode == 13) {
                return false;
            }

            var that = $(this);
            var id = 'menu_search';
            var query = $(this).val();
            // Box Shadow
            var blue = 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6)';
            var red = 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(208,28,28,.6)';

            if (pdg_timer[id] !== undefined) clearTimeout(pdg_timer[id]);
            pdg_timer[id]=setTimeout(function(){

                if(query != '') {
                    $.get("/admin/ajax/menu_search/?query=" + encodeURI(query), function (data) {

                        var obj = $.parseJSON(data);

                        // alert(obj.html);
                        if (obj.html !== '') {
                            that.css('box-shadow', blue);
                            $('.inside_menu_search').html(obj.html);
                            $('.inside_menu').hide();
                        } else {

                            if (query != '') {
                                that.css('box-shadow', red);
                            } else {
                                that.css('box-shadow', blue);
                            }

                            $('.inside_menu_search').html('');
                            $('.inside_menu').show();
                        }
                    });
                } else {
                    $('.inside_menu_search').remove();
                    $('.inside_menu').show();
                    that.css('box-shadow', blue);
                }

            },700);
        });

        $('header input.top_search').typeahead({
            ajax: '/admin/ajax/menu_search_type/',
            displayField: 'name',
            valueField: 'id',
            onSelect: function(data){
                dump_alert(data);
                //location.href = data.value;

            }
        });

    });
</script>

<script>

    // Debug Function
    function dump_alert(obj) {
        var out = "";
        if(obj && typeof(obj) == "object"){
            for (var i in obj) {
                out += i + ": " + obj[i] + "\n";
            }
        } else {
            out = obj;
        }
        alert(out);
    };

</script>