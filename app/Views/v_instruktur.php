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
                            <h5 class="mb-0">Data Instruktur</h5>
                            <button type="button" class="btn btn-primary" onclick="addInstruktur()">
                                <i class="bx bx-plus"></i> Tambah Instruktur
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="instrukturTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Tanggal Diperbarui</th>
                                            <th>Diperbarui Oleh</th>
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
            
            <!-- Modal Add/Edit Instruktur -->
            <div class="modal fade" id="instrukturModal" tabindex="-1" aria-labelledby="instrukturModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="instrukturModalLabel">Tambah Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="instrukturForm">
                                <input type="hidden" id="instruktur_id">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password">
                                    <small class="text-muted" id="passwordHint">Biarkan kosong jika tidak ingin mengubah password</small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="saveBtn" onclick="saveInstruktur()">Simpan</button>
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
    $('#instrukturTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "<?= site_url('instruktur/getInstrukturData') ?>",
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
            { data: "nama" },
            { data: "username" },
            { 
                data: "created_at",
                render: function(data) {
                    return data ? formatDateTime(data) : '-';
                }
            },
            { 
                data: "created_by_name",
                render: function(data) {
                    return data || '-';
                }
            },
            { 
                data: "updated_at",
                render: function(data) {
                    return data ? formatDateTime(data) : '-';
                }
            },
            { 
                data: "updated_by_name",
                render: function(data) {
                    return data || '-';
                }
            },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editInstruktur(${row.id})">
                                <i class="bx bx-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteInstruktur(${row.id})">
                                <i class="bx bx-trash"></i> Hapus
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

function formatDateTime(dateString) {
    // Periksa apakah dateString valid
    if (!dateString || dateString === '0000-00-00 00:00:00' || dateString === 'null') {
        return '-';
    }
    
    try {
        // Ambil tanggal dan waktu dari string MySQL (YYYY-MM-DD HH:MM:SS)
        const dateParts = dateString.split(' ')[0].split('-');
        const timeParts = dateString.split(' ')[1].split(':');
        
        // Format tanggal dalam bahasa Indonesia
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        // Ambil komponen tanggal
        const day = parseInt(dateParts[2]);
        const month = months[parseInt(dateParts[1]) - 1];
        const year = dateParts[0];
        
        // Ambil komponen waktu (jam dan menit)
        const hours = timeParts[0];
        const minutes = timeParts[1];
        
        // Format: DD Bulan YYYY pukul HH.MM
        return `${day} ${month} ${year} : ${hours}.${minutes}`;
    } catch (error) {
        console.error('Error formatting date:', error, dateString);
        return dateString || '-'; // Kembalikan string asli jika gagal memformat
    }
}

function addInstruktur() {
    // Reset form
    $('#instrukturForm')[0].reset();
    $('#instruktur_id').val('');
    $('#instrukturModalLabel').text('Tambah Instruktur');
    $('#passwordHint').hide(); // Hide password hint for new records
    $('#password').attr('required', true); // Password is required for new records
    
    // Show modal
    $('#instrukturModal').modal('show');
}

function editInstruktur(id) {
    // Get instruktur data by ID
    $.ajax({
        url: `<?= site_url('instruktur/getInstrukturById/') ?>${id}`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                const instruktur = response.data;
                
                // Fill form with data
                $('#instruktur_id').val(instruktur.id);
                $('#nama').val(instruktur.nama);
                $('#username').val(instruktur.username);
                $('#password').val(''); // Clear password field
                
                // Update modal title and show password hint
                $('#instrukturModalLabel').text('Edit Instruktur');
                $('#passwordHint').show();
                $('#password').attr('required', false); // Password is not required for updates
                
                // Show modal
                $('#instrukturModal').modal('show');
            } else {
                alert('Gagal mengambil data instruktur');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat mengambil data');
        }
    });
}

function saveInstruktur() {
    const id = $('#instruktur_id').val();
    const data = {
        nama: $('#nama').val(),
        username: $('#username').val(),
        password: $('#password').val()
    };
    
    // Validate form
    if (!data.nama || !data.username) {
        alert('Nama dan username harus diisi!');
        return;
    }
    
    // If it's a new record and password is empty
    if (!id && !data.password) {
        alert('Password harus diisi untuk instruktur baru!');
        return;
    }
    
    // Determine if it's an update or new record
    const url = id ? 
        `<?= site_url('instruktur/update/') ?>${id}` : 
        `<?= site_url('instruktur/save') ?>`;
    
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                $('#instrukturModal').modal('hide');
                $('#instrukturTable').DataTable().ajax.reload();
                alert(id ? 'Data instruktur berhasil diperbarui' : 'Instruktur baru berhasil ditambahkan');
            } else {
                alert(response.message || 'Gagal menyimpan data instruktur');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
}

function deleteInstruktur(id) {
    if (confirm('Apakah Anda yakin ingin menghapus instruktur ini?')) {
        $.ajax({
            url: `<?= site_url('instruktur/delete/') ?>${id}`,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#instrukturTable').DataTable().ajax.reload();
                    alert('Instruktur berhasil dihapus');
                } else {
                    alert(response.message || 'Gagal menghapus instruktur');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus data');
            }
        });
    }
}
</script> 