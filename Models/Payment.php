<?php

namespace Models;

use Config\Database;

class Payment
{
    public int $iduc;
    public int $iduser;
    //@var int $fail  1=>yes, 0=>no
    public int $fail;
    public string $created_at;
    public string $updated_at;

    /**
     * insert
     *
     * @return boolean
     */
    public function insert()
    {
        $sql = " INSERT INTO `payment`
        (`iduc`, `iduser`, fail)
        VALUES 
        (:iduc,     :iduser, :fail)";
        $values = [
            "iduc" => $this->iduc,
            "iduser" => $this->iduser,
            "fail" => $this->fail
        ];
        return Database::operation($sql, $values);
    }
}
