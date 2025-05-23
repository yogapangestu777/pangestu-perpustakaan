<?php

class LoanController
{
    private $database;
    private $loan;

    public function __construct()
    {
        $database = new Database();
        $this->database = $database->getConnection();
        $this->loan = new Loan($this->database);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $errors = [];
        if ($_POST) {
            $member = trim($_POST['member'] ?? '');
            $book = trim($_POST['book'] ?? '');
            $loanDate = trim($_POST['loanDate'] ?? '');
            $returnDate = trim($_POST['returnDate'] ?? '');

            if ($member === '') {
                $errors[] = "Anggota tidak boleh kosong.";
            }

            if ($book === '') {
                $errors[] = "Buku tidak boleh kosong.";
            }

            if ($loanDate === '') {
                $errors[] = "Tanggal pinjam tidak boleh kosong.";
            }

            if ($returnDate === '') {
                $errors[] = "Tanggal kembali tidak boleh kosong.";
            }

            if (empty($errors)) {
                $this->loan->memberId = $member;
                $this->loan->bookId = $book;
                $this->loan->loanDate = $loanDate;
                $this->loan->returnDate = $returnDate;

                $this->loan->createLoan();
                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil disimpan.',
                    'data' => $this->loan->getAllLoans()->fetchAll(PDO::FETCH_ASSOC)
                ]);
                exit();
            } else {
                http_response_code(422);
                echo json_encode(['message' => $errors]);
                exit();
            }
        }

        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        exit();
    }

    public function update($id = null)
    {
        header('Content-Type: application/json');
        if ($id === null) {
            http_response_code(422);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            exit();
        }

        $id = trim($id);
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            parse_str(file_get_contents("php://input"), $put_vars);
            $member = trim($put_vars['member'] ?? '');
            $book = trim($put_vars['book'] ?? '');
            $loanDate = trim($put_vars['loanDate'] ?? '');
            $returnDate = trim($put_vars['returnDate'] ?? '');

            if ($id === '') {
                $errors[] = "ID tidak boleh kosong.";
            } elseif (!ctype_digit($id)) {
                $errors[] = "ID tidak valid.";
            }

            if ($member === '') {
                $errors[] = "Anggota tidak boleh kosong.";
            }

            if ($book === '') {
                $errors[] = "Buku tidak boleh kosong.";
            }

            if ($loanDate === '') {
                $errors[] = "Tanggal pinjam tidak boleh kosong.";
            }

            if ($returnDate === '') {
                $errors[] = "Tanggal kembali tidak boleh kosong.";
            }

            if (empty($errors)) {
                $this->loan->loanId = $id;
                $this->loan->memberId = $member;
                $this->loan->bookId = $book;
                $this->loan->loanDate = $loanDate;
                $this->loan->returnDate = $returnDate;

                $this->loan->updateLoan();

                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil diperbarui.',
                    'data' => $this->loan->getAllLoans()->fetchAll(PDO::FETCH_ASSOC)
                ]);
                exit();
            } else {
                http_response_code(422);
                echo json_encode(['message' => $errors]);
                exit();
            }
        }

        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        exit();
    }

    public function delete($id = null)
    {
        header('Content-Type: application/json');

        if ($id === null) {
            http_response_code(422);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            exit();
        }

        $id = trim($id);

        if (!ctype_digit($id)) {
            http_response_code(422);
            echo json_encode(['message' => 'ID tidak valid.']);
            exit();
        }

        $this->loan->loanId = $id;

        $deleteResult = $this->loan->deleteLoan();

        if ($deleteResult) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Data berhasil dihapus.',
                'data' => $this->loan->getAllLoans()->fetchAll(PDO::FETCH_ASSOC)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Gagal menghapus data.']);
        }
        exit();
    }
}
