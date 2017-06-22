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
 * Content Component Category Tree
 *
 * @since  1.6
 */
class GlossariocosisCategories extends JCategories
{
    /**
     * Class constructor
     *
     * @param   array  $options  Array of options
     *
     * @since   11.1
     */
    public function __construct($options = array())
    {
        $options['table'] = '#__glossario_cosis';
        $options['extension'] = 'com_glossariocosis';

        parent::__construct($options);
    }
}
