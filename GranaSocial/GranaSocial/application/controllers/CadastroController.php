<?php

/**
 * Controle dos Parametros da veiculo
 *
 * @name ParametrosController.php
 * @author Alexis Moura 1/4/2009 10:39:36
 * @package Controller
 * @version $Id$
 */
class CadastroController extends Zend_Controller_Action {


    /**
     * M�todo para inicializa��o de vari�veis.
     *
     * @name init
     * @access public
     * @return void
     */
    public function init(){

        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }

    /**
     * M�todo principal da classe.
     *
     * @name indexAction
     * @access public
     * @return void
     */
    public function indexAction(){

        
    }



}

