<button style="display:none" data-target="succesModal" class="btn modal-trigger" id="clickMotal">Modal</button>


<div id="succesModal" class="modal"
     style="background-image: url('<?php echo get_template_directory_uri() . '/img/background.jpg' ?>')">
    <h4 class="white-color main-bg modal-title text-center">Your vote has been taken into account</h4>
    <div class="modal-content">
    <div class="row">

            <p   class="text-center">


                <a class="second-bg white-color btn-tudigo" href="<?php echo home_url() ?>"> Back to home</a>
                <a class="main-bg white-color btn-tudigo" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo  get_the_permalink()?>" id="shareOnfaceBook"  data-projectid="<?php echo get_the_ID() ?>"> I share</a>

            </p>


        </div>
    </div>
</div>
