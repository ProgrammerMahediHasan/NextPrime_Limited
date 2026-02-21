<?php
include_once("../header.php");
global $base_url;
?>
<style>
  .faq-wrap{max-width:1000px;margin:24px auto;padding:0 14px}
  .faq-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
  .faq-title{font-size:24px;font-weight:800;color:#0f172a}
  .faq-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 8px 24px rgba(2,6,23,.06);overflow:hidden}
  .faq-body{padding:16px}
</style>

<div class="faq-wrap">
  <div class="faq-head">
    <div class="faq-title">Frequently Asked Questions</div>
    <a class="btn btn-primary" href="<?= $base_url ?>/home">Back to Dashboard</a>
  </div>
  <div class="faq-card">
    <div class="faq-body">
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1h">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
              How do I view my profile?
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1h" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Go to Profile under the header menu or open <?= htmlspecialchars($base_url) ?>/profile.html. It shows your name, role, status, contact and actions to edit.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
              How can I change my role to Manager?
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2h" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Only Admins can change roles. Admins will see a Make Manager button in the profile view; otherwise use Users module to update role.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq3h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
              How do I manage tasks?
            </button>
          </h2>
          <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3h" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Open <?= htmlspecialchars($base_url) ?>/task-management.html to add tasks with priority and due date. Drag cards across Backlog, To Do, In Progress, Done. Your tasks are saved for your account.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq4h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
              Attendance and Leave: where to find reports?
            </button>
          </h2>
          <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4h" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Use Daily Attendance and Leave modules from the sidebar to view attendance logs, monthly summary and leave assignments, with filters and detailed views.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq5h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
              How is payroll calculated?
            </button>
          </h2>
          <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faq5h" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Payroll considers fixed per-day rate and deducts days for late or overused leave according to salary and leave policies. Check Salary configuration and Payslip view.
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include("../footer.php"); ?>
