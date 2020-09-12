<?php
/**
 * responsavel pela autenticação
 *
 * @name AuthController
 * @author Alexis Moura 1/4/2009 09:52:39
 * @package models
 * @version $Id$
 */
class AuthController extends Zend_Controller_Action {

    /**
     * Metodo chamado quando o controller é inicializado
     *
     * @name init
     * @access public
     * @return void
     */
    function init()
    {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        Zend_Loader::loadClass('Sabv_Filter_Input');
    }

    /**
     * Action inicial do controller.
     *
     * @name indexAction
     * @access public
     * @return void
     */
    function indexAction()
    {
        //$this->_redirect('/');
    }

    /**
     * Action responsavel por validar o login do usuario
     *
     * @name loginAction
     * @access public
     * @return void
     */
    function loginAction()
    {
		$db = Zend_Registry::get('db');
        $this->view->message = '';
		//$c = $db->fetchRow(" SELECT * FROM usuario LIMIT 0, 50");
        $auth = Zend_Auth::getInstance();
        $passwd = $this->getRequest()->getParam('password');
        
        if (!$auth->hasIdentity() || !empty($passwd) ) {
            if ($this->getRequest()->isPost() || ($this->getRequest()->isGet() && ($this->getRequest()->getParam('tipo') == 'get'))) 
            {
                
                Zend_Loader::loadClass('Zend_Filter_StripTags');
                $filter = new Zend_Filter_StripTags();
                $username = $filter->filter($this->_request->getParam('username'));
                $password = $filter->filter($this->_request->getParam('password'));
                $data = $this->_request->getParams();
                
                if(!empty($username) && !empty($passwd))
                {
                    Zend_Loader::loadClass('Sabv_Auth_Adapter_DbTable');

                    $authAdapter = new Sabv_Auth_Adapter_DbTable($db);
                    $authAdapter->setTableName('usuario');
                    $authAdapter->setIdentityColumn('username');
                    $authAdapter->setCredentialColumn('password');
                    
                    // função criada para aceitar a clausula where na autenticação
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential(md5($password));
                    
                    // faz a autenticação
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
                    
                    if ($result->isValid()) {
                        
                        // sucesso : guarda os dados do usuario, com excessao da senha
                        $data = $authAdapter->getResultRowObject(null, 'password');
                        $auth->getStorage()->write($data);
                        
                        // aumenta o session timeout para 1 hora
                        $authSession = new Zend_Session_Namespace('Zend_Auth');
                        $authSession->setExpirationSeconds(3600);
                        
                        // cria sessao para guardar dados do safci e coloca timeou em 60 segundos
                        $ns = new Zend_Session_Namespace('sabv');
                        $ns->setExpirationSeconds(864000);
                        
                        $this->_redirect('/index/index');
                    } else {
                        $this->view->errors = "Login falhou.";
                    }
                }
                else{
                    $this->view->errors = "Login falhou.";
                }
                if(!$data)
                    $this->view->assign($data);
                $this->render();
            }
        }
        else{
            $this->_redirect('/');
        }

    }

    /**
     * Action responsavel por realizar o logout
     *
     * @name logoutAction
     * @access public
     * @return void
     */
    function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $ns = Zend_Registry::get('ns');
        $base = $ns->safci->base;
        $ns->unsetAll();
        if (!empty($base)) {
            $this->_redirect('http://' . $_SERVER['SERVER_ADDR'] . $base . '/logout.php');
        }
        else {
		    $this->_redirect($this->getRequest()->getModuleName().'/index');
		}

    }
}
