<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
    {
    	$this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');

        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/appLogs/".date("Y-m-d"));
	    $logger = new Zend_Log($writer);
	    Zend_Registry::set('logger', $logger);
    }

}

