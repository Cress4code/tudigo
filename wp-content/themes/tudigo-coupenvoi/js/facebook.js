$(document).ready(function(){

    window.fbAsyncInit = function () {
        // FB JavaScript SDK configuration and setup
        FB.init({
            appId: '141870889846321', // FB App ID
            cookie: true,  // enable cookies to allow the server to access the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.11' // use graph api version 2.8
        });

        // Check whether the user already logged in
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                //display user data
               // getFbUserData();
            }
        });
        FB.AppEvents.logPageView();
    };

// Load the JavaScript SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
    $("#fbLink").click( function() {
        var projectID = $(this).data("id");

        FB.login(function (response) {
            if (response.authResponse) {

                // Get and display the user profile data
                getFbUserData(projectID);
            } else {
                document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
            }
        }, {scope: 'email'});
    });

// Fetch the user profile data from facebook

    function getFbUserData(projectID) {
        FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture,birthday'},
            function (response) {
                var hasregistrerd = 1;
                console.log(response);

                var formData;
                var custom_action;


                    custom_action = "facebook_user";
                        var  civility=(response.gender=="male")?"Mr":"Mss";
                        formData = {
                            email: response.email,
                            nom: response.last_name,
                            prenom: response.first_name,
                            datedenaissance: "",
                            zipCode: "",
                            civility: civility,

                            post_id: projectID

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
                                $('.error').addClass("second-bg");
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

            });
    }


});
