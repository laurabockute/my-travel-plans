<?php
defined("C5_EXECUTE") or die("Access Denied.");

$ih = Core::make('helper/image');
?>

<!-- Feature Area -->
<!-- Carousel -->
<section class="carousel_wrap <?php echo ($useLargeHeading) ? 'carousel_news_wrap' : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 carousel_col">
                <header class="carousel_header">
                    <?php
                    if ($useLargeHeading) {
                        echo '<h1 class="carousel_heading">'.$heading.'</h1>';
                    } else {
                        echo '<h2 class="carousel_heading">'.$heading.'</h2>';
                    }

                    echo $content;
                    ?>
                </header>
                <div class="carousel_body js-carousel js-equalize" data-carousel-options='{"matchHeight":true,"contained":false,"paged":true,"theme":"carousel_base carousel_home","show":{"980px":1}}' data-equalize-options='{"target":".carousel_caption"}'>

                    <?php
                    if (!empty($item_items)) {
                        $i = 0;
                        foreach ($item_items as $item_item_key => $item_item) {
                            ?>
                            <div class="carousel_item">
                                <div class="carousel_item_content theme_<?php echo h($item_item["theme"]); ?>">
                                    <div class="carousel_content <?php echo $i === 0 ? 'carousel_first' : '' ?>">
                                        <figure class="carousel_figure">
                                            <picture class="carousel_picture">
                                                <!--[if IE 9]><video style="display: none;"><![endif]-->

                                                <?php
                                                $thumb586 = $thumb469 = $thumb335 = null;
                                                if ($item_item["image"]) {
                                                    try {
                                                        $thumb586 = $ih->getThumbnail($item_item["image"], 586, 390, true);
                                                        $thumb469 = $ih->getThumbnail($item_item["image"], 469, 313, true);
                                                        $thumb335 = $ih->getThumbnail($item_item["image"], 335, 224, true);
                                                    } catch (\Exception $e) {
                                                        
                                                    }
                                                }

                                                if ($thumb586) {
                                                    echo '<source media="(min-width: 992px)" srcset="'.$thumb586->src.'">';
                                                } else {
                                                    echo '<source media="(min-width: 992px)" srcset="https://spacehold.it/586x390/sjc/2">';
                                                }

                                                if ($thumb586) {
                                                    echo '<source media="(min-width: 768px)" srcset="'.$thumb469->src.'">';
                                                } else {
                                                    echo '<source media="(min-width: 768px)" srcset="https://spacehold.it/469x313/sjc/2">';
                                                }
                                                ?>
                                                <!--[if IE 9]></video><![endif]-->

                                                <?php
                                                if ($thumb335) {
                                                    echo '<img class="carousel_image" src="'.$thumb335->src.'" alt="'.$item_item["image"]->getTitle().'">';
                                                } else {
                                                    echo '<img class="carousel_image" src="https://spacehold.it/335x224/sjc/2" alt="@@alt">';
                                                }
                                                ?>
                                            </picture>
                                        </figure>

                                        <?php
                                        $link = !empty($item_item["image_link"]) && (($page = Page::getByID($item_item["image_link"])) && $page->error === false) ? $page->getCollectionLink() : '#';
                                        ?>
                                        <a href="<?php echo $link ?>">
                                            <div class="carousel_caption">
                                                <p class="carousel_type"><?php echo h($item_item["title"]) ?></p>
                                                <p class="carousel_link"><?php echo $item_item["text"]; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- END: Carousel -->
<!-- END: Feature Area -->