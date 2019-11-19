<?php
class DbConfig
{    
    private $_host = DB_HOST;
    private $_username = DB_USERNAME;
    private $_password = DB_PASSWORD;
    private $_database = DB_NAME;
    
    protected $connection;
    
    public function __construct()
    {
        if (!isset($this->connection)) {
            
            $this->connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
            
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
        return $this->connection;
    }
}