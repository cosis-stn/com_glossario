<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Glossariocosis
 * @author     Clayton Alves Rodrigues <clayton.rodrigues@tesouro.gov.br>
 * @copyright  © 2016 STN/COSIS. Todos os direitos reservados.
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Glossarios controller class.
 *
 * @since  1.6
 */
class GlossariocosisControllerGlossariosForm extends JControllerForm {

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @return void
     *
     * @since    1.6
     */
    public function edit($key = NULL, $urlVar = NULL) {
        $app = JFactory::getApplication();

        // Get the previous edit id (if any) and the current edit id.
        $previousId = (int) $app->getUserState('com_glossariocosis.edit.glossarios.id');
        $editId = $app->input->getInt('id', 0);

        // Set the user id for the user to edit in the session.
        $app->setUserState('com_glossariocosis.edit.glossarios.id', $editId);

        // Get the model.
        $model = $this->getModel('GlossariosForm', 'GlossariocosisModel');

        // Check out the item
        if ($editId) {
            $model->checkout($editId);
        }

        // Check in the previous user.
        if ($previousId) {
            $model->checkin($previousId);
        }

        // Redirect to the edit screen.
        $this->setRedirect(JRoute::_('index.php?option=com_glossariocosis&view=glossariosform&layout=edit', false));
    }

    /**
     * Method to save a user's profile data.
     *
     * @return void
     *
     * @throws Exception
     * @since  1.6
     */
    public function save($key = NULL, $urlVar = NULL) {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('GlossariosForm', 'GlossariocosisModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

        // Validate the posted data.
        $form = $model->getForm();

        if (!$form) {
            throw new Exception($model->getError(), 500);
        }

        // Validate the posted data.
        $data = $model->validate($form, $data);

        // Check for errors.
        if ($data === false) {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            $input = $app->input;
            $jform = $input->get('jform', array(), 'ARRAY');

            // Save the data in the session.
            $app->setUserState('com_glossariocosis.edit.glossarios.data', $jform);

            // Redirect back to the edit screen.
            $id = (int) $app->getUserState('com_glossariocosis.edit.glossarios.id');
            $this->setRedirect(JRoute::_('index.php?option=com_glossariocosis&view=glossariosform&layout=edit&id=' . $id, false));
        }

        // Attempt to save the data.
        $return = $model->save($data);

        // Check for errors.
        if ($return === false) {
            // Save the data in the session.
            $app->setUserState('com_glossariocosis.edit.glossarios.data', $data);

            // Redirect back to the edit screen.
            $id = (int) $app->getUserState('com_glossariocosis.edit.glossarios.id');
            $this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
            $this->setRedirect(JRoute::_('index.php?option=com_glossariocosis&view=glossariosform&layout=edit&id=' . $id, false));
        }

        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }

        // Clear the profile id from the session.
        $app->setUserState('com_glossariocosis.edit.glossarios.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_GLOSSARIOCOSIS_ITEM_SAVED_SUCCESSFULLY'));
        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $url = (empty($item->link) ? 'index.php?option=com_glossariocosis&view=glossrio' : $item->link);
        $this->setRedirect(JRoute::_($url, false));

        // Flush the data from the session.
        $app->setUserState('com_glossariocosis.edit.glossarios.data', null);
    }

    /**
     * Method to abort current operation
     *
     * @return void
     *
     * @throws Exception
     */
    public function cancel($key = NULL) {
        $app = JFactory::getApplication();

        // Get the current edit id.
        $editId = (int) $app->getUserState('com_glossariocosis.edit.glossarios.id');

        // Get the model.
        $model = $this->getModel('GlossariosForm', 'GlossariocosisModel');

        // Check in the item
        if ($editId) {
            $model->checkin($editId);
        }

        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $url = (empty($item->link) ? 'index.php?option=com_glossariocosis&view=glossrio' : $item->link);
        $this->setRedirect(JRoute::_($url, false));
    }

    /**
     * Method to remove data
     *
     * @return void
     *
     * @throws Exception
     *
     * @since 1.6
     */
    public function remove() {
        $app = JFactory::getApplication();
        $model = $this->getModel('GlossariosForm', 'GlossariocosisModel');
        $pk = $app->input->getInt('id');

        // Attempt to save the data
        try {
            $return = $model->delete($pk);

            // Check in the profile
            $model->checkin($return);

            // Clear the profile id from the session.
            $app->setUserState('com_glossariocosis.edit.glossarios.id', null);

            $menu = $app->getMenu();
            $item = $menu->getActive();
            $url = (empty($item->link) ? 'index.php?option=com_glossariocosis&view=glossrio' : $item->link);

            // Redirect to the list screen
            $this->setMessage(JText::_('COM_EXAMPLE_ITEM_DELETED_SUCCESSFULLY'));
            $this->setRedirect(JRoute::_($url, false));

            // Flush the data from the session.
            $app->setUserState('com_glossariocosis.edit.glossarios.data', null);
        } catch (Exception $e) {
            $errorType = ($e->getCode() == '404') ? 'error' : 'warning';
            $this->setMessage($e->getMessage(), $errorType);
            $this->setRedirect('index.php?option=com_glossariocosis&view=glossrio');
        }
    }

}
