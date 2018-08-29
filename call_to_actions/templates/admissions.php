<section class="admission_feature">
    <div class="admission_feature_wrapper">
        <?php
        if ($bgimage) {
            Loader::element('js_background', array(
                'thumbnails' => [
                     "0px"   => [500, 500],
                     "500px" => [768, 768],
                     "768px" => [992, 558],
                     "992px" => [1400, 435]
                ],
                'image' => $bgimage,
                'bgclass' => 'admission_feature_bg'
            ), 'sjc2016');
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <header class="admission_feature_header">
                        <h1 class="admission_feature_heading"><?php  echo h($headline); ?></h1>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="admission_feature_body">

                    <?php
                    if (!empty($ctas_items)) {
                        foreach ($ctas_items as $ctas_item_key => $ctas_item) {

                            $link = null;
                            $text = $ctas_item["link_text"];
                            $theme = 'theme_' . $ctas_item["theme"];

                            if (!empty($ctas_item["link"])) {
                                if(is_numeric($currentCID = $ctas_item["link"])) {
                                    $thisLink = is_object($pageObj = Page::getByID($currentCID)) ? Page::getByID($currentCID)->getCollectionLink() : '';
                                    $fallbackLinkName = $pageObj->getCollectionName();
                                } else {
                                    $thisLink =  $ctas_item["link"];
                                }
                                $link = $thisLink;
                                $text = isset($ctas_item["link_text"]) && trim($ctas_item["link_text"]) != "" ? $ctas_item["link_text"] : $fallbackLinkName;
                            }

                            ?>
                            <div class="admission_feature_item <?php echo $theme ?>">
                                <div class="admission_feature_item_wrapper">
                                    <a rel="external_test" href="<?php echo $link ?>" class="student_content">
                                        <?php
                                        if ($ctas_item["image"]) {
                                            Loader::element('figure', array(
                                                'default' => [383,256],
                                                'thumbnails' => [
                                                     // "992px"   => [383,256],
                                                     // "768px"   => [383,256],
                                                     // "500px"   => [383,256],
                                                ],
                                                'image' => $ctas_item["image"],
                                                'class_prefix' => 'admission_feature_item'
                                            ), 'sjc2016');
                                        }
                                        ?>
                                         <div class="admission_feature_item_link">
                                            <span class="admission_feature_item_label"><?php echo $text ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>