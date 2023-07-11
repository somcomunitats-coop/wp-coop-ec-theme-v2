<?php

/**
 * Title: CE News Card.
 * Slug: ce-pattern/ce-news-card
 * Categories: ce-pattern
 * Viewport Width: 1280
 */

?>

<!-- wp:group {"backgroundColor":"base","className":"is-style-no-padding","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-no-padding has-base-background-color has-background ce-pattern-news-card">
  <!-- wp:post-featured-image {"isLink":true,"align":"wide"} /-->

  <!-- wp:group {"className":"is-style-padded","layout":{"type":"default"}} -->
  <div class="wp-block-group is-style-padded">
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
</div>
<!-- /wp:group -->
