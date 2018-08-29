<?php
namespace Concrete\Package\Sjc2016\Block\CallToActions;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Core;
use File;
use Page;
use Database;

class Controller extends BlockController
{
    public $helpers = array('form');
    public $btFieldsRequired = array('ctas' => array());
    protected $btExportFileColumns = array('bgimage');
    protected $btExportTables = array('btCallToActions', 'btCallToActionsCtasEntries');
    protected $btTable = 'btCallToActions';
    protected $btInterfaceWidth = 800;
    protected $btInterfaceHeight = 600;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btCacheBlockOutputLifetime = 0;
    protected $pkg = 'sjc2016';
    
    public function getBlockTypeDescription()
    {
        return t("");
    }

    public function getBlockTypeName()
    {
        return t("Call To Actions");
    }

    public function getSearchableContent()
    {
        $content = array();
        $content[] = $this->headline;
        return implode(" ", $content);
    }

    public function view()
    {
        $db = Database::connection();
        
        if ($this->bgimage && ($f = File::getByID($this->bgimage)) && is_object($f)) {
            $this->set("bgimage", $f);
        } else {
            $this->set("bgimage", false);
        }
        $ctas = array();
        $ctas["theme_options"] = array(
            'red' => "Red",
            'green' => "Green",
            'orange' => "Orange",
            'blue' => "Blue"
        );
        $ctas_items = $db->fetchAll('SELECT * FROM btCallToActionsCtasEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($ctas_items as $ctas_item_k => &$ctas_item_v) {
            if (isset($ctas_item_v['image']) && trim($ctas_item_v['image']) != "" && ($f = File::getByID($ctas_item_v['image'])) && is_object($f)) {
                $ctas_item_v['image'] = $f;
            } else {
                $ctas_item_v['image'] = false;
            }
        }
        $this->set('ctas_items', $ctas_items);
        $this->set('ctas', $ctas);
    }

    public function delete()
    {
        $db = Database::connection();
        $db->delete('btCallToActionsCtasEntries', array('bID' => $this->bID));
        parent::delete();
    }

    public function duplicate($newBID)
    {
        $db = Database::connection();
        $ctas_items = $db->fetchAll('SELECT * FROM btCallToActionsCtasEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($ctas_items as $ctas_item) {
            unset($ctas_item['id']);
            $ctas_item['bID'] = $newBID;
            $db->insert('btCallToActionsCtasEntries', $ctas_item);
        }
        parent::duplicate($newBID);
    }

    public function add()
    {
        $this->addEdit();
        $ctas = $this->get('ctas');
        $this->set('ctas_items', array());
        $this->set('ctas', $ctas);
    }

    public function edit()
    {
        $db = Database::connection();
        $this->addEdit();
        $ctas = $this->get('ctas');
        $ctas_items = $db->fetchAll('SELECT * FROM btCallToActionsCtasEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        foreach ($ctas_items as &$ctas_item) {
            if (!File::getByID($ctas_item['image'])) {
                unset($ctas_item['image']);
            }
        }
        $this->set('ctas', $ctas);
        $this->set('ctas_items', $ctas_items);
    }

