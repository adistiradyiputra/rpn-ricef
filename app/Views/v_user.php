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
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
                            <i class="bx bx-plus me-1"></i> Tambah Data
                        </button>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <div class="table-responsive text-nowrap p-3">
                                    <table id="userTable" class="display table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Form -->
                    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="userForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userModalLabel">Form Input Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="userId">
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama:</label>
                                            <input type="text" class="form-control" id="name" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username:</label>
                                            <input type="text" class="form-control" id="username" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" class="form-control" id="password">
                                        </div>

                                        <!-- Checkbox untuk Show Password -->
                                        <div class="mb-3">
                                            <input type="checkbox" id="showPassword" onclick="togglePassword()">
                                            <label for="showPassword">Show Password</label>
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
$(document).ready(function() {
    var table = $('#userTable').DataTable({
        ajax: '<?= site_url('user/getUsers') ?>',
        columns: [
            { data: 'id', render: function(data, type, row, meta) { return meta.row + 1; } }, // Nomor urut
            { data: 'name' },
            { data: 'username' },
            { 
                data: 'password',
                render: function(data, type, row) {
                    return `<input type="password" class="form-control" value="${data}" disabled>`;
                }
            },
            { 
                data: null, 
                render: function(data, type, row) {
                    return `<button class="btn btn-warning btn-sm" onclick="editUser(${row.id})"><i class="bx bx-edit"></i> Edit</button> 
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})"><i class="bx bx-trash"></i> Hapus</button>`;
                }
            }
        ]
    });

    $('#userForm').submit(function(e) {
        e.preventDefault();
        let id = $('#userId').val();
        let url = id ? '<?= site_url('user/updateUser/') ?>' + id : '<?= site_url('user/saveUser') ?>';
        
        $.post(url, {
            name: $('#name').val(),
            username: $('#username').val(),
            password: $('#password').val()
        }, function(response) {
            resetForm(); // Reset form setelah submit
            $('#userModal').modal('hide'); // Tutup modal
            table.ajax.reload(); // Reload data di tabel
            showToast(id ? "Data berhasil diperbarui!" : "Data berhasil ditambahkan!");
        });
    });
});

function editUser(id) {
    $.get('<?= site_url('user/getUsers') ?>', function(response) {
        let user = response.data.find(u => u.id == id);
        $('#userId').val(user.id);
        $('#name').val(user.name);
        $('#username').val(user.username);
        $('#password').val(''); // Password langsung ditampilkan

        $('#password').attr('type', 'text');
        $('#userModal').modal('show');
    });
}

function deleteUser(id) {
    if (confirm("Hapus user ini?")) {
        $.get('<?= site_url('user/deleteUser/') ?>' + id, function() {
            $('#userTable').DataTable().ajax.reload();
            showToast("Data berhasil dihapus!", "error");
        });
    }
}

// Fungsi untuk mereset form input
function resetForm() {
    $('#userId').val('');
    $('#name').val('');
    $('#username').val('');
    $('#password').val('');

    // Checkbox "Show Password" default tidak tercentang
    $('#showPassword').prop('checked', false);
    $('#password').attr('type', 'password');
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

// Fungsi untuk menampilkan/menghilangkan password
function togglePassword() {
    let passwordField = document.getElementById("password");
    if ($('#showPassword').is(':checked')) {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>
