<?= $this->include('layout/header') ?>
<!-- Tambahkan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">
                        <span class="text-muted fw-light">Test /</span> 
                        <?= $set_soal['jenis'] == 'pretest' ? 'Pre Test' : 'Post Test' ?> - <?= $set_soal['nama_set'] ?>
                    </h4>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Informasi Test</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Pelatihan:</strong> <?= $set_soal['nama_pelatihan'] ?></p>
                                    <p><strong>Jenis Test:</strong> <?= $set_soal['jenis'] == 'pretest' ? 'Pre Test' : 'Post Test' ?></p>
                                    <p><strong>Jumlah Soal:</strong> <?= count($soal) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Soal</h5>
                        </div>
                        <div class="card-body">
                            <form id="testForm" action="<?= site_url('test/selesai') ?>" method="post">
                                <input type="hidden" name="id_set_soal" value="<?= $set_soal['id'] ?>">
                                
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="btn-group" role="group">
                                            <?php foreach ($soal as $key => $s): ?>
                                            <button type="button" class="btn btn-outline-primary soal-nav" data-soal="<?= $key ?>"><?= $key + 1 ?></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php foreach ($soal as $key => $s): ?>
                                <div class="soal-container" id="soal-<?= $key ?>" style="display: <?= $key == 0 ? 'block' : 'none' ?>;">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Soal <?= $key + 1 ?></h5>
                                            <div class="mb-3">
                                                <p><?= $s['pertanyaan'] ?></p>
                                            </div>
                                            
                                            <input type="hidden" name="id_soal_<?= $key ?>" value="<?= $s['id'] ?>">
                                            
                                            <div class="mb-3">
                                                <?php foreach ($s['pilihan'] as $p): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="jawaban_<?= $key ?>" value="<?= $p['id'] ?>" <?= isset($s['jawaban_peserta']) && $s['jawaban_peserta']['id_pilihan_jawaban'] == $p['id'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label"><?= $p['teks_pilihan'] ?></label>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mt-4">
                                                <?php if ($key > 0): ?>
                                                <button type="button" class="btn btn-secondary" onclick="showSoal(<?= $key - 1 ?>)">Sebelumnya</button>
                                                <?php else: ?>
                                                <div></div>
                                                <?php endif; ?>
                                                
                                                <?php if ($key < count($soal) - 1): ?>
                                                <button type="button" class="btn btn-primary" onclick="saveAndNext(<?= $key ?>)">Selanjutnya</button>
                                                <?php else: ?>
                                                <button type="button" class="btn btn-success" onclick="confirmSelesai()">Selesai</button>
                                                <?php endif; ?>
                                            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Navigasi soal
        window.showSoal = function(index) {
            document.querySelectorAll('.soal-container').forEach(function(el) {
                el.style.display = 'none';
            });
            document.getElementById('soal-' + index).style.display = 'block';
            
            document.querySelectorAll('.soal-nav').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.soal-nav')[index].classList.add('active');
        }
        
        // Simpan jawaban dan pindah ke soal berikutnya
        window.saveAndNext = function(currentIndex) {
            const soalContainer = document.getElementById('soal-' + currentIndex);
            const id_soal = soalContainer.querySelector('input[name="id_soal_' + currentIndex + '"]').value;
            
            const selectedOption = soalContainer.querySelector('input[name="jawaban_' + currentIndex + '"]:checked');
            const jawaban = selectedOption ? selectedOption.value : '';
            
            // Validasi jawaban
            if (!jawaban) {
                alert('Anda harus memilih jawaban terlebih dahulu!');
                return false;
            }
            
            // Simpan jawaban dengan AJAX
            saveJawaban(id_soal, jawaban, currentIndex, function() {
                // Callback setelah jawaban berhasil disimpan
                // Pindah ke soal berikutnya
                showSoal(currentIndex + 1);
            });
        }
        
        // Fungsi untuk menyimpan jawaban
        function saveJawaban(id_soal, jawaban, currentIndex, callback) {
            // Tambahkan CSRF token
            const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
            
            // Tampilkan indikator loading jika diperlukan
            document.querySelectorAll('.soal-nav')[currentIndex].classList.add('btn-warning');
            
            // Gunakan Fetch API
            fetch('<?= site_url('test/simpanJawaban') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'id_set_soal': <?= $set_soal['id'] ?>,
                    'id_soal': id_soal,
                    'jawaban': jawaban
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Hapus indikator loading
                    document.querySelectorAll('.soal-nav')[currentIndex].classList.remove('btn-warning');
                    
                    // Tandai soal sudah dijawab
                    document.querySelectorAll('.soal-nav')[currentIndex].classList.add('btn-primary');
                    document.querySelectorAll('.soal-nav')[currentIndex].classList.remove('btn-outline-primary');
                    
                    // Panggil callback jika ada
                    if (typeof callback === 'function') {
                        callback();
                    }
                } else {
                    // Hapus indikator loading
                    document.querySelectorAll('.soal-nav')[currentIndex].classList.remove('btn-warning');
                    
                    alert('Gagal menyimpan jawaban: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hapus indikator loading
                document.querySelectorAll('.soal-nav')[currentIndex].classList.remove('btn-warning');
                
                alert('Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
            });
        }
        
        window.confirmSelesai = function() {
            // Verifikasi semua soal sudah dijawab
            let allAnswered = true;
            document.querySelectorAll('.soal-nav').forEach(function(el) {
                if (!el.classList.contains('btn-primary')) {
                    allAnswered = false;
                }
            });
            
            if (!allAnswered) {
                alert('Anda harus menjawab semua soal terlebih dahulu!');
                return false;
            }
            
            if (confirm('Apakah Anda yakin ingin menyelesaikan test ini?')) {
                document.getElementById('testForm').submit();
            }
        }
        
        // Inisialisasi navigasi soal
        document.querySelectorAll('.soal-nav').forEach(function(el, index) {
            el.addEventListener('click', function() {
                // Simpan jawaban soal saat ini jika ada pilihan yang dipilih
                const currentActiveIndex = document.querySelector('.soal-nav.active').getAttribute('data-soal');
                const currentContainer = document.getElementById('soal-' + currentActiveIndex);
                const currentSelectedOption = currentContainer.querySelector(`input[name="jawaban_${currentActiveIndex}"]:checked`);
                
                if (currentSelectedOption) {
                    const currentSoalId = currentContainer.querySelector(`input[name="id_soal_${currentActiveIndex}"]`).value;
                    const currentJawaban = currentSelectedOption.value;
                    
                    // Simpan jawaban secara asynchronous
                    saveJawaban(currentSoalId, currentJawaban, currentActiveIndex);
                }
                
                // Pindah ke soal yang diklik
                showSoal(index);
            });
        });
        
        // Tandai soal yang sudah dijawab
        <?php foreach ($soal as $key => $s): ?>
        <?php if (isset($s['jawaban_peserta'])): ?>
        document.querySelectorAll('.soal-nav')[<?= $key ?>].classList.add('btn-primary');
        document.querySelectorAll('.soal-nav')[<?= $key ?>].classList.remove('btn-outline-primary');
        <?php endif; ?>
        <?php endforeach; ?>
        
        // Aktifkan soal pertama
        document.querySelectorAll('.soal-nav')[0].classList.add('active');
    });
</script>

<meta name="X-CSRF-TOKEN" content="<?= csrf_hash() ?>">
<?= $this->include('layout/footer') ?> 