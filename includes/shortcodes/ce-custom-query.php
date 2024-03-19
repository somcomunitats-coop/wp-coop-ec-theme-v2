<?php

function get_news_by_id_shortcode()
{
    ob_start(); // Start output buffering to capture the output
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
            $tags = get_the_tags();
            foreach ($tags as $tag) {
                echo '<li>' . $tag->name . '</li>';
            }

            echo '<li> <strong>' . get_the_title() . '</strong></li>';
        //echo '<li>' . get_the_tags($post->ID) . '</li>';
        endwhile;
    endif;
    echo "Hello from shortcode" . $queried_tag;
    return ob_get_clean(); // Return the buffered output
}
add_shortcode('get_news_by_tag', 'get_news_by_id_shortcode');
