<?php setlocale(LC_TIME, 'id_ID.utf8', 'Indonesian_indonesia.1252'); ?>
<?=$this->include("layout/header") ?>
<!-- Layout wrapper -->
<style>
    textarea, select, input {
        field-sizing: content;
    }
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    .dropdown-toggle::after {
        display: none;
    }
    .dropdown-menu {
        right: 0;
        left: auto;
    }
    .modal-lg {
        max-width: 90%; /* Atur lebar maksimum modal menjadi 90% */
    }
    #detailTable {
        width: 100%; /* Pastikan tabel menggunakan lebar penuh dari modal */
        table-layout: auto; /* Biarkan tabel menyesuaikan lebar kolom berdasarkan konten */
    }
    #detailTable th, #detailTable td {
        white-space: normal; /* Biarkan teks membungkus */
        overflow: visible; /* Tampilkan overflow */
        text-overflow: clip; /* Jangan gunakan ellipsis */
        padding: 12px; /* Tambahkan padding untuk estetika */
    }
    #detailTable th {
        width: auto; /* Biarkan lebar kolom header menyesuaikan */
    }
    #detailTable td {
        width: auto; /* Biarkan lebar kolom data menyesuaikan */
    }
    .dataTables_filter input {
        width: 300px; /* Atur lebar input pencarian */
        padding: 8px; /* Tambahkan padding untuk estetika */
        margin-left: 10px; /* Tambahkan margin kiri untuk jarak */
        border: 1px solid #ced4da; /* Tambahkan border */
        border-radius: 4px; /* Tambahkan border-radius */
    }
    .search-box {
        position: relative;
    }

    .search-box input {
        padding-right: 30px;
        border-radius: 20px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        box-shadow: 0 0 5px rgba(0,123,255,0.3);
        border-color: #80bdff;
    }

    /* Tambahkan CSS baru */
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

    #detail_jumlah_peserta a {
        color: ##696cff;
        font-size: 1.0rem;
    }

    #detail_jumlah_peserta a:hover {
        color: #696cff;
        text-decoration: none;
    }

    .select2-container {
        z-index: 99999;
    }
    
    .select2-dropdown {
        z-index: 99999;
    }
    
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        min-height: 38px;
        background-color: #fff;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 2px 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #696cff;
        color: white;
        border: none;
        padding: 4px 8px;
        margin: 2px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 4px;
        padding: 0 4px;
        border-radius: 2px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: rgba(255,255,255,0.2);
        color: white;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #696cff;
        color: white;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgba(105, 108, 255, 0.1);
    }
    
    .select2-option {
        padding: 6px;
        display: block;
    }
    
    .select2-selection-text {
        color: #333;
        font-weight: 500;
    }
    
    .select2-container--default .select2-search--inline .select2-search__field {
        margin-top: 6px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__clear {
        margin-top: 6px;
    }
</style>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container"> 
        <?=$this->include("layout/sidebar") ?>
        <div class="layout-page">
            <?=$this->include("layout/navbar") ?>
            <div class="content-wrapper">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPelatihanModal">
                        Tambah Daftar Pelatihan
                    </button>
                        <div class="search-box">
                            <input type="text" id="searchPelatihan" class="form-control" placeholder="Cari pelatihan..." style="width: 300px;">
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="row" id="pelatihanList">
                            <?php foreach ($pelatihan_detail as $detail): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="<?= $detail['image_url'] ?? 'path/to/default/image.jpg' ?>" class="card-img-top mt-2 p-2" alt="<?= $detail['nama_pelatihan'] ?>">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title"> <?= $detail['nama_pelatihan'] ?> </h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-light p-3 fs-4" style="background-color: transparent; border: none;" data-bs-toggle="dropdown" aria-expanded="false">&#x22EE;</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="editPelatihan(<?= $detail['id'] ?>)">Update</a></li>
                                                        <li><a class="dropdown-item text-danger" href="#" onclick="deletePelatihan(<?= $detail['id'] ?>)">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p class="card-text"><strong>Pemateri:</strong> <?= $detail['nama_pemateri'] ?></p>
                                            <!-- <p class="card-text"><strong>Periode:</strong> <?= strftime('%d %B %Y', strtotime($detail['periode_mulai_daftar'])) ?> s/d <?= strftime('%d %B %Y', strtotime($detail['periode_selesai_daftar'])) ?></p> -->
                                            <p class="card-text"><strong>Jadwal:</strong> <?= strftime('%d %B %Y', strtotime($detail['jadwal_pelatihan'])) ?></p>
                                            <p class="card-text"><strong>Pusat Penelitian:</strong> <?= $detail['puslit'] ?></p>
                                            <a href="#" class="btn btn-primary mt-auto" onclick="showDetailPelatihan(<?= $detail['id'] ?>)">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Pelatihan -->
<div class="modal fade" id="editPelatihanModal" tabindex="-1" aria-labelledby="editPelatihanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editPelatihanForm" onsubmit="event.preventDefault(); updatePelatihan();">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPelatihanModalLabel">Edit Detail Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id_pelatihan">
                    <div class="mb-3">
                        <label for="edit_pemateri" class="form-label">Pemateri:</label>
                        <select class="form-control" id="edit_pemateri" name="pemateri_id[]" multiple required style="width:100%">
                            <option value="">Pilih Pemateri</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_periode_mulai_daftar" class="form-label">Periode Mulai Daftar:</label>
                        <input type="date" class="form-control" id="edit_periode_mulai_daftar" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_periode_selesai_daftar" class="form-label">Periode Selesai Daftar:</label>
                        <input type="date" class="form-control" id="edit_periode_selesai_daftar" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jadwal_pelatihan" class="form-label">Jadwal Pelatihan:</label>
                        <input type="date" class="form-control" id="edit_jadwal_pelatihan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Upload Gambar:</label>
                        <input type="file" class="form-control" id="edit_image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <!-- Modal Detail Pelatihan -->
            <div class="modal fade" id="detailPelatihanModal" tabindex="-1" aria-labelledby="detailPelatihanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailPelatihanModalLabel">Detail Pelatihan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table id="detailTable" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pusat Penelitian</th>
                                        <th>Nama Pelatihan</th>
                                        <th>Periode Pendaftaran</th>
                                        <th>Jadwal Pelatihan</th>
                                        <th>Pemateri/Instruktur</th>
                                        <th>Form Pre Test/Post Test</th>
                                        <th>Status</th>
                                        <th>Dokumen</th>
                                        <th>Jumlah Peserta Terdaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="detail_no"></td>
                                        <td id="detail_pusat_penelitian"></td>
                                        <td id="detail_nama_pelatihan"></td>
                                        <td id="detail_periode_pendaftaran"></td>
                                        <td id="detail_jadwal_pelatihan"></td>
                                        <td id="detail_pemateri"></td>
                                        <td id="detail_form_test"></td>
                                        <td id="detail_status"></td>
                                        <td id="detail_dokumen"></td>
                                        <td id="detail_jumlah_peserta"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Detail Peserta -->
            <div class="modal fade" id="pesertaModal" tabindex="-1" aria-labelledby="pesertaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pesertaModalLabel">Detail Peserta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="detail_pelatihan_id_peserta">
                            <button class="btn btn-primary mb-3" onclick="addNewPeserta()">Tambah Peserta</button>
                            <table id="pesertaTable" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Instansi</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Tambah Pelatihan -->
            <div class="modal fade" id="addPelatihanModal" tabindex="-1" aria-labelledby="addPelatihanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addPelatihanForm" onsubmit="event.preventDefault(); saveDetailPelatihan();">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPelatihanModalLabel">Tambah Detail Pelatihan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="add_id_pelatihan" class="form-label">Nama Pelatihan:</label>
                                    <select class="form-control" id="add_id_pelatihan" required>
                                        <option value="">Pilih Pelatihan</option>
                                        <?php foreach ($pelatihan as $p): ?>
                                            <option value="<?= $p['id'] ?>"><?= $p['nama_pelatihan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="add_puslit" class="form-label">Pusat Penelitian / Unit:</label>
                                    <input type="text" class="form-control" id="add_puslit" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="add_pemateri" class="form-label">Pemateri:</label>
                                    <select class="form-control" id="add_pemateri" name="pemateri_id[]" multiple="multiple">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="add_periode_mulai_daftar" class="form-label">Periode Mulai Daftar:</label>
                                    <input type="date" class="form-control" id="add_periode_mulai_daftar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_periode_selesai_daftar" class="form-label">Periode Selesai Daftar:</label>
                                    <input type="date" class="form-control" id="add_periode_selesai_daftar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_jadwal_pelatihan" class="form-label">Jadwal Pelatihan:</label>
                                    <input type="date" class="form-control" id="add_jadwal_pelatihan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="add_image" class="form-label">Upload Gambar:</label>
                                    <input type="file" class="form-control" id="add_image" accept="image/*">
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

            <!-- Modal Detail Dokumen -->
            <div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dokumenModalLabel">Detail Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="detail_pelatihan_id">
                            <button class="btn btn-primary mb-3" onclick="addNewRow()">Tambah Dokumen</button>
                            <table id="dokumenTable" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi melalui JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Dokumen -->
            <div class="modal fade" id="editDokumenModal" tabindex="-1" aria-labelledby="editDokumenModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDokumenModalLabel">Edit Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_dokumen_id">
                            <div class="mb-3">
                                <label for="edit_nama_dokumen" class="form-label">Nama Dokumen</label>
                                <input type="text" class="form-control" id="edit_nama_dokumen" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_lampiran" class="form-label">File Dokumen</label>
                                <input type="file" class="form-control" id="edit_lampiran">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="updateDokumen()">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
            <?=$this->include("layout/footer") ?>
        </div>
    </div>
</div>

<script>
// Add these variables at the top of your script
const userPuslit = '<?= session()->get('puslit') ?>';
const userLevel = '<?= session()->get('level') ?>';

function addDocument() {
    // Logic to add a document
    alert('Menambahkan dokumen baru');
}

function editPelatihan(id) {
    $.ajax({
        url: '<?= site_url('detailPelatihan/getDetail') ?>/' + id,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#edit_id_pelatihan').val(response.data.id);
                $('#edit_periode_mulai_daftar').val(response.data.periode_mulai_daftar);
                $('#edit_periode_selesai_daftar').val(response.data.periode_selesai_daftar);
                $('#edit_jadwal_pelatihan').val(response.data.jadwal_pelatihan);
                
                // Convert pemateri string to array and remove whitespace
                let pemateriArr = [];
                if (response.data.pemateri) {
                    pemateriArr = response.data.pemateri.split(',').map(id => id.trim());
                }
                
                // Load instruktur options and set selected values
                loadInstrukturOptions(pemateriArr, true);
                
                $('#editPelatihanModal').modal('show');
            } else {
                alert('Gagal mengambil data. Silakan coba lagi.');
            }
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan saat mengambil data: ' + error);
        }
    });
}

