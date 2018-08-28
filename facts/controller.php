<?php namespace Application\Block\Facts;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use Database;
use File;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
use AssetList;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('heading', 'item' => array('image', 'fact', 'description_1'));
    protected $btExportFileColumns = array('image');
    protected $btExportPageColumns = array();
    protected $btExportTables = array('btFacts', 'btFactsItemEntries');
    protected $btTable = 'btFacts';
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
        return t("Add one or more blocks with a interesting/fun fact, an image and a descriptive text.");
    }

    public function getBlockTypeName()
    {
        return t("Facts");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->heading;
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btFactsItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => $item_item_v) {
            if (isset($item_item_v["fact"]) && trim($item_item_v["fact"]) != "") {
                $content[] = $item_item_v["fact"];
            }
            if (isset($item_item_v["description_1"]) && trim($item_item_v["description_1"]) != "") {
                $content[] = $item_item_v["description_1"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        $item = array();
        $item_items = $db->fetchAll('SELECT * FROM btFactsItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => &$item_item_v) {
            if (isset($item_item_v['image']) && trim($item_item_v['image']) != "" && ($f = File::getByID($item_item_v['image'])) && is_object($f)) {
                $item_item_v['image'] = $f;
            } else {
                $item_item_v['image'] = false;
            }
            $item_item_v["description_1"] = isset($item_item_v["description_1"]) ? LinkAbstractor::translateFrom($item_item_v["description_1"]) : null;
        }
        $this->set('item_items', $item_items);
        $this->set('item', $item);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btFactsItemEntries', array('bID' => $this->bID));
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btFactsItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item) {
            unset($item_item['id']);
            $item_item['bID'] = $newBID;
            $db->insert('btFactsItemEntries', $item_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $item = $this->get('item');
        $this->set('item_items', array());
        $this->set('item', $item);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $item = $this->get('item');
        $item_items = $db->fetchAll('SELECT * FROM btFactsItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as &$item_item) {
            if (!File::getByID($item_item['image'])) {
                unset($item_item['image']);
            }
        }
        
        foreach ($item_items as &$item_item) {
            $item_item['description_1'] = isset($item_item['description_1']) ? LinkAbstractor::translateFromEditMode($item_item['description_1']) : null;
        }
        $this->set('item', $item);
        $this->set('item_items', $item_items);
    }

    protected function addEdit()
    {
        $item = array();
        $this->set('item', $item);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/facts/css_form/repeatable-ft.form.css', array(), $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/facts/js_form/handlebars-v4.0.4.js', array(), $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/facts/js_form/handlebars-helpers.js', array(), $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('core/file-manager');
        $this->requireAsset('redactor');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        $rows = $db->fetchAll('SELECT * FROM btFactsItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
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
                if (isset($item_item['fact']) && trim($item_item['fact']) != '') {
                    $data['fact'] = trim($item_item['fact']);
                } else {
                    $data['fact'] = null;
                }
                $data['description_1'] = isset($item_item['description_1']) ? LinkAbstractor::translateTo($item_item['description_1']) : null;
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
                                $db->update('btFactsItemEntries', $data, array('id' => $id));
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btFactsItemEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btFactsItemEntries', array('id' => $value));
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
                        if (in_array("fact", $this->btFieldsRequired['item']) && (!isset($item_v['fact']) || trim($item_v['fact']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Fact"), t("Item"), $item_k));
                        }
                        if (in_array("description_1", $this->btFieldsRequired['item']) && (!isset($item_v['description_1']) || trim($item_v['description_1']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Description"), t("Item"), $item_k));
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
        $al = AssetList::getInstance();
        $al->register('javascript', 'auto-js-facts', 'blocks/facts/auto.js', array(), $this->pkg);
        $this->requireAsset('javascript', 'auto-js-facts');
        $this->edit();
    }
}