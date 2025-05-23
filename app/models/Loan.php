<?php

class Loan
{
    private $connection;
    private $tableName = "peminjaman";

    public $loanId;
    public $bookId;
    public $memberId;
    public $loanDate;
    public $returnDate;

    public function __construct($database)
    {
        $this->connection = $database;
    }

    public function getAllLoans()
    {
        $query = "SELECT p.*, b.judul as buku, a.nama as anggota 
                FROM " . $this->tableName . " p 
                LEFT JOIN buku b ON p.id_buku = b.id_buku 
                LEFT JOIN anggota a ON p.id_anggota = a.id_anggota 
                ORDER BY p.id_peminjaman DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function getLoanById($id)
    {
        $query = "SELECT p.*, b.judul as buku, a.nama as anggota 
                FROM " . $this->tableName . " p 
                LEFT JOIN buku b ON p.id_buku = b.id_buku 
                LEFT JOIN anggota a ON p.id_anggota = a.id_anggota 
                WHERE p.id_peminjaman = ? LIMIT 0,1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createLoan()
    {
        $this->connection->beginTransaction();

        try {
            // Insert loan record
            $query = "INSERT INTO " . $this->tableName . " SET id_buku=:bookId, id_anggota=:memberId, tanggal_pinjam=:loanDate, tanggal_kembali=:returnDate";
            $statement = $this->connection->prepare($query);

            $statement->bindParam(":bookId", $this->bookId);
            $statement->bindParam(":memberId", $this->memberId);
            $statement->bindParam(":loanDate", $this->loanDate);
            $statement->bindParam(":returnDate", $this->returnDate);

            $statement->execute();

            // Update book status
            $updateQuery = "UPDATE buku SET status_buku = 'dipinjam' WHERE id_buku = :bookId";
            $updateStatement = $this->connection->prepare($updateQuery);
            $updateStatement->bindParam(":bookId", $this->bookId);
            $updateStatement->execute();

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollback();
            return false;
        }
    }

    public function updateLoan()
    {
        $query = "UPDATE " . $this->tableName . " SET id_buku=:bookId, id_anggota=:memberId, tanggal_pinjam=:loanDate, tanggal_kembali=:returnDate WHERE id_peminjaman=:id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(":bookId", $this->bookId);
        $statement->bindParam(":memberId", $this->memberId);
        $statement->bindParam(":loanDate", $this->loanDate);
        $statement->bindParam(":returnDate", $this->returnDate);
        $statement->bindParam(":id", $this->loanId);
        $statement->execute();
        return true;
    }

    public function deleteLoan()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE id_peminjaman = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->loanId);
        return $statement->execute();
    }


    public function returnBook()
    {
        $this->connection->beginTransaction();

        try {
            // Delete loan record
            $query = "DELETE FROM " . $this->tableName . " WHERE id_peminjaman = ?";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(1, $this->loanId);
            $statement->execute();

            // Update book status back to available
            $updateQuery = "UPDATE buku SET status_buku = 'tersedia' WHERE id_buku = :bookId";
            $updateStatement = $this->connection->prepare($updateQuery);
            $updateStatement->bindParam(":bookId", $this->bookId);
            $updateStatement->execute();

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollback();
            return false;
        }
    }
}
