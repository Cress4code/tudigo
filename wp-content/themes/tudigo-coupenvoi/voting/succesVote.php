<button style="display:none" data-target="succesModal" class="btn modal-trigger" id="clickMotal">Modal</button>


<div id="succesModal" class="modal"
     style="background-image: url('<?php echo get_template_directory_uri() . '/img/background.jpg' ?>')">
    <h4 class="white-color main-bg modal-title text-center">Thank you ! Your vote has been taken into account.

    </h4>
    <div class="modal-content">
    <div class="row">

            <p   class="text-center">
                Now, you can add an extra vote to your favorite project by sharing the project page on facebook using the « Share » button below.
<br>


                <a class="second-bg white-color btn-tudigo" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo  get_the_permalink()?>&quote=<?php echo getFacebookContentOfPost(get_the_ID());?>&_rdc=<?php echo the_permalink()?>" id="shareOnfaceBook"  data-projectid="<?php echo get_the_ID() ?>"> I share</a>

            </p>


        </div>
    </div>
</div>
