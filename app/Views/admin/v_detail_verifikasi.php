<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">
                        <span class="text-muted fw-light">Verifikasi Nilai /</span> Detail Hasil Test
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Informasi Test</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Nama Peserta</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= $hasil['nama_peserta'] ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Pelatihan</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= $hasil['nama_pelatihan'] ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Jenis Test</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if ($hasil['jenis'] == 'pretest'): ?>
                                                    <span class="badge bg-primary">Pre Test</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">Post Test</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Waktu Mulai</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= date('d-m-Y H:i:s', strtotime($hasil['waktu_mulai'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Waktu Selesai</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= date('d-m-Y H:i:s', strtotime($hasil['waktu_selesai'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Nilai</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= $hasil['nilai_mentah'] ?></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-4 col-form-label">Status Verifikasi</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if ($hasil['status_verifikasi'] == 'belum'): ?>
                                                    <span class="badge bg-warning">Belum Diverifikasi</span>
                                                <?php elseif ($hasil['status_verifikasi'] == 'proses'): ?>
                                                    <span class="badge bg-info">Proses Verifikasi</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Form Verifikasi</h5>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('verifikasi/verifikasi/' . $hasil['id']) ?>" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Status Kelulusan</label>
                                            <select class="form-select" name="status_lulus" required>
                                                <option value="1" <?= $hasil['status_lulus'] == 1 ? 'selected' : '' ?>>Lulus</option>
                                                <option value="0" <?= $hasil['status_lulus'] == 0 ? 'selected' : '' ?>>Tidak Lulus</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan</label>
                                            <textarea class="form-control" name="catatan" rows="3"><?= $hasil['catatan'] ?></textarea>
                                        </div>
                                        <div class="mt-4">
                                            <a href="<?= site_url('verifikasi') ?>" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Verifikasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Jawaban Peserta</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('verifikasi/verifikasi/' . $hasil['id']) ?>" method="post">
                                <?php $no = 1; foreach ($jawaban as $j): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Soal <?= $no++ ?></h5>
                                        <div class="mb-3">
                                            <p><?= $j['soal']['pertanyaan'] ?></p>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <p><strong>Jawaban Peserta:</strong> <?= $j['pilihan']['teks_pilihan'] ?? 'Tidak menjawab' ?></p>
                                            <p>
                                                <strong>Status:</strong> 
                                                <?php if ($j['is_benar'] == 1): ?>
                                                    <span class="badge bg-success">Benar</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Salah</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>