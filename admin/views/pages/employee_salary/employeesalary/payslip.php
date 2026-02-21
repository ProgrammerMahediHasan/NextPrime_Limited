<?php
global $db, $tx;
if (!isset($tx) || !$tx) { $tx = "rt_"; }
$enginePath = dirname(__DIR__, 4) . "/models/payroll/payrollengine.model.php";
if (file_exists($enginePath)) { require_once($enginePath); }
$employee_id  = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;
$salary_month = $_GET['salary_month'] ?? '';
$calc = null;
$emp  = null;
if ($employee_id > 0 && $salary_month) {
    $calc = PayrollEngine::calculateMonthlySalary($employee_id, $salary_month);
    if ($calc) {
        $emp = $db->query("
            SELECT e.id, e.name, e.email, e.phone, d.name AS department_name, des.name AS designation_name
            FROM {$tx}employees e
            LEFT JOIN {$tx}department d ON e.dept_id = d.id
            LEFT JOIN {$tx}designations des ON e.desig_id = des.id
            WHERE e.id = {$employee_id}
        ")->fetch_object();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>NextPrime Payslip</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background:#eef1f7; color:#1f2937; margin:0; padding:0; }
        .container { max-width:920px; margin:0 auto; padding:20px; }
        .title { text-align:center; font-weight:700; color:#111827; margin:14px 0 4px; font-size:24px; }
        .sub { text-align:center; color:#6b7280; margin-bottom:16px; }
        .filter { background:#fff; padding:14px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,.06); display:flex; gap:12px; margin-bottom:18px; }
        .filter select, .filter input { padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; flex:1; }
        .filter button { background:#2563eb; color:#fff; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:600; }
        .actions { display:flex; justify-content:space-between; margin:0 0 16px; }
        .btn { padding:10px 14px; border-radius:8px; border:none; font-weight:600; cursor:pointer; }
        .btn-print { background:#10b981; color:#fff; }
        .btn-back { background:#374151; color:#fff; }
        .card { background:#fff; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,.06); padding:20px; }
        .header { display:flex; justify-content:space-between; border-bottom:1px solid #e5e7eb; padding-bottom:12px; margin-bottom:16px; }
        .header .left div { margin:2px 0; }
        .header .right { text-align:right; }
        .stats { display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; margin-bottom:12px; }
        .stat { background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; text-align:center; }
        .stat .label { color:#6b7280; font-size:12px; }
        .stat .value { font-weight:700; font-size:18px; margin-top:6px; color:#111827; }
        .meta { text-align:center; color:#6b7280; font-size:12px; margin-bottom:10px; }
        .section { background:#111827; color:#fff; padding:6px 10px; border-radius:6px; font-weight:600; margin:12px 0 8px; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
        table { width:100%; border-collapse:collapse; border-radius:8px; overflow:hidden; }
        th, td { border:1px solid #e5e7eb; padding:8px; text-align:left; font-size:13px; }
        th { background:#f3f4f6; font-weight:600; }
        .netpay { background:#0f766e; color:#fff; border-radius:10px; padding:12px; display:flex; justify-content:space-between; align-items:center; }
        .netpay .big { font-size:20px; font-weight:800; }
        @media print { 
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            body { font-size:11px; background:#fff; }
            .filter, .actions, .sub { display:none; } 
            .container { padding:0; max-width:100%; }
            .card { box-shadow:none; padding:8px; break-inside: avoid; page-break-inside: avoid; }
            .title { font-size:18px; margin:8px 0 4px; }
            .header { padding-bottom:6px; margin-bottom:8px; }
            .stats { grid-template-columns: repeat(3, 1fr); gap:6px; margin-bottom:8px; }
            .stat { padding:8px; }
            .meta { font-size:11px; margin-bottom:6px; }
            .section { margin:8px 0 6px; padding:5px 8px; }
            .grid { gap:8px; }
            table { font-size:12px; }
            th, td { padding:6px; }
            .netpay { padding:8px; }
            .netpay .big { font-size:16px; }
            /* Print only the payslip area */
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
        @page {
            size: A4 portrait;
            margin: 8mm;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">NextPrime Limited</h2>
        <div class="sub">HRMS & Payroll • Employee Payslip</div>

    <form class="filter" method="GET">
        <select name="employee_id" required>
            <option value="">Select Employee</option>
            <?php
            $rs = $db->query("SELECT id,name FROM {$tx}employees ORDER BY name ASC");
            while($row = $rs->fetch_object()){
                $sel = ($employee_id == intval($row->id)) ? "selected" : "";
                echo "<option value='{$row->id}' {$sel}>{$row->name}</option>";
            }
            ?>
        </select>
        <input type="month" name="salary_month" value="<?= htmlspecialchars($salary_month ?: date('Y-m')) ?>" required>
        <button type="submit">View Payslip</button>
    </form>

    <?php if($calc): ?>
    <div class="actions">
        <button class="btn btn-back" data-back data-fallback="<?= $base_url ?>/employeesalary">← Back</button>
        <button class="btn btn-print" onclick="window.print()">Print Payslip</button>
    </div>

    <div id="print-area">
    <div class="card">
        <div style="text-align:center; margin-bottom:8px;">
            <img src="<?= $base_url ?>/assets/images/nextprime-logo-pro.svg" alt="Logo" style="width:150px; height:auto;">
        </div>
        <div class="header">
            <div class="left">
                <div><b>Payslip</b></div>
                <div>Salary: <?= date('F Y', strtotime($calc['salary_month'].'-01')) ?></div>
                <div>Pay Date: <?= date('d M Y') ?></div>
            </div>
            <div class="right">
                <div><b>Employee:</b> <?= htmlspecialchars($emp->name ?? 'N/A') ?></div>
                <div>ID: <?= intval($employee_id) ?></div>
                <div><?= htmlspecialchars(($emp->department_name ?? 'N/A')) ?> • <?= htmlspecialchars(($emp->designation_name ?? 'N/A')) ?></div>
            </div>
        </div>

        <?php 
            $working_days_used = 30;
            $late_deduct_days = intval($calc['late_deduct_days']);
            $overused_days = floatval($calc['lwp_balance_overflow_days']);
            $late_text = $late_deduct_days . ' ' . ($late_deduct_days == 1 ? 'day' : 'days');
            $overused_text = (strpos((string)$overused_days, '.') !== false ? rtrim(rtrim(number_format($overused_days,2,'.',''), '0'), '.') : number_format($overused_days,0,'.','')) . ' ' . ($overused_days == 1.0 ? 'day' : 'days');
            $display_total_deduct_days = $late_deduct_days + $overused_days;
        ?>
        <div class="stats">
            <div class="stat">
                <div class="label">Gross Salary</div>
                <div class="value"><?= number_format(round($calc['gross_salary']),0,'.','') ?></div>
            </div>
            <div class="stat">
                <div class="label">Total Deductions</div>
                <div class="value"><?= number_format(round($calc['tax_deduction'] + $calc['pf_deduction'] + $calc['unpaid_deduction']),0,'.','') ?></div>
            </div>
            <div class="stat">
                <div class="label">Net Pay</div>
                <div class="value"><?= number_format($calc['net_salary'],0,'.','') ?></div>
            </div>
        </div>
      

        <div class="section">Earnings</div>
        <table>
            <tr><th>Component</th><th>Amount</th></tr>
            <tr><td>Basic Salary</td><td><?= number_format(round($calc['basic_salary']),0,'.','') ?></td></tr>
            <tr><td>House Rent Allowance</td><td><?= number_format(round($calc['hra']),0,'.','') ?></td></tr>
            <tr><td>Medical Allowance</td><td><?= number_format(round($calc['medical_allowance']),0,'.','') ?></td></tr>
            <tr><td><b>Total Earnings</b></td><td><b><?= number_format(round($calc['gross_salary']),0,'.','') ?></b></td></tr>
        </table>

        <div class="section">Deductions</div>
        <div class="grid">
            <table>
                <tr><th>Component</th><th>Amount</th></tr>
                <tr><td>Tax</td><td><?= number_format(round($calc['tax_deduction']),0,'.','') ?></td></tr>
                <tr><td>Providend Fund</td><td><?= number_format(round($calc['pf_deduction']),0,'.','') ?></td></tr>
                <tr><td>Deductions (Leave + Late + Absent)</td><td><?= number_format($calc['unpaid_deduction'],0,'.','') ?></td></tr>
                <tr><td><b>Total Deductions</b></td><td><b><?= number_format(round($calc['tax_deduction'] + $calc['pf_deduction'] + $calc['unpaid_deduction']),0,'.','') ?></b></td></tr>
            </table>
            <table>
                <tr><th>Attendance Summary</th><th>Count</th></tr>
                <tr><td>Working Days Used</td><td><?= $working_days_used ?></td></tr>
                <tr><td>Late Deduct</td><td><?= $late_text ?></td></tr>
                <tr><td>Over Leave Deduct</td><td><?= $overused_text ?></td></tr>
                <tr><td><b>Total Leave Deductions</b></td><td><b><?= $display_total_deduct_days ?> days deduct</b></td></tr>
            </table>
        </div>

            <div class="section">Net Pay</div>
        <div class="netpay">
            <div>Gross: <?= number_format(round($calc['gross_salary']),0,'.','') ?> • Deductions: <?= number_format(round($calc['tax_deduction'] + $calc['pf_deduction'] + $calc['unpaid_deduction']),0,'.','') ?></div>
            <div class="big">Net: <?= number_format($calc['net_salary'],0,'.','') ?></div>
        </div>
    </div>
    </div>
    <?php elseif($employee_id || $salary_month): ?>
        <div class="card">No payslip data found. Please select a valid employee and month.</div>
    <?php endif; ?>
    </div>
</body>
</html>
