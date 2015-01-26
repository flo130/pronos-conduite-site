var error_msg = "Une erreur interne est survenue. Essayez de recharger la page pour recommencer.";

(function($) {
    $(document).ready(function() {
        //enable toolstips
        $('[data-toggle="tooltip"]').tooltip();
    
    
        //delays loading of images
        $("img.lazy").lazyload({
            effect : "fadeIn"
        });


        //show/hide the comment part
        $(".showComments").bind("click", function (e) {
            $(this).next(".comments").toggle("fast", function(event) {});
            return false;
        });


        //show/hide day in calendar
        $(".select-day").bind("change", function (e) {
            $(".day:not([class*='hide'])").addClass("hide");
            $("#"+$(this).val()).removeClass('hide');
        });


        //permet de d'afficher une journée par défaut. L'idéal aurai été la journée en cours...
        $("#journee-1").toggleClass("hide");
        $('.select-day option[journee-1]').attr('selected','selected');
        
        //gére le suivant / précédent du calendrier
        $(".previous, .next").bind("click", function(e) {
            //recupere la journée (xxx) à afficher en cherchant l'élément enfant "a" du "li" cliqué la structure du "li" est :
            //<li class="previous">
            //    <a class="journee-xxx">précédent</a>
            //</li>
            var dayToShow = $(this).children("a").attr("class");
            
            //on ajoute la class "hide" tous les éléments dont la class est "day" qui n'ont pas la class "hide"
            //en gros on cache la journée qui est montrée (et éventuellement s'il y a un bug celle qui seraient montrées)
            $(".day:not([class*='hide'])").addClass("hide");
            
            //on motre la journée choisie : en s'appuyant sur l'ID
            $("#" + dayToShow).toggleClass("hide");
            
            //on selectionne la journée dans la select
            $('.select-day option[' + dayToShow + ']').attr('selected','selected');
            
            //coupe le comportement standard
            return false;
        });


        //track place bet event
        $("#place-bet").on("click", function() {
            ga("send", "event", "button", "click", "place bet");
        });
        
        
        //scroll slide effect when clicking on an anchor
        $(".slide-anchor").on("click", function(e){
            e.preventDefault(); 
            var target = $(this).attr("href");
            $("html, body").stop().animate({
                scrollTop: $(target).offset().top
            }, 1000 );
        });
        
        
        //post a comment
        $(".commentForm").on("submit", function (e) {
            var match = $(this).children("input.postMatch");
            var comment = $(this).children("textarea.postComment");
            var badge = $(this).parent().prev("a").children(".badge");        
    
            if (match.val() == "") {
                alert(error_msg);
                return false;
            } 
            if (comment.val() == "") {
                alert("Le commentaire ne doit pas être vide.");
                return false;
            } 

            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.state == "success") {    
                        comment.before(response.html);
                        badge.html(parseInt(badge.html()) + 1);
                        comment.val("");    
                    } else {
                        alert(error_msg);
                    }
                }
            });
            return false;
        });
        
        
        //post a litige => vote for
        $("#litige").on("submit", function (e) {
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.state == "success") {    
                        $('#vote-ok').modal('toggle');
                    } else if (response.state == "deny") {
                        $('#vote-deny').modal('toggle');
                    } else if (response.state == "connection") {
                        $('#vote-connection').modal('toggle');
                    } else {
                        alert(error_msg);
                    }
                }
            });
            return false;
        });
        
        
        //update a litige
        $(".update-litige").on("submit", function (e) {
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                cache: false,
                dataType: "json",
                success: function(response) {
                    if (response.state == "success") {
                        location.reload();
                    } else {
                        $('#litige-update-error').modal('toggle');
                    }
                }
            });
            return false;
        });
        
        
        //create a litige => create it and not vote for it
        $(".create-litige").on("submit", function (e) {
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                cache: false,
                dataType: "json",
                success: function(response) {
                    if (response.state == "success") {
                        $(location).attr("href", "/admin/litige");
                    } else {
                        $('#litige-create-error').modal('toggle');
                    }
                }
            });
            return false;
        });
        
        
        //update an account in admin part
        $(".update-account").on("submit", function (e) {
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                cache: false,
                dataType: "json",
                success: function(response) {
                    switch (response.state) {
                        case "error_mail": 
                            $("#msg-error-mail").toggleClass("hide");
                        break;
                        
                        case "error_password": 
                            $("#msg-error-pwd").toggleClass("hide");
                        break;
                        
                        case "success": 
                            $("#msg-success").toggleClass("hide");
                            $("#inputLogin").val(response.data.login);
                            $("#inputMail").val(response.data.mail);
                        break;
                        
                        case "error": 
                            $("#msg-error").toggleClass("hide");
                        break;
                    }
                }
            });
            return false;
        });
        
      
        //get older notifications
        $("#more-notifications").on("click", function(e) {
            //show the loader
            $(".loader").toggleClass("hide");
            var link = $(this);
            
            //ajax request to get the notifications
            $.ajax({
                url: link.attr("href"),
                cache: false,
                type: "GET",
                success: function(response) {
                    //ajoute les nouvelles notif sous celle deja affichées
                    var data = $.parseJSON(response);
                    $("#notifications").append(data.html);
                   
                   //s'il n'y a plus d'éléments, on supprime le lien...   
                    if (data.html === '') {
                        link.remove();
                    } else {
                        //construction d'une nouvelle url pour récupérer les anciennes notif (les 10 suivantes)
                        var old_url = link.attr("href").split("/");
                        var start_value = Number(old_url[3]) + Number(10);
                        var end_value = Number(old_url[4]) + Number(10);
                        var new_url = "/" + old_url[1] + "/" + old_url[2] + "/" + start_value + "/" + end_value;
                        //var new_url = "/" + old_url[1] + "/" + old_url[2] + "/" + old_url[3] + "/" + end_value;
    
                        //changement de l'url
                        link.attr("href", new_url);
                    } 
                }
            });
            
            //hide the loader
            $(".loader").toggleClass("hide");
            
            return false;
        });
        

        //enable twitter bootstrap tabbable tabs via JavaScript
        $("#feeds-tab a").click(function(event) {
            event.preventDefault();
            
            //retrieve the url of the feed in the HREF of the A element
            var feedUrl = $(this).attr("href");
            //count on which LI the click occurred to show the correct one
            var itemNumber = $(this).parent().index();
            
            $(".loader").removeClass("hide");
            
            //get the feed 
            $.ajax({
                url: feedUrl,
                cache: false,
                type: "GET",
                success: function(response) {
                    var data = $.parseJSON(response);
                    $("#tab" + itemNumber).html(data.html);
                    $(".loader").addClass("hide");
                }
            });
            
            //twitter bootstrap methode to show a tab item
            $('#feeds-tab li:eq('+itemNumber+') a').tab('show');
        });
        
        //refresh the twitter tab every N seconds
        /*
        setTimeout(function(){
            refreshFeedsData();
        }, 5000);
        */
    });
})(jQuery);


//permet de rafraichir l'onglet du flux twitter
function refreshFeedsData() 
{
    $(".loader").removeClass("hide");
    $.ajax({
        url: "/home/feed/Twitter",
        cache: false,
        type: "GET",
        success: function(response) {
            var data = $.parseJSON(response);
            $("#tab0").html(data.html);
            $(".loader").addClass("hide");
        }
    });
}
