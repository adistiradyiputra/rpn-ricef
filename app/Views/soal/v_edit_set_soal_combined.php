<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">
                        <span class="text-muted fw-light">Bank Soal /</span> Edit Soal
                    </h4>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Form Edit Soal</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('banksoal/update_set/' . $set_soal['id']) ?>" method="post">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Set Soal</label>
                                            <input type="text" class="form-control" name="nama_set" value="<?= $set_soal['nama_set'] ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pelatihan</label>
                                            <select class="form-control" name="id_detail_pelatihan" required>
                                                <option value="">Pilih Pelatihan</option>
                                                <?php foreach ($pelatihan as $p): ?>
                                                <option value="<?= $p['id'] ?>" <?= $set_soal['id_detail_pelatihan'] == $p['id'] ? 'selected' : '' ?>>
                                                    <?= $p['nama_pelatihan'] ?> - <?= $p['puslit'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Test</label>
                                            <select class="form-control" name="jenis" required>
                                                <option value="">Pilih Jenis Test</option>
                                                <option value="pretest" <?= $set_soal['jenis'] == 'pretest' ? 'selected' : '' ?>>Pre Test</option>
                                                <option value="posttest" <?= $set_soal['jenis'] == 'posttest' ? 'selected' : '' ?>>Post Test</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="aktifSwitch" name="aktif" value="1" <?= $set_soal['aktif'] == 1 ? 'checked' : '' ?>>
                                                <label class="form-check-label" id="statusLabel"><?= $set_soal['aktif'] == 1 ? 'Aktif' : 'Nonaktif' ?></label>
                                                <input type="hidden" id="aktifValue" name="aktif" value="<?= $set_soal['aktif'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-3">Daftar Pertanyaan</h5>
                                <div id="pertanyaan-container">
                                    <?php if(isset($set_soal['items']) && !empty($set_soal['items'])): ?>
                                        <?php foreach($set_soal['items'] as $index => $item): ?>
                                            <div class="pertanyaan-item mb-4 border p-3 rounded">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">Pertanyaan <span class="nomor-pertanyaan"><?= $index + 1 ?></span></h6>
                                                    <button type="button" class="btn btn-outline-danger btn-sm hapus-pertanyaan" <?= count($set_soal['items']) <= 1 ? 'disabled' : '' ?>>
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </button>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <textarea class="form-control" name="pertanyaan[]" rows="3" placeholder="Masukkan pertanyaan..." required><?= $item['pertanyaan'] ?></textarea>
                                                    <input type="hidden" name="id_soal[]" value="<?= $item['id_soal'] ?>">
                                                </div>
                                                
                                                <div class="pilihan-container">
                                                    <?php foreach($item['pilihan'] as $key => $pilihan): ?>
                                                        <div class="mb-3 row pilihan-item">
                                                            <div class="col-md-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="is_benar_<?= $index ?>" value="<?= $key ?>" <?= $pilihan['is_benar'] == 1 ? 'checked' : '' ?> required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="teks_pilihan_<?= $index ?>[]" value="<?= $pilihan['teks_pilihan'] ?>" required>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" <?= count($item['pilihan']) <= 2 ? 'disabled' : '' ?>>
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm tambah-pilihan" data-index="<?= $index ?>">
                                                        <i class="bx bx-plus"></i> Tambah Pilihan Jawaban
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            Belum ada soal dalam set ini. Silakan tambahkan soal baru.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-4">
                                    <button type="button" class="btn btn-outline-success" id="tambah-pertanyaan">
                                        <i class="bx bx-plus"></i> Tambah Pertanyaan
                                    </button>
                                </div>
                                
                                <div class="mt-4">
                                    <a href="<?= site_url('banksoal') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
        // Toggle aktif/nonaktif
        $('#aktifSwitch').change(function() {
            if($(this).is(':checked')) {
                $('#statusLabel').text('Aktif');
                $('#aktifValue').val(1);
            } else {
                $('#statusLabel').text('Nonaktif');
                $('#aktifValue').val(0);
            }
        });
        
        // Variabel untuk menghitung jumlah pertanyaan
        let pertanyaanCounter = <?= isset($set_soal['items']) ? count($set_soal['items']) : 0 ?>;
        
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
                        <textarea class="form-control" name="pertanyaan_baru[]" rows="3" placeholder="Masukkan pertanyaan..." required></textarea>
                    </div>
                    
                    <div class="pilihan-container">
                        <!-- Default 2 pilihan jawaban -->
                        <div class="mb-3 row pilihan-item">
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_benar_new_${pertanyaanCounter - 1}" value="0" checked required>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="teks_pilihan_new_${pertanyaanCounter - 1}[]" placeholder="Pilihan A" required>
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
                                    <input class="form-check-input" type="radio" name="is_benar_new_${pertanyaanCounter - 1}" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="teks_pilihan_new_${pertanyaanCounter - 1}[]" placeholder="Pilihan B" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan" disabled>
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary btn-sm tambah-pilihan" data-index="new_${pertanyaanCounter - 1}">
                            <i class="bx bx-plus"></i> Tambah Pilihan Jawaban
                        </button>
                    </div>
                </div>
            `;
            
            $('#pertanyaan-container').append(newPertanyaan);
            
            // Aktifkan semua tombol hapus pertanyaan jika ada lebih dari 1 pertanyaan
            if (pertanyaanCounter > 1) {
                $('.hapus-pertanyaan').prop('disabled', false);
            }
            
            // Update nomor pertanyaan
            updateNomorPertanyaan();
        });
        
        // Hapus pertanyaan (delegasi event untuk elemen dinamis)
        $(document).on('click', '.hapus-pertanyaan', function() {
            const pertanyaanItem = $(this).closest('.pertanyaan-item');
            const hasIdSoal = pertanyaanItem.find('input[name="id_soal[]"]').length > 0;
            
            if (hasIdSoal) {
                // Jika ini adalah soal yang sudah ada, tambahkan hidden input untuk menandai penghapusan
                const idSoal = pertanyaanItem.find('input[name="id_soal[]"]').val();
                $('<input>').attr({
                    type: 'hidden',
                    name: 'delete_soal[]',
                    value: idSoal
                }).appendTo('form');
            }
            
            pertanyaanItem.remove();
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
            });
        }
        
        // Tambah pilihan jawaban (delegasi event untuk elemen dinamis)
        $(document).on('click', '.tambah-pilihan', function() {
            const index = $(this).data('index');
            const pilihanContainer = $(this).closest('.pertanyaan-item').find('.pilihan-container');
            let pilihanCount = pilihanContainer.find('.pilihan-item').length;
            const isNewQuestion = index.toString().includes('new_');
            
            const newPilihan = `
                <div class="mb-3 row pilihan-item">
                    <div class="col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_benar_${index}" value="${pilihanCount}" required>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="teks_pilihan_${index}[]" placeholder="Pilihan ${String.fromCharCode(65 + pilihanCount)}" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm hapus-pilihan">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            
            pilihanContainer.append(newPilihan);
            pilihanCount++;
            
            // Aktifkan tombol hapus pilihan jika ada lebih dari 2 pilihan
            if (pilihanCount > 2) {
                pilihanContainer.find('.hapus-pilihan').prop('disabled', false);
            }
        });
        
        // Hapus pilihan jawaban (delegasi event untuk elemen dinamis)
        $(document).on('click', '.hapus-pilihan', function() {
            const pilihanItem = $(this).closest('.pilihan-item');
            const pilihanContainer = pilihanItem.closest('.pilihan-container');
            
            pilihanItem.remove();
            
            const pilihanItems = pilihanContainer.find('.pilihan-item');
            
            // Nonaktifkan tombol hapus jika tinggal 2 pilihan
            if (pilihanItems.length <= 2) {
                pilihanContainer.find('.hapus-pilihan').prop('disabled', true);
            }
            
            // Update value radio button dan placeholder
            pilihanItems.each(function(i) {
                $(this).find('input[type="radio"]').val(i);
                const huruf = String.fromCharCode(65 + i);
                $(this).find('input[type="text"]').attr('placeholder', 'Pilihan ' + huruf);
            });
        });
        
        // Validasi form sebelum submit
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Validasi setiap pertanyaan
            $('.pertanyaan-item').each(function(index) {
                const pertanyaan = $(this).find('textarea').val();
                
                if (!pertanyaan || !pertanyaan.trim()) {
                    isValid = false;
                    alert(`Pertanyaan ${index + 1} tidak boleh kosong`);
                    return false;
                }
                
                // Dapatkan nama radio button yang benar
                const radioName = $(this).find('input[type="radio"]').first().attr('name');
                const isBenarChecked = $(this).find(`input[name="${radioName}"]:checked`).length;
                
                if (isBenarChecked === 0) {
                    isValid = false;
                    alert(`Pilih jawaban yang benar untuk Pertanyaan ${index + 1}`);
                    return false;
                }
                
                // Validasi setiap pilihan jawaban
                $(this).find('input[type="text"]').each(function(i) {
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

<style>
.pertanyaan-item {
    border-left: 3px solid #696cff !important;
}
</style>

<?= $this->include('layout/footer') ?> 