<?php

function get_news_by_id_shortcode()
{
    ob_start(); // Start output buffering to capture the output


?>
    <section class="wp-block-group is-style-no-padding is-layout-constrained wp-block-group-is-layout-constrained">
        <div class="wp-block-group is-layout-flow wp-block-group-is-layout-flow">
            <div class="wp-block-query ce-news-query is-layout-flow wp-block-query-is-layout-flow">
                <ul class="wp-block-post-template is-layout-flow wp-block-post-template-is-layout-flow">
                    <?php
                    global $wp_query;
                    $queried_tag = $wp_query->get_queried_object_id();
                    $news_args = array(
                        'post_type' => 'ce-news',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'tag_id' => $queried_tag,
                    );
                    $news_by_tag = new WP_Query($news_args);
                    if ($news_by_tag->have_posts()) :
                        while ($news_by_tag->have_posts()) :
                            $news_by_tag->the_post();
                            $post_id = get_the_ID();
                            require(dirname(__FILE__, 2) . '/shortcodes/ce-news-card-template.php');

                        endwhile;
                    endif; ?>
                    <div class="pagination">
                        <?php
                        echo paginate_links(array(
                            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'total'        => $news_by_tag->max_num_pages,
                            'current'      => max(1, get_query_var('paged')),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 1,
                            'prev_next'    => true,
                            'prev_text'    => sprintf('<i></i> %1$s', __('Newer Posts', 'text-domain')),
                            'next_text'    => sprintf('%1$s <i></i>', __('Older Posts', 'text-domain')),
                            'add_args'     => false,
                            'add_fragment' => '',
                        ));
                        ?>
                    </div>


                </ul>
            </div>
        </div>
    </section>

<?php
    return ob_get_clean(); // Return the buffered output
}
add_shortcode('get_news_by_tag', 'get_news_by_id_shortcode');
