$(document).ready(function () {
    bookAdd = function bookAdd(){
        $("#clear_button").trigger('click');
        $("#form-title").html('<i class="fa fa-plus"></i> Add  New Book');
        $("#save_book").html('Save');
        $('#entry-form').modal('show');
    }
    $("#course_name").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: url+'/course-autosuggest/Admin',
                dataType: "json",
                type: "post",
                async:false,
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        appendTo : $('#entry-form'),
        minLength: 2,
        select: function(event, ui) {
            var id = ui.item.id;
            $(this).next().val(id);
        },
    });
    $("#course_name").on('click',function(){
        $(this).val("");
        $(this).next().val("");
    });
});
