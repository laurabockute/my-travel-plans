<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php  $unique_tabs_id = Core::make('helper/validation/identifier')->getString(18);
$tabs = array(
    array('form-basics-' . $unique_tabs_id, t('Basics'), true),
    array('form-images_items-' . $unique_tabs_id, t('Images'))
);
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="ccm-tab-content" id="ccm-tab-content-form-basics-<?php  echo $unique_tabs_id; ?>">
    <div class="form-group">
    <?php  echo $form->label('launchLabel', t("Label to open the gallery") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("E.g. &quot;Launch the Gallery&quot;") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('launchLabel', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('launchLabel'), $launchLabel, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php  echo $form->label('theme', t("Theme")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('theme', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->select($view->field('theme'), $theme_options, $theme, array()); ?>
</div><div class="form-group">
    <?php 
    if (isset($image) && $image > 0) {
        $image_o = File::getByID($image);
        if (!$image_o || $image_o->isError()) {
            unset($image_o);
        }
    } ?>
    <?php  echo $form->label('image', t("Image") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("The image that shows up on the page itself") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('image', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make("helper/concrete/asset_library")->image('ccm-b-popup_gallery-image-' . Core::make('helper/validation/identifier')->getString(18), $view->field('image'), t("Choose Image"), $image_o); ?>
</div><div class="form-group">
    <?php  echo $form->label('popupHeading', t("Popup Heading") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("E.g. &quot;Annapolis, Through the Years&quot;") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('popupHeading', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('popupHeading'), $popupHeading, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php  echo $form->label('popupIntro', t("Popup Intro text")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('popupIntro', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make('editor')->outputBlockEditModeEditor($view->field('popupIntro'), $popupIntro); ?>
</div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-form-images_items-<?php  echo $unique_tabs_id; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php  echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php  $repeatable_container_id = 'btPopupGallery-images-container-' . Core::make('helper/validation/identifier')->getString(18); ?>
    <div id="<?php  echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php  echo t('Add Image'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php  echo htmlspecialchars(
                json_encode(
                    array(
                        'items' => $images_items,
                        'order' => array_keys($images_items),
                    )
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php  echo t('Add Image'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php  echo t('Images') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php  echo $view->field('images'); ?>[{{id}}][image]" class="control-label"><?php  echo t("Image"); ?></label>
    <?php  echo isset($btFieldsRequired['images']) && in_array('image', $btFieldsRequired['images']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div data-file-selector-input-name="<?php  echo $view->field('images'); ?>[{{id}}][image]" class="ccm-file-selector ft-image-image-file-selector" data-file-selector-f-id="{{ image }}"></div>
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('images'); ?>[{{id}}][caption]" class="control-label"><?php  echo t("Caption"); ?></label>
    <?php  echo isset($btFieldsRequired['images']) && in_array('caption', $btFieldsRequired['images']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php  echo $view->field('images'); ?>[{{id}}][caption]" id="<?php  echo $view->field('images'); ?>[{{id}}][caption]" class="form-control" rows="5">{{ caption }}</textarea>
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
    Concrete.event.publish('btPopupGallery.images.edit.open', {id: '<?php  echo $repeatable_container_id; ?>'});
    $.each($('#<?php  echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>