<?= $this->include('layout/header') ?>
<!-- Tambahkan jQuery jika belum ada di header -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan DataTables jika diperlukan -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Test</h4>
                    
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
                        <div class="card-header">
                            <h5 class="mb-0">Daftar Test</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="testTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pelatihan</th>
                                            <th>Jenis Test</th>
                                            <th>Status</th>
                                            <th>Verifikasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($hasil_test as $h): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $h['nama_pelatihan'] ?></td>
                                            <td>
                                                <?php if ($h['jenis'] == 'pretest'): ?>
                                                    <span class="badge bg-primary">Pre Test</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">Post Test</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($h['waktu_selesai'] == null): ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php elseif ($h['status_verifikasi'] != 'terverifikasi'): ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php elseif ($h['status_lulus'] == 1): ?>
                                                    <span class="badge bg-success">Lulus</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Tidak Lulus</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($h['waktu_selesai'] == null): ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php elseif ($h['status_verifikasi'] == 'belum'): ?>
                                                    <span class="badge bg-warning">Belum Diverifikasi</span>
                                                <?php elseif ($h['status_verifikasi'] == 'proses'): ?>
                                                    <span class="badge bg-info">Proses Verifikasi</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($h['waktu_selesai'] != null): ?>
                                                    <button class="btn btn-primary btn-sm" disabled>Selesai</button>
                                                <?php elseif (isset($h['set_aktif']) && $h['set_aktif'] == 0): ?>
                                                    <button class="btn btn-danger btn-sm" disabled>Test Belum Aktif</button>
                                                <?php else: ?>
                                                    <a href="<?= site_url('test/mulai/' . $h['id_set_soal']) ?>" class="btn btn-primary btn-sm">
                                                        Kerjakan
                                                    </a>
                                                <?php endif; ?>
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
    // Pastikan jQuery sudah dimuat sebelum menggunakan
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah jQuery tersedia
        if (typeof jQuery !== 'undefined') {
            // Inisialisasi DataTable
            $('#testTable').DataTable();
        } else {
            console.error('jQuery tidak tersedia. DataTable tidak dapat diinisialisasi.');
        }
    });
</script>

<?= $this->include('layout/footer') ?> 