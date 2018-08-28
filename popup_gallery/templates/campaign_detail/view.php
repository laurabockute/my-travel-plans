<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php
$ih = Core::make('helper/image');
?>

<div class="campaign_lockup">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <div class="campaign_lockup_container with_gallery">
                            <div class="row">
                                <div class="col-xs-12">

                                    <!-- Gallery -->
                                    <section class="gallery_wrap">
                                        <div class="gallery">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-5 col_centered">
                                                    <a href="#gallery_show" class="js-lightbox gallery_link theme_<?php echo h($theme) ?>"><span class="gallery_label"><?php echo h($launchLabel); ?></span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $dataBackgroundOptions = '';
                                        $thumb500  = $ih->getThumbnail($image, 500, 500, true);
                                        $thumb740  = $ih->getThumbnail($image, 740, 740, true);
                                        $thumb980  = $ih->getThumbnail($image, 980, 552, true);
                                        $thumb1400 = $ih->getThumbnail($image, 1400, 435, true);
                                        $dataBackgroundOptions = '{"source":{"0px":"'.$thumb500->src.'","500px":"'.$thumb740->src.'","768px":"'.$thumb980->src.'","992px":"'.$thumb1400->src.'"}}';
                                        ?>
                                        <div class="js-background gallery_background" data-background-options='<?php echo $dataBackgroundOptions ?>'></div>
                                    </section>

                                    <div id="gallery_show" class="gallery_show">
                                        <div class="gallery_content">
                                            <header class="gallery_header">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <?php
                                                            $iImageItems = count($images_items);
                                                            ?>
                                                            <p class="gallery_count"><?php echo t2('%d photo', '%d photos', $iImageItems, $iImageItems); ?></p>

                                                            <?php
                                                            if ($popupHeading) {
                                                                echo '<h1 class="gallery_heading">'.h($popupHeading).'</h1>';
                                                            }
                                                            ?>

                                                            <?php
                                                            if ($popupIntro) {
                                                                // This is originally wrapped in a p-tag, but we may want to use the wysiwyg-editor.
                                                                echo '<div class="gallery_intro">'.$popupIntro.'</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </header>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="gallery_body">

                                                            <?php
                                                            foreach ($images_items as $image_item) {
                                                                if (!$image_item['image']) {
                                                                    continue;
                                                                }
                                                                ?>
                                                                <div class="gallery_item">
                                                                    <figure class="gallery_figure">
                                                                        <picture class="gallery_picture">
                                                                            <!--[if IE 9]><video style="display: none;"><![endif]-->

                                                                            <?php
                                                                            $thumb980 = $ih->getThumbnail($image_item['image'], 980, 552, true);
                                                                            if ($thumb980) {
                                                                                ?>
                                                                                <source media="(min-width: 992px)" srcset="<?php echo $thumb980->src ?>">
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            $thumb740 = $ih->getThumbnail($image_item['image'], 740, 416, true);
                                                                            if ($thumb740) {
                                                                                ?>
                                                                                <source media="(min-width: 992px)" srcset="<?php echo $thumb740->src ?>">
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            $thumb500 = $ih->getThumbnail($image_item['image'], 500, 282, true);
                                                                            if ($thumb500) {
                                                                                ?>
                                                                                <source media="(min-width: 992px)" srcset="<?php echo $thumb500->src ?>">
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <!--[if IE 9]></video><![endif]-->

                                                                            <?php
                                                                            $thumb300 = $ih->getThumbnail($image_item['image'], 300, 169, true);
                                                                            if ($thumb300) {
                                                                                ?>
                                                                                <img class="gallery_image" src="<?php echo $thumb300->src ?>" alt="<?php echo $image_item["image"]->getTitle(); ?>">
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                        </picture>
                                                                    </figure>
                                                                    <?php
                                                                    if (trim($image_item['caption'])) {
                                                                        ?>
                                                                        <div class="gallery_caption">
                                                                            <p>
                                                                                <?php
                                                                                echo h($image_item['caption']);
                                                                                ?>
                                                                            </p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Gallery -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

