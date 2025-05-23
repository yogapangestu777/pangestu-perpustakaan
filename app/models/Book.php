<?php

class Book
{
    private $connection;
    private $tableName = "buku";

    public $bookId;
    public $title;
    public $author;
    public $publishYear;
    public $bookStatus;

    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function getAllBooks()
    {
        $query = "SELECT * FROM " . $this->tableName . " ORDER BY id_buku DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function getBookById($id)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id_buku = ? LIMIT 0,1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createBook()
    {
        $query = "INSERT INTO " . $this->tableName . " SET judul=:title, penulis=:author, tahun_terbit=:publishYear, status_buku=:status";
        $statement = $this->connection->prepare($query);

        $statement->bindParam(":title", $this->title);
        $statement->bindParam(":author", $this->author);
        $statement->bindParam(":publishYear", $this->publishYear);
        $statement->bindParam(":status", $this->bookStatus);

        return $statement->execute();
    }

    public function updateBook()
    {
        $query = "UPDATE " . $this->tableName . " SET judul=:title, penulis=:author, tahun_terbit=:publishYear, status_buku=:status WHERE id_buku=:id";
        $statement = $this->connection->prepare($query);

        $statement->bindParam(":title", $this->title);
        $statement->bindParam(":author", $this->author);
        $statement->bindParam(":publishYear", $this->publishYear);
        $statement->bindParam(":status", $this->bookStatus);
        $statement->bindParam(":id", $this->bookId);

        return $statement->execute();
    }

    public function deleteBook()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE id_buku = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->bookId);
        return $statement->execute();
    }

    public function getAvailableBooks()
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE status_buku = 'tersedia' ORDER BY judul";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }
}