function deletePelatihan(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data ini akan dihapus secara permanen beserta semua peserta dan dokumen terkait!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            // First delete all related peserta records
            $.ajax({
                url: '<?= site_url('detailPelatihan/deleteAllPeserta/') ?>' + id,
                type: 'POST',
                success: function(pesertaResponse) {
                    if (pesertaResponse.success) {
                        // Then delete all related dokumen records
                        $.ajax({
                            url: '<?= site_url('detailPelatihan/deleteAllDokumen/') ?>' + id,
                            type: 'POST',
                            success: function(dokumenResponse) {
                                if (dokumenResponse.success) {
                                    // Finally delete the detail_pelatihan record
                                    $.ajax({
                                        url: '<?= site_url('detailPelatihan/delete/') ?>' + id,
                                        type: 'POST',
                                        success: function(response) {
                                            Swal.fire("Deleted!", "Data telah dihapus.", "success");
                                            window.location.reload();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(xhr.responseText);
                                            Swal.fire("Error!", "Terjadi kesalahan saat menghapus data pelatihan.", "error");
                                        }
                                    });
                                } else {
                                    console.error(dokumenResponse);
                                    Swal.fire("Error!", "Terjadi kesalahan saat menghapus dokumen terkait.", "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus dokumen terkait.", "error");
                            }
                        });
                    } else {
                        console.error(pesertaResponse);
                        Swal.fire("Error!", "Terjadi kesalahan saat menghapus peserta terkait.", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "Terjadi kesalahan saat menghapus peserta terkait.", "error");
                }
            });
        }
    });
}

