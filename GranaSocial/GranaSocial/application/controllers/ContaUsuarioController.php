<?php

/**
 * Controle dos Parametros da veiculo
 *
 * @name ParametrosController.php
 * @author Alexis Moura 1/4/2009 10:39:36
 * @package Controller
 * @version $Id$
 */
class ContausuarioController extends Zend_Controller_Action {


    /**
     * Método para inicialização de variáveis.
     *
     * @name init
     * @access public
     * @return void
     */
    public function init(){

        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }
    /**
     * Método que realiza a verificação de login do usuário.
     *
     * @name preDispatch
     * @access public
     * @return void
     */
    public function preDispatch(){
        
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect('auth/login');
        }
    }
    /**
     * Método principal da classe.
     *
     * @name indexAction
     * @access public
     * @return void
     */
    public function indexAction(){

        
    }



}

