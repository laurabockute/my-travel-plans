<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php  $unique_tabs_id = Core::make('helper/validation/identifier')->getString(18);
$tabs = array(
    array('form-basics-' . $unique_tabs_id, t('Basics'), true),
    array('form-item_items-' . $unique_tabs_id, t('Items'))
);
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="ccm-tab-content" id="ccm-tab-content-form-basics-<?php  echo $unique_tabs_id; ?>">
    <div class="form-group">
    <?php  echo $form->label('heading', t("Heading") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("E.g. &quot;News&quot;") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('heading', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('heading'), $heading, array (
  'maxlength' => 255,
)); ?>
</div>
<div class="form-group">
    <?php  echo $form->label('useLargeHeading', t("Use large heading") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("If checked the heading will be Heading 1 instead of Heading 2.") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('useLargeHeading', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->select($view->field('useLargeHeading'), (isset($btFieldsRequired) && in_array('useLargeHeading', $btFieldsRequired) ? array() : array("" => "--" . t("Select") . "--")) + array(0 => t("No"), 1 => t("Yes")), $useLargeHeading, array()); ?>
</div>
<div class="form-group">
    <?php  echo $form->label('content', t("Content")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('content', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make('editor')->outputBlockEditModeEditor($view->field('content'), $content); ?>
</div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-form-item_items-<?php  echo $unique_tabs_id; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php  echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php  $repeatable_container_id = 'btPageCarousel-item-container-' . Core::make('helper/validation/identifier')->getString(18); ?>
    <div id="<?php  echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php  echo t('Add Item'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php  echo htmlspecialchars(
                json_encode(
                    array(
                        'items' => $item_items,
                        'order' => array_keys($item_items),
                    )
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php  echo t('Add Item'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php  echo t('Item') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php  echo $view->field('item'); ?>[{{id}}][image]" class="control-label"><?php  echo t("Image"); ?></label>
    <?php  echo isset($btFieldsRequired['item']) && in_array('image', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div data-file-selector-input-name="<?php  echo $view->field('item'); ?>[{{id}}][image]" class="ccm-file-selector ft-image-image-file-selector" data-file-selector-f-id="{{ image }}"></div>
</div>
<div class="form-group">
    <label for="<?php  echo $view->field('item'); ?>[{{id}}][image_link]" class="control-label"><?php  echo t("Image") . " " . t("link"); ?></label>
    <div data-page-selector="{{token}}" data-input-name="<?php  echo $view->field('item'); ?>[{{id}}][image_link]" data-cID="{{image_link}}" class="ft-image-image-page-selector"></div>
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('item'); ?>[{{id}}][title]" class="control-label"><?php  echo t("Title") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("E.g. &quot;Student&quot; or &quot;FEBRUARY 28, 2016&quot;") . '"></i>'; ?></label>
    <?php  echo isset($btFieldsRequired['item']) && in_array('title', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php  echo $view->field('item'); ?>[{{id}}][title]" id="<?php  echo $view->field('item'); ?>[{{id}}][title]" class="form-control" type="text" value="{{ title }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('item'); ?>[{{id}}][text]" class="control-label"><?php  echo t("Text"); ?></label>
    <?php  echo isset($btFieldsRequired['item']) && in_array('text', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php  echo $view->field('item'); ?>[{{id}}][text]" id="<?php  echo $view->field('item'); ?>[{{id}}][text]" class="ft-wysiwyg">{{ text }}</textarea>
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('item'); ?>[{{id}}][theme]" class="control-label"><?php  echo t("Theme"); ?></label>
    <?php  echo isset($btFieldsRequired['item']) && in_array('theme', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  $itemTheme_options = $item['theme_options']; ?>
                    <select name="<?php  echo $view->field('item'); ?>[{{id}}][theme]" id="<?php  echo $view->field('item'); ?>[{{id}}][theme]" class="form-control">{{#select theme}}<?php  foreach ($itemTheme_options as $k => $v) {
                        echo "<option value='" . $k . "'>" . $v . "</option>";
                     } ?>{{/select}}</select>
</div></div>

                <span class="sortable-item-collapse-toggle"></span>

                <a href="#" class="sortable-item-delete" data-attr-confirm-text="<?php  echo t('Are you sure'); ?>">
                    <i class="fa fa-times"></i>
                </a>

                <div class="sortable-item-handle">
                    <i class="fa fa-sort"></i>
                </div>
            </div>
        </script>
    </div>

<script type="text/javascript">
    Concrete.event.publish('btPageCarousel.item.edit.open', {id: '<?php  echo $repeatable_container_id; ?>'});
    $.each($('#<?php  echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>