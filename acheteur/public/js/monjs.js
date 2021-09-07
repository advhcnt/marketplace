$(function() {

    /*$("#image1").slideUp(10000, function() {
        /modification de la class de image2/
        var visibilite = $('#image2').attr("class");
        var image1 = visibilite;
        var modification = visibilite.split(" ");
        modification[4] = "show";
        modification = modification.join(" ");
        console.log(image1);
        $("#image1").attr("class", image1);
        $("#image2").attr("class", modification);


        $('#image2').slideUp(100000,
            function() {
                /modification de la class de image2 /
                var visibilite = $('#image3').attr("class");
                var image2 = visibilite;
                var modification = visibilite.split(" ");
                modification[4] = "show";
                modification = modification.join(" ");
                console.log(modification);
                $("#image2").attr("class", image2);
                $('#image3').slideUp(10000, );
                $("#image3").attr("class", modification);

            }
        );
        $("#image1").slideToggle(10000);
    $("#image2").slideToggle(10000);
    $("#image3").slideToggle(10000);
     $("#body").mouseenter(function() {
        $(".text_carousel").slideToggle(10000);
    });


    });*/
    $('.carousel').carousel();


    $(".toucher").hover(function() {
        $("#toucher").attr("class", "well well-lg show")
    });

    $("#toucher").mouseleave(function() {
        $("#toucher").attr("class", "well well-lg hide")
    });

    $(".touche").hover(function() {
        $("#touche").attr("class", "well well-lg show")
    });



    $("#touche").mouseleave(function() {
        $("#touche").attr("class", "well well-lg hide")
    });


    $(".home").hover(function() {
        $("#home").attr('class', "tooltip bs-tooltip-left  show");

    });

    $(".home").mouseleave(function() {
        $("#home").attr('class', "tooltip bs-tooltip-left  hide");

    });

    $("#home").mouseleave(function() {
        $("#home").attr('class', "tooltip bs-tooltip-left  hide");

    });
    $("#home").mouseenter(function() {
        $("#home").attr('class', "tooltip bs-tooltip-left  show");

    })





});