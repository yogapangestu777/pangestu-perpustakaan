<?php

class MemberController
{
    private $database;
    private $member;

    public function __construct()
    {
        $database = new Database();
        $this->database = $database->getConnection();
        $this->member = new Member($this->database);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $errors = [];
        if ($_POST) {
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $status = trim($_POST['status'] ?? '');

            if ($name === '') {
                $errors[] = "Nama tidak boleh kosong.";
            } elseif (strlen($name) > 100) {
                $errors[] = "Nama tidak boleh lebih dari 100 karakter.";
            }

            if ($address === '') {
                $errors[] = "Alamat tidak boleh kosong.";
            } elseif (strlen($address) > 255) {
                $errors[] = "Alamat tidak boleh lebih dari 255 karakter.";
            }

            if ($status === '') {
                $errors[] = "Status anggota tidak boleh kosong.";
            } elseif (!in_array($status, ['Aktif', 'Nonaktif'])) {
                $errors[] = "Status anggota harus 'Aktif' atau 'Nonaktif'.";
            }

            if (empty($errors)) {
                $this->member->name = $name;
                $this->member->address = $address;
                $this->member->memberStatus = $status;

                $this->member->createMember();
                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil disimpan.',
                    'data' => $this->member->getAllMembers()->fetchAll(PDO::FETCH_ASSOC)
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
            $name = trim($put_vars['name'] ?? '');
            $address = trim($put_vars['address'] ?? '');
            $status = trim($put_vars['status'] ?? '');

            if ($id === '') {
                $errors[] = "ID tidak boleh kosong.";
            } elseif (!ctype_digit($id)) {
                $errors[] = "ID tidak valid.";
            }

            if ($name === '') {
                $errors[] = "Nama tidak boleh kosong.";
            } elseif (strlen($name) > 100) {
                $errors[] = "Nama tidak boleh lebih dari 100 karakter.";
            }

            if ($address === '') {
                $errors[] = "Alamat tidak boleh kosong.";
            } elseif (strlen($address) > 255) {
                $errors[] = "Alamat tidak boleh lebih dari 255 karakter.";
            }

            if ($status === '') {
                $errors[] = "Status anggota tidak boleh kosong.";
            } elseif (!in_array($status, ['Aktif', 'Nonaktif'])) {
                $errors[] = "Status anggota harus 'Aktif' atau 'Nonaktif'.";
            }

            if (empty($errors)) {
                $this->member->memberId = $id;
                $this->member->name = $name;
                $this->member->address = $address;
                $this->member->memberStatus = $status;

                $this->member->updateMember();

                http_response_code(200);
                echo json_encode([
                    'message' => 'Data berhasil diperbarui.',
                    'data' => $this->member->getAllMembers()->fetchAll(PDO::FETCH_ASSOC)
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

        $this->member->memberId = $id;

        $deleteResult = $this->member->deleteMember();

        if ($deleteResult) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Data berhasil dihapus.',
                'data' => $this->member->getAllMembers()->fetchAll(PDO::FETCH_ASSOC)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Gagal menghapus data.']);
        }
        exit();
    }
}
