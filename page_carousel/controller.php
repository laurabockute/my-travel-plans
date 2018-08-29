<?php
namespace Concrete\Package\Sjc2016\Block\PageCarousel;

use Concrete\Core\Block\BlockController;
use Core;
use Concrete\Core\Editor\LinkAbstractor;
use Database;
use File;
use Page;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('item' => array('image', 'title', 'text'));
    protected $btExportFileColumns = array();
    protected $btExportTables = array('btPageCarousel', 'btPageCarouselItemEntries');
    protected $btTable = 'btPageCarousel';
    protected $btInterfaceWidth = 700;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = true;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $pkg = 'sjc2016';
    
    public function getBlockTypeDescription()
    {
        return t("Carousel with image and text that links to a page. Used for News Landing.");
    }

    public function getBlockTypeName()
    {
        return t("Page Carousel");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->heading;
        $content[] = $this->content;
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btPageCarouselItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => $item_item_v) {
            if (isset($item_item_v["title"]) && trim($item_item_v["title"]) != "") {
                $content[] = $item_item_v["title"];
            }
            if (isset($item_item_v["text"]) && trim($item_item_v["text"]) != "") {
                $content[] = $item_item_v["text"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $this->set('content', LinkAbstractor::translateFrom($this->content));
        if (trim($this->useLargeHeading) == "") {
            $this->set("useLargeHeading", '0');
        }
        $item = array();
        $item["theme_options"] = array(
            '' => "-- " . t("None") . " --",
            'blue' => "Blue",
            'green' => "Green",
            'red' => "Red"
        );
        $item_items = $db->fetchAll('SELECT * FROM btPageCarouselItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => &$item_item_v) {
            if (isset($item_item_v['image']) && trim($item_item_v['image']) != "" && ($f = File::getByID($item_item_v['image'])) && is_object($f)) {
                $item_item_v['image'] = $f;
            } else {
                $item_item_v['image'] = false;
            }
            $item_item_v["text"] = isset($item_item_v["text"]) ? LinkAbstractor::translateFrom($item_item_v["text"]) : null;
        }
        $this->set('item_items', $item_items);
        $this->set('item', $item);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btPageCarouselItemEntries', array('bID' => $this->bID));
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btPageCarouselItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item) {
            unset($item_item['id']);
            $item_item['bID'] = $newBID;
            $db->insert('btPageCarouselItemEntries', $item_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $this->set("useLargeHeading", 0);
        $item = $this->get('item');
        $this->set('item_items', array());
        $this->set('item', $item);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        
        $this->set('content', LinkAbstractor::translateFromEditMode($this->content));
        $item = $this->get('item');
        $item_items = $db->fetchAll('SELECT * FROM btPageCarouselItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as &$item_item) {
            if (!File::getByID($item_item['image'])) {
                unset($item_item['image']);
            }
        }
        
        foreach ($item_items as &$item_item) {
            $item_item['text'] = isset($item_item['text']) ? LinkAbstractor::translateFromEditMode($item_item['text']) : null;
        }
        $this->set('item', $item);
        $this->set('item_items', $item_items);
    }

    protected function addEdit()
    {
        $item = array();
        $item['theme_options'] = array(
            '' => "-- " . t("None") . " --",
            'blue' => "Blue",
            'green' => "Green",
            'red' => "Red"
        );
        $this->set('item', $item);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/page_carousel/css_form/repeatable-ft.form.css', array(), $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/page_carousel/js_form/handlebars-v4.0.4.js', array(), $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/page_carousel/js_form/handlebars-helpers.js', array(), $this->pkg);
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
    }

    public function save($args)
    {
        $db = Database::connection();
        $args['content'] = LinkAbstractor::translateTo($args['content']);
        if (!isset($args["useLargeHeading"]) || trim($args["useLargeHeading"]) == "" || !in_array($args["useLargeHeading"], array(0, 1))) {
            $args["useLargeHeading"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btPageCarouselItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $item_items = isset($args['item']) && is_array($args['item']) ? $args['item'] : array();
        $queries = array();
        if (!empty($item_items)) {
            $i = 0;
            foreach ($item_items as $item_item) {
                $data = array(
                    'sortOrder' => $i + 1,
                );
                if (isset($item_item['image']) && trim($item_item['image']) != '') {
                    $data['image'] = trim($item_item['image']);
                } else {
                    $data['image'] = null;
                }
if (isset($item_item['image_link']) && trim($item_item['image_link']) != '') {
                    $data['image_link'] = trim($item_item['image_link']);
                } else {
                    $data['image_link'] = null;
                }
                if (isset($item_item['title']) && trim($item_item['title']) != '') {
                    $data['title'] = trim($item_item['title']);
                } else {
                    $data['title'] = null;
                }
                $data['text'] = isset($item_item['text']) ? LinkAbstractor::translateTo($item_item['text']) : null;
                if (isset($item_item['theme']) && trim($item_item['theme']) != '') {
                    $data['theme'] = trim($item_item['theme']);
                } else {
                    $data['theme'] = null;
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
                                $db->update('btPageCarouselItemEntries', $data, array('id' => $id));
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btPageCarouselItemEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btPageCarouselItemEntries', array('id' => $value));
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
        if (in_array("heading", $this->btFieldsRequired) && (trim($args["heading"]) == "")) {
            $e->add(t("The %s field is required.", t("Heading")));
        }
        if (in_array("content", $this->btFieldsRequired) && (trim($args["content"]) == "")) {
            $e->add(t("The %s field is required.", t("Content")));
        }
        if (in_array("useLargeHeading", $this->btFieldsRequired) && (trim($args["useLargeHeading"]) == "" || !in_array($args["useLargeHeading"], array(0, 1)))) {
            $e->add(t("The %s field is required.", t("Use large heading")));
        }
        $itemEntriesMin = 0;
        $itemEntriesMax = 0;
        $itemEntriesErrors = 0;
        $item = array();
        if (isset($args['item']) && is_array($args['item']) && !empty($args['item'])) {
            if ($itemEntriesMin >= 1 && count($args['item']) < $itemEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Item"), $itemEntriesMin, count($args['item'])));
                $itemEntriesErrors++;
            }
            if ($itemEntriesMax >= 1 && count($args['item']) > $itemEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Item"), $itemEntriesMax, count($args['item'])));
                $itemEntriesErrors++;
            }
            if ($itemEntriesErrors == 0) {
                foreach ($args['item'] as $item_k => $item_v) {
                    if (is_array($item_v)) {
                        if (in_array("image", $this->btFieldsRequired['item']) && (!isset($item_v['image']) || trim($item_v['image']) == "" || !is_object(File::getByID($item_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("Item"), $item_k));
                        }
                        if (in_array("title", $this->btFieldsRequired['item']) && (!isset($item_v['title']) || trim($item_v['title']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Title"), t("Item"), $item_k));
                        }
                        if (in_array("text", $this->btFieldsRequired['item']) && (!isset($item_v['text']) || trim($item_v['text']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Text"), t("Item"), $item_k));
                        }
                        if ((in_array("theme", $this->btFieldsRequired['item']) && (!isset($item_v['theme']) || trim($item_v['theme']) == "")) || (isset($item_v['theme']) && trim($item_v['theme']) != "" && !in_array($item_v['theme'], array("blue", "green", "red")))) {
                            $e->add(t("The %s field has an invalid value (%s, row #%s).", t("Theme"), t("Item"), $item_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Item'), $item_k));
                    }
                }
            }
        } else {
            if ($itemEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Item"), $itemEntriesMin));
            }
        }
        return $e;
    }

    public function composer()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('javascript', 'auto-js-page_carousel', 'blocks/page_carousel/auto.js', array(), $this->pkg);
        $this->requireAsset('javascript', 'auto-js-page_carousel');
        $this->edit();
    }
}