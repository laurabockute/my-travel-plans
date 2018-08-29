<?php
namespace Concrete\Package\Sjc2016\Block\ImageCallout;

use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('image', 'heading', 'text', 'theme');
    protected $btExportFileColumns = array('image');
    protected $btTable = 'btImageCallout';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $btDefaultSet = 'multimedia';
    protected $pkg = 'sjc2016';
    
    public function getBlockTypeDescription()
    {
        return t("Mini highlights block. Theme and link colors are configurable.");
    }

    public function getBlockTypeName()
    {
        return t("Image Callout");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->heading;
        $content[] = $this->text;
        return implode(" ", $content);
    }

    public function view()
    {
        
        if ($this->image && ($f = File::getByID($this->image)) && is_object($f)) {
            $this->set("image", $f);
        } else {
            $this->set("image", false);
        }
        $theme_options = array(
            'blue' => "Blue",
            'green' => "Green",
            'orange' => "Orange"
        );
        $this->set("theme_options", $theme_options);
        $firstButtonTheme_options = array(
            '' => "-- " . t("None") . " --",
            'blue' => "Blue",
            'green' => "Green",
            'orange' => "Orange"
        );
        $this->set("firstButtonTheme_options", $firstButtonTheme_options);
        $secondButtonTheme_options = array(
            '' => "-- " . t("None") . " --",
            'blue' => "Blue",
            'green' => "Green",
            'orange' => "Orange"
        );
        $this->set("secondButtonTheme_options", $secondButtonTheme_options);
    }

    public function add()
    {
        $this->addEdit();

        $this->set("firstButtonTheme", "blue");
        $this->set("secondButtonTheme", "orange");
    }

    public function edit()
    {
        $this->addEdit();
    }

    protected function addEdit()
    {
        $this->set("theme_options", array(
                'blue' => "Blue",
                'green' => "Green",
                'orange' => "Orange"
            )
        );
        $this->set("firstButtonTheme_options", array(
                '' => "-- " . t("None") . " --",
                'blue' => "Blue",
                'green' => "Green",
                'orange' => "Orange"
            )
        );
        $this->set("secondButtonTheme_options", array(
                '' => "-- " . t("None") . " --",
                'blue' => "Blue",
                'green' => "Green",
                'orange' => "Orange"
            )
        );

        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("image", $this->btFieldsRequired) && (trim($args["image"]) == "" || !is_object(File::getByID($args["image"])))) {
            $e->add(t("The %s field is required.", t("Image")));
        }
        if (in_array("heading", $this->btFieldsRequired) && (trim($args["heading"]) == "")) {
            $e->add(t("The %s field is required.", t("Heading")));
        }
        if (in_array("text", $this->btFieldsRequired) && trim($args["text"]) == "") {
            $e->add(t("The %s field is required.", t("Text")));
        }
        if ((in_array("theme", $this->btFieldsRequired) && (!isset($args["theme"]) || trim($args["theme"]) == "")) || (isset($args["theme"]) && trim($args["theme"]) != "" && !in_array($args["theme"], array("blue", "green", "orange")))) {
            $e->add(t("The %s field has an invalid value.", t("Theme color")));
        }
        if (in_array("firstButtonLink", $this->btFieldsRequired) && (trim($args["firstButtonLink"]) == "" || $args["firstButtonLink"] == "0" || (($page = Page::getByID($args["firstButtonLink"])) && $page->error !== false))) {
            $e->add(t("The %s field is required.", t("First Button Link")));
        }
        if ((in_array("firstButtonTheme", $this->btFieldsRequired) && (!isset($args["firstButtonTheme"]) || trim($args["firstButtonTheme"]) == "")) || (isset($args["firstButtonTheme"]) && trim($args["firstButtonTheme"]) != "" && !in_array($args["firstButtonTheme"], array("blue", "green", "orange")))) {
            $e->add(t("The %s field has an invalid value.", t("First Button Theme Color")));
        }
        if (in_array("secondButtonLink", $this->btFieldsRequired) && (trim($args["secondButtonLink"]) == "" || $args["secondButtonLink"] == "0" || (($page = Page::getByID($args["secondButtonLink"])) && $page->error !== false))) {
            $e->add(t("The %s field is required.", t("Second Button Link")));
        }
        if ((in_array("secondButtonTheme", $this->btFieldsRequired) && (!isset($args["secondButtonTheme"]) || trim($args["secondButtonTheme"]) == "")) || (isset($args["secondButtonTheme"]) && trim($args["secondButtonTheme"]) != "" && !in_array($args["secondButtonTheme"], array("blue", "green", "orange")))) {
            $e->add(t("The %s field has an invalid value.", t("Second Button Theme Color")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}