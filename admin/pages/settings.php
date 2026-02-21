<?php include_once("../header.php"); ?>
<div class="container mt-4 mb-4">
  <div class="row">
    <div class="col-12">
      <h1 class="mb-3">Settings</h1>
    </div>
  </div>
  <div class="row g-4">
    <div class="col-12 col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Appearance</h5>
        </div>
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <span>Dark Mode</span>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="settingsDarkMode">
            </div>
          </div>
          <div class="mt-3">
            <label class="form-label" for="settingsTheme">Theme Color</label>
            <select class="form-select" id="settingsTheme">
              <option value="default">Default</option>
              <option value="blue">Blue</option>
              <option value="green">Green</option>
              <option value="purple">Purple</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Notifications</h5>
        </div>
        <div class="card-body">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="settingsEmailNotif" checked>
            <label class="form-check-label" for="settingsEmailNotif">Email notifications</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="settingsSmsNotif">
            <label class="form-check-label" for="settingsSmsNotif">SMS notifications</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="settingsPushNotif" checked>
            <label class="form-check-label" for="settingsPushNotif">Push notifications</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Account</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="settingsName">Full Name</label>
              <input type="text" class="form-control" id="settingsName" placeholder="Your name">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="settingsEmail">Email</label>
              <input type="email" class="form-control" id="settingsEmail" placeholder="name@example.com">
            </div>
            <div class="col-12">
              <label class="form-label" for="settingsPassword">New Password</label>
              <input type="password" class="form-control" id="settingsPassword" placeholder="••••••••">
            </div>
          </div>
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Changes</button>
            <button class="btn btn-outline-secondary">Reset</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.getElementById("settingsDarkMode").addEventListener("change", function () {
      document.documentElement.setAttribute("data-theme", this.checked ? "dark" : "light");
    });
    document.getElementById("settingsTheme").addEventListener("change", function () {
      document.documentElement.style.setProperty("--bs-primary", this.value === "default" ? "" : this.value);
    });
  </script>
</div>
<?php include_once("../footer.php"); ?>
