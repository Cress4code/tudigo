<div id="modal1" class="modal"
     style="background-image: url('<?php echo get_template_directory_uri() . '/img/background.jpg' ?>')">
    <h4 class="white-color main-bg modal-title text-center">
        COMPLETE ALL THE FOLLOWING FIELDS</h4>
    <p id="confirmationText" class="text-center">
        <br>
        A confirmation email has just been sent to you.
        <br>
        <br>

        <a class="second-bg white-color btn-tudigo" href="<?php echo home_url()?>"> Bach to home page</a>

    </p>
    <div class="row">
        <div class="modal-content">
            <form class="white-bg form-corver haveSmallPadding" method="post" id="saveEmailVoting"  >
                <div class="">


                    <div class="row">

                        <div id="first-to-show">

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" type="email" class="validate" required name="email">
                                    <label for="email">Email <span class="error"></span></label>
                                </div>
                            </div>
                        </div>
                        <div id="second-to-show">
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="civility" name="civility" required class="validate" >


                                        <option value="Miss">Miss</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                    </select>

                                    <label for="civility">Civility</label>
                                </div>

                                <div class="input-field col s6">

                                    <input   id="prenom" name="prenom"   type="text" class="validate">
                                    <label for="prenom">First Name</label>
                                </div>

                            </div>
                            <div class="row">

                                <div class="input-field col s6">
                                    <input id="nom" type="text" name="nom"   class="validate">
                                    <label for="nom">Last Name</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="datedenaissance" type="text"    name="datedenaissance" class="  datepicker">
                                    <label for="datedenaissance">Birthday</label>

                                </div>
                            </div>


                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="zipCode" id="zipCode"   name="zipCode"   type="text" class="validate">
                                    <label for="zipCode">ZipCode</label>
                                </div>

                            </div>




                        </div>
                        <div class="g-recaptcha" data-sitekey="6Le0djwUAAAAABwWLNHxwNngUnMu5gSi7PxcomsL"></div>
                    </div>

                    <div class=" text-center">
                        <button type="submit" class="main-bg white-color btn-tudigo">Continue</button>
                    </div>
            </form>


        </div>
        <div class="col s12 m3"></div>

    </div>

</div>
