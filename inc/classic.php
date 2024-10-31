<div class="tc_sing_blog swiper-slide">
    <div class="tc_post_thumbnail">
        
        <a <?php if("yes" === $settings['img_link']):?> href ="<?php esc_url(the_permalink()); ?>" <?php endif;?> >
         <?php
        if ($thumb_id) {
            $image1_alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
            $image_src = \Elementor\Group_Control_Image_Size::get_attachment_image_src($thumb_id, 'blg_img', $settings);
            echo sprintf('<img src="%s" title="%s" alt="%s"%s />', esc_url($image_src), get_the_title($thumb_id), $image1_alt, '');
        }
        ?>
        </a>
    </div>
    <?php if("yes" === $settings['post_title'] || 'yes' === $settings['post_content'] || $settings["button_text"]):?>
    <div class="tc_content_box" style="text-align: <?php echo esc_attr($settings["slider_align"]) ?>;">
    <?php if("yes" === $settings['post_title']): ?>
        <h3><?php esc_html(the_title()); ?></h3>
    <?php endif; ?>
        <div class="tc_blg_content">
            <?php if ('yes' === $settings['post_content']) :
                if ('tc_classic' === $settings['skin_type']) :
                    echo wp_kses_post(wp_trim_words(get_the_content(), $settings['post_excerpt'], "<span class='tc_post_dots'>..</span>"));
                else : echo wp_kses_post(get_the_content());
                endif;
            endif; ?>
        </div>
        <?php if ($settings["button_text"]) : ?>
            <a href="<?php esc_url(the_permalink())?>" class="tc_blg_btn">
                <?php echo esc_html($settings["button_text"]) ?>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>