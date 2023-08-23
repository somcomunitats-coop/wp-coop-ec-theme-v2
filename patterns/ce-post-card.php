<?php

/**
 * Title: CE Post Card.
 * Slug: ce-pattern/post-card
 * Categories: ce-pattern
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"tagName":"article","backgroundColor":"base","className":"is-style-no-padding ce-card ce-post-card","layout":{"type":"constrained"}} -->
<article class="wp-block-group is-style-no-padding has-base-background-color has-background ce-card ce-post-card">
  <!-- wp:post-featured-image {"isLink":true,"align":"wide"} /-->

  <!-- wp:spacer {"height":"40px"} -->
  <div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->

  <!-- wp:group {"className":"ce-card-body","layout":{"type":"default"}} -->
  <div class="wp-block-group ce-card-body">
    <!-- wp:group {"className":"is-style-show-desktop","layout"{"type":"default"}} -->
    <div class="wp-block-group is-style-show-desktop">
      <!-- wp:post-terms {"term":"post_tag"} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-tablet","layout"{"type":"default"}} -->
    <div class="wp-block-group is-style-show-tablet">
      <!-- wp:post-terms {"term":"post_tag"} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"className":"is-style-show-mobile","layout"{"type":"default"}} -->
    <div class="wp-block-group is-style-show-mobile">
      <!-- wp:post-terms {"term":"post_tag"} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:spacer {"height":"1em","width":"0px","style":{"layout":{}}} -->
    <div style="height:1em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    <!-- wp:post-date /-->
    <!-- wp:post-title {"isLink":true,"level":4,"className":"wp-block-heading"} /-->
    <!-- wp:post-excerpt {"moreText":"Més informació"} /-->
  </div>
  <!-- /wp:group -->

  <!-- wp:spacer {"height":"3rem"} -->
  <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->
</article>
<!-- /wp:group -->
