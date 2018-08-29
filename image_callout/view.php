<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php
$ih =  Core::make('helper/image');

$thumb690 = $thumb454 = null;
if ($image) {
    $thumb690 = $ih->getThumbnail($image, 690, 460, true);
    $thumb307 = $ih->getThumbnail($image, 307, 205, true);
}

if (!$thumb690 || !$thumb307) {
    return false;
}
?>

<!-- Image Callout -->
<section class="image_callout_wrap theme_<?php echo h($theme) ?>">
    <div class="row">
        <div class="col-xs-5 image_callout_wrapper">
            <div class="image_callout">
                <figure class="image_callout_figure">
                    <picture class="image_callout_picture">
                        <!--[if IE 9]><video style="display: none;"><![endif]-->
                        <source media="(min-width: 992px)" srcset="<?php echo $thumb307->src ?>">
                        <!--[if IE 9]></video><![endif]-->
                        <img class="image_callout_image" src="<?php echo $thumb690->src ?>" alt="<?php echo $image->getTitle() ?>">
                    </picture>
                </figure>
            </div>
        </div>
        <div class="col-xs-7 image_callout_desc_wrapper">
            <div class="image_callout_desc">
                <h5 class="image_callout_heading"><?php echo h($heading); ?></h5>
                <p class="image_callout_text"><?php echo h($text); ?></p>

                <?php
                // First (optional) button
                if (!empty($firstButtonLink)) {
                    if(is_numeric($firstButtonLink)) {
                        $link = is_object($pageObj = Page::getByID($firstButtonLink)) ? Page::getByID($firstButtonLink)->getCollectionLink() : '';
                        $fallbackLinkName = $pageObj->getCollectionName();
                    } else {
                        $link =  $firstButtonLink;
                        $fallbackLinkName = '';
                    }

                    $title = ($firstButtonLink_text) != "" ? $firstButtonLink_text : $fallbackLinkName;
                    $button_theme = h($firstButtonTheme) ? h($firstButtonTheme) : 'blue';
                    ?>
                    <a href="<?php echo $link ?>" rel="external_test" class="image_callout_button theme_<?php echo $button_theme ?>"><?php echo $title ?></a>
                    <?php
                }


                // Second (optional) button
                if (!empty($secondButtonLink)) {

                    if(is_numeric($secondButtonLink)) {
                        $link = is_object($pageObj = Page::getByID($secondButtonLink)) ? Page::getByID($secondButtonLink)->getCollectionLink() : '';
                        $fallbackLinkName = $pageObj->getCollectionName();
                    } else {
                        $link =  $secondButtonLink;
                        $fallbackLinkName = '';
                    }


                    $title = ($secondButtonLink_text) != "" ? $secondButtonLink_text : $fallbackLinkName;
                    $button_theme = h($secondButtonTheme) ? h($secondButtonTheme) : 'blue';
                    ?>
                    <a href="<?php echo $link ?>" rel="external_test" class="image_callout_button theme_<?php echo $button_theme ?>"><?php echo $title ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Image Callout -->