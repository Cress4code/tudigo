
<div class="default-padding-section">
    <h2 class="title-2 text-center default-padding-title">
        <?php
        echo get_field("project_section_title", "option");
        ?>
    </h2>
    <div class="row">
        <div class="col s12 m3"></div>
        <div class="col s12 m6">
            <ul class="timeline timeline-centered">
                <?php
                $projectsDates = get_field("project_date_repeteur", "option");
                if (!empty($projectsDates)) {
                    foreach ($projectsDates as $projectsDate) {
                        $projectsDate = (object)$projectsDate;
                        ?>
                        <li class="timeline-item">
                            <div class="timeline-info second-color">
                        <span><?php
                            echo changedate($projectsDate->date)
                            ?></span>
                            </div>
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title main-color"><?php
                                    echo $projectsDate->title
                                    ?></h3>
                                <p><?php
                                    echo $projectsDate->description
                                    ?></p>
                            </div>
                        </li>
                        <?php
                    }
                }
                ?>


            </ul>
        </div>
        <div class="col s12 m3"></div>
    </div>

</div>