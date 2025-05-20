<?= $this->include('layout/header') ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?= $this->include('layout/sidebar') ?>
        <div class="layout-page">
            <?= $this->include('layout/navbar') ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">
                        <span class="text-muted fw-light">Bank Soal /</span> Tambah Set Soal
                    </h4>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Form Tambah Set Soal</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('banksoal/save_set') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Set Soal</label>
                                            <input type="text" class="form-control" name="nama_set" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Test</label>
                                            <select class="form-select" name="jenis" required>
                                                <option value="">Pilih Jenis Test</option>
                                                <option value="pretest">Pre Test</option>
                                                <option value="posttest">Post Test</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pelatihan</label>
                                            <select class="form-select" name="id_detail_pelatihan" required>
                                                <option value="">Pilih Pelatihan</option>
                                                <?php foreach ($pelatihan as $p): ?>
                                                <option value="<?= $p['id'] ?>"><?= $p['nama_pelatihan'] ?> - <?= $p['puslit'] ?></option>
                                                <?php endforeach; ?>
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

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5>Pilih Soal</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="soalTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">
                                                            <input type="checkbox" id="check_all">
                                                        </th>
                                                        <th>Pertanyaan</th>
                                                        <th width="15%">Bobot</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="soal_container">
                                                    <!-- Soal akan dimuat melalui AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    // Gunakan jQuery alih-alih $ untuk menghindari konflik
    jQuery(document).ready(function($) {
        console.log('Document ready');
        
        loadSoal();
        
        $('#check_all').change(function() {
            $('input[name="id_soal[]"]').prop('checked', $(this).prop('checked'));
        });

        $('form').on('submit', function(e) {
            // Ambil soal yang dipilih
            const selectedSoal = $('input[name="id_soal[]"]:checked');
            if (selectedSoal.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu soal');
                return false;
            }
            
            // Kumpulkan bobot untuk soal yang dipilih
            selectedSoal.each(function(index) {
                const row = $(this).closest('tr');
                const bobot = row.find('input[name="bobot[]"]').val();
                
                // Tambahkan input hidden untuk bobot yang terkait dengan soal yang dipilih
                $('<input>').attr({
                    type: 'hidden',
                    name: 'bobot_values[]',
                    value: bobot
                }).appendTo(this.form);
            });
            
            // Lanjutkan submit form
            return true;
        });
    });

    function loadSoal() {
        // Pastikan jQuery tersedia
        if (typeof jQuery === 'undefined') {
            console.error('jQuery tidak tersedia untuk loadSoal()');
            return;
        }
        
        const $ = jQuery;
        
        // Tambahkan log untuk debugging
        console.log('Loading soal');
        
        $.ajax({
            url: '<?= site_url('banksoal/getSoal') ?>',
            type: 'GET',
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    let html = '';
                    if (response.data.length === 0) {
                        html = '<tr><td colspan="3" class="text-center">Tidak ada soal</td></tr>';
                    } else {
                        response.data.forEach(function(soal) {
                            html += `
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id_soal[]" value="${soal.id}" class="soal-checkbox">
                                    </td>
                                    <td>${soal.pertanyaan}</td>
                                    <td>
                                        <input type="number" class="form-control bobot-input" name="bobot[]" value="1" min="1" max="100">
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    $('#soal_container').html(html);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
</script>

<?= $this->include('layout/footer') ?>