<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Verifikasi Nilai</h4>
                    
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
                            <h5 class="mb-0">Daftar Hasil Test</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="hasilTestTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Pelatihan</th>
                                            <th>Jenis Test</th>
                                            <th>Nilai</th>
                                            <th>Status</th>
                                            <th>Verifikasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($hasil_test as $h): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $h['nama_peserta'] ?></td>
                                            <td><?= $h['nama_pelatihan'] ?></td>
                                            <td>
                                                <?php if ($h['jenis'] == 'pretest'): ?>
                                                    <span class="badge bg-primary">Pre Test</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">Post Test</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $h['nilai_mentah'] ?></td>
                                            <td>
                                                <?php if ($h['waktu_selesai'] == null): ?>
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
                                                <?php if ($h['waktu_selesai'] != null && $h['status_verifikasi'] != 'terverifikasi'): ?>
                                                    <a href="<?= site_url('verifikasi/detail/' . $h['id']) ?>" class="btn btn-primary btn-sm">
                                                        Verifikasi
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= site_url('verifikasi/detail/' . $h['id']) ?>" class="btn btn-info btn-sm">
                                                        Detail
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
    // Inisialisasi DataTable
    document.addEventListener('DOMContentLoaded', function() {
        $('#hasilTestTable').DataTable();
    });
</script>

<?= $this->include('layout/footer') ?> 