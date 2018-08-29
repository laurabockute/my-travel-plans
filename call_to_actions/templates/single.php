<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>
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

            <div class="call_to_action <?php echo $theme ?>">
                <?php
                if ($ctas_item["image"]) {
                    Loader::element('js_background', array(
                        'thumbnails' => [
                             "0px"   => [750, 240]
                        ],
                        'image' => $ctas_item["image"],
                        'bgclass' => 'call_to_action_bg'
                    ), 'sjc2016');
                }
                ?>
                <a rel="external_test" class="call_to_action_link" href="<?php echo $link ?>">
                    <span class="call_to_action_label"><?php echo $text ?></span>
                </a>
            </div>
        <?php
    }
}
?>