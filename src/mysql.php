<?php

namespace mysqlconnect;

use mysqli;
use mysqli_result;
use stdClass;

class mysql
{
    private mysqli $db;
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    private int $port;

    public function __construct(
        string $host,
        string $user,
        string $password,
        int $port,
        string $database
    )
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    private function connect(): void
    {
        $this->db = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->port
        );
        $this->db->set_charset("utf8");
    }

    private function disconnect(): void
    {
        try {
            $this->db->close();
        } catch (Exception $e) {
        }
    }

    /**
     * @param string $text
     * @return string
     */
    public function _limpiar(string $text): string
    {
        return $this->db->real_escape_string($text);
    }

    public function _ultimo_id(): mixed
    {
        return $this->db->insert_id;
    }

    /**
     * @param string $sql
     * @return stdClass|null
     */
    public function _db_consulta(string $sql): ?stdClass
    {
        $this->connect();

        $result = $this->db->query($sql);
        if ($result instanceof mysqli_result) {
            $data = array();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $resultObject = new stdClass();
            $resultObject->num_rows = $result->num_rows;
            $resultObject->row = $data[0] ?? array();
            $resultObject->rows = $data;
        } else {
            $this->disconnect();
            return null;
        }

        $this->disconnect();

        return $resultObject;
    }
}