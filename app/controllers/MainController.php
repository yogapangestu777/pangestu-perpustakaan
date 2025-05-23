<?php

class MainController
{
    private $database;
    private $member;
    private $book;
    private $loan;

    public function __construct()
    {
        $database = new Database();
        $this->database = $database->getConnection();
        $this->member = new Member($this->database);
        $this->book = new Book($this->database);
        $this->loan = new Loan($this->database);
    }

    public function index()
    {
        $members = $this->member->getAllMembers()->fetchAll(PDO::FETCH_ASSOC);
        $books = $this->book->getAllBooks()->fetchAll(PDO::FETCH_ASSOC);
        $loans = $this->loan->getAllLoans()->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/index.php';
    }
}
