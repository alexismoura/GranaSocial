<?php
/**
 * Controller chamado quando algum erro do sistema gera excessão
 *
 * @name ErrorController.php
 * @author Alexis Moura 1/4/2009 10:39:36
 * @package Controller
 * @version $Id$
 */
class ErrorController extends Zend_Controller_Action
{

    /**
     * Action padrão do controller de erros.
     *
     * @name editAction
     * @access public
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $this->view->exception = $errors->exception;
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller ou action não encontrados
                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
                $this->view->errorType = 404;
                break;
            default:
                //erro desconhecido - grava no log
                $log = Zend_Registry::get('log');
                $log->debug($errors->exception->getMessage() . "\n" . $errors->exception->getTraceAsString() . "\n-----------------------------");
                //throw $errors->exception;
                break;
        }
    }
}
