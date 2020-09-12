<?php
/**
 * Controller Incial do sistema
 *
 * @name IndexController.php
 * @author Alexis Moura 1/4/2009 10:39:36
 * @package Controller
 * @version $Id$
 */
class IndexController extends Zend_Controller_Action {


    /**
     * Descrição dos campos a serem validados
     *
     * @name $_descricaoCampos
     * @access protected
     * @var array
     */
    protected $_descricaoCampos = array('cod_ent' => 'Entidade',
        							    'username' => 'Matrícula',
        								'password' => 'Senha');


    function init()
    {
		$this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        Zend_Loader::loadClass('Entidade');
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }


    function preDispatch()
    {
        $auth = Sabv_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect('auth/login');
        }
         
    }


    function indexAction()
    {

		$c=10;
		$d = $c-10;
		//$acl = Zend_Registry::get('acl');
		$entidade = new Entidade();
		$Id = 0;
		//$dadosEntidade = $entidade->select()->where("Id ='{$Id}'");
        //$result = $entidade->fetchRow($dadosEntidade);
//
//        if($result){
        
//
//			$resultArray = $result->toArray();
//			$this->view->entidade = $resultArray['entidade'];
//
//		}
//        // busca a role do usuario logado
//        $this->view->entidades = $entidade->fetchAll();
//        $this->view->title = "SABV - Página Inicial";
		$this->render();
    }



}
