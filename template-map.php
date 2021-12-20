<?php /**
 * Template Name: Karta
 */

get_header();

$offices = get_terms([
    'taxonomy'  => 'lan',
    'orderby'   => 'name'
]);
?>

<main role="main" class="main-content" id="map-page">
    <?php get_template_part( 'template-simplehead' );?>

    <div class="lw-map">
        <div class="lw-map--search">
            <div class="lw-map--search--wrapper">
                <input class="lw-map--search--input" type="text" placeholder="Sök på ort, län, adress eller postnummer">
                <button class="lw-map--search--btn"></button>
            </div>
                <div class="btn-wrapper">
                    <button class="btn btn-primary" id="location-btn">Hitta min närmaste Francks</button>
                    <p class="reset-offices">Visa alla</p>
                </div>
        </div>

        <div class="lw-map--offices">
            <button id="uparrow"></button>
            <div class="lw-map--offices--inner">
                <?php foreach( $offices as $o ) :
                    if ( $o->parent != 0 ) :
                        $contact_info = get_field('kontaktinfo', $o);
                        $img = get_field('office_img', $o);
                        $location = get_field('map', $o);
                            // $address = '';
                            // foreach( array('street_name', 'street_number', 'post_code') as $i => $k ) {
                            //     if( isset( $location[ $k ] ) ) {
                            //         $address .= sprintf( '<span class="%s">%s</span> ', $k, $location[ $k ] );
                            //     }
                            // }

                        if( $location ) :
                        $county = get_term($o->parent, 'lan');
                ?>
                        <div class="lw-office-item"
                            data-id="<?php echo $o->term_id; ?>"
                            data-lat="<?php echo esc_attr($location['lat']); ?>"
                            data-lng="<?php echo esc_attr($location['lng']); ?>">

                            <?php if( $img ) : ?>
                                <div class="lw-office-item--img" <?php echo $img ? 'style="background-image: url('.$img['url'].');"' : ''; ?>></div>
                            <?php endif; ?>

                            <h3 class="lw-office-item--county"><?php echo $county->name; ?></h3>
                            <h2 class="lw-office-item--city"><?php echo $o->name; ?></h2>
                            <div class="lw-office-item--contact-info">
                                <?php echo $contact_info; ?>
                            </div>

                            <div class="btn-wrapper">
                                <a class="lw-office-item--contact-btn btn btn-primary" href="<?php echo esc_url(get_term_link($o));?>">
                                    <?php the_field('kontorknapp', 'options');?>
                                </a>

                                <div class="lw-office-item--find-btn-wrapper">
                                    <div class="lw-office-item--find-btn btn btn-primary">
                                        <?php 
                                            if ( get_field('find_office_link_text', 'options') ) {
                                                the_field('find_office_link_text', 'options');
                                            } else {
                                                echo 'Hitta hit';
                                            }    
                                            ?>
                                    </div>
                                    <div class="lw-office-item--find-links">
                                        <a class="lw-office-item--find-link" href="http://maps.apple.com/?daddr=<?php echo $location['address']; ?>&dirflg=d&t=m" target="_blank">
                                            Apple Kartor
                                        </a>
                                        
                                        <a class="lw-office-item--find-link" href="https://www.google.com/maps/search/?api=1&query=<?php echo $location['address']; ?>&travelmode=driving" target="_blank">
                                            Google Maps
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- <div class="nothing-found">
                    Inget kontor matchade vad du sökte efter.
                </div> -->
            </div>
        </div>

        <div class="lw-map--area">
            <?php get_template_part('component-map'); ?>
        </div>

    </div>
</main>

<?php get_footer() ?>