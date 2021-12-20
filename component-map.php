<?php
/**
 * Component List stores
 * *
 * @package SHK
 */


$places = get_terms(array(
    'taxonomy'  => 'lan',
))

?>


<div id="map-area">

	<div id="f-map" class="f-map">
	<?php foreach( $places as $place ) :
        $term_id = $place->term_id;
        $location = get_field('map', $place);
        $contact_info = get_field('kontaktinfo', $place);
        if( $location ) :
            $county = get_term($place->parent, 'lan');
            $address = '';
            foreach( array('street_name', 'street_number', 'post_code') as $i => $k ) {
                if( isset( $location[ $k ] ) ) {
                    $address .= sprintf( '<span class="%s">%s</span> ', $k, $location[ $k ] );
                }
            }
        ?>
            <div class="marker" data-id="<?php echo $term_id; ?>" data-type="<?php /* echo implode(', ', $cat); */ ?>" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
                <h3 class="lw-office-item--county"><?php echo $county->name; ?></h3>
                <h2 class="lw-office-item--city"><?php echo $place->name; ?></h2>
                <div class="lw-office-item--contact-info">
                    <?php echo $contact_info; ?>

                <div class="lw-office-item--address" style="display: none !important;">
                    <?php 
                        echo $address;
                    ?>
                </div>
                </div>
                <a class="lw-office-item--contact-btn btn btn-primary" href="<?php echo esc_url(get_term_link($place));?>">
                    <?php the_field('kontorknapp', 'options');?>
                </a>
            </div>
            
        <?php endif; ?>
        
    <?php endforeach; ?>
	</div>

</div>

