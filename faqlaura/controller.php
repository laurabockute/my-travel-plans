<?php namespace Application\Block\Faqlaura;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use Database;
use Concrete\Core\Editor\LinkAbstractor;
use AssetList;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('item' => array('heading', 'content'));
    protected $btExportFileColumns = array();
    protected $btExportPageColumns = array();
    protected $btExportTables = array('btFaqlaura', 'btFaqlauraItemEntries');
    protected $btTable = 'btFaqlaura';
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
        return t("Expandable accordion for use on FAQs as well as any expandable list of sub-headings");
    }

    public function getBlockTypeName()
    {
        return t("FAQ");
    }

    public function getSearchableContent()
    {
        $content = array();
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btFaqlauraItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => $item_item_v) {
            if (isset($item_item_v["heading"]) && trim($item_item_v["heading"]) != "") {
                $content[] = $item_item_v["heading"];
            }
            if (isset($item_item_v["content"]) && trim($item_item_v["content"]) != "") {
                $content[] = $item_item_v["content"];
            }
        }
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        if (trim($this->useLargeHeading) == "") {
            $this->set("useLargeHeading", '0');
        }
        $item = array();
        $item_items = $db->fetchAll('SELECT * FROM btFaqlauraItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item_k => &$item_item_v) {
            $item_item_v["content"] = isset($item_item_v["content"]) ? LinkAbstractor::translateFrom($item_item_v["content"]) : null;
        }
        $this->set('item_items', $item_items);
        $this->set('item', $item);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btFaqlauraItemEntries', array('bID' => $this->bID));
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $item_items = $db->fetchAll('SELECT * FROM btFaqlauraItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($item_items as $item_item) {
            unset($item_item['id']);
            $item_item['bID'] = $newBID;
            $db->insert('btFaqlauraItemEntries', $item_item);
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
        $item = $this->get('item');
        $item_items = $db->fetchAll('SELECT * FROM btFaqlauraItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        
        foreach ($item_items as &$item_item) {
            $item_item['content'] = isset($item_item['content']) ? LinkAbstractor::translateFromEditMode($item_item['content']) : null;
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
        $al->register('css', 'repeatable-ft.form', 'blocks/faqlaura/css_form/repeatable-ft.form.css', array(), $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/faqlaura/js_form/handlebars-v4.0.4.js', array(), $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/faqlaura/js_form/handlebars-helpers.js', array(), $this->pkg);
        $this->requireAsset('core/sitemap');
        $this->requireAsset('css', 'repeatable-ft.form');
        $this->requireAsset('javascript', 'handlebars');
        $this->requireAsset('javascript', 'handlebars-helpers');
        $this->requireAsset('redactor');
        $this->requireAsset('core/file-manager');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
    }

    public function save($args)
    {
        $db = Database::connection();
        if (!isset($args["useLargeHeading"]) || trim($args["useLargeHeading"]) == "" || !in_array($args["useLargeHeading"], array(0, 1))) {
            $args["useLargeHeading"] = '';
        }
        $rows = $db->fetchAll('SELECT * FROM btFaqlauraItemEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $item_items = isset($args['item']) && is_array($args['item']) ? $args['item'] : array();
        $queries = array();
        if (!empty($item_items)) {
            $i = 0;
            foreach ($item_items as $item_item) {
                $data = array(
                    'sortOrder' => $i + 1,
                );
                if (isset($item_item['heading']) && trim($item_item['heading']) != '') {
                    $data['heading'] = trim($item_item['heading']);
                } else {
                    $data['heading'] = null;
                }
                $data['content'] = isset($item_item['content']) ? LinkAbstractor::translateTo($item_item['content']) : null;
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
                                $db->update('btFaqlauraItemEntries', $data, array('id' => $id));
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btFaqlauraItemEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btFaqlauraItemEntries', array('id' => $value));
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
                        if (in_array("heading", $this->btFieldsRequired['item']) && (!isset($item_v['heading']) || trim($item_v['heading']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Heading"), t("Item"), $item_k));
                        }
                        if (in_array("content", $this->btFieldsRequired['item']) && (!isset($item_v['content']) || trim($item_v['content']) == "")) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Content"), t("Item"), $item_k));
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
        $al->register('javascript', 'auto-js-faqlaura', 'blocks/faqlaura/auto.js', array(), $this->pkg);
        $this->requireAsset('javascript', 'auto-js-faqlaura');
        $this->edit();
    }
}