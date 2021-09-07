function bs_input_file() {
    $(".input-file").before(
        function() {
            if (!$(this).prev().hasClass('input-ghost')) {
                var element = $("<input type='file' class='input-ghost multiple' style='visibility:hidden; height:0' multiple>");
                element.attr("name", $(this).attr("name"));
                element.change(function() {
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function() {
                    element.click();
                });

                $(this).find('input').css("cursor", "pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();


});


$("#formulaire2").change(function() {

    var i = $("#toto").val();
    if (i != "0") {
        $("#message2").attr("class", "hidden");
    }
});

$("#formulaire1").change(function() {
    var b = $("#toto1").val();
    if (b != "0") {
        $("#message1").attr("class", "hidden");
    }

});