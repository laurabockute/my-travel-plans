<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<section class="calls_to_action" role="region" aria-labelledby="calls_to_action_heading">
    <div class="calls_to_action_wrapper">
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
                'bgclass' => 'calls_to_action_bg'
            ), 'sjc2016');
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <header class="calls_to_action_header">
                        <h2 class="calls_to_action_heading"><?php  echo h($headline); ?></h2>
                    </header>
                    <div class="calls_to_action_body calls_to_action_count_<?php echo count($ctas_items) ?>">


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

                                <div class="calls_to_action_item <?php echo $theme ?>">
                                    <div class="calls_to_action_item_wrapper">
                                        <?php
                                        if ($ctas_item["image"]) {
                                            Loader::element('js_background', array(
                                                'thumbnails' => [
                                                     "0px"   => [400, 226]
                                                ],
                                                'image' => $ctas_item["image"],
                                                'bgclass' => 'calls_to_action_item_bg'
                                            ), 'sjc2016');
                                        }
                                        ?>
                                        <a rel="external_test" class="calls_to_action_link" href="<?php echo $link ?>">
                                            <?php
                                            if ($ctas_item["image"]) {
                                                Loader::element('figure', array(
                                                    'default' => [80,80],
                                                    'thumbnails' => [
                                                         "768px"   => [263,127]
                                                    ],
                                                    'image' => $ctas_item["image"],
                                                    'class_prefix' => 'calls_to_action'
                                                ), 'sjc2016');
                                            }
                                            ?>
                                            <div class="calls_to_action_content">
                                                <span class="calls_to_action_label"><?php echo $text ?></span>
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