<?php setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian_indonesia.1252'); ?>
<?=$this->include("layout/header") ?>
<!-- Layout wrapper -->
<style>
    .table > :not(caption) > * > * {
        padding: 0.75rem;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .btn-group {
        gap: 0.25rem;
    }

    .modal-xl {
        max-width: 95%;
    }

    .table-responsive {
        min-height: 400px;
    }

    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .dataTables_wrapper .dataTables_length select {
        min-width: 80px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 250px;
        padding: 0.375rem 0.75rem;
    }
</style>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container"> 
        <?=$this->include("layout/sidebar") ?>
        <div class="layout-page">
            <?=$this->include("layout/navbar") ?>
            <div class="content-wrapper">
                <div class="container-fluid p-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Peserta</h5>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-export me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" id="exportAllPeserta">Semua Peserta</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Per Pelatihan</h6></li>
                                    <?php 
                                    $unique_pelatihan = [];
                                    foreach($peserta as $p) {
                                        if(!empty($p['nama_pelatihan']) && !empty($p['id_pelatihan']) && !isset($unique_pelatihan[$p['id_pelatihan']])) {
                                            $unique_pelatihan[$p['id_pelatihan']] = $p['nama_pelatihan'];
                                        }
                                    }
                                    ?>
                                    <?php foreach($unique_pelatihan as $id => $nama): ?>
                                        <li><a class="dropdown-item export-by-pelatihan" href="#" data-id="<?= $id ?>"><?= $nama ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pesertaTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Instansi</th>
                                            <th>Telepon</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Jadwal Pelatihan</th>
                                            <th>Pusat Penelitian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Edit Peserta -->
            <div class="modal fade" id="editPesertaModal" tabindex="-1" aria-labelledby="editPesertaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPesertaModalLabel">Edit Peserta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_peserta_id">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="edit_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="edit_password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit_nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_instansi" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="edit_instansi">
                            </div>
                            <div class="mb-3">
                                <label for="edit_telp" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="edit_telp">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="updatePeserta()">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <?=$this->include("layout/footer") ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#pesertaTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "<?= site_url('peserta/getPesertaData') ?>",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "username" },
            { data: "nama" },
            { data: "alamat" },
            { data: "instansi" },
            { data: "telp" },
            { data: "nama_pelatihan" },
            { 
                data: "jadwal_pelatihan",
                render: function(data) {
                    return data ? formatDate(data) : '-';
                }
            },
            { data: "puslit" },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editPeserta(${row.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deletePeserta(${row.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'asc']],
        responsive: true,
    });
});

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

function editPeserta(id) {
    // Get peserta data by ID
    $.ajax({
        url: `<?= site_url('peserta/getPesertaById/') ?>${id}`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                const peserta = response.data;
                $('#edit_peserta_id').val(peserta.id);
                $('#edit_username').val(peserta.username);
                $('#edit_password').val(''); // Clear password field
                $('#edit_nama').val(peserta.nama);
                $('#edit_alamat').val(peserta.alamat);
                $('#edit_instansi').val(peserta.instansi);
                $('#edit_telp').val(peserta.telp);
                
                $('#editPesertaModal').modal('show');
            } else {
                alert('Gagal mengambil data peserta');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat mengambil data');
        }
    });
}

function updatePeserta() {
    const id = $('#edit_peserta_id').val();
    const data = {
        username: $('#edit_username').val(),
        password: $('#edit_password').val(),
        nama: $('#edit_nama').val(),
        alamat: $('#edit_alamat').val(),
        instansi: $('#edit_instansi').val(),
        telp: $('#edit_telp').val()
    };
    
    $.ajax({
        url: `<?= site_url('peserta/update/') ?>${id}`,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                $('#editPesertaModal').modal('hide');
                $('#pesertaTable').DataTable().ajax.reload();
                alert('Data peserta berhasil diperbarui');
            } else {
                alert(response.message || 'Gagal memperbarui data peserta');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat memperbarui data');
        }
    });
}

function deletePeserta(id) {
    if (confirm('Apakah Anda yakin ingin menghapus peserta ini?')) {
        $.ajax({
            url: `<?= site_url('peserta/delete/') ?>${id}`,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#pesertaTable').DataTable().ajax.reload();
                    alert('Peserta berhasil dihapus');
                } else {
                    alert(response.message || 'Gagal menghapus peserta');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus data');
            }
        });
    }
}

$('#exportAllPeserta').on('click', function(e) {
    e.preventDefault();
    window.location.href = '<?= site_url('peserta/exportExcel') ?>';
});

$('.export-by-pelatihan').on('click', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    window.location.href = `<?= site_url('peserta/exportExcel') ?>/${id}`;
});
</script> 