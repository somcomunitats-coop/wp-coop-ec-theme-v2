<?php
/**
 * Title: CE Header.
 * Slug: wpct/ce-header
 * Categories: wpct-header
 * Viewport Width: 1280
 */

?>
<?php
    $current_lang = pll_current_language();
?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--sxxs)","bottom":"var(--wp--custom--spacing--sxxs)"},"margin":{"top":"0px"}}},"backgroundColor":"brand","layout":{"inherit":true}} -->
<div class="wp-block-group alignfull has-brand-background-color has-background" style="margin-top:0px;padding-top:var(--wp--custom--spacing--sxxs);padding-bottom:var(--wp--custom--spacing--sxxs)"><!-- wp:group {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-group">

<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"600","lineHeight":"1.2"}},"textColor":"base","fontSize":"xx-small"} -->
<p class="has-base-color has-text-color has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase"><i class="fa-solid fa-circle-user"></i></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"600","lineHeight":"1.2"}},"fontSize":"xx-small"} -->
<p class="has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase">
    <?php if($current_lang == 'ca'): ?>
        <a style="color:#FFF;" href="#accedeix-ca"><?php echo esc_html__( 'Accedeix', 'wpct-ce' ); ?></a>
    <?php endif; ?>
    <?php if($current_lang == 'es'): ?>
        <a style="color:#FFF;" href="#accedeix-es"><?php echo esc_html__( 'Accede', 'wpct-ce' ); ?></a>
    <?php endif; ?>
</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"600","lineHeight":"1.2"}},"textColor":"base","fontSize":"xx-small"} -->
<p class="has-base-color has-text-color has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase"><i class="fa-solid fa-bolt"></i></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"600","lineHeight":"1.2"}},"fontSize":"xx-small"} -->
<p class="has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase">
    <?php if($current_lang == 'ca'): ?>
        <a style="color:#FFF;" href="#alta-ca"><?php echo esc_html__( 'Alta CE', 'wpct-ce' ); ?></a>
    <?php endif; ?>
    <?php if($current_lang == 'es'): ?>
        <a style="color:#FFF;" href="#alta-es"><?php echo esc_html__( 'Alta CE', 'wpct-ce' ); ?></a>
    <?php endif; ?>
</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"600","lineHeight":"1.2"}},"textColor":"base","fontSize":"xx-small"} -->
<p class="has-base-color has-text-color has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase"><i class="fa-solid fa-globe"></i></p>
<!-- /wp:paragraph -->
<!-- wp:list {"style":{"typography":{"lineHeight":"1.2","fontStyle":"normal","fontWeight":"600","textTransform":"uppercase"}},"textColor":"base","className":"is-style-no-disc","fontSize":"xx-small"} -->
<ul class="is-style-no-disc has-base-color has-text-color has-xx-small-font-size" style="font-style:normal;font-weight:600;line-height:1.2;text-transform:uppercase">
    <?php pll_the_languages( array( 'show_flags' => 0, 'dropdown' => 0,'force_home' => 0,'hide_current'=> 1) ); ?>
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--sm)","bottom":"var(--wp--custom--spacing--sm)"},"margin":{"top":"0px"}}},"className":"ce-header","layout":{"inherit":true}} -->
<div class="wp-block-group alignfull ce-header" style="margin-top:0px;padding-top:var(--wp--custom--spacing--sm);padding-bottom:var(--wp--custom--spacing--sm)"><!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:site-title {"style":{"elements":{"link":{"color":{"text":"var:preset|color|brand"}}}},"textColor":"typography"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group">

<?php if($current_lang == 'ca'): ?>
<!-- wp:navigation { "ref":521, "layout":{"type":"flex","orientation":"horizontal"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sxs)"}}} /-->
<?php endif; ?>
<?php if($current_lang == 'es'): ?>
<!-- wp:navigation { "ref":524, "layout":{"type":"flex","orientation":"horizontal"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sxs)"}}} /-->
<?php endif; ?>

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-rounded"} -->
<div class="wp-block-button is-style-rounded">
<a class="wp-block-button__link wp-element-button" href="<?php if($current_lang == 'ca'): echo '#cercar-ca'; endif;if($current_lang == 'es'): echo '#cercar-es'; endif; ?>"><i class="fa-solid fa-magnifying-glass"></i>
    <?php 
        if($current_lang == 'ca'):
            echo esc_html__( 'Cerca Comunitats', 'wpct-ce' );
        endif;
        if($current_lang == 'es'):
            echo esc_html__( 'Busca Comunidades', 'wpct-ce' );
        endif;
    ?>
</a>
</div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"5px"} -->
<div style="height:5px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->