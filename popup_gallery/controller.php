<?php
namespace Concrete\Package\Sjc2016\Block\PopupGallery;

use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
use Database;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('launchLabel', 'theme', 'image', 'images' => array());
    protected $btExportFileColumns = array('image');
    protected $btExportTables = array('btPopupGallery', 'btPopupGalleryImagesEntries');
    protected $btTable = 'btPopupGallery';
    protected $btInterfaceWidth = 700;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = true;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $btDefaultSet = 'multimedia';
    protected $pkg = 'sjc2016';
    
    public function getBlockTypeDescription()
    {
        return t("");
    }

    public function getBlockTypeName()
    {
        return t("Popup Gallery");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->launchLabel;
        $content[] = $this->popupHeading;
        $content[] = $this->popupIntro;
        $db = Database::connection();
        $images_items = $db->fetchAll('SELECT * FROM btPopupGalleryImagesEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($images_items as $images_item_k => $images_item_v) {
            if (isset($images_item_v["caption"]) && trim($images_item_v["caption"]) != "") {
                $content[] = $images_item_v["caption"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $theme_options = array(
            'blue' => "Blue",
            'red' => "Red",
            'orange' => "Orange",
            'green' => "Green"
        );
        $this->set("theme_options", $theme_options);
        
        if ($this->image && ($f = File::getByID($this->image)) && is_object($f)) {
            $this->set("image", $f);
        } else {
            $this->set("image", false);
        }
        $this->set('popupIntro', LinkAbstractor::translateFrom($this->popupIntro));
        $images = array();
        $images_items = $db->fetchAll('SELECT * FROM btPopupGalleryImagesEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($images_items as $images_item_k => &$images_item_v) {
            if (isset($images_item_v['image']) && trim($images_item_v['image']) != "" && ($f = File::getByID($images_item_v['image'])) && is_object($f)) {
                $images_item_v['image'] = $f;
            } else {
                $images_item_v['image'] = false;
            }
        }
        $this->set('images_items', $images_items);
        $this->set('images', $images);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btPopupGalleryImagesEntries', array('bID' => $this->bID));
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $images_items = $db->fetchAll('SELECT * FROM btPopupGalleryImagesEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($images_items as $images_item) {
            unset($images_item['id']);
            $images_item['bID'] = $newBID;
            $db->insert('btPopupGalleryImagesEntries', $images_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $images = $this->get('images');
        $this->set('images_items', array());
        $this->set('images', $images);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        
        $this->set('popupIntro', LinkAbstractor::translateFromEditMode($this->popupIntro));
        $images = $this->get('images');
        $images_items = $db->fetchAll('SELECT * FROM btPopupGalleryImagesEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($images_items as &$images_item) {
            if (!File::getByID($images_item['image'])) {
                unset($images_item['image']);
            }
        }
        $this->set('images', $images);
        $this->set('images_items', $images_items);
    }

    protected function addEdit()
    {
        $this->set("theme_options", array(
                'blue' => "Blue",
                'red' => "Red",
                'orange' => "Orange",
                'green' => "Green"
            )
        );
        $images = array();
        $this->set('images', $images);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/popup_gallery/css_form/repeatable-ft.form.css', array(), $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/popup_gallery/js_form/handlebars-v4.0.4.js', array(), $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/popup_gallery/js_form/handlebars-helpers.js', array(), $this->pkg);
        $this->requireAsset('core/file-manager');
        $this->requireAsset('redactor');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
    }

    public function save($args)
    {
        $db = Database::connection();
        $args['popupIntro'] = LinkAbstractor::translateTo($args['popupIntro']);
        $rows = $db->fetchAll('SELECT * FROM btPopupGalleryImagesEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $images_items = isset($args['images']) && is_array($args['images']) ? $args['images'] : array();
        $queries = array();
        if (!empty($images_items)) {
            $i = 0;
            foreach ($images_items as $images_item) {
                $data = array(
                    'sortOrder' => $i + 1,
                );
                if (isset($images_item['image']) && trim($images_item['image']) != '') {
                    $data['image'] = trim($images_item['image']);
                } else {
                    $data['image'] = null;
                }
                if (isset($images_item['caption']) && trim($images_item['caption']) != '') {
                    $data['caption'] = trim($images_item['caption']);
                } else {
                    $data['caption'] = null;
                }
                if (isset($rows[$i])) {
                    $queries['update'][$rows[$i]['id']] = $data;
                    unset($rows[$i]);
                } else {
                    $data['bID'] = $this->bID;
                    $queries['insert'][] = $data;
                }
                $i++;
            }
        }
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $queries['delete'][] = $row['id'];
            }
        }
        if (!empty($queries)) {
            foreach ($queries as $type => $values) {
                if (!empty($values)) {
                    switch ($type) {
                        case 'update':
                            foreach ($values as $id => $data) {
                                $db->update('btPopupGalleryImagesEntries', $data, array('id' => $id));
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btPopupGalleryImagesEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btPopupGalleryImagesEntries', array('id' => $value));
                            }
                            break;
                    }
                }
            }
        }
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("launchLabel", $this->btFieldsRequired) && (trim($args["launchLabel"]) == "")) {
            $e->add(t("The %s field is required.", t("Label to open the gallery")));
        }
        if ((in_array("theme", $this->btFieldsRequired) && (!isset($args["theme"]) || trim($args["theme"]) == "")) || (isset($args["theme"]) && trim($args["theme"]) != "" && !in_array($args["theme"], array("blue", "red", "orange", "green")))) {
            $e->add(t("The %s field has an invalid value.", t("Theme")));
        }
        if (in_array("image", $this->btFieldsRequired) && (trim($args["image"]) == "" || !is_object(File::getByID($args["image"])))) {
            $e->add(t("The %s field is required.", t("Image")));
        }
        if (in_array("popupHeading", $this->btFieldsRequired) && (trim($args["popupHeading"]) == "")) {
            $e->add(t("The %s field is required.", t("Popup Heading")));
        }
        if (in_array("popupIntro", $this->btFieldsRequired) && (trim($args["popupIntro"]) == "")) {
            $e->add(t("The %s field is required.", t("Popup Intro text")));
        }
        $imagesEntriesMin = 0;
        $imagesEntriesMax = 0;
        $imagesEntriesErrors = 0;
        $images = array();
        if (isset($args['images']) && is_array($args['images']) && !empty($args['images'])) {
            if ($imagesEntriesMin >= 1 && count($args['images']) < $imagesEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Images"), $imagesEntriesMin, count($args['images'])));
                $imagesEntriesErrors++;
            }
            if ($imagesEntriesMax >= 1 && count($args['images']) > $imagesEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Images"), $imagesEntriesMax, count($args['images'])));
                $imagesEntriesErrors++;
            }
            if ($imagesEntriesErrors == 0) {
                foreach ($args['images'] as $images_k => $images_v) {
                    if (is_array($images_v)) {
                        if (in_array("image", $this->btFieldsRequired['images']) && (!isset($images_v['image']) || trim($images_v['image']) == "" || !is_object(File::getByID($images_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("Images"), $images_k));
                        }
                        if (in_array("caption", $this->btFieldsRequired['images']) && (!isset($images_v['caption']) || trim($images_v['caption']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Caption"), t("Images"), $images_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Images'), $images_k));
                    }
                }
            }
        } else {
            if ($imagesEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Images"), $imagesEntriesMin));
            }
        }
        return $e;
    }

    public function composer()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('javascript', 'auto-js-popup_gallery', 'blocks/popup_gallery/auto.js', array(), $this->pkg);
        $this->requireAsset('javascript', 'auto-js-popup_gallery');
        $this->edit();
    }
}