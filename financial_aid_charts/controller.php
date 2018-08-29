<?php namespace Application\Block\FinancialAidCharts;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('bgImage', 'aidPieCost', 'aidPieCostHint', 'aidPieGrant', 'aidPieGrantHint', 'aidPieTuitionTerm', 'aidPieTotal', 'aidPiePercentage', 'aidBarTuition', 'aidBarTuitionHint', 'aidBarRoomBoard', 'aidBarRoomBoardHint', 'aidBarScholarship', 'aidBarScholarshipHint', 'aidBarTotalSublabel', 'aidBarTotal', 'aidBarPercentage');
    protected $btExportFileColumns = array('bgImage');
    protected $btExportPageColumns = array();
    protected $btTable = 'btFinancialAidCharts';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $pkg = false;
    
    public function getBlockTypeDescription()
    {
        return t("Pie and Bar Charts on Financial Aid page.");
    }

    public function getBlockTypeName()
    {
        return t("Financial Aid Charts");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->hiddenTitle;
        $content[] = $this->title;
        $content[] = $this->aidPieCost;
        $content[] = $this->aidPieCostHint;
        $content[] = $this->aidPieGrant;
        $content[] = $this->aidPieGrantHint;
        $content[] = $this->aidPieTuitionTerm;
        $content[] = $this->aidPieTotal;
        $content[] = $this->aidPiePercentage;
        $content[] = $this->aidBarTuition;
        $content[] = $this->aidBarTuitionHint;
        $content[] = $this->aidBarRoomBoard;
        $content[] = $this->aidBarRoomBoardHint;
        $content[] = $this->aidBarScholarship;
        $content[] = $this->aidBarScholarshipHint;
        $content[] = $this->aidBarTotalSublabel;
        $content[] = $this->aidBarTotal;
        $content[] = $this->aidBarPercentage;
        return implode(" ", $content);
    }

    public function view()
    {
        
        if ($this->bgImage && ($f = File::getByID($this->bgImage)) && is_object($f)) {
            $this->set("bgImage", $f);
        } else {
            $this->set("bgImage", false);
        }
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
    }

    protected function addEdit()
    {
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("bgImage", $this->btFieldsRequired) && (trim($args["bgImage"]) == "" || !is_object(File::getByID($args["bgImage"])))) {
            $e->add(t("The %s field is required.", t("Background Image")));
        }
        if (in_array("hiddenTitle", $this->btFieldsRequired) && (trim($args["hiddenTitle"]) == "")) {
            $e->add(t("The %s field is required.", t("Hidden Title")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("aidPieCost", $this->btFieldsRequired) && (trim($args["aidPieCost"]) == "")) {
            $e->add(t("The %s field is required.", t("Cost # (Pie)")));
        }
        if (in_array("aidPieCostHint", $this->btFieldsRequired) && (trim($args["aidPieCostHint"]) == "")) {
            $e->add(t("The %s field is required.", t("Cost Hint (Pie)")));
        }
        if (in_array("aidPieGrant", $this->btFieldsRequired) && (trim($args["aidPieGrant"]) == "")) {
            $e->add(t("The %s field is required.", t("Grant # (Pie)")));
        }
        if (in_array("aidPieGrantHint", $this->btFieldsRequired) && (trim($args["aidPieGrantHint"]) == "")) {
            $e->add(t("The %s field is required.", t("Grant Hint (Pie)")));
        }
        if (in_array("aidPieTuitionTerm", $this->btFieldsRequired) && (trim($args["aidPieTuitionTerm"]) == "")) {
            $e->add(t("The %s field is required.", t("Tuition Term (Pie)")));
        }
        if (in_array("aidPieTotal", $this->btFieldsRequired) && (trim($args["aidPieTotal"]) == "")) {
            $e->add(t("The %s field is required.", t("Total # (Pie)")));
        }
        if (in_array("aidPiePercentage", $this->btFieldsRequired) && (trim($args["aidPiePercentage"]) == "")) {
            $e->add(t("The %s field is required.", t("Percentage (Pie)")));
        }
        if (in_array("aidBarTuition", $this->btFieldsRequired) && (trim($args["aidBarTuition"]) == "")) {
            $e->add(t("The %s field is required.", t("Tuition # (Bar)")));
        }
        if (in_array("aidBarTuitionHint", $this->btFieldsRequired) && (trim($args["aidBarTuitionHint"]) == "")) {
            $e->add(t("The %s field is required.", t("Tuition Hint (Bar)")));
        }
        if (in_array("aidBarRoomBoard", $this->btFieldsRequired) && (trim($args["aidBarRoomBoard"]) == "")) {
            $e->add(t("The %s field is required.", t("Room Board # (Bar)")));
        }
        if (in_array("aidBarRoomBoardHint", $this->btFieldsRequired) && (trim($args["aidBarRoomBoardHint"]) == "")) {
            $e->add(t("The %s field is required.", t("Room Board Hint (Bar)")));
        }
        if (in_array("aidBarScholarship", $this->btFieldsRequired) && (trim($args["aidBarScholarship"]) == "")) {
            $e->add(t("The %s field is required.", t("Scholarship/Aid # (Bar)")));
        }
        if (in_array("aidBarScholarshipHint", $this->btFieldsRequired) && (trim($args["aidBarScholarshipHint"]) == "")) {
            $e->add(t("The %s field is required.", t("Scholarship/Aid Hint (Bar)")));
        }
        if (in_array("aidBarTotalSublabel", $this->btFieldsRequired) && (trim($args["aidBarTotalSublabel"]) == "")) {
            $e->add(t("The %s field is required.", t("Label for Total (Bar)")));
        }
        if (in_array("aidBarTotal", $this->btFieldsRequired) && (trim($args["aidBarTotal"]) == "")) {
            $e->add(t("The %s field is required.", t("Total # (Bar)")));
        }
        if (in_array("aidBarPercentage", $this->btFieldsRequired) && (trim($args["aidBarPercentage"]) == "")) {
            $e->add(t("The %s field is required.", t("Percentage (Bar)")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}