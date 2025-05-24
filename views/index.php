<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Anggota - Perpustakaan</title>
    <!-- CSS files -->
    <link href="/assets/css/tabler.min.css?1692870487" rel="stylesheet" />
    <link href="/assets/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
    <link href="/assets/css/demo.min.css?1692870487" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/datatable.css">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <script src="/assets/js/demo-theme.min.js?1692870487"></script>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    Baitul Hikmah
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <span class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <div class="d-none d-xl-block ps-2">
                                <div>Yoga Pangestu</div>
                                <div class="mt-1 small text-secondary">Software Developer</div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                Selamat Datang di Perpustakaan yang Mengubah Dunia dari Kegelapan Menuju Kemajuan.
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#memberModal" data-modal-title="Tambah Anggota" data-action="members/store" data-method="POST">Tambah Anggota</button>
                            <div class="card">
                                <div class="card-body">
                                    <div id="table-default" class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap datatable" id="memberTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-tbody">
                                                <?php $iteration = 1; ?>
                                                <?php foreach ($members as $member): ?>
                                                    <tr>
                                                        <td><?= $iteration ?></td>
                                                        <td><?= htmlspecialchars($member['nama']) ?></td>
                                                        <td><?= htmlspecialchars($member['alamat']) ?></td>
                                                        <td><?= htmlspecialchars($member['status_anggota']) ?></td>
                                                        <td>
                                                            <div class="btn-list flex-nowrap">
                                                                <div class="dropdown">
                                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                                        ...
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#memberModal"
                                                                            data-modal-title="Edit Anggota"
                                                                            data-action="members/update/<?= $member['id_anggota'] ?>"
                                                                            data-method="PUT" data-name="<?= htmlspecialchars($member['nama']) ?>"
                                                                            data-address="<?= htmlspecialchars($member['alamat']) ?>"
                                                                            data-status="<?= htmlspecialchars($member['status_anggota']) ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                                <path d="M16 5l3 3" />
                                                                            </svg>
                                                                            <span class="ps-1">Edit</span>
                                                                        </button>
                                                                        <button class="dropdown-item deleteMember" data-id="<?= $member['id_anggota'] ?>" type="button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M4 7l16 0" />
                                                                                <path d="M10 11l0 6" />
                                                                                <path d="M14 11l0 6" />
                                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            </svg>
                                                                            <span class="ps-1">Hapus</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $iteration++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#bookModal" data-modal-title="Tambah Buku" data-action="books/store" data-method="POST">Tambah Buku</button>
                            <div class="card">
                                <div class="card-body">
                                    <div id="table-default" class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap datatable" id="bookTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul</th>
                                                    <th>Penulis</th>
                                                    <th>Tahun Terbit</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-tbody">
                                                <?php $iteration = 1; ?>
                                                <?php foreach ($books as $book): ?>
                                                    <tr>
                                                        <td><?= $iteration ?></td>
                                                        <td><?= htmlspecialchars($book['judul']) ?></td>
                                                        <td><?= htmlspecialchars($book['penulis']) ?></td>
                                                        <td><?= htmlspecialchars($book['tahun_terbit']) ?></td>
                                                        <td><?= htmlspecialchars($book['status_buku']) ?></td>
                                                        <td>
                                                            <div class="btn-list flex-nowrap">
                                                                <div class="dropdown">
                                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                                        ...
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#bookModal"
                                                                            data-modal-title="Edit Buku"
                                                                            data-action="books/update/<?= $book['id_buku'] ?>"
                                                                            data-method="PUT" data-title="<?= htmlspecialchars($book['judul']) ?>"
                                                                            data-author="<?= htmlspecialchars($book['penulis']) ?>"
                                                                            data-publish-year="<?= htmlspecialchars($book['tahun_terbit']) ?>"
                                                                            data-status="<?= htmlspecialchars($book['status_buku']) ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                                <path d="M16 5l3 3" />
                                                                            </svg>
                                                                            <span class="ps-1">Edit</span>
                                                                        </button>
                                                                        <button class="dropdown-item deleteBook" data-id="<?= $book['id_buku'] ?>" type="button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M4 7l16 0" />
                                                                                <path d="M10 11l0 6" />
                                                                                <path d="M14 11l0 6" />
                                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            </svg>
                                                                            <span class="ps-1">Hapus</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $iteration++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#loanModal" data-modal-title="Tambah Peminjaman" data-action="loans/store" data-method="POST">Tambah Peminjaman</button>
                            <div class="card">
                                <div class="card-body">
                                    <div id="table-default" class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap datatable" id="loanTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Anggota</th>
                                                    <th>Buku</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Kembali</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-tbody">
                                                <?php $iteration = 1; ?>
                                                <?php foreach ($loans as $loan): ?>
                                                    <tr>
                                                        <td><?= $iteration ?></td>
                                                        <td><?= htmlspecialchars($loan['anggota']) ?></td>
                                                        <td><?= htmlspecialchars($loan['buku']) ?></td>
                                                        <td><?= htmlspecialchars($loan['tanggal_pinjam']) ?></td>
                                                        <td><?= htmlspecialchars($loan['tanggal_kembali']) ?></td>
                                                        <td>
                                                            <div class="btn-list flex-nowrap">
                                                                <div class="dropdown">
                                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                                        ...
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loanModal"
                                                                            data-modal-title="Edit Peminjaman"
                                                                            data-action="loans/update/<?= $loan['id_peminjaman'] ?>"
                                                                            data-method="PUT" data-member="<?= htmlspecialchars($loan['id_anggota']) ?>"
                                                                            data-book="<?= htmlspecialchars($loan['id_buku']) ?>"
                                                                            data-loan-date="<?= htmlspecialchars($loan['tanggal_pinjam']) ?>"
                                                                            data-return-date="<?= htmlspecialchars($loan['tanggal_pinjam']) ?>">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                                <path d="M16 5l3 3" />
                                                                            </svg>
                                                                            <span class="ps-1">Edit</span>
                                                                        </button>
                                                                        <button class="dropdown-item deleteLoan" data-id="<?= $loan['id_peminjaman'] ?>" type="button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M4 7l16 0" />
                                                                                <path d="M10 11l0 6" />
                                                                                <path d="M14 11l0 6" />
                                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            </svg>
                                                                            <span class="ps-1">Hapus</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $iteration++; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Hak Cipta &copy; 2025
                                    <a href="pangestu.vercel.app" class="link-secondary">Yoga Pangestu</a>.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- member modal -->
    <div class="modal modal-blur fade" id="memberModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="memberName">Nama</label>
                        <input type="text" name="name" id="memberName" class="form-control" placeholder="Masukan nama anggota">
                    </div>
                    <div class="mb-3">
                        <label for="memberAddress">Alamat</label>
                        <textarea name="address" id="memberAddress" class="form-control" placeholder="Masukan alamat anggota" cols="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="memberStatus">Status</label>
                        <br />
                        <div class="form-selectgroup">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="status" value="Aktif" class="form-selectgroup-input" checked="">
                                <span class="form-selectgroup-label">Aktif</span>
                            </label>
                            <label class="form-selectgroup-item">
                                <input type="radio" name="status" value="Nonaktif" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveMember" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- book modal -->
    <div class="modal modal-blur fade" id="bookModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bookTitle">Judul</label>
                        <input type="text" name="title" id="bookTitle" class="form-control" placeholder="Masukan judul buku">
                    </div>
                    <div class="mb-3">
                        <label for="bookAuthor">Penulis</label>
                        <input type="text" name="author" id="bookAuthor" class="form-control" placeholder="Masukan penulis buku">
                    </div>
                    <div class="mb-3">
                        <label for="bookPublishYear">Tahun Terbit</label>
                        <input type="number" name="publish_year" id="bookPublishYear" class="form-control" placeholder="Masukan tahun terbit buku">
                    </div>
                    <div class="mb-3">
                        <label for="bookStatus">Status</label>
                        <br />
                        <div class="form-selectgroup">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="status" value="Aktif" class="form-selectgroup-input" checked="">
                                <span class="form-selectgroup-label">Aktif</span>
                            </label>
                            <label class="form-selectgroup-item">
                                <input type="radio" name="status" value="Nonaktif" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveBook" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- loan modal -->
    <div class="modal modal-blur fade" id="loanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="loanMember">Anggota</label>
                        <select name="member" id="loanMember" class="form-control">
                            <?php foreach ($activeMembers as $member): ?>
                                <option value="<?php echo $member['id_anggota']; ?>"><?php echo $member['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="loanBook">Buku</label>
                        <select name="book" id="loanBook" class="form-control">
                            <?php foreach ($books as $book): ?>
                                <option value="<?php echo $book['id_buku']; ?>"><?php echo $book['judul']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="loanLoanDate">Tanggal Pinjam</label>
                        <input type="date" name="loan_date" id="loanLoanDate" class="form-control" placeholder="Masukan tanggal pinjam buku">
                    </div>
                    <div class="mb-3">
                        <label for="loanReturnDate">Tanggal Kembali</label>
                        <input type="date" name="loan_date" id="loanReturnDate" class="form-control" placeholder="Masukan tanggal kembali buku">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveLoan" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/tabler.min.js?1692870487" defer></script>
    <script src="/assets/js/demo.min.js?1692870487" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
    <script src="assets/js/datatable.js"></script>
    <script>
        $('.datatable').DataTable({});
    </script>
    <script src="assets/js/member.js"></script>
    <script src="assets/js/book.js"></script>
    <script src="assets/js/loan.js"></script>
</body>

</html>