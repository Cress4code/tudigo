<div class="default-padding-section silver-bg">
    <div class="partners  ">
        <h3 class="text-center">Sponsors and partners</h3>
        <br>
        <div class="container">
            <div class="partners-slider owl-carousel">
                <?php
                $parterns = get_field("site_partners", 'option');
                if (!empty($parterns)) {
                    foreach ($parterns as $partern) {
                        $partern = (object)$partern;
                        ?>
                        <div class="caroussel-item " style="width: 185px;"><a target="_blank" title="<?php echo $partern->partners_company_name ?>"
                                                      href="<?php echo $partern->partners_url?>"><img
                                        src="<?php echo $partern->partners_logo ?>"
                                        alt="<?php echo $partern->partners_company_name ?>"/></a>
                        </div>
                        <?
                    }
                }
                ?>

            </div>
            <br>
            <br>
            <br>
            <div class="text-center">
                <a href="<?php echo home_url("sponsors-and-partners") ?>" title="All partners"
                   class="btn-tudigo second-btn second-bg read-more white-color">
                    Our partners
                </a>

            </div>
        </div>
    </div><!-- .partners -->
</div><!-- .partners -->
<?php
global $activePhase;
if($activePhase==0){
if (is_user_logged_in()) {
    ?>
    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large second-bg" title="Tableau de bord">
            <i class="large material-icons">apps</i>
        </a>
        <ul>
            <li><a href="<?php echo wp_logout_url(home_url()) ?>" class="btn-floating main-bg"><i class="material-icons">power_settings_new </i></a>
            </li>
            <li><a href="<?php echo site_url('project-creation') ?>" class="btn-floating main-bg"><i
                            class="material-icons">create</i></a></li>


            <li><a href="<?php echo home_url('account-detail') ?>" class="btn-floating yellow darken-1"><i class="material-icons">account_circle</i></a></li>
        </ul>
    </div>
    <?php
}
}
?>

<footer>

    <div class="links-footer default-padding-section main-bg white-color text-center">

        <?php
        global $phases;
        global $activePhase;
        $callforapplication = (object)$phases[0];
        $onlineVote = (object)$phases[1];


        ?>

        <p><?php  echo  get_field("site_footer_desc","option")?></p>
       <div class="footer-menu">
           <?php
           html5blank_nav("secondary-menu");
           ?>
       </div>

        <?php
        echo date('Y') . "  ";
        bloginfo("name");
        ?>
    </div>
</footer>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_field("api_google_map", "option") ?>&libraries=places&callback=initAutocomplete"
        async defer></script>
<script>
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    var options = {
        types: ['(cities)'],
        componentRestrictions: {country: 'us'}
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('city')),
            options);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();


        console.log(place);
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
<?php
wp_footer()
?>
<?php
get_template_part("voting/emailVotingpopup");
?>
</body>
</html>
