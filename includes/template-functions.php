<?php

function wpct_ce_landing_badges($remote)
{
    $type = $remote->get_terms(WPCT_CE_REST_TYPE_TAX);
    $assoc = $remote->get_terms(WPCT_CE_REST_ASSOC_TYPE_TAX);
    $status = $remote->get_terms(WPCT_CE_REST_STATUS_TAX);

    if (!is_wp_error($type) && $type && count($type) > 0) {
        $type = $type[0];
    }

    if (!is_wp_error($assoc) && $assoc && count($assoc) > 0) {
        $assoc = $assoc[0];
    }

    if (!is_wp_error($status) && $status && count($status) > 0) {
        $status = $status[0];
    }

    ob_start();
?>
    <div id="wpct-ce-landing-badges" class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex disabled-buttons">
        <?php if (!empty($type)) : ?>
            <button class="wp-block-button has-custom-font-size has-x-small-font-size">
                <a href="<?= get_term_link($type); ?>" class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--50);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--50)"><?= apply_filters('wpct_ce_type_icon', null, $type->slug) ?><?= $type->name ?></a>
            </button>
        <?php endif; ?>
        <?php if (!(empty($assoc) || $assoc->name === 'undefined')) : ?>
            <button class="wp-block-button has-custom-font-size has-x-small-font-size">
                <a href="<?= get_term_link($assoc); ?>" class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= $assoc->name ?></a>
            </button>
        <?php endif; ?>
        <?php if (!empty($status)) : ?>
            <button class="wp-block-button has-custom-font-size has-x-small-font-size">
                <a href="<?= get_term_link($status); ?>" class="wp-block-button__link has-base-color has-brand-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= apply_filters('wpct_ce_status_icon', null, $status->slug) ?><?= $status->name ?></a>
            </button>
        <?php endif; ?>
    </div>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}

