<?php

class Member
{
    private $connection;
    private $tableName = "anggota";

    public $memberId;
    public $name;
    public $address;
    public $memberStatus;

    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function getAllMembers()
    {
        $query = "SELECT * FROM " . $this->tableName . " ORDER BY id_anggota DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function getMemberById($id)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id_anggota = ? LIMIT 0,1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createMember()
    {
        $query = "INSERT INTO " . $this->tableName . " SET nama=:name, alamat=:address, status_anggota=:status";
        $statement = $this->connection->prepare($query);

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":address", $this->address);
        $statement->bindParam(":status", $this->memberStatus);

        return $statement->execute();
    }

    public function updateMember()
    {
        $query = "UPDATE " . $this->tableName . " SET nama=:name, alamat=:address, status_anggota=:status WHERE id_anggota=:id";
        $statement = $this->connection->prepare($query);

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":address", $this->address);
        $statement->bindParam(":status", $this->memberStatus);
        $statement->bindParam(":id", $this->memberId);

        return $statement->execute();
    }

    public function deleteMember()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE id_anggota = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->memberId);
        return $statement->execute();
    }
}