function updatePelatihan() {
    const formData = new FormData();
    const id = $('#edit_id_pelatihan').val();
    const pemateriId = $('#edit_pemateri').val(); // ini akan return array
    const periode_mulai_daftar = $('#edit_periode_mulai_daftar').val();
    const periode_selesai_daftar = $('#edit_periode_selesai_daftar').val();
    const jadwal_pelatihan = $('#edit_jadwal_pelatihan').val();

    formData.append('id_pelatihan', id);
    
    // Append setiap pemateri ID sebagai array
    if (pemateriId && pemateriId.length > 0) {
        pemateriId.forEach(function(id) {
            formData.append('pemateri_id[]', id);
        });
    }
    
    formData.append('periode_mulai_daftar', periode_mulai_daftar);
    formData.append('periode_selesai_daftar', periode_selesai_daftar);
    formData.append('jadwal_pelatihan', jadwal_pelatihan);

    const imageFile = $('#edit_image')[0].files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    $.ajax({
        url: '<?= site_url('detailPelatihan/update') ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert('Detail pelatihan berhasil diperbarui!');
                $('#editPelatihanModal').modal('hide');
                window.location.reload();
            } else {
                alert('Gagal memperbarui data. Silakan coba lagi.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            alert('Terjadi kesalahan saat memperbarui data: ' + error);
        }
    });
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

function showDetailPelatihan(id) {
    $.ajax({
        url: '<?= site_url('detailPelatihan/getDetail') ?>/' + id,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                console.log('Response data:', response.data);
                console.log('Pemateri data:', response.data.pemateri);
                let no = 1;
                $('#detail_no').text(no);
                $('#detail_pusat_penelitian').text(response.data.puslit);
                $('#detail_nama_pelatihan').text(response.data.nama_pelatihan);
                $('#detail_periode_pendaftaran').html(
                    formatDate(response.data.periode_mulai_daftar) +
                    ' s/d ' +
                    formatDate(response.data.periode_selesai_daftar)
                );
                $('#detail_jadwal_pelatihan').html(formatDate(response.data.jadwal_pelatihan));
                
                // Ambil nama semua pemateri jika lebih dari satu
                let pemateriArr = [];
                if (response.data.pemateri) {
                    pemateriArr = response.data.pemateri.split(' - ');
                }
                if (pemateriArr.length > 0) {
                    $.ajax({
                        url: '<?= site_url('instruktur/getInstrukturOptions') ?>',
                        type: 'GET',
                        success: function(instrukturResponse) {
                            if (instrukturResponse.success) {
                                let namaList = [];
                                instrukturResponse.data.forEach(function(ins) {
                                    if (pemateriArr.includes(ins.id.toString())) {
                                        namaList.push(ins.nama);
                                    }
                                });
                                $('#detail_pemateri').text(namaList.join(' - '));
                            }
                        }
                    });
                } else {
                    $('#detail_pemateri').text('-');
                }
                $('#detail_form_test').html('<a href="#">Lihat Form</a>');
                const statusBadge = response.data.status == 1
                    ? '<span class="badge bg-success">Buka</span>'
                    : '<span class="badge bg-danger">Tutup</span>';
                $('#detail_status').html(statusBadge);
                $('#detail_dokumen').html('<a href="#" onclick="showDokumen(' + id + ')">Lihat Dokumen</a>');
                $.ajax({
                    url: '<?= site_url('detailPelatihan/getPesertaCount/') ?>' + id,
                    type: 'GET',
                    success: function(countResponse) {
                        if (countResponse.success) {
                            $('#detail_jumlah_peserta').html(
                                `<a href="#" onclick="showPesertaDetail(${id})" style="text-decoration: none;">
                                    ${countResponse.count} Peserta
                                </a>`
                            );
                        }
                    },
                    error: function() {
                        $('#detail_jumlah_peserta').html(
                            `<a href="#" onclick="showPesertaDetail(${id})" style="text-decoration: none;">
                                0
                            </a>`
                        );
                    }
                });
                $('#detailPelatihanModal').modal('show');
            } else {
                alert('Gagal mengambil data. Silakan coba lagi.');
            }
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan saat mengambil data: ' + error);
        }
    });
}

