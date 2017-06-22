<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Glossariocosis
 * @author     Clayton Alves Rodrigues <clayton.rodrigues@tesouro.gov.br>
 * @copyright  © 2016 STN/COSIS. Todos os direitos reservados.
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access.
defined('_JEXEC') or die;

/**
 * Glossrio list controller class.
 *
 * @since  1.6
 */
class GlossariocosisControllerGlossrio extends GlossariocosisController {

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional
     * @param   array   $config  Configuration array for model. Optional
     *
     * @return object	The model
     *
     * @since	1.6
     */
    public function &getModel($name = 'Glossrio', $prefix = 'GlossariocosisModel', $config = array()) {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));

        return $model;
    }

}
