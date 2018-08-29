<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

    <?php if (isset($useLargeHeading) && trim($useLargeHeading) != "") { ?><?php echo $useLargeHeading == 1 ? t("Yes") : t("No"); ?><?php } ?>
          <div class="accordion-set">
                <?php if (!empty($item_items)) { ?>
                    <div class="accordion-container">
                        <?php foreach ($item_items as $item_item_key => $item_item) { ?>
                        
                            <?php if (isset($item_item["heading"]) && trim($item_item["heading"]) != "") { ?>
                            
                                <a aria-expanded="false" href="#" class="accordion-toggle <?php echo ($useLargeHeading) ? 'heading_3' : '' ?>" data-defaultopen="false" aria-disabled="true">
                                    <?php echo h($item_item["heading"]); ?>
                                    <span class="toggle-icon"><span class="fa-stack fa-lg"><span class="fa fa-circle fa-stack-2x"></span><span class="fa fa-angle-right fa-stack-1x"></span></span></span>
                                        <!--end toggle-icon -->
                                </a>
                              <?php } ?>
                              
                              
                                    <?php if (isset($item_item["content"]) && trim($item_item["content"]) != "") { ?>
                                        <div class="accordion-content" style="display: none;">
                                            <?php echo $item_item["content"]; ?>
                                        </div>
                                        <?php } ?>
                                        
                                        
                       <?php } ?>
                    </div>
                 <?php } ?>
           </div>