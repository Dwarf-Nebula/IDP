<?php


/**
 * @package database
 */


/*
 * database interface
 */
interface database
{
    /**
     * make connection with the database
     *
     * @param string @dbHost
     * @param string @dbUser
     * @param string @dbPass
     * @param string @dbName
     * @param string @dbPort
     */

    public function connect ($db_host, $db_user, $db_pass, $db_name, $db_port );

    /**
     * Run a Query
     */

    public function query( $query );
}

/**
 * DatabaseResult interface
 */

interface databaseResult
{
    /**
     * @return array
     */
    public function fetch_assoc();

    /**
     * @return array
     */

    public function fetch_all();

    /**
     * @return int
     */

    public function rows();

}

/**
 * Database exception class.
 */

class databaseException extends Exception
{
// TODO implement databaseException class
}

/**
 * PDO class
 */

Class MySQL implements database
{
    /**
     * @var array
    */
    public $connection;

    /**
     * Make connection with a MySQL database using PDO
     */
    public function connect($db_host, $db_user, $db_pass, $db_name, $db_port)
    {
        if (!$this->connection = new PDO('mysql:host='.$db_host.';port='.$db_port.';dbname='.$db_name,$db_user,$db_pass)){
            throw new databaseException( 'Connection with MySQL database failed' );
        }
    }

    /**
     * @throws databaseException
     * @return MySQLResult
     */

    public function query($query)
    {
        $preparedQuery = $this->connection->prepare($query);
        $preparedQuery->execute();
            if (!$preparedQuery){
                throw new databaseException( $this->connection->errorInfo());
            }
        return new MYSQLResult( $preparedQuery );
    }

}

/**
 * MySQLResult class.
 */

class MySQLResult implements databaseResult
{
    /**
     * @var array
     */
    private $result;

    /**
     * Constructor
     *
     * @param handler $result
     */

    public function __construct( $result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     */

    public function fetch_assoc()
    {
        return $this->result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function fetch_all()
    {
        $result = array();
            while($row = $this->fetch_assoc()){
                $result[] = $row;
            }
        return $result;
    }

    /**
     * @return int
     */

    public function rows()
    {
        return $this->result->rowCount();

    }


}
