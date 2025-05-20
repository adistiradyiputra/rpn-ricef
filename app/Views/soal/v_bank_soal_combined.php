<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Bank Soal</h4>
                    
                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Set Soal</h5>
                            <a href="<?= site_url('banksoal/create') ?>" class="btn btn-primary">
                                Tambah Soal
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="bankSoalTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Set</th>
                                            <th>Jenis Test</th>
                                            <th>Pelatihan</th>
                                            <th>Jumlah Soal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Hanya menampilkan set soal (pre test dan post test) -->
                                        <?php $no = 1; ?>
                                        <?php foreach ($set_soal as $s): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $s['nama_set'] ?></td>
                                            <td>
                                                <?php if ($s['jenis'] == 'pretest'): ?>
                                                    <span class="badge bg-primary">Pre Test</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">Post Test</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $s['nama_pelatihan'] ?? '-' ?></td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= isset($s['items']) ? count($s['items']) : 0 ?> Soal
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($s['aktif'] == 1): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('banksoal/edit_set/' . $s['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="bx bx-edit"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteSetSoal(<?= $s['id'] ?>)">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
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
</div>

<script>
    $(document).ready(function() {
        $('#bankSoalTable').DataTable();
    });
    
    function deleteSetSoal(id) {
        if (confirm('Apakah Anda yakin ingin menghapus set soal ini?')) {
            $.ajax({
                url: '<?= site_url('banksoal/delete_set/') ?>' + id,
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }
    }
</script>

<?= $this->include('layout/footer') ?> 