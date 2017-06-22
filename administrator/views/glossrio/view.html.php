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

jimport('joomla.application.component.view');

/**
 * View class for a list of Glossariocosis.
 *
 * @since  1.6
 */
class GlossariocosisViewGlossrio extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  Template name
     *
     * @return void
     *
     * @throws Exception
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        GlossariocosisHelpersGlossariocosis::addSubmenu('glossrio');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return void
     *
     * @since    1.6
     */
    protected function addToolbar() {
        $state = $this->get('State');
        $canDo = GlossariocosisHelpersGlossariocosis::getActions();

        JToolBarHelper::title(JText::_('COM_GLOSSARIOCOSIS_TITLE_GLOSSRIO'), 'glossrio.png');

        // Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/glossarios';

        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('glossarios.add', 'JTOOLBAR_NEW');
                JToolbarHelper::custom('glossrio.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('glossarios.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('glossrio.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('glossrio.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } elseif (isset($this->items[0])) {
                // If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'glossrio.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('glossrio.archive', 'JTOOLBAR_ARCHIVE');
            }

            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('glossrio.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        // Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'glossrio.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } elseif ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('glossrio.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_glossariocosis');
        }

        // Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_glossariocosis&view=glossrio');

        $this->extra_sidebar = '';
        JHtmlSidebar::addFilter(
                JText::_("JOPTION_SELECT_CATEGORY"), 'filter_categoria', JHtml::_('select.options', JHtml::_('category.options', 'com_glossariocosis'), "value", "text", $this->state->get('filter.categoria'))
        );

        JHtmlSidebar::addFilter(
                JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_published', JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)
        );
    }

    /**
     * Method to order fields 
     *
     * @return void 
     */
    protected function getSortFields() {
        return array(
            'a.`id`' => JText::_('JGRID_HEADING_ID'),
            'a.`categoria`' => JText::_('COM_GLOSSARIOCOSIS_GLOSSRIO_CATEGORIA'),
            'a.`manual`' => JText::_('COM_GLOSSARIOCOSIS_GLOSSRIO_MANUAL'),
            'a.`termo`' => JText::_('COM_GLOSSARIOCOSIS_GLOSSRIO_TERMO'),
            'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
            'a.`state`' => JText::_('JSTATUS'),
        );
    }

}
