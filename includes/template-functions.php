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
    $base_url = get_option('wpct_hb_base_url');
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

    const contactSection = document.getElementById("contacte");
    <?php if (!$has_links) : ?>
    contactSection.querySelectorAll(".ce-landing-links").forEach((el) => el.parentElement.removeChild(el));
    <?php else : ?>
    const socialLinks = contactSection.querySelectorAll(".wp-block-social-link");
    for (const link of socialLinks) {
        if (link.classList.contains("wp-social-link-twitter")) {
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
        # case 'ce_tag_common_generation':
        case strpos($slug, 'generacio-renovable') !== false:
            return '<i class="fa-solid fa-solar-panel"></i>';
            // return '<i class="fa-regular fa-solar-panel"></i>';
            break;
        # case 'ce_tag_energy_efficiency':
        case strpos($slug, 'eficiencia-energetica') !== false:
            return '<i class="fa-solid fa-lightbulb"></i>';
            // return '<i class="fa-regular fa-lightbulb-cfl-on"></i>';
            break;
        # case 'ce_tag_sustainable_mobility':
        case strpos($slug, 'mobilitat-sostenible') !== false:
            return '<i class="fa-solid fa-car-on"></i>';
            // return '<i class="fa-regular fa-car-bolt"></i>';
            break;
        # case 'ce_tag_citizen_education':
        case strpos($slug, 'formacio-ciutadana') !== false:
            return '<i class="fa-solid fa-book-open-reader"></i>';
            // return '<i class="fa-regular fa-presentation-screen"></i>';
            break;
        # case 'ce_tag_thermal_energy':
        case strpos($slug, 'energia-termica') !== false:
            return '<i class="fa-solid fa-house-fire"></i>';
            // return '<i class="fa-regular fa-air-conditioner"></i>';
            break;
        # case 'ce_tag_collective_purchases':
        case strpos($slug, 'compres-colectives') !== false:
            return '<i class="fa-solid fa-basket-shopping"></i>';
            // return '<i class="fa-regular fa-basket-shopping"></i>';
            break;
        # case 'ce_tag_renewable_energy':
        case strpos($slug, 'subministrament-renovable') !== false:
            return '<i class="fa-solid fa-leaf"></i>';
            // return '<i class="fa-regular fa-seedling"></i>';
            break;
        # case 'ce_tag_aggregate_demand':
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
