<?php
/**
 * Template Name: Create xml
 * http://v4-alpha.getbootstrap.com/components/forms/
*/
/* create a dom document with encoding utf8 */
    $domtree = new DOMDocument('1.0', 'UTF-8');

    /* create the root element of the xml tree */
    $xmlRoot = $domtree->createElement("markers");
    /* append it to the document created */
    $xmlRoot1 = $domtree->appendChild($xmlRoot);
    echo WP_CONTENT_DIR;
    $args = array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'posts_per_page' => -1);
    $query = new WP_Query($args);
    if( $query->have_posts()):
        while($query->have_posts()):
            $query->the_post();
            global $post;
            $job_id = $post->ID;
            $lat = get_post_meta($job_id,'jb_lat',true);
            $lng = get_post_meta($job_id,'jb_lng',true);
            $domElement = $domtree->createElement("marker");

            $domAttribute  = $domtree->createAttribute ('post_title');
            $domAttribute->value = $post->post_title;
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);

            $domAttribute  = $domtree->createAttribute ('permalink');
            $domAttribute->value = get_permalink($post->ID);
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);

            $domAttribute  = $domtree->createAttribute ('lat');
            $domAttribute->value = $lat;
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);

            $domAttribute  = $domtree->createAttribute ('lng');
            $domAttribute->value = $lng;
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);

            $domAttribute  = $domtree->createAttribute ('id');
            $domAttribute->value = $post->ID;
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);

            $domAttribute  = $domtree->createAttribute ('address1');
            $domAttribute->value = 'Address';
            $domElement->appendChild($domAttribute);
            $xmlRoot->appendChild($domElement);


            // $currentTrack->appendChild($domAttribute);
            // $currentTrack->createAttribute ('id',$post->ID);
            // $currentTrack->createAttribute ('address1',$post->ID);
            // $currentTrack->createAttribute ('lat',$lat);
            // $currentTrack->createAttribute ('city',$lat);
            // $currentTrack->createAttribute ('lng',$long);
            // $currentTrack->createAttribute ('postcode',$lat);


        endwhile;
    endif;



   $domtree->save(WP_CONTENT_DIR."/markers.xml");
?>