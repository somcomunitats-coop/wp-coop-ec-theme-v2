<?php

/*
 * Title: CE Post Card Simple
 * Slug: ce-pattern/post-card-simple
 * Categories: ce-pattern
 * Viewport Width: 1500
 */



$terms = get_the_terms($post_id, 'post_tag');
?>
<li class="wp-block-post ce-news type-ce-news status-publish has-post-thumbnail hentry">

    <article class="wp-block-group is-style-no-padding ce-card ce-post-card has-base-background-color has-background is-layout-constrained wp-block-group-is-layout-constrained">
        <figure class="alignwide wp-block-post-featured-image"><a href="<?= get_permalink(); ?>" target="_self"><img src="<?= get_the_post_thumbnail_url(); ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="<?= get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true); ?>" style="object-fit:cover;" decoding="async" loading="lazy"></a></figure>
        <div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
        <div class="wp-block-group ce-card-body is-layout-flow wp-block-group-is-layout-flow">
            <div class="wp-block-group is-style-show-desktop is-layout-flow wp-block-group-is-layout-flow">
                <div class="taxonomy-post_tag wp-block-post-terms">
                    <?php foreach ($terms as $term) { ?><a href="<?= 'https://somcomunitats.local/tag/' . $term->slug . '/'; ?>" rel="tag"><?= $term->name ?></a><?php } ?>
                </div>
            </div>

            <div class="wp-block-group is-style-show-tablet is-layout-flow wp-block-group-is-layout-flow">
                <div class="taxonomy-post_tag wp-block-post-terms">
                    <?php foreach ($terms as $term) { ?><a href="<?= 'https://somcomunitats.local/tag/' . $term->slug . '/'; ?>" rel="tag"><?= $term->name ?></a><?php } ?>
                </div>
            </div>
            <div class="wp-block-group is-style-show-mobile is-layout-flow wp-block-group-is-layout-flow">
                <div class="taxonomy-post_tag wp-block-post-terms">
                    <?php foreach ($terms as $term) { ?><a href="<?= 'https://somcomunitats.local/tag/' . $term->slug . '/'; ?>" rel="tag"><?= $term->name ?></a><?php } ?>
                </div>
            </div>
            <div style="height:1em;width:0px" aria-hidden="true" class="wp-block-spacer"></div>
            <div class="wp-block-post-date"><time datetime="2023-11-17T10:33:24+00:00"><?= get_the_date(); ?></time></div>

            <h5 class="wp-block-heading wp-block-post-title"><a href="<?= get_permalink(); ?>" target="_self"><?php echo get_the_title(); ?></a></h5>

            <div class="wp-block-post-excerpt">
                <p class="wp-block-post-excerpt__excerpt"><?= get_the_excerpt(); ?></p>
                <p class="wp-block-post-excerpt__more-text"><a class="wp-block-post-excerpt__more-link" href="<?php echo get_permalink(); ?>">Más información</a></p>
            </div>
        </div>
        <div style="height:3rem" aria-hidden="true" class="wp-block-spacer"> </div>
    </article>

</li>