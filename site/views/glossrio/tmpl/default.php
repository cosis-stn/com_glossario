<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Glossariocosis
 * @author     Clayton Alves Rodrigues <clayton.rodrigues@tesouro.gov.br>
 * @copyright  © 2016 Secretaria do Tesouro Nacional. Todos os direitos reservados.
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// Não acessar diretamente
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
JHtml::_('jquery.framework');
$doc->addScript(JUri::base() . '/media/com_glossariocosis/js/form.js');
$doc->addStyleSheet(JUri::base() . '/media/com_glossariocosis/css/form.css')
?>
<div class="row-fluid">
    <h1 class="span12">Glossário de Termos</h1>
    <div class="input-append">
        <input 
            type="text" 
            name="buscar-glossario" 
            title="Buscar no Glossário" 
            placeholder="Buscar no Glossário" 
            class="searchField buscar-termos" 
            id="portal-searchbox-field">       
        <button class="btn searchButton btn-buscar-termos" type="submit">
            <span class="hide">Buscar</span>
            <i class="icon-search"></i>
        </button>
    </div>
    <br />
    <div class="btn-group btn-group-xs">    
        <?php foreach ($this->letras as $letra): ?>
            <button id="letra-<?php echo $letra; ?>" class="btn-default filtra-letra" style="width:20px;">
                <?php echo $letra; ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div id="termos">
        <?php if (count($this->arGlossarios)): ?>
            <?php foreach ($this->arGlossarios as $obGlossario): ?>
                <div class="letra-<?php echo substr($obGlossario->termo, 0, 1); ?> letras"> 
                    <h3 style="margin-bottom:0;"><?php echo $obGlossario->termo; ?></h3>
                    <?php echo $obGlossario->descricao; ?>
                    <hr />
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>    
</div>
