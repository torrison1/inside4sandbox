<!-- jquery ui
<link rel="stylesheet" href="/files/admin/js/jquery-ui-1.12.1/jquery-ui.css">
<script src="/files/admin/js/jquery-ui-1.12.1/jquery-ui.js"></script>
-->

<script>
    $(function(){
        $('.show-list-search-input').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: '/content/ajaxPostShowListSearch/',
                    dataType: 'json',
                    data: {q: request.term},
                    success: function (data) {
                        response(data.map(function (value) {
                            return {
                                value: value.content_name,
                                label: value.content_name,
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                $(this).val(ui.item.value);
                $('.showListFilterForm').submit();
            },
            minLength: 2
        });
    });
</script>