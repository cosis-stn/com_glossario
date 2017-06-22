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

jimport('joomla.application.component.controllerform');

/**
 * Glossarios controller class.
 *
 * @since  1.6
 */
class GlossariocosisControllerGlossarios extends JControllerForm {

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct() {
        $this->view_list = 'glossrio';
        parent::__construct();
    }
}
