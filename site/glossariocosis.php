<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Glossariocosis
 * @author     Clayton Alves Rodrigues <clayton.rodrigues@tesouro.gov.br>
 * @copyright  © 2016 Secretaria do Tesouro Nacional. Todos os direitos reservados.
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Glossariocosis', JPATH_COMPONENT);
JLoader::register('GlossariocosisController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Glossariocosis');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
