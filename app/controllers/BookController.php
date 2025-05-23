<?php

class BookController
{
    private $database;
    private $book;

    public function __construct()
    {
        $database = new Database();
        $this->database = $database->getConnection();
        $this->book = new Book($this->database);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $errors = [];
        if ($_POST) {
            $title = trim($_POST['title'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $publishYear = trim($_POST['publishYear'] ?? '');
            $status = trim($_POST['status'] ?? '');

            if ($title === '') {
                $errors[] = "Judul tidak boleh kosong.";
            } elseif (strlen($title) > 100) {
                $errors[] = "Judul tidak boleh lebih dari 100 karakter.";
            }

            if ($author === '') {
                $errors[] = "Penulis tidak boleh kosong.";
            } elseif (strlen($author) > 255) {
                $errors[] = "Penulis tidak boleh lebih dari 255 karakter.";
            }

            if ($publishYear === '') {
                $errors[] = "Tahun terbit tidak boleh kosong.";
            } elseif (!ctype_digit($publishYear)) {
                $errors[] = "Tahun terbit harus berupa angka.";
            }

            if ($status === '') {
                $errors[] = "Status buku tidak boleh kosong.";
            } elseif (!in_array($status, ['Aktif', 'Nonaktif'])) {
                $errors[] = "Status buku harus 'Aktif' atau 'Nonaktif'.";
            }

            if (empty($errors)) {
                $this->book->title = $title;
                $this->book->author = $author;
                $this->book->publishYear = $publishYear;
                $this->book->bookStatus = $status;

                $this->book->createBook();
                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil disimpan.',
                    'data' => $this->book->getAllBooks()->fetchAll(PDO::FETCH_ASSOC)
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
            $title = trim($put_vars['title'] ?? '');
            $author = trim($put_vars['author'] ?? '');
            $publishYear = trim($put_vars['publishYear'] ?? '');
            $status = trim($put_vars['status'] ?? '');

            if ($id === '') {
                $errors[] = "ID tidak boleh kosong.";
            } elseif (!ctype_digit($id)) {
                $errors[] = "ID tidak valid.";
            }

            if ($title === '') {
                $errors[] = "Judul tidak boleh kosong.";
            } elseif (strlen($title) > 100) {
                $errors[] = "Judul tidak boleh lebih dari 100 karakter.";
            }

            if ($author === '') {
                $errors[] = "Penulis tidak boleh kosong.";
            } elseif (strlen($author) > 255) {
                $errors[] = "Penulis tidak boleh lebih dari 255 karakter.";
            }

            if ($publishYear === '') {
                $errors[] = "Tahun terbit tidak boleh kosong.";
            } elseif (!ctype_digit($publishYear)) {
                $errors[] = "Tahun terbit harus berupa angka.";
            }

            if ($status === '') {
                $errors[] = "Status buku tidak boleh kosong.";
            } elseif (!in_array($status, ['Aktif', 'Nonaktif'])) {
                $errors[] = "Status buku harus 'Aktif' atau 'Nonaktif'.";
            }

            if (empty($errors)) {
                $this->book->bookId = $id;
                $this->book->title = $title;
                $this->book->author = $author;
                $this->book->publishYear = $publishYear;
                $this->book->bookStatus = $status;

                $this->book->updateBook();

                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil diperbarui.',
                    'data' => $this->book->getAllBooks()->fetchAll(PDO::FETCH_ASSOC)
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

        $this->book->bookId = $id;

        $deleteResult = $this->book->deleteBook();

        if ($deleteResult) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Data berhasil dihapus.',
                'data' => $this->book->getAllBooks()->fetchAll(PDO::FETCH_ASSOC)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Gagal menghapus data.']);
        }
        exit();
    }
}
