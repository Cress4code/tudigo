<?php
$terms=wp_get_post_terms(get_the_ID(),"states-project");
if( !empty($terms)){
    $terms=$terms[0];
    $termSlug=$terms->slug;
}else{
    echo ' <div id="info-box"></div>';
}

?>



<!-- Generator: Adobe Illustrator 13.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 14948)  -->
<svg
        xmlns:i="http://ns.adobe.com/AdobeIllustrator/10.0/"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:cc="http://creativecommons.org/ns#"
        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
        xmlns:svg="http://www.w3.org/2000/svg"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
        xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
        version="1.1"
        id="MapCalifornia"
        sodipodi:version="0.32"
        sodipodi:docname="California_county_map_(labeled).svg"
        sodipodi:docbase="d:\Home\Wikipedia"
        inkscape:version="0.46"
        x="0px"
        y="0px"
        width="620.843px"
        height="733.026px"
        viewBox="0 0 620.843 733.026"
        enable-background="new 0 0 620.843 733.026"
        xml:space="preserve"
        inkscape:output_extension="org.inkscape.output.svg.inkscape"><metadata
            id="metadata1053">
        <rdf:RDF>
            <cc:Work
                    rdf:about="">
                <dc:format>image/svg+xml</dc:format>
                <dc:type
                        rdf:resource="http://purl.org/dc/dcmitype/StillImage"/>
            </cc:Work>
        </rdf:RDF>
    </metadata>
    <defs
            id="defs1051">
        <inkscape:perspective
                sodipodi:type="inkscape:persp3d"
                inkscape:vp_x="0 : 366.513 : 1"
                inkscape:vp_y="0 : 1000 : 0"
                inkscape:vp_z="620.84302 : 366.513 : 1"
                inkscape:persp3d-origin="310.42151 : 244.342 : 1"
                id="perspective1055"/>


    </defs>
    <sodipodi:namedview
            inkscape:window-height="845"
            inkscape:window-width="1152"
            inkscape:pageshadow="2"
            inkscape:pageopacity="0.0"
            guidetolerance="10.0"
            gridtolerance="10.0"
            objecttolerance="10.0"
            borderopacity="1.0"
            bordercolor="#666666"
            pagecolor="#ffffff"
            id="base"
            showgrid="false"
            inkscape:zoom="10.084226"
            inkscape:cx="491.65084"
            inkscape:cy="183.32514"
            inkscape:window-x="-4"
            inkscape:window-y="-4"
            inkscape:current-layer="g7"/>
    <switch
            id="switch3">
        <foreignObject
                requiredExtensions="http://ns.adobe.com/AdobeIllustrator/10.0/"
                x="0"
                y="0"
                width="1"
                height="1"
                id="foreignObject5">
            <i:pgfRef
                    xlink:href="#adobe_illustrator_pgf">
            </i:pgfRef>
        </foreignObject>
        <g
                i:extraneous="self"
                id="g7">

            <?php

            $args = ['taxonomy' => "states-project",
                'hide_empty' => false];

            $states = get_terms($args);
           // print_r($states);
            if (!empty($states)) {
                foreach ($states as $state) {
                    $svg_code = get_field('svg_code', $state);
                    $figure = get_field('figure', $state);
                    $active="#fff";
                  if (isset($termSlug) && $termSlug==$state->slug){
                      $active="#ff4b68 ";
                  }
                    if ($figure == "path") {
                        ?>
                        <path
                                href="<?php  echo get_term_link($state)?>"
                                id="<?php echo $state->slug ?>"
                                fill="<?php echo $active?>"
                                stroke="#004182"
                                stroke-miterlimit="1"
                                class=""
                                data-info="<?php echo $state->name ?> <br/> <?php echo $state->count ?> projects  "
                                d="<?php echo strip_tags($svg_code) ?>"
                        />
                        <?php
                    } else {

                        ?>
                        <polyline
                                id="<?php echo $state->slug ?>"
                                class=""

                                data-info="<?php echo $state->name ?> <br/> <?php echo $state->count ?> projects  "
                                fill="<?php echo $active?>"
                                stroke="#004182"
                                stroke-miterlimit="1"
                                href="<?php  echo get_term_link($state)?>"
                                points="<?php echo strip_tags($svg_code)?>"/>

                        <?php
                    }
                }
            }
            ?>

    </switch>
</svg>
