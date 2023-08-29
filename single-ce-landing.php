<?php

$post_id = get_the_ID();
$service_types = get_the_terms($post_id, 'ce-service');
if ($service_types && sizeof($service_types)) {
  $service_type = get_the_terms($post_id, 'ce-service')[0];
} else {
  $service_type = get_terms('ce-service')[0];
}

$current_lang = apply_filters("wpml_current_language", null);

$data = [
  'community_type' => $service_type->slug,
  'allow_new_members' => get_post_meta($post_id, 'ce_allow_new_members', true) || false,
  'why_become_cooperator' => get_post_meta($post_id, 'ce_why_become_cooperator', true),
  'become_cooperator_process' => get_post_meta($post_id, 'ce_become_cooperator_process', true),
  'street' => get_post_meta($post_id, 'ce_street', true),
  'postal_code' => get_post_meta($post_id, 'ce_postal_code', true),
  'city' => get_post_meta($post_id, 'ce_city', true),
  'external_website_link' => get_post_meta($post_id, 'ce_external_website_link', true),
  'twitter_link' => get_post_meta($post_id, 'ce_twitter_link', true),
  'telegram_link' => get_post_meta($post_id, 'ce_telegram_link', true),
  'instagram_link' => get_post_meta($post_id, 'ce_instagram_link', true),
  'community_active_services' => array_map(function ($term) {
    return [
      'name' => $term->name,
      'slug' => $term->slug,
      'ext_id' => get_option('eaction_' . $term->term_id)['source_xml_id']
    ];
  }, get_the_terms($post_id, 'ce-eaction')),
];

ob_start(); ?>

