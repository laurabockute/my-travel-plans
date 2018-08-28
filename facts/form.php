<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php $tabs = array(
    array('form-basics-' . $identifier_getString, t('Basics'), true),
    array('form-item_items-' . $identifier_getString, t('Item'))
);
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="ccm-tab-content" id="ccm-tab-content-form-basics-<?php echo $identifier_getString; ?>">
    <div class="form-group">
    <?php echo $form->label('heading', t("Heading")); ?>
    <?php echo isset($btFieldsRequired) && in_array('heading', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('heading'), $heading, array (
  'maxlength' => 255,
)); ?>
</div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-form-item_items-<?php echo $identifier_getString; ?>">
    <script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Core::make('helper/validation/token')->generate('editor')?>";
</script>
            <?php
	$core_editor = Core::make('editor');
	if (method_exists($core_editor, 'getEditorInitJSFunction')) {
		/* @var $core_editor \Concrete\Core\Editor\CkeditorEditor */
		?>
		<script type="text/javascript">var blockDesignerEditor = <?php echo $core_editor->getEditorInitJSFunction(); ?>;</script>
	<?php
	} else {
	/* @var $core_editor \Concrete\Core\Editor\RedactorEditor */
	?>
		<script type="text/javascript">
			var blockDesignerEditor = function (identifier) {$(identifier).redactor(<?php echo json_encode(array('plugins' => array("concrete5lightbox", "undoredo", "specialcharacters", "table", "concrete5magic"), 'minHeight' => 300,'concrete5' => array('filemanager' => $core_editor->allowFileManager(), 'sitemap' => $core_editor->allowSitemap()))); ?>).on('remove', function () {$(this).redactor('core.destroy');});};
		</script>
		<?php
	} ?><?php $repeatable_container_id = 'btFacts-item-container-' . $identifier_getString; ?>
    <div id="<?php echo $repeatable_container_id; ?>">
        <div class="sortable-items-wrapper">
            <a href="#" class="btn btn-primary add-entry">
                <?php echo t('Add Entry'); ?>
            </a>

            <div class="sortable-items" data-attr-content="<?php echo htmlspecialchars(
                json_encode(
                    array(
                        'items' => $item_items,
                        'order' => array_keys($item_items),
                    )
                )
            ); ?>">
            </div>

            <a href="#" class="btn btn-primary add-entry add-entry-last">
                <?php echo t('Add Entry'); ?>
            </a>
        </div>

        <script class="repeatableTemplate" type="text/x-handlebars-template">
            <div class="sortable-item" data-id="{{id}}">
                <div class="sortable-item-title">
                    <span class="sortable-item-title-default">
                        <?php echo t('Item') . ' ' . t("row") . ' <span>#{{id}}</span>'; ?>
                    </span>
                    <span class="sortable-item-title-generated"></span>
                </div>

                <div class="sortable-item-inner">            <div class="form-group">
    <label for="<?php echo $view->field('item'); ?>[{{id}}][image]" class="control-label"><?php echo t("Image") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("Will be resized to 100x100 pixels") . '"></i>'; ?></label>
    <?php echo isset($btFieldsRequired['item']) && in_array('image', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <div data-file-selector-input-name="<?php echo $view->field('item'); ?>[{{id}}][image]" class="ccm-file-selector ft-image-image-file-selector" data-file-selector-f-id="{{ image }}"></div>
</div>            <div class="form-group">
    <label for="<?php echo $view->field('item'); ?>[{{id}}][fact]" class="control-label"><?php echo t("Fact") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("E. g. &quot;1&quot; or &quot;#2&quot; or &quot;3%&quot;") . '"></i>'; ?></label>
    <?php echo isset($btFieldsRequired['item']) && in_array('fact', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <input name="<?php echo $view->field('item'); ?>[{{id}}][fact]" id="<?php echo $view->field('item'); ?>[{{id}}][fact]" class="form-control" type="text" value="{{ fact }}" maxlength="255" />
</div>            <div class="form-group">
    <label for="<?php echo $view->field('item'); ?>[{{id}}][description_1]" class="control-label"><?php echo t("Description"); ?></label>
    <?php echo isset($btFieldsRequired['item']) && in_array('description_1', $btFieldsRequired['item']) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <textarea name="<?php echo $view->field('item'); ?>[{{id}}][description_1]" id="<?php echo $view->field('item'); ?>[{{id}}][description_1]" class="ft-item-description_1">{{ description_1 }}</textarea>
</div></div>

                <span class="sortable-item-collapse-toggle"></span>

                <a href="#" class="sortable-item-delete" data-attr-confirm-text="<?php echo t('Are you sure'); ?>">
                    <i class="fa fa-times"></i>
                </a>

                <div class="sortable-item-handle">
                    <i class="fa fa-sort"></i>
                </div>
            </div>
        </script>
    </div>

<script type="text/javascript">
    Concrete.event.publish('btFacts.item.edit.open', {id: '<?php echo $repeatable_container_id; ?>'});
    $.each($('#<?php echo $repeatable_container_id; ?> input[type="text"].title-me'), function () {
        $(this).trigger('keyup');
    });
</script>
</div>