    protected function addEdit()
    {
        $ctas = array();
        $ctas['theme_options'] = array(
            'red' => "Red",
            'green' => "Green",
            'orange' => "Orange",
            'blue' => "Blue"
        );
        $this->set('ctas', $ctas);
        $this->set('identifier', new \Concrete\Core\Utility\Service\Identifier());
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('css', 'repeatable-ft.form', 'blocks/call_to_actions/css_form/repeatable-ft.form.css', array(), $this->pkg);
        $al->register('javascript', 'handlebars', 'blocks/call_to_actions/js_form/handlebars-v4.0.4.js', array(), $this->pkg);
        $al->register('javascript', 'handlebars-helpers', 'blocks/call_to_actions/js_form/handlebars-helpers.js', array(), $this->pkg);
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
        $rows = $db->fetchAll('SELECT * FROM btCallToActionsCtasEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $ctas_items = isset($args['ctas']) && is_array($args['ctas']) ? $args['ctas'] : array();
        $queries = array();
        if (!empty($ctas_items)) {
            $i = 0;
            foreach ($ctas_items as $ctas_item) {
                $data = array(
                    'sortOrder' => $i + 1,
                );

                if (isset($ctas_item['link']) && trim($ctas_item['link']) != '') {
                    $data['link'] = trim($ctas_item['link']);
                } else {
                    $data['link'] = null;
                }

                if (isset($ctas_item['link_text']) && trim($ctas_item['link_text']) != '') {
                    $data['link_text'] = trim($ctas_item['link_text']);
                } else {
                    $data['link_text'] = null;
                }
                if (isset($ctas_item['image']) && trim($ctas_item['image']) != '') {
                    $data['image'] = trim($ctas_item['image']);
                } else {
                    $data['image'] = null;
                }
                if (isset($ctas_item['theme']) && trim($ctas_item['theme']) != '') {
                    $data['theme'] = trim($ctas_item['theme']);
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
                                $db->update('btCallToActionsCtasEntries', $data, array('id' => $id));
                            }
                            break;
                        case 'insert':
                            foreach ($values as $data) {
                                $db->insert('btCallToActionsCtasEntries', $data);
                            }
                            break;
                        case 'delete':
                            foreach ($values as $value) {
                                $db->delete('btCallToActionsCtasEntries', array('id' => $value));
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
        if (in_array("headline", $this->btFieldsRequired) && (trim($args["headline"]) == "")) {
            $e->add(t("The %s field is required.", t("Headline")));
        }
        if (in_array("bgimage", $this->btFieldsRequired) && (trim($args["bgimage"]) == "" || !is_object(File::getByID($args["bgimage"])))) {
            $e->add(t("The %s field is required.", t("Background Image")));
        }
        $ctasEntriesMin = 1;
        $ctasEntriesMax = 4;
        $ctasEntriesErrors = 0;
        $ctas = array();
        if (isset($args['ctas']) && is_array($args['ctas']) && !empty($args['ctas'])) {
            if ($ctasEntriesMin >= 1 && count($args['ctas']) < $ctasEntriesMin) {
                $e->add(t("The %s field requires at least %s entries, %s entered.", t("Call To Action"), $ctasEntriesMin, count($args['ctas'])));
                $ctasEntriesErrors++;
            }
            if ($ctasEntriesMax >= 1 && count($args['ctas']) > $ctasEntriesMax) {
                $e->add(t("The %s field is set to a maximum of %s entries, %s entered.", t("Call To Action"), $ctasEntriesMax, count($args['ctas'])));
                $ctasEntriesErrors++;
            }
            if ($ctasEntriesErrors == 0) {
                foreach ($args['ctas'] as $ctas_k => $ctas_v) {
                    if (is_array($ctas_v)) {
                        if (in_array("image", $this->btFieldsRequired['ctas']) && (!isset($ctas_v['image']) || trim($ctas_v['image']) == "" || !is_object(File::getByID($ctas_v['image'])))) {
                            $e->add(t("The %s field is required (%s, row #%s).", t("Image"), t("Call To Action"), $ctas_k));
                        }
                        if ((in_array("theme", $this->btFieldsRequired['ctas']) && (!isset($ctas_v['theme']) || trim($ctas_v['theme']) == "")) || (isset($ctas_v['theme']) && trim($ctas_v['theme']) != "" && !in_array($ctas_v['theme'], array("red", "green", "orange", "blue")))) {
                            $e->add(t("The %s field has an invalid value (%s, row #%s).", t("Theme"), t("Call To Action"), $ctas_k));
                        }
                    } else {
                        $e->add(t("The values for the %s field, row #%s, are incomplete.", t('Call To Action'), $ctas_k));
                    }
                }
            }
        } else {
            if ($ctasEntriesMin >= 1) {
                $e->add(t("The %s field requires at least %s entries, none entered.", t("Call To Action"), $ctasEntriesMin));
            }
        }
        return $e;
    }

    public function composer()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('javascript', 'auto-js-call_to_actions', 'blocks/call_to_actions/auto.js', array(), $this->pkg);
        $this->requireAsset('javascript', 'auto-js-call_to_actions');
        $this->edit();
    }
}