<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<section class="stat_wrap grid">
	<?php if (isset($heading) && trim($heading) != "") { ?>
        <header class="stat_header">
        	<h2 class="stat_heading"><?php echo h($heading); ?></h2>
        </header>
	<?php } ?>
    
	<?php if (!empty($item_items)) { ?>
    	<?php $i = 0; ?>
		<?php foreach ($item_items as $item_item_key => $item_item) { ?><?php if ($item_item["image"]) { ?>
            <div class="col-xs-12 col-sm-4">
    		<div class="stat_content">
            <figure class="stat_figure">
                <picture class="stat_picture">
                    <?php if ($item_item["image_thumb"] = Core::make('helper/image')->getThumbnail($item_item["image"], 100, 100, true)) { ?>
                    	 <!--[if IE 9]>
                         <video style="display: none;"><![endif]-->
                         <source media="(min-width: 992px)" srcset="<?php echo $item_item["image_thumb"]->src; ?>">
                         <!--[if IE 9]></video><![endif]-->
                        <img class="stat_image" src="<?php echo $item_item["image_thumb"]->src; ?>" alt="<?php echo $item_item["image"]->getTitle(); ?>"/>
                    <?php } ?>
                </picture>
            </figure>
		<?php } ?>
        
        <?php if (isset($item_item["fact"]) && trim($item_item["fact"]) != "") { ?>
            <div class="stat_number_wrap">
                <h3 class="stat_number"><?php echo h($item_item["fact"]); ?></h3>
            </div>
            </div>
			<?php } ?>
        
		<?php if (isset($item_item["description_1"]) && trim($item_item["description_1"]) != "") { ?>
        	<div class="stat_desc"><?php echo $item_item["description_1"]; ?></div>
		<?php } ?>
	
        </div>
        <?php if($i % 3 == 2){ ?>
        <div class="clearfix"></div>
        <?php } ?>
        <?php $i++; ?>
	<?php } ?>
	<?php } ?>
 </section>