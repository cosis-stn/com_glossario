<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Glossariocosis
 * @author     Clayton Alves Rodrigues <clayton.rodrigues@tesouro.gov.br>
 * @copyright  © 2016 Secretaria do Tesouro Nacional. Todos os direitos reservados.
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Glossariocosis helper.
 *
 * @since  1.6
 */
class GlossariocosisHelpersGlossariocosis {

    /**
     * Configure the Linkbar.
     *
     * @param   string  $vName  string
     *
     * @return void
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
                JText::_('COM_GLOSSARIOCOSIS_TITLE_GLOSSRIO'), 'index.php?option=com_glossariocosis&view=glossrio', $vName == 'glossrio'
        );

        JHtmlSidebar::addEntry(
                JText::_('JCATEGORIES') . ' (' . JText::_('COM_GLOSSARIOCOSIS_TITLE_GLOSSRIO') . ')', "index.php?option=com_categories&extension=com_glossariocosis", $vName == 'categories'
        );
        if ($vName == 'categories') {
            JToolBarHelper::title('Glossario COSIS: JCATEGORIES (COM_GLOSSARIOCOSIS_TITLE_GLOSSRIO)');
        }
    }

    /**
     * Gets the files attached to an item
     *
     * @param   int     $pk     The item's id
     *
     * @param   string  $table  The table's name
     *
     * @param   string  $field  The field's name
     *
     * @return  array  The files
     */
    public static function getFiles($pk, $table, $field) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select($field)
                ->from($table)
                ->where('id = ' . (int) $pk);

        $db->setQuery($query);

        return explode(',', $db->loadResult());
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return    JObject
     *
     * @since    1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_glossariocosis';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    /**
     * Get group name using group ID
     * @param integer $group_id Usergroup ID
     * @return mixed group name if the group was found, null otherwise
     */
    public static function getGroupNameByGroupId($group_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select('title')
                ->from('#__usergroups')
                ->where('id = ' . intval($group_id));

        $db->setQuery($query);
        return $db->loadResult();
    }

}

class GlossariocosisHelper extends GlossariocosisHelpersGlossariocosis {
    
}
