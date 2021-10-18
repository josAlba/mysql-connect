<?php

namespace mysqlconnect;

use mysqli;
use mysqli_result;
use stdClass;

class mysql
{
    private $db;

    /**
     * @param string $text
     * @return string
     */
    public function _limpiar(string $text): string
    {
        return $this->db->real_escape_string($text);
    }

    public function __construct($host, $user, $passwd, $port, $db)
    {
        $this->db = new mysqli(
            $host,
            $user,
            $passwd,
            $port,
            $db);
        $this->db->set_charset("utf8");
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function _ultimo_id()
    {
        return $this->db->insert_id;
    }

    /**
     * @param string $sql
     * @return stdClass|null
     */
    public function _db_consulta(string $sql): ?stdClass
    {
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
            return null;
        }
        return $resultObject;
    }

}