function showPesertaDetail(id) {
    $('#detail_pelatihan_id_peserta').val(id);
    $('#pesertaModal').modal('show');
    loadPesertaTable(id);
}

function showDokumen(detail_pelatihan_id) {
    $('#detail_pelatihan_id').val(detail_pelatihan_id);
    $('#dokumenModal').modal('show');
    loadDokumenTable(detail_pelatihan_id);
}

function loadDokumenTable(detail_pelatihan_id) {
    if ($.fn.DataTable.isDataTable('#dokumenTable')) {
        $('#dokumenTable').DataTable().destroy();
    }

    $('#dokumenTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "<?= site_url('detailPelatihan/getDokumen/') ?>" + detail_pelatihan_id,
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { 
                "data": null,
                "width": "5%",
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { 
                "data": "nama_dokumen",
                "width": "40%"
            },
            { 
                "data": "lampiran",
                "width": "25%",
                "render": function(data) {
                    return data ? '<a href="' + data + '" target="_blank" class="btn btn-info btn-sm">Lihat File</a>' : '-';
                }
            },
            {
                "data": null,
                "width": "30%",
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editDokumen(${row.id}, '${row.nama_dokumen}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteDokumen(${row.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    `;
                }
            }
        ],
        "pageLength": 5,
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
        "ordering": true,
        "order": [[0, "asc"]],
        "responsive": true,
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        "scrollX": false,
        "autoWidth": false
    });
}

