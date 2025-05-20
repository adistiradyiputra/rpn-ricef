<?= $this->include("layout/header") ?>

<div class="container-xxl" style="min-height: 100vh; margin: 0; padding: 0; background: #f5f5f9;">
  <div class="authentication-wrapper authentication-basic container-p-y" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div class="authentication-inner" style="width: 100%; max-width: 450px;">
      <!-- Login Card -->
      <div class="card" style="border: none; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);">
        <div class="card-body" style="padding: 2.5rem;">
          <!-- Logo -->
          <div class="app-brand justify-content-center" style="margin-bottom: 2rem; display: flex; justify-content: center;">
            <a href="<?= base_url(); ?>" class="app-brand-link" style="display: flex; align-items: center; gap: 0.8rem; text-decoration: none;">
              <span class="app-brand-logo" style="display: block;">
                <img src="<?= base_url('assets/img/logo.png'); ?>" style="width: 65px; height: 120px; display: block;" alt="Logo">
              </span>
            </a>
            <span class="app-brand-text demo text-body fw-bolder ms-2 mt-2" style="font-size: 22px; text-transform: uppercase; margin: 0; line-height: 1.3; color: #566a7f; letter-spacing: 0.5px;">
              Capacity<br>Building
            </span>
          </div>

          <!-- Flash Message -->
          <?php if(session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>
          <?php if(session()->getFlashdata('message')): ?>
              <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
          <?php endif; ?>

          <!-- Login Form -->
          <form id="formAuthentication" class="mb-3" action="<?= site_url('auth') ?>" method="post">
            <div class="mb-3">
              <label for="username" class="form-label" style="font-size: 14px; font-weight: 500; margin-bottom: 0.5rem;">Username</label>
              <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                placeholder="Masukkan username"
                style="height: 45px; padding: 0.6rem 1rem; font-size: 14px; border-radius: 5px;"
                autofocus
                required
              />
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password" style="font-size: 14px; font-weight: 500; margin-bottom: 0.5rem;">Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  id="password"
                  class="form-control"
                  name="password"
                  placeholder="••••••••"
                  style="height: 45px; padding: 0.6rem 1rem; font-size: 14px; border-radius: 5px;"
                  required
                />
              </div>
            </div>
            <span class="cursor-pointer" style="display: flex; align-items: center; gap: 0.5rem; margin: 1rem 0; font-size: 14px;">
              <input type="checkbox" id="showPassword" onclick="togglePassword()" style="margin: 0;"> Show Password
            </span>

            <div class="mt-4">
              <button class="btn btn-primary w-100" type="submit" style="height: 45px; font-size: 15px; font-weight: 500;">Sign in</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Fungsi untuk menampilkan atau menyembunyikan password
  function togglePassword() {
      let passwordField = document.getElementById("password");
      if (document.getElementById("showPassword").checked) {
          passwordField.type = "text";
      } else {
          passwordField.type = "password";
      }
  }
</script>

<?= $this->include("layout/footer") ?>
