<?php

namespace Das\App\Repository;

use Lombok\Getter;
use Lombok\Helper;
use Lombok\Setter;
use Exception;

#[Setter, Getter]
class  DB extends \Lombok\Helper
{
    protected string $host;
    protected string $username;
    protected string $password;
    protected string $db;
    protected int $port;


    public  function __construct(
        // string $host,
        // string $username,
        // string $password,
        // string $db,
        // int $port,

        // string $host=getenv('DB_HOST'),
        // string $username=getenv('DB_USER'),
        // string $password=getenv('DB_PASSWORD'),
        // string $db=getenv('DB_NAME'),
        // int $port=getenv('DB_PORT'),
    )
    {
        parent::__construct();
        
        // $this->host = $host;
        // $this->username = $username;
        // $this->password = $password;
        // $this->db = $db;
        // $this->port = $port;

        $this->host = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->db = getenv('DB_NAME');
        $this->port = getenv('DB_PORT');
    }
    public function connect()
    {
        return mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->db,
            $this->port
        );
    }
}
