<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php  $unique_tabs_id = Core::make('helper/validation/identifier')->getString(18);
$tabs = array(
    array('form-basics-' . $unique_tabs_id, t('Basics'), true),
    array('form-ctas_items-' . $unique_tabs_id, t('Call To Action'))
);
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="ccm-tab-content" id="ccm-tab-content-form-basics-<?php  echo $unique_tabs_id; ?>">
    <div class="form-group">
    <?php  echo $form->label('headline', t("Headline")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('headline', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('headline'), $headline, array (
  'maxlength' => 255,
)); ?>
</div><div class="form-group">
    <?php 
    if (isset($bgimage) && $bgimage > 0) {
        $bgimage_o = File::getByID($bgimage);
        if (!$bgimage_o || $bgimage_o->isError()) {
            unset($bgimage_o);
        }
    } ?>
    <?php  echo $form->label('bgimage', t("Background Image")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('bgimage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make("helper/concrete/asset_library")->image('ccm-b-call_to_actions-bgimage-' . Core::make('helper/validation/identifier')->getString(18), $view->field('bgimage'), t("Choose Image"), $bgimage_o); ?>
</div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-form-ctas_items-<?php  echo $unique_tabs_id; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php  echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
<?php  $repeatable_container_id = 'btCallToActions-ctas-container-' . Core::make('helper/validation/identifier')->getString(18); ?>
    <div id="<?php  echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php  echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php  echo htmlspecialchars(
                json_encode(
                    array(
                        'items' => $ctas_items,
                        'order' => array_keys($ctas_items),
                    )
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php  echo t('Add Entry'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php  echo t('Call To Action') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php  echo $view->field('ctas'); ?>[{{id}}][link]" class="control-label"><?php  echo t("Link"); ?></label>
    <?php  echo isset($btFieldsRequired['ctas']) && in_array('link', $btFieldsRequired['ctas']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input type="text" class="form-control" name="<?php  echo $view->field('ctas'); ?>[{{id}}][link]" value="{{link}}" />
                    </div>

<div class="form-group">
    <label for="<?php  echo $view->field('ctas'); ?>[{{id}}][link_text]" class="control-label"><?php  echo t("Link") . " " . t("Text"); ?></label>
    <input name="<?php  echo $view->field('ctas'); ?>[{{id}}][link_text]" id="<?php  echo $view->field('ctas'); ?>[{{id}}][link_text]" class="form-control" type="text" value="{{ link_text }}" />
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('ctas'); ?>[{{id}}][image]" class="control-label"><?php  echo t("Image"); ?></label>
    <?php  echo isset($btFieldsRequired['ctas']) && in_array('image', $btFieldsRequired['ctas']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div data-file-selector-input-name="<?php  echo $view->field('ctas'); ?>[{{id}}][image]" class="ccm-file-selector ft-image-image-file-selector" data-file-selector-f-id="{{ image }}"></div>
</div>            <div class="form-group">
    <label for="<?php  echo $view->field('ctas'); ?>[{{id}}][theme]" class="control-label"><?php  echo t("Theme"); ?></label>
    <?php  echo isset($btFieldsRequired['ctas']) && in_array('theme', $btFieldsRequired['ctas']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  $ctasTheme_options = $ctas['theme_options']; ?>
                    <select name="<?php  echo $view->field('ctas'); ?>[{{id}}][theme]" id="<?php  echo $view->field('ctas'); ?>[{{id}}][theme]" class="form-control">{{#select theme}}<?php  foreach ($ctasTheme_options as $k => $v) {
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
    Concrete.event.publish('btCallToActions.ctas.edit.open', {id: '<?php  echo $repeatable_container_id; ?>'});
    $.each($('#<?php  echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>