<!-- wp:template-part {"slug":"header","theme":"wp-coop-ce-theme-v-2","tagName":"header","className":"site-header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"0"},"padding":{"top":"0"}}},"layout":{"type":"default"}} -->
<main class="wp-block-group" style="margin-top:0;padding-top:0">
  <!-- wp:group {"tagName":"section","align":"full","className":"is-style-no-padding","layout":{"type":"default"}} -->
  <section class="wp-block-group alignfull is-style-no-padding">
    <!-- wp:group {"className":"is-style-show-desktop","layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group is-style-show-desktop">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"35%"}},"className":"is-style-no-padding","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"}} -->
      <div class="wp-block-group is-style-no-padding">
        <!-- wp:post-featured-image {"width":"100%"} /-->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"65%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"2rem","style":{"layout":{}}} -->
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group">
          <!-- wp:buttons -->
          <div class="wp-block-buttons">
            <!-- wp:button {"backgroundColor":"second-base-light","textColor":"typography","style":{"spacing":{"padding":{"left":"var:preset|spacing|50","right":"var:preset|spacing|50","top":"0.44rem","bottom":"0.44rem"}}},"fontSize":"x-small"} -->
            <div class="wp-block-button has-custom-font-size has-x-small-font-size">
              <a href="/ce-service/<?= $service_type->slug; ?>/" class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--50);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--50)"><?= $service_type->name; ?></a>
            </div>
            <!-- /wp:button -->

            <!-- wp:button {"backgroundColor":"second-base-light","textColor":"typography","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30","top":"0.44rem","bottom":"0.44rem"}}}} -->
            <div class="wp-block-button" style="display: none;" aria-hidden="true">
              <a class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)">Societat Cooperativa</a>
            </div>
            <!-- /wp:button -->

            <!-- wp:button {"backgroundColor":"brand","textColor":"base","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30","top":"0.44rem","bottom":"0.44rem"}}}} -->
            <div class="wp-block-button">
              <?php if ($data['allow_new_members']) : ?>
                <a class="wp-block-button__link has-base-color has-brand-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= __('Oberta', 'wpct'); ?></a>
              <?php else : ?>
                <a class="wp-block-button__link has-base-color has-brand-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= __('Tancada', 'wpct'); ?></a>
              <?php endif ?>
            </div>
            <!-- /wp:button -->
          </div>
          <!-- /wp:buttons -->

          <!-- wp:paragraph {"className":"ce-landing-breadcrumb"} -->
          <p class="ce-landing-breadcrumb"><a onclick="history.back()"><?= __('Tornar al mapa', 'wpct') ?></a></p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:post-title /-->

        <!-- wp:post-excerpt /-->

        <!-- wp:spacer {"height":"1rem","style":{"layout":{}}} -->
        <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:list {"className": "wpct-ce-eactions"} -->
        <ul class="ce-landing-eactions">
          <?php
          foreach ($data['community_active_services'] as $service) : ?>
            <!-- wp:list-item -->
            <li>
              <a href="/ce-eaction/<?= $service['slug']; ?>" rel="tag">
                <i><?= apply_filters('wpct_rest_ce_service_icon', $service) ?></i>
                <p><?= $service['name']; ?></p>
              </a>
            </li>
            <!-- /wp:list-item -->
          <?php endforeach; ?>
        </ul>
        <!-- /wp:list -->

        <!-- wp:spacer {"height":"2rem","style":{"layout":{}}} -->
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile-tablet","layout":{"type":"constrained"}} -->
    <div class="wp-block-group is-style-show-mobile-tablet">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"65%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"2rem","style":{"layout":{}}} -->
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group">
          <!-- wp:buttons -->
          <div class="wp-block-buttons">
            <!-- wp:button {"backgroundColor":"second-base-light","textColor":"typography","style":{"spacing":{"padding":{"left":"var:preset|spacing|50","right":"var:preset|spacing|50","top":"0.44rem","bottom":"0.44rem"}}},"fontSize":"x-small"} -->
            <div class="wp-block-button has-custom-font-size has-x-small-font-size">
              <a href="/ce-service/<?= $service_type->slug; ?>/" class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--50);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--50)"><?= $service_type->name; ?></a>
            </div>
            <!-- /wp:button -->

            <!-- wp:button {"backgroundColor":"second-base-light","textColor":"typography","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30","top":"0.44rem","bottom":"0.44rem"}}}} -->
            <div class="wp-block-button" style="display: none" aria-hidden="true">
              <a class="wp-block-button__link has-typography-color has-second-base-light-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)">Societat Cooperativa</a>
            </div>
            <!-- /wp:button -->

            <!-- wp:button {"backgroundColor":"brand","textColor":"base","style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30","top":"0.44rem","bottom":"0.44rem"}}}} -->
            <div class="wp-block-button">
              <?php if ($data['allow_new_members']) : ?>
                <a class="wp-block-button__link has-base-color has-brand-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= __('Oberta', 'wpct'); ?></a>
              <?php else : ?>
                <a class="wp-block-button__link has-base-color has-brand-background-color has-text-color has-background wp-element-button" style="padding-top:0.44rem;padding-right:var(--wp--preset--spacing--30);padding-bottom:0.44rem;padding-left:var(--wp--preset--spacing--30)"><?= __('Tancada', 'wpct'); ?></a>
              <?php endif ?>
            </div>
            <!-- /wp:button -->
          </div>
          <!-- /wp:buttons -->

          <!-- wp:paragraph {"className":"ce-landing-breadcrumb"} -->
          <p class="ce-landing-breadcrumb"><a href="/"><?= __('Tornar al mapa', 'wpct'); ?></a></p>
          <!-- /wp:paragraph -->
        </div>
        <!-- /wp:group -->

        <!-- wp:post-title /-->

        <!-- wp:post-excerpt /-->

        <!-- wp:spacer {"height":"1rem","style":{"layout":{}}} -->
        <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:list {"className": "wpct-ce-eactions"} -->
        <ul class="wpct-ce-eactions">
          <?php
          foreach ($data['community_active_services'] as $service) : ?>
            <!-- wp:list-item -->
            <li>
              <a href="/ce-eaction/<?= $service['slug']; ?>" rel="tag">
                <i><?= apply_filters('wpct_rest_ce_service_icon', $service) ?></i>
                <p><?= $service['name']; ?></p>
              </a>
            </li>
            <!-- /wp:list-item -->
          <?php endforeach; ?>
        </ul>

        <!-- wp:spacer {"height":"2rem","style":{"layout":{}}} -->
        <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"35%"}},"className":"is-style-no-padding","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"}} -->
      <div class="wp-block-group is-style-no-padding">
        <!-- wp:post-featured-image {"width":"100%"} /-->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
  </section>
  <!-- /wp:group -->

  <!-- wp:group {"tagName":"section","align":"full","backgroundColor":"second-base-ultra-light","className":"is-style-no-padding","layout":{"type":"default"}} -->
  <section class="wp-block-group alignfull is-style-no-padding has-second-base-ultra-light-background-color has-background">
    <!-- wp:group {"className":"is-style-show-desktop","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"}} -->
    <div class="wp-block-group is-style-show-desktop">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"6rem","style":{"layout":{}}} -->
        <div style="height:6rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading"><?= __('Qui som', 'wpct'); ?></h3>
        <!-- /wp:heading -->

        <!-- wp:post-content /-->

        <!-- wp:spacer {"height":"7rem"} -->
        <div style="height:7rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"backgroundColor":"brand","className":"is-style-no-padding","layout":{"type":"flex","flexWrap":"nowrap"}} -->
      <div class="wp-block-group is-style-no-padding has-brand-background-color has-background">
        <!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
        <div class="wp-block-group is-style-horizontal-padded">
          <!-- wp:heading {"textAlign":"center","textColor":"base"} -->
          <h2 class="wp-block-heading has-text-align-center has-base-color has-text-color"><?= __('Fes-te’n soci/a', 'wpct'); ?></h2>
          <!-- /wp:heading -->

          <!-- wp:paragraph {"align":"center","textColor":"base"} -->
          <p class="has-text-align-center has-base-color has-text-color"><?= __('Sol·licita adherir-te com a soci/a i accedeix al serveis <br>de la comunitat energètica', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"1rem","width":"0px","style":{"layout":{}}} -->
          <div style="height:1rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
          <div class="wp-block-buttons">
            <!-- wp:button {"fontSize":"small"} -->
            <div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link wp-element-button" href="#contacte"><?= __('Posa-t’hi en contacte', 'wpct'); ?></a></div>
            <!-- /wp:button -->
          </div>
          <!-- /wp:buttons -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile-tablet","layout":{"type":"constrained"}} -->
    <div class="wp-block-group is-style-show-mobile-tablet">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"3rem","style":{"layout":{}}} -->
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:heading {"level":3} -->
        <h3 class="wp-block-heading"><?= __('Qui som', 'wpct'); ?></h3>
        <!-- /wp:heading -->

        <!-- wp:post-content /-->

        <!-- wp:spacer {"height":"4rem","style":{"layout":{}}} -->
        <div style="height:4rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"backgroundColor":"brand","className":"is-style-no-padding","layout":{"type":"flex","flexWrap":"nowrap"}} -->
      <div class="wp-block-group is-style-no-padding has-brand-background-color has-background">
        <!-- wp:group {"style":{"layout":{"selfStretch":"fill","flexSize":null}},"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
        <div class="wp-block-group is-style-horizontal-padded">
          <!-- wp:spacer {"height":"3rem"} -->
          <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:heading {"textAlign":"center","textColor":"base"} -->
          <h2 class="wp-block-heading has-text-align-center has-base-color has-text-color"><?= __('Fes-te’n soci/a', 'wpct'); ?></h2>
          <!-- /wp:heading -->

          <!-- wp:paragraph {"align":"center","textColor":"base"} -->
          <p class="has-text-align-center has-base-color has-text-color"><?= __('Sol·licita adherir-te com a soci/a i accedeix al serveis <br>de la comunitat energètica', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"1rem","width":"0px","style":{"layout":{}}} -->
          <div style="height:1rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
          <div class="wp-block-buttons">
            <!-- wp:button {"fontSize":"small"} -->
            <div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link wp-element-button" href="#contacte"><? __('Posa-t’hi en contacte', 'wpct'); ?></a></div>
            <!-- /wp:button -->
          </div>
          <!-- /wp:buttons -->

          <!-- wp:spacer {"height":"4rem"} -->
          <div style="height:4rem" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
  </section>
  <!-- /wp:group -->

  <!-- wp:group {"tagName":"section","align":"full","backgroundColor":"main","className":"is-style-no-padding","layout":{"type":"default"}} -->
  <section class="wp-block-group alignfull is-style-no-padding has-main-background-color has-background">
    <!-- wp:group {"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
    <div class="wp-block-group is-style-horizontal-padded">
      <!-- wp:spacer {"height":"6rem","className":"is-style-show-desktop"} -->
      <div style="height:6rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
      <!-- /wp:spacer -->

      <!-- wp:spacer {"height":"3rem","className":"is-style-show-mobile-tablet"} -->
      <div style="height:3rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
      <!-- /wp:spacer -->

      <!-- wp:image {"align":"center","id":3178,"sizeSlug":"full","linkDestination":"none"} -->
      <figure class="wp-block-image aligncenter size-full"><img src="/wp-content/uploads/2023/07/share-thumbnail.png" alt="" class="wp-image-3178" /></figure>
      <!-- /wp:image -->

      <!-- wp:spacer {"height":"2rem"} -->
      <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->

      <!-- wp:heading {"textAlign":"center","textColor":"base"} -->
      <h2 class="wp-block-heading has-text-align-center has-base-color has-text-color"><?= __('Ajuda a fer créixer la Comunitat Energètica', 'wpct'); ?></h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"align":"center","textColor":"base","fontSize":"medium"} -->
      <p class="has-text-align-center has-base-color has-text-color has-medium-font-size"><?= __('Comparteix entre els teus veïns i veïnes i ajuda a fer créixer la Comunitat Energètica. Fem possible la transició energètica!', 'wpct'); ?></p>
      <!-- /wp:paragraph -->

      <!-- wp:spacer {"height":"2rem"} -->
      <div style="height:2rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->

      <!-- wp:buttons {"className":"ce-landing-share-pannel","layout":{"type":"flex","justifyContent":"center"}} -->
      <div class="wp-block-buttons ce-landing-share-pannel">
        <!-- wp:button {"textAlign":"center","fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link has-text-align-center wp-element-button"><?= __('Comparteix enllaç', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per correu', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per Telegram', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per Whatsapp', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per Twitter', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per Instagram', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->

        <!-- wp:button {"fontSize":"small"} -->
        <div class="wp-block-button has-custom-font-size has-small-font-size">
          <a class="wp-block-button__link wp-element-button"><?= __('Comparteix per Mastodon', 'wpct'); ?></a>
        </div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->

      <!-- wp:spacer {"height":"7rem","className":"is-style-show-desktop"} -->
      <div style="height:7rem" aria-hidden="true" class="wp-block-spacer is-style-show-desktop"></div>
      <!-- /wp:spacer -->

      <!-- wp:spacer {"height":"4rem","className":"is-style-show-mobile-tablet"} -->
      <div style="height:4rem" aria-hidden="true" class="wp-block-spacer is-style-show-mobile-tablet"></div>
      <!-- /wp:spacer -->
    </div>
    <!-- /wp:group -->
  </section>
  <!-- /wp:group -->

  <!-- wp:group {"tagName":"section","align":"full","className":"is-style-no-padding","layout":{"type":"default"}} -->
  <section class="wp-block-group alignfull is-style-no-padding">
    <!-- wp:group {"className":"is-style-show-desktop","layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group is-style-show-desktop">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-no-padding","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-no-padding">
        <!-- wp:cover {"url":"/wp-content/uploads/2023/07/igualada-cover-2.png","id":3181,"dimRatio":0,"minHeight":640,"minHeightUnit":"px","layout":{"type":"constrained"}} -->
        <div class="wp-block-cover" style="min-height:640px">
          <span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
          <img class="wp-block-cover__image-background wp-image-3181" alt="" src="/wp-content/uploads/2023/07/igualada-cover-2.png" data-object-fit="cover" />
          <div class="wp-block-cover__inner-container">
            <!-- wp:paragraph {"align":"center","placeholder":"Escriu un títol...","fontSize":"large"} -->
            <p class="has-text-align-center has-large-font-size"></p>
            <!-- /wp:paragraph -->
          </div>
        </div>
        <!-- /wp:cover -->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"3rem","style":{"layout":{}}} -->
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading"><?= __('Perquè fer-se soci/a', 'wpct'); ?></h4>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p><?= $data['why_become_cooperator']; ?></p>
        <!-- /wp:paragraph -->

        <?php
        if ($data['become_cooperator_process']) : ?>
          <!-- wp:heading {"level":4} -->
          <h4 class="wp-block-heading"><?= __('Procés d’alta', 'wpct'); ?></h4>
          <!-- /wp:heading -->

          <!-- wp:paragraph -->
          <p><?= $data['become_cooperator_process']; ?></p>
          <!-- /wp:paragraph -->

        <?php endif; ?>

        <!-- wp:spacer {"height":"1rem","style":{"layout":{}}} -->
        <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:buttons -->
        <div class="wp-block-buttons">
          <!-- wp:button {"className":"is-style-rounded","fontSize":"small"} -->
          <div class="wp-block-button has-custom-font-size is-style-rounded has-small-font-size"><a class="wp-block-button__link wp-element-button" href="#contacte"><?= __('Posa-t’hi en contacte', 'wpct'); ?></a></div>
          <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

        <!-- wp:spacer {"height":"3rem","style":{"layout":{}}} -->
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile-tablet","layout":{"type":"constrained"}} -->
    <div class="wp-block-group is-style-show-mobile-tablet">
      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-no-padding","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-no-padding">
        <!-- wp:cover {"url":"https://wordpress.local/wp-content/uploads/2023/07/igualada-cover-2.png","id":3181,"dimRatio":0,"minHeight":400,"minHeightUnit":"px","layout":{"type":"constrained"}} -->
        <div class="wp-block-cover" style="min-height:400px">
          <span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
          <img class="wp-block-cover__image-background wp-image-3181" alt="" src="https://wordpress.local/wp-content/uploads/2023/07/igualada-cover-2.png" data-object-fit="cover" />
          <div class="wp-block-cover__inner-container">
            <!-- wp:paragraph {"align":"center","placeholder":"Escriu un títol...","fontSize":"large"} -->
            <p class="has-text-align-center has-large-font-size"></p>
            <!-- /wp:paragraph -->
          </div>
        </div>
        <!-- /wp:cover -->
      </div>
      <!-- /wp:group -->

      <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-horizontal-padded","layout":{"type":"default"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:spacer {"height":"3rem","style":{"layout":{}}} -->
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading"><?= __('Perquè fer-se soci/a', 'wpct'); ?></h4>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p><?= $data['why_become_cooperator']; ?></p>
        <!-- /wp:paragraph -->

        <?php
        if ($data['become_cooperator_process']) : ?>
          <!-- wp:heading {"level":4} -->
          <h4 class="wp-block-heading"><?= __('Procés d’alta', 'wpct'); ?></h4>
          <!-- /wp:heading -->

          <!-- wp:paragraph -->
          <p><?= $data['become_cooperator_process']; ?></p>
          <!-- /wp:paragraph -->

        <?php endif; ?>

        <!-- wp:spacer {"height":"1rem","style":{"layout":{}}} -->
        <div style="height:1rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:buttons -->
        <div class="wp-block-buttons">
          <!-- wp:button {"className":"is-style-rounded","fontSize":"small"} -->
          <div class="wp-block-button has-custom-font-size is-style-rounded has-small-font-size">
            <!-- /wp:heading -->
            <a class="wp-block-button__link wp-element-button" href="#contacte"><?= __('Posa-t’hi en contacte', 'wpct'); ?></a>
          </div>
          <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

        <!-- wp:spacer {"height":"3rem","style":{"layout":{}}} -->
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
  </section>
  <!-- /wp:group -->

  <!-- wp:group {"tagName":"section","align":"full","backgroundColor":"primary","className":"is-style-no-padding ce-landing-contact-section","layout":{"type":"default"}} -->
  <section class="wp-block-group alignfull is-style-no-padding ce-landing-contact-section has-primary-background-color has-background">
    <!-- wp:group {"className":"is-style-show-desktop","layout":{"type":"default"}} -->
    <div class="wp-block-group is-style-show-desktop">
      <!-- wp:spacer {"height":"5rem"} -->
      <div style="height:5rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->

      <!-- wp:group {"className":"is-style-horizontal-padded","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-default","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
        <div class="wp-block-group is-style-default">
          <!-- wp:heading -->
          <h2 class="wp-block-heading"><?= __('Contacta', 'wpct'); ?></h2>
          <!-- /wp:heading -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"3rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Adreça', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:paragraph -->
          <p><?= $data['street']; ?>, <?= $data['postal_code']; ?>, <?= $data['city']; ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
          <div class="wp-block-group">
            <!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity" />
            <!-- /wp:separator -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Butlletí', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:paragraph -->
          <p><?= __('Vols rebre informació de La Tonenca SCCL', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"className":"ce-landing-newsletter-form","layout":{"type":"flex","flexWrap":"nowrap"}} -->
          <div class="wp-block-group ce-landing-newsletter-form">
            <!-- wp:gravityforms/form {"formId":"5","title":false,"description":false,"ajax":true} /-->

            <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"100%","selfStretch":"fixed"}}} -->
            <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
          <div class="wp-block-group">
            <!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity" />
            <!-- /wp:separator -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Contacte', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
          <div class="wp-block-group">
            <!-- wp:paragraph -->
            <p><a href="http://<?= $data['external_website_link']; ?>"><strong><?= $data['external_website_link']; ?></strong> </a></p>
            <!-- /wp:paragraph -->

            <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"1em","selfStretch":"fixed"}}} -->
            <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:social-links {"iconColor":"typography","iconColorValue":"#191919","className":"is-style-logos-only"} -->
            <ul class="wp-block-social-links has-icon-color is-style-logos-only">
              <!-- wp:social-link {"url":"https://twitter.com","service":"twitter"} /-->
              <!-- wp:social-link {"url":"https://instagram.com","service":"instagram"} /-->
              <!-- wp:social-link {"url":"https://desktop.telegram.org/","service":"telegram"} /-->
            </ul>
            <!-- /wp:social-links -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->

        <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"70px","selfStretch":"fixed"}}} -->
        <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-default","layout":{"type":"default"}} -->
        <div id="contacte" class="wp-block-group is-style-default">
          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Formulari de contacte'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:paragraph -->
          <p><?= __('Consulta <a href="/recursos/#faqs">les preguntes més freqüents</a> i posa’t en contacte amb la Comunitat Energètica', 'wpct'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"2rem","width":"0px"} -->
          <div style="height:2rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"className":"is-style-default ce-landing-contact-form","layout":{"type":"default"}} -->
          <div class="wp-block-group is-style-default ce-landing-contact-form">
            <!-- wp:gravityforms/form {"formId":"6","title":false,"description":false} /-->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->

      <!-- wp:spacer {"height":"7rem"} -->
      <div style="height:7rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile-tablet","layout":{"type":"default"}} -->
    <div class="wp-block-group is-style-show-mobile-tablet">
      <!-- wp:spacer {"height":"3rem"} -->
      <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->

      <!-- wp:group {"className":"is-style-horizontal-padded","layout":{"type":"constrained"}} -->
      <div class="wp-block-group is-style-horizontal-padded">
        <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-default","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
        <div class="wp-block-group is-style-default">
          <!-- wp:heading -->
          <h2 class="wp-block-heading"><?= __('Contacta', 'wpct'); ?></h2>
          <!-- /wp:heading -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Adreça'); ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:paragraph -->
          <p><?= $data['street']; ?>, <?= $data['postal_code']; ?>, <?= $data['city']; ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
          <div class="wp-block-group">
            <!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity" />
            <!-- /wp:separator -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Butlletí', 'wpct') ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:group {"className":"ce-landing-newsletter-form","layout":{"type":"default"}} -->
          <div class="wp-block-group ce-landing-newsletter-form">
            <!-- wp:gravityforms/form {"formId":"5","title":false,"description":false,"ajax":true} /-->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"1rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
          <div class="wp-block-group">
            <!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity" />
            <!-- /wp:separator -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"2rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Contacte', 'wpct') ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
          <div class="wp-block-group">
            <!-- wp:paragraph -->
            <p><a href="https://<?= $data['external_website_link'] ?>"><strong><?= $data['external_website_link']; ?></strong> </a></p>
            <!-- /wp:paragraph -->

            <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"1em","selfStretch":"fixed"}}} -->
            <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->

            <!-- wp:social-links {"iconColor":"typography","iconColorValue":"#191919","className":"is-style-logos-only"} -->
            <ul class="wp-block-social-links has-icon-color is-style-logos-only">
              <!-- wp:social-link {"url":"https://twitter.com","service":"twitter"} /-->
              <!-- wp:social-link {"url":"https://instagram.com","service":"instagram"} /-->
              <!-- wp:social-link {"url":"https://desktop.telegram.org/","service":"telegram"} /-->
            </ul>
            <!-- /wp:social-links -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"0px","width":"0px","style":{"layout":{"flexSize":"1rem","selfStretch":"fixed"}}} -->
          <div style="height:0px;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-default","layout":{"type":"default"}} -->
        <div id="contacte" class="wp-block-group is-style-default">
          <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
          <div class="wp-block-group">
            <!-- wp:separator {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
            <hr class="wp-block-separator has-alpha-channel-opacity" />
            <!-- /wp:separator -->
          </div>
          <!-- /wp:group -->

          <!-- wp:spacer {"height":"2rem","width":"0px","style":{"layout":{}}} -->
          <div style="height:2rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:paragraph {"fontSize":"medium"} -->
          <p class="has-medium-font-size"><?= __('Formulari de contacte', 'wpct') ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:paragraph -->
          <p><?= __('Consulta <a href="/recursos/#faqs">les preguntes més freqüents</a> i posa’t en contacte amb la Comunitat Energètica', 'wpct') ?></p>
          <!-- /wp:paragraph -->

          <!-- wp:spacer {"height":"1rem","width":"0px","style":{"layout":{}}} -->
          <div style="height:1rem;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
          <!-- /wp:spacer -->

          <!-- wp:group {"className":"ce-landing-contact-form","layout":{"type":"default"}} -->
          <div class="wp-block-group ce-landing-contact-form">
            <!-- wp:gravityforms/form {"formId":"4","title":false,"description":false} /-->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->

      <!-- wp:spacer {"height":"4rem"} -->
      <div style="height:4rem" aria-hidden="true" class="wp-block-spacer"></div>
      <!-- /wp:spacer -->
    </div>
    <!-- /wp:group -->
  </section>
  <!-- /wp:group -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","theme":"wp-coop-ce-theme-v-2","tagName":"footer","className":"site-footer"} /-->

<?php
$html = do_shortcode(do_blocks(ob_get_clean()));
add_filter('the_content', function () use ($html) {
  return $html;
}, 99);
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>

<body <?= body_class(); ?>>
  <div class="wp-site-blocks">
    <?php the_content(); ?>
  </div>
  <?php wp_footer(); ?>
</body>

</html>
