<?php

namespace mysqlconnect;

use Exception;
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

    private function disconnect(): bool
    {
        try {
            $this->db->close();
            return true;
        } catch (Exception $e) {
            return false;
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

    /**
     * @param string $query
     * @return stdClass|null
     */
    public function query(string $query): ?stdClass
    {
        $this->connect();

        $result = $this->db->query($query);
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

    public function queryInsert(string $query): mixed
    {
        $this->connect();

        $this->db->query($query);
        $insertId = $this->db->insert_id;

        if (empty($insertId)) {
            return null;
        }

        $this->disconnect();

        return $insertId;
    }
}