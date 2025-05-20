<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">
                        <span class="text-muted fw-light">Bank Soal /</span> Tambah Soal
                    </h4>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Form Tambah Soal</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('banksoal/save_combined') ?>" method="post">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pelatihan</label>
                                            <select class="form-control" name="id_detail_pelatihan" required>
                                                <option value="">Pilih Pelatihan</option>
                                                <?php foreach ($pelatihan ?? [] as $p): ?>
                                                <option value="<?= $p['id'] ?>"><?= $p['nama_pelatihan'] ?> - <?= $p['puslit'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Test</label>
                                            <select class="form-control" name="jenis" required>
                                                <option value="">Pilih Jenis Test</option>
                                                <option value="pretest">Pre Test</option>
                                                <option value="posttest">Post Test</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="aktif" value="1" checked>
                                                <label class="form-check-label">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="mb-3">Daftar Pertanyaan</h5>
                                <div id="pertanyaan-container">
                                    <!-- Default pertanyaan pertama -->
                                    <div class="pertanyaan-item mb-4 border p-3 rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Pertanyaan <span class="nomor-pertanyaan">1</span></h6>
                                            <button type="button" class="btn btn-outline-danger btn-sm hapus-pertanyaan" disabled>
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <textarea class="form-control" name="pertanyaan[]" rows="3" placeholder="Masukkan pertanyaan..." required></textarea>
                                        </div>
                                        
                                        <div class="pilihan-container">
                                            <!-- Default 2 pilihan jawaban -->
                                            <div class="mb-3 row pilihan-item">
                                                <div class="col-md-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="is_benar_0" value="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="teks_pilihan_0[]" placeholder="Pilihan A" required>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" disabled>
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3 row pilihan-item">
                                                <div class="col-md-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="is_benar_0" value="1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="teks_pilihan_0[]" placeholder="Pilihan B" required>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" disabled>
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm tambah-pilihan" data-index="0">
                                                <i class="bx bx-plus"></i> Tambah Pilihan Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <button type="button" class="btn btn-outline-success" id="tambah-pertanyaan">
                                        <i class="bx bx-plus"></i> Tambah Pertanyaan
                                    </button>
                                </div>
                                
                                <div class="mt-4">
                                    <a href="<?= site_url('banksoal') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pastikan jQuery dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        // Variabel untuk menghitung jumlah pertanyaan
        let pertanyaanCounter = 1;
        
        // Tambah pertanyaan baru
        $('#tambah-pertanyaan').click(function() {
            pertanyaanCounter++;
            
            const newPertanyaan = `
                <div class="pertanyaan-item mb-4 border p-3 rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Pertanyaan <span class="nomor-pertanyaan">${pertanyaanCounter}</span></h6>
                        <button type="button" class="btn btn-outline-danger btn-sm hapus-pertanyaan">
                            <i class="bx bx-trash"></i> Hapus
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <textarea class="form-control" name="pertanyaan[]" rows="3" placeholder="Masukkan pertanyaan..." required></textarea>
                    </div>
                    
                    <div class="pilihan-container">
                        <!-- Default 2 pilihan jawaban -->
                        <div class="mb-3 row pilihan-item">
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_benar_${pertanyaanCounter - 1}" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="teks_pilihan_${pertanyaanCounter - 1}[]" placeholder="Pilihan A" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" disabled>
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 row pilihan-item">
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_benar_${pertanyaanCounter - 1}" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="teks_pilihan_${pertanyaanCounter - 1}[]" placeholder="Pilihan B" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" disabled>
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary btn-sm tambah-pilihan" data-index="${pertanyaanCounter - 1}">
                            <i class="bx bx-plus"></i> Tambah Pilihan Jawaban
                        </button>
                    </div>
                </div>
            `;
            
            $('#pertanyaan-container').append(newPertanyaan);
            
            // Aktifkan tombol hapus pertanyaan jika ada lebih dari 1 pertanyaan
            if (pertanyaanCounter > 1) {
                $('.hapus-pertanyaan').prop('disabled', false);
            }
            
            // Update nomor pertanyaan
            updateNomorPertanyaan();
        });
        
        // Hapus pertanyaan (delegasi event untuk elemen dinamis)
        $(document).on('click', '.hapus-pertanyaan', function() {
            $(this).closest('.pertanyaan-item').remove();
            pertanyaanCounter--;
            
            // Nonaktifkan tombol hapus jika tinggal 1 pertanyaan
            if (pertanyaanCounter <= 1) {
                $('.hapus-pertanyaan').prop('disabled', true);
            }
            
            // Update nomor pertanyaan dan indeks
            updateNomorPertanyaan();
        });
        
        // Update nomor pertanyaan dan indeks
        function updateNomorPertanyaan() {
            $('.pertanyaan-item').each(function(index) {
                $(this).find('.nomor-pertanyaan').text(index + 1);
                
                // Update nama radio button dan input field
                $(this).find('input[type="radio"]').attr('name', 'is_benar_' + index);
                $(this).find('input[type="text"]').attr('name', 'teks_pilihan_' + index + '[]');
                
                // Update data-index pada tombol tambah pilihan
                $(this).find('.tambah-pilihan').attr('data-index', index);
            });
        }
        
        // Tambah pilihan jawaban (delegasi event untuk elemen dinamis)
        $(document).on('click', '.tambah-pilihan', function() {
            const index = $(this).data('index');
            const pilihanContainer = $(this).closest('.pertanyaan-item').find('.pilihan-container');
            let pilihanCount = pilihanContainer.find('.pilihan-item').length;
            pilihanCount++;
            
            const huruf = String.fromCharCode(65 + pilihanCount - 1); // A, B, C, ...
            
            const newPilihan = `
                <div class="mb-3 row pilihan-item">
                    <div class="col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_benar_${index}" value="${pilihanCount - 1}" required>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="teks_pilihan_${index}[]" placeholder="Pilihan ${huruf}" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            pilihanContainer.append(newPilihan);
            
            // Aktifkan tombol hapus pilihan jika ada lebih dari 2 pilihan
            if (pilihanCount > 2) {
                pilihanContainer.find('.hapus-pilihan').prop('disabled', false);
            }
        });
        
        // Hapus pilihan jawaban (delegasi event untuk elemen dinamis)
        $(document).on('click', '.hapus-pilihan', function() {
            const pilihanItem = $(this).closest('.pilihan-item');
            const pilihanContainer = pilihanItem.closest('.pilihan-container');
            const index = $(this).closest('.pertanyaan-item').find('.tambah-pilihan').data('index');
            
            pilihanItem.remove();
            
            const pilihanItems = pilihanContainer.find('.pilihan-item');
            
            // Nonaktifkan tombol hapus jika tinggal 2 pilihan
            if (pilihanItems.length <= 2) {
                pilihanContainer.find('.hapus-pilihan').prop('disabled', true);
            }
            
            // Update value radio button
            pilihanItems.each(function(i) {
                $(this).find('input[type="radio"]').val(i);
                
                // Update placeholder dengan huruf yang benar
                const huruf = String.fromCharCode(65 + i);
                $(this).find('input[type="text"]').attr('placeholder', 'Pilihan ' + huruf);
            });
        });
        
        // Validasi form sebelum submit
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Validasi setiap pertanyaan
            $('.pertanyaan-item').each(function(index) {
                const pertanyaan = $(this).find('textarea[name="pertanyaan[]"]').val();
                const isBenarChecked = $(this).find(`input[name="is_benar_${index}"]:checked`).length;
                
                if (!pertanyaan || !pertanyaan.trim()) {
                    isValid = false;
                    alert(`Pertanyaan ${index + 1} tidak boleh kosong`);
                    return false;
                }
                
                if (isBenarChecked === 0) {
                    isValid = false;
                    alert(`Pilih jawaban yang benar untuk Pertanyaan ${index + 1}`);
                    return false;
                }
                
                // Validasi setiap pilihan jawaban
                const pilihanInputs = $(this).find(`input[name="teks_pilihan_${index}[]"]`);
                pilihanInputs.each(function(i) {
                    if (!$(this).val() || !$(this).val().trim()) {
                        isValid = false;
                        alert(`Pilihan ${String.fromCharCode(65 + i)} pada Pertanyaan ${index + 1} tidak boleh kosong`);
                        return false;
                    }
                });
                
                if (!isValid) return false;
            });
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    });
</script>

<?= $this->include('layout/footer') ?> 