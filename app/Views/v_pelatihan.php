<?=$this->include("layout/header") ?>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container"> 
            <?=$this->include("layout/sidebar") ?>
            <!-- Layout container -->
            <div class="layout-page">
                <?=$this->include("layout/navbar") ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="pt-4 ps-4">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#divisiModal" onclick="resetForm()">
                            <i class="bx bx-plus me-1"></i> Tambah Pelatihan
                        </button>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <div class="table-responsive text-nowrap p-3">
                                    <table id="divisiTable" class="display table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pusat Penelitian / Unit</th>
                                                <th>Nama Pelatihan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Form -->
                    <div class="modal fade" id="divisiModal" tabindex="-1" aria-labelledby="divisiModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="divisiForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="divisiModalLabel">Form Pelatihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="pelatihanId">
                                        
                                        <div class="mb-3">
                                            <label for="puslit" class="form-label">Pusat Penelitian / Unit</label>
                                            <select class="form-control" id="puslit" required>
                                                <option value="" disabled selected>- Pilih Puslit -</option>
                                                <option value="KANDIR">KANDIR</option>
                                                <option value="PPKS">PPKS</option>
                                                <option value="PPK">PPK</option>
                                                <option value="PPKKI">PPKKI</option>
                                                <option value="P3GI">P3GI</option>
                                                <option value="PPTK">PPTK</option>
                                            </select>
                                        </div>
                                        <label class="form-label">Nama Pelatihan:</label>
                                        <div id="pelatihan-container">
                                            <div class="mb-3 pelatihan-group">
                                                <input type="text" class="form-control" name="nama_pelatihan" id="nama_pelatihan" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Content -->
                <!-- Footer -->
                <?=$this->include("layout/footer") ?>
            </div>
        </div>
    </div>

<script>
// Define variables in global scope
var userLevel = <?= json_encode(session()->get('level')) ?>; // Ambil level dari session
var userPuslit = <?= json_encode(session()->get('puslit')) ?>; // Ambil puslit dari session

$(document).ready(function() {
    var table = $('#divisiTable').DataTable({
        ajax: '<?= site_url('pelatihan/getPelatihan') ?>',
        columns: [
            { data: 'id', render: function(data, type, row, meta) { return meta.row + 1; } }, // Nomor urut
            { data: 'puslit' },
            { data: 'nama_pelatihan' },
            { 
                data: null, 
                render: function(data, type, row) {
                    return `<button class="btn btn-warning btn-sm" onclick="editDivisi(${row.id})"><i class="bx bx-edit"></i> Edit</button> 
                            <button class="btn btn-danger btn-sm" onclick="deleteDivisi(${row.id})"><i class="bx bx-trash"></i> Hapus</button>`;
                }
            }
        ]
    });

    $('#addPelatihan').click(function() {
        $('#pelatihan-container').append(`
            <div class="mb-3 pelatihan-group d-flex align-items-center">
                <input type="text" class="form-control flex-grow-1 me-2" name="nama_pelatihan[]" id="nama_pelatihan" required>
                <button type="button" class="btn btn-danger btn-sm remove-pelatihan"> Hapus</button>
            </div>
        `);
    });

    // Event untuk menghapus input pelatihan
    if (userLevel != 2) {
        $('#puslit').prop('disabled', false); // Aktifkan select jika level bukan 2
    } else {
        $('#puslit').prop('disabled', true); // Nonaktifkan select jika level 2
    }
    
    $(document).on('click', '.remove-pelatihan', function() {
        $(this).closest('.pelatihan-group').remove();
        
        // Jika hanya tersisa satu input, hapus tombol "Hapus" yang tersisa
        if ($('#pelatihan-container .pelatihan-group').length === 1) {
            $('#pelatihan-container .pelatihan-group .remove-pelatihan').remove();
        }
    });


    $('#divisiForm').submit(function(e) {
        e.preventDefault();
        let id = $('#pelatihanId').val();
        let url = id ? '<?= site_url('pelatihan/updatePelatihan/') ?>' + id : '<?= site_url('pelatihan/savePelatihan') ?>';
        
        $.post(url, {
            puslit:         $('#puslit').val(),
            nama_pelatihan: $('input[name="nama_pelatihan[]"]').map(function(){ return $(this).val(); }).get()
        }, function(response) {
            $('#divisiModal').modal('hide'); // Tutup modal
            table.ajax.reload(); // Reload data di tabel
            showToast(id ? "Data berhasil diperbarui!" : "Data berhasil ditambahkan!");
        });
    });
});

function editDivisi(id) {
    $.get('<?= site_url('pelatihan/getPelatihan') ?>', function(response) {
        let divisi = response.data.find(d => d.id == id);
        $('#pelatihanId').val(divisi.id);
        $('#puslit').val(divisi.puslit);
        
        // Kosongkan container pelatihan dan tambahkan input baru
        $('#pelatihan-container').empty();
        divisi.nama_pelatihan.split(',').forEach(function(nama) {
            $('#pelatihan-container').append(`
                <div class="mb-3 pelatihan-group d-flex align-items-center">
                    <input type="text" class="form-control flex-grow-1 me-2" name="nama_pelatihan[]" value="${nama.trim()}" required>
                </div>
            `);
        });

        $('#divisiModal').modal('show');
    });
}

function deleteDivisi(id) {
    if (confirm("Hapus pelatihan ini?")) {
        $.get('<?= site_url('pelatihan/deletePelatihan/') ?>' + id, function() {
            $('#divisiTable').DataTable().ajax.reload();
            showToast("Data berhasil dihapus!", "error");
        });
    }
}

// Fungsi untuk mereset form input
function resetForm() {
    $('#pelatihanId').val('');
    
    // Set puslit value based on user session
    if (userPuslit && userPuslit !== 'superadmin') {
        $('#puslit').val(userPuslit);
    } else {
        $('#puslit').val('');
    }
    
    $('#nama_pelatihan').val('');
    $('#pelatihan-container').html(`
        <div class="mb-3 pelatihan-group d-flex align-items-center">
            <input type="text" class="form-control flex-grow-1 me-2" name="nama_pelatihan[]" required>
        </div>
    `);
}

// Fungsi untuk menampilkan toast notification
function showToast(message, type = "success") {
    let bgColor = type === "error" ? "linear-gradient(to right, #ff416c, #ff4b2b)" : "linear-gradient(to right, #00b09b, #96c93d)";
    
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: bgColor,
        stopOnFocus: true
    }).showToast();
}
</script>
