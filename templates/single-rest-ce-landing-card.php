<?php

/**
 * Template Name: Single Rest CE Landing Card
 * Type: rest-ce-landing
 *
 * @plugin wpct-rest-ce-landings
 */

$post_id = get_the_ID();
$address = get_post_meta($post_id, 'ce-address', true);
if (!$address) $address = '&nbsp;';
ob_start();
?>

<!-- wp:group {"tagName":"article","backgroundColor":"base","className":"is-style-no-padding ce-card ce-post-card ce-landing-card","layout":{"type":"constrained"}} -->
<article class="wp-block-group is-style-no-padding has-base-background-color has-background ce-card ce-post-card ce-landing-card">
  <!-- wp:post-featured-image {"isLink":true,"align":"wide"} /-->

  <!-- wp:post-terms {"term":"rest-ce-status", "separator": ""} /-->

  <!-- wp:spacer {"height":"40px"} -->
  <div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->

  <!-- wp:group {"className":"ce-card-body"} -->
  <div class="wp-block-group ce-card-body">
    <!-- wp:group {"className":"is-style-show-desktop ce-card-terms"} -->
    <div class="wp-block-group is-style-show-desktop ce-card-terms">
      <!-- wp:post-terms {"term":"rest-ce-service","separator":""} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-tablet ce-card-terms"} -->
    <div class="wp-block-group is-style-show-tablet ce-card-terms">
      <!-- wp:post-terms {"term":"rest-ce-service","separator":""} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile ce-card-terms"} -->
    <div class="wp-block-group is-style-show-mobile ce-card-terms">
      <!-- wp:post-terms {"term":"rest-ce-service","separator":""} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:spacer {"height":"1em","width":"0px"} -->
    <div style="height:1em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:post-title {"isLink":true,"level":4,"className":"wp-block-heading"} /-->

    <div class="wp-block-post-excerpt">
      <div class="wp-block-post-excerpt__excerpt"><?= get_the_excerpt($post_id); ?></div>
    </div>

    <!-- wp:separator -->
    <hr class="wp-block-separator has-alpha-channel-opacity" />
    <!-- /wp:separator -->
    <p><?= $address ?></p>

    <p class="wp-block-post-excerpt__more-text">
      <a class="wp-block-post-excerpt__more-link" href="<?= get_post_permalink($post_id) ?>" tabindex="0">Més informació</a>
    </p>
  </div>
  <!-- /wp:group -->

  <!-- wp:spacer {"height":"3rem"} -->
  <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->
</article>
<!-- /wp:group -->

<?php
$content = do_shortcode(do_blocks(ob_get_clean()));
echo $content;