function editDokumen(id, nama_dokumen) {
    const table = $('#dokumenTable').DataTable();
    const row = table.row($(`button[onclick="editDokumen(${id}, '${nama_dokumen}')"]`).closest('tr'));
    
    row.nodes().to$().find('td').each(function(index) {
        switch(index) {
            case 1: // Nama Dokumen
                $(this).html(`<input type="text" class="form-control" value="${nama_dokumen}">`);
                break;
            case 2: // File
                $(this).html(`
                    <input type="file" class="form-control" id="lampiran_${id}">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah file</small>
                `);
                break;
            case 3: // Aksi
                $(this).html(`
                    <div class="btn-group" role="group">
                        <button class="btn btn-success btn-sm" onclick="updateDokumen(${id})">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="cancelEditDokumen(${id}, '${nama_dokumen}')">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                `);
                break;
        }
    });
}

function updateDokumen(id) {
    const row = $(`button[onclick^="updateDokumen(${id})"]`).closest('tr');
    const nama_dokumen = row.find('td:eq(1) input').val();
    const lampiran = $(`#lampiran_${id}`)[0].files[0];

    if (!nama_dokumen) {
        alert('Nama dokumen harus diisi!');
        return;
    }

    const formData = new FormData();
    formData.append('nama_dokumen', nama_dokumen);
    if (lampiran) {
        formData.append('lampiran', lampiran);
    }

    $.ajax({
        url: '<?= site_url('detailPelatihan/updateDokumen/') ?>' + id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#dokumenTable').DataTable().ajax.reload();
                alert('Dokumen berhasil diperbarui');
            } else {
                alert(response.message || 'Gagal memperbarui dokumen');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Terjadi kesalahan saat memperbarui dokumen');
        }
    });
}

function cancelEditDokumen(id, nama_dokumen) {
    $('#dokumenTable').DataTable().ajax.reload();
}

function deleteDokumen(id) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        $.ajax({
            url: '<?= site_url('detailPelatihan/deleteDokumen/') ?>' + id,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#dokumenTable').DataTable().ajax.reload();
                    alert('Dokumen berhasil dihapus!');
                } else {
                    alert('Gagal menghapus dokumen. Silakan coba lagi.');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan saat menghapus dokumen: ' + error);
            }
        });
    }
}

function loadPesertaTable(detail_pelatihan_id) {
    if ($.fn.DataTable.isDataTable('#pesertaTable')) {
        $('#pesertaTable').DataTable().destroy();
    }

    $('#pesertaTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "<?= site_url('detailPelatihan/getPeserta/') ?>" + detail_pelatihan_id,
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { 
                "data": null,
                "width": "5%",
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "username", "width": "15%" },
            { "data": null, "width": "10%", "render": function() { return '********'; }},
            { "data": "nama", "width": "15%" },
            { "data": "alamat", "width": "20%" },
            { "data": "instansi", "width": "15%" },
            { "data": "telp", "width": "10%" },
            {
                "data": null,
                "width": "10%",
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editPeserta(${row.id}, '${row.username}', '${row.nama}', '${row.alamat}', '${row.instansi}', '${row.telp}')">
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
        "pageLength": 5,
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
        "ordering": true,
        "order": [[0, "asc"]],
        "responsive": true,
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        "scrollX": false,
        "autoWidth": false
    });
}

function editPeserta(id, username, nama, alamat, instansi, telp) {
    const table = $('#pesertaTable').DataTable();
    const row = table.row($(`button[onclick="editPeserta(${id}, '${username}', '${nama}', '${alamat}', '${instansi}', '${telp}')"]`).closest('tr'));
    const rowData = row.data();
    
    row.nodes().to$().find('td').each(function(index) {
        switch(index) {
            case 1: // Username
                $(this).html(`<input type="text" class="form-control" value="${username}">`);
                break;
            case 2: // Password
                $(this).html(`<input type="password" class="form-control" placeholder="Kosongkan jika tidak diubah">`);
                break;
            case 3: // Nama
                $(this).html(`<input type="text" class="form-control" value="${nama}">`);
                break;
            case 4: // Alamat
                $(this).html(`<input type="text" class="form-control" value="${alamat}">`);
                break;
            case 5: // Instansi
                $(this).html(`<input type="text" class="form-control" value="${instansi}">`);
                break;
            case 6: // Telepon
                $(this).html(`<input type="text" class="form-control" value="${telp}">`);
                break;
            case 7: // Aksi
                $(this).html(`
                    <div class="btn-group" role="group">
                        <button class="btn btn-success btn-sm" onclick="updatePeserta(${id})">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="cancelEdit(${id}, '${username}', '${nama}', '${alamat}', '${instansi}', '${telp}')">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                `);
                break;
        }
    });
}

