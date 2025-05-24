$(document).ready(function () {
    let option = {};

    function fillTable(data) {
        const table = $('#memberTable').DataTable();
        table.clear();
        data.forEach((member, index) => {
            table.row.add([
                index + 1,
                member.nama,
                member.alamat,
                member.status_anggota,
                `
                <div class="btn-list flex-nowrap">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">...</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#memberModal"
                                data-modal-title="Edit Anggota"
                                data-action="members/update/${member.id_anggota}"
                                data-method="PUT"
                                data-name="${member.nama}"
                                data-address="${member.alamat}"
                                data-status="${member.status_anggota}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                <span class="ps-1">Edit</span>
                            </button>
                            <button class="dropdown-item deleteMember" data-id="${member.id_anggota}" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
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
                `
            ]);
        });
        table.draw();
    }

    function resetModal() {
        $("#memberName").val('');
        $("#memberAddress").val('');
        $("input[name='member_status'][value='Aktif']").prop("checked", true);
    }

    $("#memberModal").on("show.bs.modal", function (event) {
        const $button = $(event.relatedTarget);
        option = {
            modalTitle: $button.data("modal-title"),
            action: $button.data("action"),
            method: $button.data("method")
        };

        $(".modal-title").text(option.modalTitle);

        if (option.method === 'PUT') {
            $("#memberName").val($button.data("name") || '');
            $("#memberAddress").val($button.data("address") || '');
            $("input[name='member_status'][value='" + ($button.data("status") || 'Aktif') + "']").prop("checked", true);
        } else {
            resetModal();
        }
    });

    $("#saveMember").on("click", function () {
        const postData = {
            name: $("#memberName").val(),
            address: $("#memberAddress").val(),
            status: $("input[name='member_status']:checked").val()
        };
        $.ajax({
            url: option.action,
            method: option.method,
            data: postData,
            success: function (response) {
                fillTable(response.data);

                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                    $('#memberModal').modal('hide');
                    resetModal();
                });
            },
            error: function (xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.message) {
                        errorMessage = Array.isArray(res.message) ? res.message.join('<br>') : res.message;
                    }
                } catch {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Response tidak valid dari server.',
                        confirmButtonColor: '#d33'
                    });
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorMessage,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    $('#memberModal').on('hidden.bs.modal', resetModal);

    $(document).on("click", ".deleteMember", function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: "Apa Anda Yakin?",
            text: "Jika anda menghapus data ini maka semua data yang berelasi dengan data ini akan hilang!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#949596",
            confirmButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/members/delete/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: window.CSRF_TOKEN
                    },
                    success: function (response) {
                        fillTable(response.data);
                        Swal.fire('Terhapus!', response.message, 'success');
                    },
                    error: function (xhr) {
                        let message = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                        Swal.fire('Gagal!', message, 'error');
                    }
                });
            }
        });
    });
});
