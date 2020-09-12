<?php

class Sabv_Auth extends Zend_Auth
{
    /**
     * Singleton instance
     *
     * @var Zend_Auth
     */
    protected static $_instance = null;

    /**
     * Persistent storage handler
     *
     * @var Zend_Auth_Storage_Interface
     */
    protected $_storage = null;

    /**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
    private function __construct()
    {}

    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    private function __clone()
    {}

    /**
     * Returns an instance of Zend_Auth
     *
     * Singleton pattern implementation
     *
     * @return Zend_Auth Provides a fluent interface
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    


}