function updatePeserta(id) {
    const row = $(`button[onclick^="updatePeserta(${id})"]`).closest('tr');
    const data = {
        username: row.find('td:eq(1) input').val(),
        password: row.find('td:eq(2) input').val(),
        nama: row.find('td:eq(3) input').val(),
        alamat: row.find('td:eq(4) input').val(),
        instansi: row.find('td:eq(5) input').val(),
        telp: row.find('td:eq(6) input').val()
    };

    $.ajax({
        url: '<?= site_url('detailPelatihan/updatePeserta/') ?>' + id,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                $('#pesertaTable').DataTable().ajax.reload();
                alert('Data peserta berhasil diperbarui');
            } else {
                alert(response.message || 'Gagal memperbarui data peserta');
            }
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan saat memperbarui data');
        }
    });
}

function cancelEdit(id, username, nama, alamat, instansi, telp) {
    const table = $('#pesertaTable').DataTable();
    table.ajax.reload();
}

function deletePeserta(id) {
    if (confirm('Apakah Anda yakin ingin menghapus peserta ini?')) {
        $.ajax({
            url: '<?= site_url('detailPelatihan/deletePeserta/') ?>' + id,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('#pesertaTable').DataTable().ajax.reload();
                    alert('Peserta berhasil dihapus');
                } else {
                    alert('Gagal menghapus peserta');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat menghapus data');
            }
        });
    }
}

function addNewPeserta() {
    const detail_pelatihan_id = $('#detail_pelatihan_id_peserta').val();
    const newRow = `
        <tr id="new-peserta-row">
            <td>#</td>
            <td><input type="text" class="form-control" id="username"></td>
            <td><input type="password" class="form-control" id="password"></td>
            <td><input type="text" class="form-control" id="nama"></td>
            <td><input type="text" class="form-control" id="alamat"></td>
            <td><input type="text" class="form-control" id="instansi"></td>
            <td><input type="text" class="form-control" id="telp"></td>
            <td>
                <button class="btn btn-success btn-sm" onclick="savePeserta()">Simpan</button>
                <button class="btn btn-danger btn-sm" onclick="cancelAddPeserta()">Batal</button>
            </td>
        </tr>
    `;
    
    $('#pesertaTable tbody').prepend(newRow);
}

function savePeserta() {
    const detail_pelatihan_id = $('#detail_pelatihan_id_peserta').val();
    const data = {
        id_detail_pelatihan: detail_pelatihan_id,
        username: $('#username').val(),
        password: $('#password').val(),
        nama: $('#nama').val(),
        alamat: $('#alamat').val(),
        instansi: $('#instansi').val(),
        telp: $('#telp').val()
    };

    $.ajax({
        url: '<?= site_url('detailPelatihan/savePeserta') ?>',
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                $('#new-peserta-row').remove();
                $('#pesertaTable').DataTable().ajax.reload();
                alert('Peserta berhasil ditambahkan!');
            } else {
                alert(response.message || 'Gagal menambahkan peserta');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Terjadi kesalahan saat menyimpan data peserta');
        }
    });
}

function cancelAddPeserta() {
    $('#new-peserta-row').remove();
}

function saveDetailPelatihan() {
    const formData = new FormData();
    const id_pelatihan = $('#add_id_pelatihan').val();
    const puslit = $('#add_puslit').val();
    const pemateriId = $('#add_pemateri').val();
    const periode_mulai_daftar = $('#add_periode_mulai_daftar').val();
    const periode_selesai_daftar = $('#add_periode_selesai_daftar').val();
    const jadwal_pelatihan = $('#add_jadwal_pelatihan').val();

    console.log('Saving pemateri:', pemateriId); // Debug log
    
    formData.append('id_pelatihan', id_pelatihan);
    formData.append('puslit', puslit);
    
    // Append setiap pemateri ID sebagai array
    if (pemateriId && pemateriId.length > 0) {
        pemateriId.forEach(function(id) {
            formData.append('pemateri_id[]', id);
        });
    }
    
    // Debug: Log formData contents
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    formData.append('periode_mulai_daftar', periode_mulai_daftar);
    formData.append('periode_selesai_daftar', periode_selesai_daftar);
    formData.append('jadwal_pelatihan', jadwal_pelatihan);

    const imageFile = $('#add_image')[0].files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    console.log('Selected Pemateri:', pemateriId);

    $.ajax({
        url: '<?= site_url('detailPelatihan/saveDetailPelatihan') ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert('Detail pelatihan berhasil ditambahkan!');
                $('#addPelatihanModal').modal('hide');
                window.location.reload();
            } else {
                alert('Gagal menambahkan detail pelatihan. Silakan coba lagi.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            alert('Terjadi kesalahan saat menyimpan data: ' + error);
        }
    });
}

