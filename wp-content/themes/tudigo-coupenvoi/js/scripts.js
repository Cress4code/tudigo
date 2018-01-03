$(document).ready(function ($  ) {


    $("#second-to-show").hide();
    $("#confirmationText").hide();


    var dataId


    $(".voteUp").click(function () {
        dataId = $(this).data("id");

        $("#modal1").modal();
    });

    var hasregistrerd = 1;

    $("#saveEmailVoting").submit(function (e) {

        e.preventDefault();
        var email = $("#email").val();
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        var datedenaissance = $("#datedenaissance").val();
        var zipCode = $("#zipCode").val();
        var civility = $("#civility").val();
        var canBeSubmitted = false;
        if (email !== "" && nom !== "" && prenom !== "" && datedenaissance !== "" && zipCode !== "" && civility !== "") {
            canBeSubmitted = true;
        } else {
            canBeSubmitted = false;
        }

        if (validateEmail(email)) {
            var formData
            var custom_action;
            if (hasregistrerd == 1) {
                custom_action = "chk";
                formData = {
                    email: email,
                    post_id: dataId,
                };
            } else {
                custom_action = "sve";
                if (canBeSubmitted == true) {
                    formData = {
                        email: email,
                        nom: nom,
                        prenom: prenom,
                        datedenaissance: datedenaissance,
                        zipCode: zipCode,
                        civility: civility,

                        post_id: dataId

                    }

                }

            }

            $.ajax({
                dataType: "json",
                url: voteurscript.ajax_url,
                type: 'post',
                data: {
                    action: 'voting_xhr',
                    custom_action: custom_action,
                    form_data: formData
                },
                success: function (response) {
                    console.log(response);

                    if (response.CODESTATUS == 0) {
                        //$("#first-to-show").hide();
                        $('.modal-title').text(" COMPLETE ALL THE FOLLOWING FIELDS .")
                        $("#second-to-show").show();
                        hasregistrerd = 0;


                    }

                    if (response.CODESTATUS == 1) {
                        //have votedTODAY
                        hasregistrerd = 1;
                        $('.error').text("You can't vote again Today . Come Back Tomorrow  ");


                    }
                    if (response.CODESTATUS == 2) {
                        //have VOTESAVED
                        hasregistrerd = 1;
                        $('.modal-title').text("\n" +
                            "YOUR REGISTRATION IS COMPLETE");
                        $("#saveEmailVoting").hide();
                        $("#confirmationText").show();


                    }


                }
            });


        } else {
            alert("email invalide")
        }


    });

    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test(email);
    }


    $('select').material_select();

    //DROPIFY

    $('.dropify').dropify();

    $("path, polyline").hover(function (e) {
        $('#info-box').css('display', 'block');
        $('#info-box').html($(this).data('info'));
    });
   // $("path, polyline").off( "mouseenter mouseleave" );
    $("path, polyline").click(function (e) {
       var  href=$(this).attr("href");
       window.location.href=href;
    });

    $("path, polyline").mouseleave(function (e) {
        $('#info-box').css('display', 'none');
    });

    $(document).mousemove(function (e) {
        $('#info-box').css('top', e.pageY - $('#info-box').height() - 30);
        $('#info-box').css('left', e.pageX - ($('#info-box').width()) / 2);
    }).mouseover();

    var ios = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    if (ios) {
        $('a').on('click touchend', function () {
            var link = $(this).attr('href');
            window.open(link, '_blank');
            return false;
        });
    }

    var menu = 0
    $(".burger").click(function () {
        if (menu == 0) {
            $(this).addClass(" open");
            $(".menu-open").addClass(" open");
            menu = 1;
        } else {
            $(this).removeClass(" open");
            $(".menu-open").removeClass(" open");
            menu = 0;
        }


    });


    $('.datepicker').pickadate({
        labelMonthNext: 'Next month',
        labelMonthPrev: 'Previous month',
        labelMonthSelect: 'Select a month',
        labelYearSelect: 'Select a year',
        monthsFull: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdaysFull: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        weekdaysLetter: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        today: 'Today',
        clear: 'Clear',
        close: 'OK',
        selectYears: 100,
        formatSubmit:  'yyyy-mm-dd',
        selectMonths: true,
        


    });

    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'left', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false ,// Stops event propagation
        }
    );

    /*CAROUSSEL*/


    $('.partners-slider').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        items: 6,
        dots: false,
        nav: false,
        responsive: {
            0: {
                items: 1,
            },
            360: {
                items: 2,
            },
            576: {
                items: 3,
            },
            992: {
                items: 6,
            }
        }
    });


    // FORM CHAR COUNTER
    $('.mustCounted').characterCounter();




    //VOTING
    $('#clickMotal').click(function(){

        $('#succesModal').modal();
    } );

    $('#clickMotal').trigger("click");


    $("#shareOnfaceBook").click(function(e){
        e.preventDefault();
        var projectID ;
        projectID = $(this).attr("data-projectid");
         var href=$(this).attr("href");

       var  formData = {
            projectID: projectID,

        };
        $.ajax({
            dataType: "json",
            url: voteurscript.ajax_url,
            type: 'post',
            data: {
                action: 'voting_xhr',
                custom_action: "share",
                form_data: formData
            },
            success: function (response) {
                console.log(response);
                if(response.CODESTATUS==3){
                    open_infos(href);
                    window.location.href;
                }


            }
        });



    });


    function open_infos(pageLink)
    {
        window.open(pageLink,'TUDIO SHARE PROJECT','menubar=no, scrollbars=no, top=100, left=100, width=500, height=600');
    }


    //VOTING
    $('#clickVideoModal').click(function(){

        $('#videoModalPopup').modal();
    } );


});
