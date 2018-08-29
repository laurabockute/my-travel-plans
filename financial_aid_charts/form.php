<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php  $unique_tabs_id = Core::make('helper/validation/identifier')->getString(18);
$tabs = array(
    array('form-basics-' . $unique_tabs_id, t('Basics'), true),
    array('form-pie_items-' . $unique_tabs_id, t('Pie Chart')),
    array('form-bar_items-' . $unique_tabs_id, t('Bar Chart'))
);
echo Core::make('helper/concrete/ui')->tabs($tabs); ?>

<div class="ccm-tab-content" id="ccm-tab-content-form-basics-<?php  echo $unique_tabs_id; ?>">
<div class="form-group">
    <?php
    if (isset($bgImage) && $bgImage > 0) {
        $bgImage_o = File::getByID($bgImage);
        if (!is_object($bgImage_o)) {
            unset($bgImage_o);
        }
    } ?>
    <?php echo $form->label('bgImage', t("Background Image")); ?>
    <?php echo isset($btFieldsRequired) && in_array('bgImage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo Core::make("helper/concrete/asset_library")->image('ccm-b-financial_aid_charts-bgImage-' . $identifier_getString, $view->field('bgImage'), t("Choose Image"), $bgImage_o); ?>
</div>

<div class="form-group">
    <?php echo $form->label('hiddenTitle', t("Hidden Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('hiddenTitle', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('hiddenTitle'), $hiddenTitle, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('title', t("Title")); ?>
    <?php echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('title'), $title, array (
  'maxlength' => 255,
)); ?>
</div>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-form-pie_items-<?php  echo $unique_tabs_id; ?>">
<div class="form-group">
    <?php echo $form->label('aidPieCost', t("Cost # (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $59,203") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieCost', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieCost'), $aidPieCost, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPieCostHint', t("Cost Hint (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. Cost to Educate a Johnnie") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieCostHint', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieCostHint'), $aidPieCostHint, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPieGrant', t("Grant # (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $24,203") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieGrant', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieGrant'), $aidPieGrant, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPieGrantHint', t("Grant Hint (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. St. John’s Forever Grant for all students") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieGrantHint', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieGrantHint'), $aidPieGrantHint, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPieTuitionTerm', t("Tuition Term (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. 2019-20 Tuition") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieTuitionTerm', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieTuitionTerm'), $aidPieTuitionTerm, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPieTotal', t("Total # (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $35k") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPieTotal', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPieTotal'), $aidPieTotal, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidPiePercentage', t("Percentage (Pie)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. 65") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidPiePercentage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidPiePercentage'), $aidPiePercentage, array (
  'maxlength' => 255,
)); ?>
</div>
</div>

<div class="ccm-tab-content" id="ccm-tab-content-form-bar_items-<?php  echo $unique_tabs_id; ?>">
<div class="form-group">
    <?php echo $form->label('aidBarTuition', t("Tuition # (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $35,000") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarTuition', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarTuition'), $aidBarTuition, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarTuitionHint', t("Tuition Hint (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. 2019-20 Tuition") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarTuitionHint', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarTuitionHint'), $aidBarTuitionHint, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarRoomBoard', t("Room Board # (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $13,390") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarRoomBoard', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarRoomBoard'), $aidBarRoomBoard, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarRoomBoardHint', t("Room Board Hint (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. Avg. Room Board &amp; Fees") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarRoomBoardHint', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarRoomBoardHint'), $aidBarRoomBoardHint, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarScholarship', t("Scholarship/Aid # (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $13,390") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarScholarship', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarScholarship'), $aidBarScholarship, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarScholarshipHint', t("Scholarship/Aid Hint (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. Avg. Merit Scholarships &amp; Need-Based Aid") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarScholarshipHint', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarScholarshipHint'), $aidBarScholarshipHint, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarTotalSublabel', t("Label for Total (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. Average Out-of-Pocket Expense for Students") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarTotalSublabel', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarTotalSublabel'), $aidBarTotalSublabel, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarTotal', t("Total # (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. $24.8k") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarTotal', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarTotal'), $aidBarTotal, array (
  'maxlength' => 255,
)); ?>
</div>

<div class="form-group">
    <?php echo $form->label('aidBarPercentage', t("Percentage (Bar)") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("e.g. 35") . '"></i>'); ?>
    <?php echo isset($btFieldsRequired) && in_array('aidBarPercentage', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php echo $form->text($view->field('aidBarPercentage'), $aidBarPercentage, array (
  'maxlength' => 255,
)); ?>
</div>
</div>