// Add this function to your existing script
function addNewRow() {
    const detail_pelatihan_id = $('#detail_pelatihan_id').val();
    
    // Create a new row with form inputs
    const newRow = `
        <tr id="new-dokumen-row">
            <td>#</td>
            <td><input type="text" class="form-control" id="new_nama_dokumen" placeholder="Nama Dokumen" required></td>
            <td><input type="file" class="form-control" id="new_lampiran"></td>
            <td>
                <div class="btn-group" role="group">
                    <button class="btn btn-success btn-sm" onclick="saveDokumen()">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="cancelAddDokumen()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </td>
        </tr>
    `;
    
    // Add the new row to the top of the table
    $('#dokumenTable tbody').prepend(newRow);
}

// Add this function to handle saving a new document
function saveDokumen() {
    const detail_pelatihan_id = $('#detail_pelatihan_id').val();
    const nama_dokumen = $('#new_nama_dokumen').val();
    const lampiran = $('#new_lampiran')[0].files[0];
    
    if (!nama_dokumen) {
        alert('Nama dokumen harus diisi!');
        return;
    }
    
    const formData = new FormData();
    formData.append('id_detail_pelatihan', detail_pelatihan_id);
    formData.append('nama_dokumen', nama_dokumen);
    
    if (lampiran) {
        formData.append('lampiran', lampiran);
    }
    
    $.ajax({
        url: '<?= site_url('detailPelatihan/saveDokumen') ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Remove the form row
                $('#new-dokumen-row').remove();
                // Reload the table
                $('#dokumenTable').DataTable().ajax.reload();
                alert('Dokumen berhasil ditambahkan!');
            } else {
                alert(response.message || 'Gagal menambahkan dokumen');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Terjadi kesalahan saat menyimpan dokumen: ' + error);
        }
    });
}

// Add this function to cancel adding a new document
function cancelAddDokumen() {
    $('#new-dokumen-row').remove();
}

$(document).ready(function() {
    // Load pemateri options saat modal dibuka
    $('#addPelatihanModal').on('shown.bs.modal', function() {
        console.log('Modal opened, loading options...');
        loadInstrukturOptions([], false);
    });
    
    $('#editPelatihanModal').on('shown.bs.modal', function() {
        const id = $('#edit_id_pelatihan').val();
        if (id) {
            $.ajax({
                url: '<?= site_url('detailPelatihan/getDetail/') ?>' + id,
                type: 'GET',
                success: function(response) {
                    if (response.success && response.data.pemateri) {
                        const selected = response.data.pemateri.split(',').map(id => id.trim());
                        loadInstrukturOptions(selected, true);
                    }
                }
            });
        }
    });
    
    // Reset saat modal ditutup
    $('#addPelatihanModal').on('hidden.bs.modal', function() {
        const targetSelect = $('#add_pemateri');
        if (targetSelect.hasClass('select2-hidden-accessible')) {
            targetSelect.select2('destroy');
        }
        targetSelect.empty();
    });
    
    $('#detailTable').DataTable();
    $('#pesertaTable').DataTable({
        "searching": true,
        "autoWidth": false,
        "columnDefs": [
            { "width": "20%", "targets": 0 },
            { "width": "30%", "targets": 1 },
            { "width": "20%", "targets": 2 },
            { "width": "20%", "targets": 3 },
            { "width": "10%", "targets": 4 },
            { "width": "10%", "targets": 5 },
            { "width": "10%", "targets": 6 },
            { "width": "10%", "targets": 7 }
        ]
    });
    $('#dokumenTable').DataTable();

    // Add search functionality
    $('#searchPelatihan').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        
        $('.card').each(function() {
            const namaPelatihan = $(this).find('.card-title').text().toLowerCase();
            const pemateri = $(this).find('.card-text').text().toLowerCase();
            const jadwal = $(this).find('.card-text:last').text().toLowerCase();
            
            if (namaPelatihan.includes(searchText) || 
                pemateri.includes(searchText) || 
                jadwal.includes(searchText)) {
                $(this).closest('.col-md-4').show();
            } else {
                $(this).closest('.col-md-4').hide();
            }
        });
    });

    // Filter pelatihan options in the dropdown based on user's puslit
    if (userLevel != '1' && userPuslit) {
        $('#add_id_pelatihan option').each(function() {
            const pelatihanId = $(this).val();
            if (pelatihanId) {
                // Instead of making an AJAX call for each option, we can rely on the server-side filtering
                // The controller already filtered the options based on puslit
                // This will improve performance significantly
            }
        });
    }
    
    // When opening the add modal, set the puslit field based on user's session
    $('[data-bs-target="#addPelatihanModal"]').on('click', function() {
        if (userLevel != '1' && userPuslit) {
            $('#add_puslit').val(userPuslit);
        } else {
            $('#add_puslit').val('');
        }
    });

    // Tambahkan event listener untuk select pelatihan pada form tambah
    $('#add_id_pelatihan').on('change', function() {
        const pelatihanId = $(this).val();
        if (pelatihanId) {
            // Ambil data puslit berdasarkan ID pelatihan
            $.ajax({
                url: '<?= site_url('pelatihan/getPelatihanById/') ?>' + pelatihanId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Isi field puslit secara otomatis
                        $('#add_puslit').val(response.data.puslit);
                    }
                },
                error: function() {
                    console.error('Gagal mengambil data pelatihan');
                }
            });
        } else {
            // Reset field puslit jika tidak ada pelatihan yang dipilih
            $('#add_puslit').val('');
        }
    });
});