function wpct_ce_landing_primary_image($remote)
{
    $primary_image = $remote->get('primary_image_file');
    if ($primary_image) {

        return ('
    <img class="wp-block-cover__image-background wp-image-5684" alt="" src="' . $primary_image . '" data-object-fit="cover"/>
    ');
    } else {
        return ('
    <img class="wp-block-cover__image-background wp-image-5684" alt="" src="' . get_stylesheet_directory_uri() . '/img/ce-landing-default.jpeg' . '" data-object-fit="cover"/>
    ');
    }
}

function wpct_ce_landing_secondary_image($remote)
{
    $secondary_image = $remote->get('secondary_image_file');
    if ($secondary_image) {

        return ('
    <img class="wp-block-cover__image-background wp-image-5684" alt="" src="' . $secondary_image . '" data-object-fit="cover"/>
    ');
    } else {
        return ('
    <img class="wp-block-cover__image-background wp-image-5684" alt="" src="' . get_stylesheet_directory_uri() . '/img/ce-landing-default.jpeg' . '" data-object-fit="cover"/>
    ');
    }
}

function wpct_ce_landing_services($remote)
{
    $terms = $remote->get_terms(WPCT_CE_REST_SERVICE_TAX);
    if (is_wp_error($terms) || !$terms) {
        return '';
    }

    // $services = $remote->get('community_active_services', []);
    ob_start();

?>
    <ul class="ce-landing-services">
        <?php foreach ($terms as $term) : ?>
            <li>
                <a href="<?= get_term_link($term) ?>" rel="tag">
                    <?= apply_filters('wpct_ce_service_icon', null, $term->slug) ?>
                    <strong><?= $term->name ?></strong>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}

function wpct_ce_landing_leads_script($remote)
{
    $allow_news = $remote->get('allow_new_members', false);
    $base_url = get_option('wpct-http-bridge_general', [])['base_url'];
    $lang = apply_filters('wpct_i18n_current_language', null, 'locale');
    $base_url .= '/' . $lang;
    $company_id = $remote->get('company_id', 1);

    ob_start();
?>
    <div>
        <script>
            const allowNewMembers = <?= $allow_news ? 'true' : 'false' ?>;
            const leadsWrappers = document.querySelectorAll(".ce-landing-leads");

            if (allowNewMembers) {
                leadsWrappers.forEach((wrapper) => {
                    const link = wrapper.querySelector(".contact a");
                    link.parentElement.removeChild(link);
                });
            }

            leadsWrappers.forEach((wrapper) => {
                for (const link of wrapper.querySelectorAll(".lead")) {
                    if (!allowNewMembers) {
                        link.parentElement.removeChild(link);
                    } else {
                        if (link.classList.contains("citizen")) {
                            link.children[0].href = "<?= $base_url ?>/become_cooperator?odoo_company_id=<?= $company_id ?>";
                        } else {
                            link.children[0].href = "<?= $base_url ?>/become_company_cooperator?odoo_company_id=<?= $company_id ?>";
                        }
                    }
                }
            });
        </script>
    </div>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}

function wpct_ce_landing_social_script($remote)
{
    $title = $remote->get('title');
    $page_url = get_page_link($remote->ID);
    $email_template = "Hola,

M'acabo d'inscriure a la %s.

Si t'hi vols sumar, visita: %s

T'animo a fer córrer la veu perquè amistats, familiars, veïns i veïnes també s'hi sumin i arribem al número de persones òptim per impulsar la transició energètica del nostre municipi.

La suma de moltes persones pot generar una energia imparable.

Som-hi!";

    $email_text = rawurlencode(sprintf(__($email_template, 'wpct-ce'), $title, $page_url));
    $share_text = rawurlencode(sprintf(__('M’acabo d’inscriure a la %s. Si t’hi vols sumar, visita: ', 'wpct-ce'), $title));
    $tweet_text = rawurlencode(sprintf(__('M’acabo d’inscriure a la %s gràcies a @somcomunitats. Si t’hi vols sumar visita: ', 'wpct-ce'), $title));

    ob_start();
?>
    <div>
        <script>
            const ceShareBtns = document.querySelector(".ce-landing-share-pannel")
                .querySelectorAll(".wp-block-button");

            for (const btn of ceShareBtns) {
                const link = btn.children[0];
                if (btn.classList.contains("ce-landing-share__link")) {
                    link.addEventListener("click", function(ev) {
                        ev.preventDefault();
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            alert("<?= __('Enllaç copait al porta-retalls', 'wpct-ce'); ?>");
                        });
                    });
                } else if (btn.classList.contains("ce-landing-share__email")) {
                    link.href = "mailto:?subject=<?= $title ?>&body=<?= $email_text ?>";
                } else if (btn.classList.contains("ce-landing-share__telegram")) {
                    link.href = "https://telegram.me/share/url?url=<?= $page_url; ?>&text=<?= $share_text; ?>";
                } else if (btn.classList.contains("ce-landing-share__whatsapp")) {
                    link.href = "https://api.whatsapp.com/send?text=<?= $share_text; ?>+<?= $page_url; ?>";
                } else if (btn.classList.contains("ce-landing-share__twitter")) {
                    link.href = "http://twitter.com/share?text=<?= $tweet_text; ?>&url=<?= $page_url; ?>";
                } else if (btn.classList.contains("ce-landing-share__instagram")) {
                    link.href = "https://instagram.com";
                } else if (btn.classList.contains("ce-landing-share__mastodon")) {
                    link.href = "https://mastodonshare.com/?text=<?= $tweet_text; ?>&url=<?= $page_url; ?>"
                }
            }
        </script>
    </div>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}

function wpct_ce_landing_contact_form($remote, $atts)
{
    $current_lang = apply_filters('wpct_i18n_current_language', null, 'slug');
    $company_id = (string) $remote->get('company_id', 1);
    $form_id = $atts['form_id'];

    $output = do_shortcode("[gravityform id='{$form_id}' title='false' description='false' ajax='true' field_values='current_lang={$current_lang}&company_id={$company_id}']");
    return str_replace(["\r", "\n"], '', $output);
}

function wpct_ce_landing_visibility_script($remote)
{
    $why_become = $remote->get('why_become_cooperator');
    $become_process = $remote->get('become_cooperator_process');
    $allow_news = $remote->get('allow_new_members');

    $website = $remote->get('external_website_link', '');
    $twitter = $remote->get('twitter_link', '');
    $instagram = $remote->get('instagram_link', '');
    $telegram = $remote->get('telegram_link', '');
    $has_links = $website || $twitter || $instagram || $telegram;

    $header_link = $remote->get('show_web_link_on_header', '');

    ob_start();
?>
    <div>
        <script id="ce-landing-visibility-script">
            const becomeSection = document.querySelector(".ce-landing-become");
            if (becomeSection) {
                <?php if (!($why_become || $become_process)) : ?>
                    becomeSection.parentElement.removeChild(becomeSection);
                <?php elseif (!$why_become) : ?>
                    becomeSection.querySelectorAll(".why-become").forEach((el) => el.parentElement.removeChild(el));
                <?php elseif (!$become_process) : ?>
                    becomeSection.querySelectorAll(".become-process").forEach(((el) => el.parentElement.removeChild(el)));
                <?php endif; ?>
                <?php if (!$allow_news) : ?>
                    becomeSection.querySelectorAll(".contact").forEach((el) => el.parentElement.removeChild(el));
                <?php endif; ?>
            }

            const contactSection = document.getElementById("contacte");
            if (contactSection) {
                <?php if (!$has_links) : ?>
                    contactSection.querySelectorAll(".ce-landing-links").forEach((el) => el.parentElement.removeChild(el));
                <?php else : ?>
                    const socialLinks = contactSection.querySelectorAll(".wp-block-social-link");
                    for (const link of socialLinks) {
                        if (link.classList.contains("wp-social-link-x")) {
                            const href = "<?= $twitter ?>";
                            if (href) {
                                link.querySelector(".wp-block-social-link-anchor")
                                    .href = href;
                            } else {
                                link.parentElement.removeChild(link);
                            }
                        } else if (link.classList.contains("wp-social-link-instagram")) {
                            const href = "<?= $instagram ?>";
                            if (href) {
                                link.querySelector(".wp-block-social-link-anchor")
                                    .href = href;
                            } else {
                                link.parentElement.removeChild(link);
                            }
                        } else if (link.classList.contains("wp-social-link-telegram")) {
                            const href = "<?= $telegram ?>";
                            if (href) {
                                link.querySelector(".wp-block-social-link-anchor")
                                    .href = href;
                            } else {
                                link.parentElement.removeChild(link);
                            }
                        }
                    }
                <?php endif; ?>
            }
            <?php if (!$header_link) : ?>
                document.querySelectorAll(".ce-landing-external-website").forEach((el) => el.parentElement.removeChild(el));
            <?php endif; ?>
        </script>
    </div>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}

add_filter('wpct_ce_service_icon', 'wpct_ce_service_icon', 10, 2);
function wpct_ce_service_icon($icon, $slug)
{
    switch ($slug) {
        # case 'energy_action_common_generation':
        case strpos($slug, 'generacio-renovable') !== false:
            return '<i class="fa-solid fa-solar-panel"></i>';
            // return '<i class="fa-regular fa-solar-panel"></i>';
            break;
        # case 'energy_action_energy_efficiency':
        case strpos($slug, 'eficiencia-energetica') !== false:
            return '<i class="fa-solid fa-lightbulb"></i>';
            // return '<i class="fa-regular fa-lightbulb-cfl-on"></i>';
            break;
        # case 'energy_action_sustainable_mobility':
        case strpos($slug, 'mobilitat-sostenible') !== false:
            return '<i class="fa-solid fa-car-on"></i>';
            // return '<i class="fa-regular fa-car-bolt"></i>';
            break;
        # case 'energy_action_citizen_education':
        case strpos($slug, 'formacio-ciutadana') !== false:
            return '<i class="fa-solid fa-book-open-reader"></i>';
            // return '<i class="fa-regular fa-presentation-screen"></i>';
            break;
        # case 'energy_action_thermal_energy':
        case strpos($slug, 'energia-termica') !== false:
            return '<i class="fa-solid fa-house-fire"></i>';
            // return '<i class="fa-regular fa-air-conditioner"></i>';
            break;
        # case 'energy_action_collective_purchases':
        case strpos($slug, 'compres-colectives') !== false:
            return '<i class="fa-solid fa-basket-shopping"></i>';
            // return '<i class="fa-regular fa-basket-shopping"></i>';
            break;
        # case 'energy_action_renewable_energy':
        case strpos($slug, 'subministrament-renovable') !== false:
            return '<i class="fa-solid fa-leaf"></i>';
            // return '<i class="fa-regular fa-seedling"></i>';
            break;
        # case 'energy_action_aggregate_demand':
        case strpos($slug, 'agregacio-demanda') !== false:
            return '<i class="fa-solid fa-chart-column"></i>';
            // return '<i class="fa-regular fa-chart-column"></i>';
            break;
        default:
            return $icon;
    }
}

add_filter('wpct_ce_type_icon', 'wpct_ce_type_icon', 10, 2);
function wpct_ce_type_icon($icon, $slug)
{
    if (strpos($slug, 'citizen') !== false) {
        return '<i class="fa fa-building"></i>';
    } elseif (strpos($slug, 'industrial') !== false) {
        return '<i class="fa fa-industry"></i>';
    } else {
        return $icon;
    }
}

add_filter('wpct_ce_status_icon', 'wpct_ce_status_icon', 10, 2);
function wpct_ce_status_icon($icon, $slug)
{
    if (strpos($slug, 'open') !== false) {
        return '<i class="fa fa-circle-half-stroke"></i>';
    } elseif (strpos($slug, 'closed') !== false) {
        return '<i class="fa fa-circle"></i>';
    } else {
        return $icon;
    }
}

// landing coord
// Display default text when services payload texts are empty



add_filter('wpct_rcpt_fetch', function ($payload, $remote_post, $locale) {
    $keys = ['awareness_services', 'design_services', 'management_services'];

    if ($remote_post->post_type === 'rest-ce-coord' && $locale === 'ca_ES') {
        foreach ($keys as $key) {
            if (empty($payload['landing'][$key])) {
                $payload['landing'][$key] = "En aquests moments no oferim serveis d'acompanyament en aquesta etapa de la Comunitat Energètica";
            }
        }
    } elseif ($remote_post->post_type === 'rest-ce-coord' && $locale === 'es_ES') {


        foreach ($keys as $key) {
            if (empty($payload['landing'][$key])) {
                $payload['landing'][$key] = "En estos momentos no ofrecemos servicios de acompañamiento en esta etapa de la Comunidad Energética";
            }
        }
    }
    return $payload;
}, 10, 3);


// landing coord
// Display map 


function wpct_ce_coord_landing_map($remote)
{
    $display_map = $remote->get('display_map');
    $lang = apply_filters('wpct_i18n_current_language', null, 'locale');
    $slug = $remote->post_name;
    $title = $remote->get('title');
    if ($display_map && $lang === 'ca_ES') {

        return '<!-- wp:group {"tagName":"section","align":"full","backgroundColor":"main","className":"is-style-no-padding","layout":{"type":"default"}} -->
                <section class="wp-block-group alignfull is-style-no-padding has-main-background-color has-background"><!-- wp:group {"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
                <div class="wp-block-group is-style-horizontal-padded"><!-- wp:spacer {"height":"6rem","className":"is-style-show-desktop"} -->
                <div style="height:6rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"3rem","className":"is-style-show-mobile-tablet"} -->
                <div style="height:3rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"2rem"} -->
                <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:group {"layout":{"type":"constrained","contentSize":"1300px"}} -->
                <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","textColor":"base"} -->
                <h2 class="wp-block-heading has-text-align-center has-base-color has-text-color">Comunitats Energètiques gestionades per ' . $title . '</h2>
                <!-- /wp:heading --></div>
                <!-- /wp:group -->

                <!-- wp:spacer {"height":"2rem"} -->
                <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
                <div id="mapa" class="wp-block-group"><!-- wp:spacer {"height":"4rem","width":"0px","style":{"layout":{}}} -->
                <div style="height:4rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <iframe allowfullscreen="" allow="clipboard-write" id="map" class="h-full w-full" src=
                "https://community-maps.somenergia.coop/ca/somcomunitats/maps/campanya?mapFilters=cat[]%3Bst[]%3Bcus[' . $slug . ']&fitBoundsCentering=1&filter=false" width="100%" height="850px" frameborder="0"></iframe><script type="text/javascript" id="community-maps-builder" data-iframe-id="map" src="https://community-maps.somenergia.coop/iframe-integration.js"></script>
                <!-- /wp:html -->

                <!-- wp:spacer {"height":"3rem","width":"0px","className":"is-style-show-tablet-desktop","style":{"layout":{}}} -->
                <div style="height:3rem;width:0px" aria-hidden="true" class="wp-block-spacer is-style-show-tablet-desktop"></div>
                <!-- /wp:spacer --></div>
                <!-- /wp:group -->

                <!-- wp:spacer {"height":"7rem","className":"is-style-show-desktop"} -->
                <div style="height:7rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"4rem","className":"is-style-show-mobile-tablet"} -->
                <div style="height:4rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
                <!-- /wp:spacer --></div>
                <!-- /wp:group --></section>
                <!-- /wp:group -->';
    } elseif ($display_map && $lang === 'es_ES') {

        return '<!-- wp:group {"tagName":"section","align":"full","backgroundColor":"main","className":"is-style-no-padding","layout":{"type":"default"}} -->
                <section class="wp-block-group alignfull is-style-no-padding has-main-background-color has-background"><!-- wp:group {"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
                <div class="wp-block-group is-style-horizontal-padded"><!-- wp:spacer {"height":"6rem","className":"is-style-show-desktop"} -->
                <div style="height:6rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"3rem","className":"is-style-show-mobile-tablet"} -->
                <div style="height:3rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"2rem"} -->
                <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:group {"layout":{"type":"constrained","contentSize":"1300px"}} -->
                <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","textColor":"base"} -->
                <h2 class="wp-block-heading has-text-align-center has-base-color has-text-color">Comunidades Energéticas gestionadas por ' . $title . '</h2>
                <!-- /wp:heading --></div>
                <!-- /wp:group -->

                <!-- wp:spacer {"height":"2rem"} -->
                <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
                <div id="mapa" class="wp-block-group"><!-- wp:spacer {"height":"4rem","width":"0px","style":{"layout":{}}} -->
                <div style="height:4rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
                <!-- /wp:spacer -->

                <!-- wp:html -->
                <iframe allowfullscreen="" allow="clipboard-write" id="map" class="h-full w-full" src=
                "https://community-maps.somenergia.coop/es/somcomunitats/maps/campanya?mapFilters=cat[]%3Bst[]%3Bcus[' . $slug . ']&fitBoundsCentering=1&filter=false" width="100%" height="850px" frameborder="0"></iframe><script type="text/javascript" id="community-maps-builder" data-iframe-id="map" src="https://community-maps.somenergia.coop/iframe-integration.js"></script>
                <!-- /wp:html -->

                <!-- wp:spacer {"height":"3rem","width":"0px","className":"is-style-show-tablet-desktop","style":{"layout":{}}} -->
                <div style="height:3rem;width:0px" aria-hidden="true" class="wp-block-spacer is-style-show-tablet-desktop"></div>
                <!-- /wp:spacer --></div>
                <!-- /wp:group -->

                <!-- wp:spacer {"height":"7rem","className":"is-style-show-desktop"} -->
                <div style="height:7rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
                <!-- /wp:spacer -->

                <!-- wp:spacer {"height":"4rem","className":"is-style-show-mobile-tablet"} -->
                <div style="height:4rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
                <!-- /wp:spacer --></div>
                <!-- /wp:group --></section>
                <!-- /wp:group -->';
    }
}

// landings (energy community and coord)
// Display butlleti

function wpct_ce_landings_butlleti_section($remote)
{
    //error_log(print_r($remote));
    $display_butlleti = $remote->get('show_newsletter_form');
    $lang = apply_filters('wpct_i18n_current_language', null, 'locale');
    if ($display_butlleti && $lang === 'ca_ES') {

        return '<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"main-light","className":"is-style-wide"} -->
    <hr class="wp-block-separator has-text-color has-main-light-color has-alpha-channel-opacity has-main-light-background-color has-background is-style-wide"/>
    <!-- /wp:separator --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:paragraph {"textColor":"main","fontSize":"medium"} -->
    <p class="has-main-color has-text-color has-medium-font-size">Butlletí</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:wpct-rcpt/field {"remoteField":"title"} -->
    <div class="wp-block-wpct-rcpt-field"><!-- wp:paragraph {"placeholder":"Setup your remote field template","style":{"elements":{"link":{"color":{"text":"var:preset|color|main"}}}},"textColor":"main"} -->
    <p class="has-main-color has-text-color has-link-color">_title_</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:wpct-rcpt/field -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:group {"className":"ce-form-newsletter","layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group ce-form-newsletter"><!-- wp:shortcode -->
    [remote_callback fn="wpct_ce_landing_contact_form" form_id="5"]
    <!-- /wp:shortcode -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"100%","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->';
    } elseif ($display_butlleti && $lang === 'es_ES') {

        return '<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"backgroundColor":"main-light","className":"is-style-wide"} -->
    <hr class="wp-block-separator has-text-color has-main-light-color has-alpha-channel-opacity has-main-light-background-color has-background is-style-wide"/>
    <!-- /wp:separator --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:paragraph {"textColor":"main","fontSize":"medium"} -->
    <p class="has-main-color has-text-color has-medium-font-size">Boletín</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:wpct-rcpt/field {"remoteField":"title"} -->
    <div class="wp-block-wpct-rcpt-field"><!-- wp:paragraph {"placeholder":"Setup your remote field template","style":{"elements":{"link":{"color":{"text":"var:preset|color|main"}}}},"textColor":"main"} -->
    <p class="has-main-color has-text-color has-link-color">_title_</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:wpct-rcpt/field -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:group {"className":"ce-form-newsletter","layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group ce-form-newsletter"><!-- wp:shortcode -->
    [remote_callback fn="wpct_ce_landing_contact_form" form_id="5"]
    <!-- /wp:shortcode -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"100%","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
    <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->';
    } else {
        return '<h6>No hi ha butlletí</h6>';
    }
}



/****   OTHER SHORTCODES */
/** Shortcode to include js script to modify body overflow properties */

add_shortcode('enable_overflow', 'wpct_ce_tarifes_overflow_visible');
function wpct_ce_tarifes_overflow_visible()
{
    ob_start();
?>
    <div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementsByTagName("body")[0].classList.add("overflow-visible");
            });
        </script>
    </div>
<?php
    $buffer = ob_get_clean();
    return str_replace(["\r", "\n"], '', $buffer);
}
