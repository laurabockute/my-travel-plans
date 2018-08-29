<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>


<div class="form-group">
    <?php  echo $form->label('theme', t("Theme color")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('theme', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->select($view->field('theme'), $theme_options, $theme, array()); ?>
</div>

<div class="form-group">
    <?php 
    if (isset($image) && $image > 0) {
        $image_o = File::getByID($image);
        if (!$image_o || $image_o->isError()) {
            unset($image_o);
        }
    } ?>
    <?php  echo $form->label('image', t("Image") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("Minimum size: 690x460") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('image', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make("helper/concrete/asset_library")->image('ccm-b-image_callout-image-' . Core::make('helper/validation/identifier')->getString(18), $view->field('image'), t("Choose Image"), $image_o); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('heading', t("Heading")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('heading', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('heading'), $heading, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('text', t("Text")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('text', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->textarea($view->field('text'), $text, array (
  'rows' => 5,
)); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('firstButtonLink', t("First Button Link")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('firstButtonLink', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('firstButtonLink'), $firstButtonLink, array ());?>
</div>

<div class="form-group">
    <?php  echo $form->label('firstButtonLink_text', t("First Button Link") . " " . t("Text")); ?>
    <?php  echo $form->text($view->field('firstButtonLink_text'), $firstButtonLink_text, array()); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('firstButtonTheme', t("First Button Theme Color")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('firstButtonTheme', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->select($view->field('firstButtonTheme'), $firstButtonTheme_options, $firstButtonTheme, array()); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('secondButtonLink', t("Second Button Link")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('secondButtonLink', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('secondButtonLink'), $secondButtonLink, array ());?>
</div>

<div class="form-group">
    <?php  echo $form->label('secondButtonLink_text', t("Second Button Link") . " " . t("Text")); ?>
    <?php  echo $form->text($view->field('secondButtonLink_text'), $secondButtonLink_text, array()); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('secondButtonTheme', t("Second Button Theme Color")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('secondButtonTheme', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->select($view->field('secondButtonTheme'), $secondButtonTheme_options, $secondButtonTheme, array()); ?>
</div>