function loadInstrukturOptions(selected = [], isEdit = false) {
    console.log('Loading instruktur options...');
    
    $.ajax({
        url: '<?= site_url('instruktur/getInstrukturOptions') ?>',
        type: 'GET',
        success: function(response) {
            console.log('Response from server:', response);
            
            if (response.success) {
                const instrukturOptions = response.data;
                const targetSelect = isEdit ? '#edit_pemateri' : '#add_pemateri';
                
                // Destroy existing Select2 if it exists
                if ($(targetSelect).hasClass('select2-hidden-accessible')) {
                    $(targetSelect).select2('destroy');
                }
                
                // Reset select
                $(targetSelect).empty();
                
                // Add placeholder option
                $(targetSelect).append(new Option('Pilih Pemateri', '', true, false));
                
                // Add options
                instrukturOptions.forEach(function(instruktur) {
                    const isSelected = selected.includes(instruktur.id.toString());
                    const option = new Option(instruktur.nama, instruktur.id, isSelected, isSelected);
                    $(targetSelect).append(option);
                });
                
                // Initialize Select2
                $(targetSelect).select2({
                    dropdownParent: $(targetSelect).closest('.modal'),
                    placeholder: "Pilih Pemateri",
                    allowClear: true,
                    width: '100%',
                    multiple: true,
                    closeOnSelect: false,
                    tags: false,
                    language: {
                        noResults: function() {
                            return "Tidak ada data pemateri";
                        }
                    },
                    templateResult: formatPemateri,
                    templateSelection: formatPemateriSelection
                }).on('select2:select select2:unselect', function(e) {
                    const selectedValues = $(this).val();
                    console.log('Current selected values:', selectedValues);
                    
                    // Update tampilan pemateri yang dipilih
                    updateSelectedPemateri(selectedValues, instrukturOptions);
                });
                
                // Set selected values if any
                if (selected && selected.length > 0) {
                    $(targetSelect).val(selected).trigger('change');
                    // Update tampilan awal jika ada nilai yang sudah dipilih
                    updateSelectedPemateri(selected, instrukturOptions);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading instruktur:', error);
            console.error('Response:', xhr.responseText);
        }
    });
}

// Fungsi untuk memperbarui tampilan pemateri yang dipilih
function updateSelectedPemateri(selectedValues, instrukturOptions) {
    if (!selectedValues || selectedValues.length === 0) {
        return;
    }
    
    const selectedNames = selectedValues.map(id => {
        const instruktur = instrukturOptions.find(opt => opt.id.toString() === id.toString());
        return instruktur ? instruktur.nama : '';
    }).filter(name => name !== '');
    
    // Update tampilan di select2
    const $select = $('#add_pemateri, #edit_pemateri');
    $select.find('option:selected').each(function(index) {
        const id = $(this).val();
        const instruktur = instrukturOptions.find(opt => opt.id.toString() === id.toString());
        if (instruktur) {
            $(this).text(instruktur.nama);
        }
    });
}

// Fungsi untuk format tampilan option di dropdown
function formatPemateri(pemateri) {
    if (!pemateri.id) {
        return $('<span class="text-muted">' + pemateri.text + '</span>');
    }
    return $('<span class="select2-option">' + pemateri.text + '</span>');
}

// Fungsi untuk format tampilan pemateri yang terpilih
function formatPemateriSelection(pemateri) {
    if (!pemateri.id) {
        return $('<span class="text-muted">' + pemateri.text + '</span>');
    }
    return $('<span class="select2-selection-text">' + pemateri.text + '</span>');
}
</script>
