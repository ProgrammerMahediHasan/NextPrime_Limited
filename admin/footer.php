
 <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header py-3">
                <h5 class="modal-title">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" placeholder="Enter full name">
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="email" class="form-label">Email Address</label>
                      <input type="email" class="form-control" id="email" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="phone" class="form-label">Phone Number</label>
                      <input type="tel" class="form-control" id="phone" placeholder="+91 9876543210">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="department" class="form-label">Department</label>
                      <select class="form-select" id="department">
                        <option selected disabled>Select Department</option>
                        <option>HR</option>
                        <option>Development</option>
                        <option>Sales</option>
                        <option>Marketing</option>
                      </select>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="designation" class="form-label">Designation</label>
                      <input type="text" class="form-control" id="designation" placeholder="e.g. Software Engineer">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="joiningDate" class="form-label">Joining Date</label>
                      <input type="date" class="form-control flatpickr-date" id="joiningDate">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="status" class="form-label">Employment Status</label>
                      <select class="form-select" id="status">
                        <option>Active</option>
                        <option>Inactive</option>
                        <option>Probation</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" rows="2" placeholder="Enter address"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="photo" class="form-label">Profile Photo</label>
                    <input class="form-control" type="file" id="photo">
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-success">Add Employee</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

    </main>

    <!-- begin::GXON Footer -->
    <footer class="footer-wrapper bg-body">
      <div class="container">
        <div class="row g-2">
          <div class="col-lg-6 col-md-7 text-center text-md-start">
            <p class="mb-0">© <span class="currentYear">2025</span> NextPrime | Proudly powered by <a href="javascript:void(0);">MAHEDI HASAN</a>.</p>
          </div>
          <div class="col-lg-6 col-md-5">
            <ul class="d-flex list-inline mb-0 gap-3 flex-wrap justify-content-center justify-content-md-end">
              <li>
                <a class="text-body" href="index.html">Home</a>
              </li>
              <li>
                <a class="text-body" href="pages/faq.html">Faq's</a>
              </li>
              <li>
                <a class="text-body" href="pages/faq.html">Support</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- end::GXON Footer -->

  </div>

  <!-- begin::GXON Page Scripts -->
  <script src="<?= $base_url?>/assets/libs/global/global.min.js"></script>
  <script src="<?= $base_url?>/assets/libs/sortable/Sortable.min.js"></script>
  <script src="<?= $base_url?>/assets/libs/chartjs/chart.js"></script>
  <script src="<?= $base_url?>/assets/libs/flatpickr/flatpickr.min.js"></script>
  <script src="<?= $base_url?>/assets/libs/apexcharts/apexcharts.min.js"></script>
  <script src="<?= $base_url?>/assets/libs/datatables/datatables.min.js"></script>
  <script src="<?= $base_url?>/assets/js/dashboard.js"></script>
  <script src="<?= $base_url?>/assets/js/todolist.js"></script>
  <script src="<?= $base_url?>/assets/js/appSettings.js"></script>
  <script src="<?= $base_url?>/assets/js/main.js"></script>
  <!-- end::GXON Page Scripts -->
</body>

</html>



