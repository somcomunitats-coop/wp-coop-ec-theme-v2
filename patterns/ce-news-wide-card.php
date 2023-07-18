<?php

/**
 * Title: CE News Wide Card.
 * Slug: ce-pattern/news-wide-card
 * Categories: ce-pattern
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"tagName":"article","align":"wide","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"},"className":"ce-pattern-news-wide-card"} -->
<article class="wp-block-group alignwide ce-wide-card ce-news-wide-card">
  <!-- wp:group {"align":"wide","style":{"layout":{"selfStretch":"fixed","flexSize":"50%"}},"className":"is-style-no-padding","layout":{"type":"default"}} -->
  <div class="wp-block-group alignwide is-style-no-padding">
    <!-- wp:post-featured-image {"isLink":true,"height":"100%","width":"100%","align":"left"} /-->
  </div>
  <!-- /wp:group -->
  <!-- wp:group {"backgroundColor":"base","className":"is-style-padded ce-card-body","layout":{"type":"constrained"}} -->
  <div class="wp-block-group is-style-padded has-base-background-color has-background ce-card-body">
    <!-- wp:spacer {"height":"3em","width":"0px","style":{"layout":{}}} -->
    <div style="height:3em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    <!-- wp:post-terms {"term":"post_tag"} /-->
    <!-- wp:spacer {"height":"1em","width":"0px","style":{"layout":{}}} -->
    <div style="height:1em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    <!-- wp:post-date /-->
    <!-- wp:post-title {"level":4,"isLink":true,"className":"wp-block-heading"} /-->
    <!-- wp:spacer {"height":"3em","width":"0px","style":{"layout":{}}} -->
    <div style="height:3em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    <!-- wp:post-excerpt {"moreText":"Més informació"} /-->
    <!-- wp:spacer {"height":"3em","width":"0px","style":{"layout":{}}} -->
    <div style="height:3em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
  </div>
  <!-- /wp:group -->
</article>
<!-- /wp:group -->
