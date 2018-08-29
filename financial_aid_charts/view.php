<?php defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="aid">
  <div class="aid_background" data-background-options='{
		"source":{
		"0px": "<?php if ($bgImage) { echo $bgImage->getURL(); } ?>",
		"500px": "<?php if ($bgImage) { echo $bgImage->getURL(); } ?>",
		"768px": "<?php if ($bgImage) { echo $bgImage->getURL(); } ?>",
		"992px": "<?php if ($bgImage) { echo $bgImage->getURL(); } ?>"
		}
		}'>
  </div>
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="aid_inner">
              <header class="aid_header">
                <?php if (isset($hiddenTitle) && trim($hiddenTitle) != "") { ?>
                    <h1 class="aid_title_hidden"><?php echo h($hiddenTitle); ?></h1>
                <?php } ?>
                <?php if (isset($title) && trim($title) != "") { ?>
                    <h2 class="aid_title"><?php echo h($title); ?></h2>
                <?php } ?>
              </header>
              <div class="aid_body">
                <div class="aid_pie">
                  <div class="aid_pie_inner">
                    <div class="aid_details">
                      <div class="aid_detail">
                        <?php if (isset($aidPieCostHint) && trim($aidPieCostHint) != "") { ?>
                          <span class="aid_detail_hint aid_detail_hint_top" role="tooltip"><?php echo h($aidPieCostHint); ?></span>
                        <?php } ?>
                        <?php if (isset($aidPieCost) && trim($aidPieCost) != "") { ?>
                            <span class="aid_detail_label"><?php echo h($aidPieCost); ?></span>
                        <?php } ?>
                      </div>
                      <div class="aid_detail">
                        <?php if (isset($aidPieGrantHint) && trim($aidPieGrantHint) != "") { ?>
                          <span class="aid_detail_hint aid_detail_hint_right" role="tooltip"><?php echo h($aidPieGrantHint); ?></span>
                        <?php } ?>
                        <?php if (isset($aidPieGrant) && trim($aidPieGrant) != "") { ?>
                          <span class="aid_detail_label"><strong class="aid_detail_label_strong aid_detail_label_strong_minus">minus</strong><?php echo h($aidPieGrant); ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="aid_info">
                      <?php if (isset($aidPieTuitionTerm) && trim($aidPieTuitionTerm) != "") { ?>
                          <span class="aid_info_sublabel"><?php echo h($aidPieTuitionTerm); ?></span>
                      <?php } ?>
                          <span class="aid_info_hidden_label">Total</span>
                      <?php if (isset($aidPieTotal) && trim($aidPieTotal) != "") { ?>
                          <span class="aid_info_label"><?php echo h($aidPieTotal); ?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="js-pie-chart pie_chart" data-percent="<?php if (isset($aidPiePercentage) && trim($aidPiePercentage) != "") { ?><?php echo h($aidPiePercentage); ?><?php } ?>" aria-hidden="true">
                    <canvas class="pie_chart_canvas"></canvas>
                  </div>
                </div>
                <div class="aid_bar_wrapper">
                  <div class="aid_details">
                    <div class="aid_detail">
                      <?php if (isset($aidBarTuitionHint) && trim($aidBarTuitionHint) != "") { ?>
                          <span class="aid_detail_hint aid_detail_hint_mini aid_detail_hint_left" role="tooltip"><?php echo h($aidBarTuitionHint); ?></span>
                      <?php } ?>
                      <?php if (isset($aidBarTuition) && trim($aidBarTuition) != "") { ?>
                          <span class="aid_detail_label"><?php echo h($aidBarTuition); ?></span>
                      <?php } ?>
                    </div>
                    <div class="aid_detail">
                      <?php if (isset($aidBarRoomBoardHint) && trim($aidBarRoomBoardHint) != "") { ?>
                          <span class="aid_detail_hint aid_detail_hint_right" role="tooltip"><?php echo h($aidBarRoomBoardHint); ?></span>
                      <?php } ?>
                      <?php if (isset($aidBarRoomBoard) && trim($aidBarRoomBoard) != "") { ?>
                          <span class="aid_detail_label"><strong class="aid_detail_label_strong aid_detail_label_strong_plus">plus</strong><?php echo h($aidBarRoomBoard); ?></span>
                      <?php } ?>
                    </div>
                    <div class="aid_detail">
                      <?php if (isset($aidBarScholarshipHint) && trim($aidBarScholarshipHint) != "") { ?>
                          <span class="aid_detail_hint aid_detail_hint_bottom" role="tooltip"><?php echo h($aidBarScholarshipHint); ?></span>
                      <?php } ?>
                      <?php if (isset($aidBarScholarship) && trim($aidBarScholarship) != "") { ?>
                          <span class="aid_detail_label"><strong class="aid_detail_label_strong aid_detail_label_strong_minus">minus</strong><?php echo h($aidBarScholarship); ?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="aid_info">
                    <?php if (isset($aidBarTotalSublabel) && trim($aidBarTotalSublabel) != "") { ?>
                        <span class="aid_info_sublabel" role="tooltip"><?php echo h($aidBarTotalSublabel); ?></span>
                    <?php } ?>
                    <span class="aid_info_hidden_label">Total</span>
                    <?php if (isset($aidBarTotal) && trim($aidBarTotal) != "") { ?>
                        <span class="aid_info_label"><?php echo h($aidBarTotal); ?></span>
                    <?php } ?>
                  </div>
                  <div class="js-bar-graph bar_graph" data-percent="<?php if (isset($aidBarPercentage) && trim($aidBarPercentage) != "") { ?><?php echo h($aidBarPercentage); ?><?php } ?>" aria-hidden="true">
                    <div class="bar_graph_value">
                      <span class="bar_graph_value_label"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
