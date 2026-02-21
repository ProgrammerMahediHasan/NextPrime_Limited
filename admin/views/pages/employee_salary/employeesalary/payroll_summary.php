<?php
global $db, $tx;

// Filter
$emp_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : '';
$showReport = isset($_GET['emp_id']);

// Employees dropdown
$emp_result = $db->query("SELECT id, name FROM {$tx}employees ORDER BY name ASC");

// Data
$result = null;
if($showReport){
    $filter_sql = "";
    if($emp_id !== '' && $emp_id != '0'){
        $filter_sql = "WHERE e.id = ".intval($emp_id);
    }
    $query = "
        SELECT 
            e.id AS emp_id,
            e.name AS emp_name,
            COALESCE(es.basic_salary,0) AS basic_salary,
            COALESCE(es.hra,0) AS hra,
            COALESCE(es.medical_allowance,0) AS medical_allowance,
            COALESCE(es.tax_deduction,0) AS tax_deduction,
            COALESCE(es.pf_deduction,0) AS pf_deduction,
            COALESCE(es.gross_salary, COALESCE(es.basic_salary,0)+COALESCE(es.hra,0)+COALESCE(es.medical_allowance,0)) AS gross_salary,
            COALESCE(es.net_salary, COALESCE(es.basic_salary,0)+COALESCE(es.hra,0)+COALESCE(es.medical_allowance,0)-COALESCE(es.tax_deduction,0)-COALESCE(es.pf_deduction,0)) AS net_salary
        FROM {$tx}employees e
        LEFT JOIN (
            SELECT s.emp_id, s.basic_salary, s.hra, s.medical_allowance, s.tax_deduction, s.pf_deduction, s.gross_salary, s.net_salary
            FROM {$tx}employee_salary s
            INNER JOIN (
                SELECT emp_id, MAX(id) AS max_id
                FROM {$tx}employee_salary
                GROUP BY emp_id
            ) m ON m.max_id = s.id
        ) es ON es.emp_id = e.id
        $filter_sql
        ORDER BY e.name ASC
    ";
    $result = $db->query($query);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payroll Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background:#f5f6fa; padding:20px; }
        h2 { text-align:center; margin-bottom:30px; color:#0d3b66; }

        /* Filter form styling */
        .filter-card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08); margin-bottom:30px; }
        .form-label { font-weight:600; color:#122f4e; }
        .btn-primary { background: linear-gradient(135deg,#0d6efd,#004bba); border:none; font-weight:500; }
        .btn-primary:hover { background: linear-gradient(135deg,#004bba,#002f7d); }

        /* Table styling */
        .table-responsive { max-height:600px; overflow-y:auto; }
        .table thead th { position: sticky; top:0; background-color: #0d3b66; color:#fff; text-align:center; z-index:10; }
        .table tbody td { vertical-align: middle; text-align: center; }
        .totals-row td { font-weight:700; color:green; background-color:#ffffff; }
    </style>
</head>
<body>

<h2>Employee Salary Summary</h2>

<!-- Filter Form -->
<div class="filter-card container">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="emp_id" class="form-label">Select Employee:</label>
            <select name="emp_id" id="emp_id" class="form-select">
                <option value="0" <?= ($emp_id==='0') ? "selected" : "" ?>>All Employees</option>
                <?php while($emp = $emp_result->fetch_object()):
                    $selected = ($emp->id == $emp_id) ? "selected" : ""; ?>
                    <option value="<?= $emp->id ?>" <?= $selected ?>><?= htmlspecialchars($emp->name) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">View Summary</button>
        </div>
    </form>
</div>

<?php if($showReport && $result): ?>
<!-- Payroll Table -->
<div class="table-responsive container">
    <table class="table table-bordered table-striped table-hover text-center">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Basic</th>
                <th>HRA</th>
                <th>Medical</th>
                <th>Gross Salary</th>
                <th>Tax</th>
                <th>PF</th>
                <th>Leave Deduct</th>
                <th>Late Deduct</th>
                <th>Net Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_basic = $total_hra = $total_medical = $total_tax = $total_pf = $total_gross = $total_net = 0;

            if($result->num_rows > 0):
                while($row = $result->fetch_object()):
                    $leave_deduct = EmployeeSalary::compute_leave_deduct($row->emp_id, $row->basic_salary);
                    $late_deduct = EmployeeSalary::compute_late_deduct($row->emp_id, $row->basic_salary);
                    $total_basic += round($row->basic_salary);
                    $total_hra += round($row->hra);
                    $total_medical += round($row->medical_allowance);
                    $total_gross += round($row->gross_salary);
                    $total_tax += round($row->tax_deduction);
                    $total_pf += round($row->pf_deduction);
                    
                    $total_net += round($row->net_salary);
                    $total_leave_deduct = ($total_leave_deduct ?? 0) + intval($leave_deduct);
                    $total_late_deduct = ($total_late_deduct ?? 0) + intval($late_deduct);
            ?>
                <tr>
                    <td><?= htmlspecialchars($row->emp_name) ?></td>
                    <td><?= number_format(round($row->basic_salary),0) ?></td>
                    <td><?= number_format(round($row->hra),0) ?></td>
                    <td><?= number_format(round($row->medical_allowance),0) ?></td>
                    <td><?= number_format(round($row->gross_salary),0) ?></td>
                    <td><?= number_format(round($row->tax_deduction),0) ?></td>
                    <td><?= number_format(round($row->pf_deduction),0) ?></td>
                    <td><?= number_format(intval($leave_deduct),0) ?></td>
                    <td><?= number_format(intval($late_deduct),0) ?></td>
                    
                    <td><?= number_format(round($row->net_salary),0) ?></td>
                </tr>
            <?php endwhile; ?>
            <!-- Totals Row -->
            <tr class="totals-row">
                <td>Total</td>
                <td><?= number_format($total_basic,0) ?></td>
                <td><?= number_format($total_hra,0) ?></td>
                <td><?= number_format($total_medical,0) ?></td>
                <td><?= number_format($total_tax,0) ?></td>
                <td><?= number_format($total_pf,0) ?></td>
                <td><?= number_format(($total_leave_deduct ?? 0),0) ?></td>
                <td><?= number_format(($total_late_deduct ?? 0),0) ?></td>
                <td><?= number_format($total_gross,0) ?></td>
                <td><?= number_format($total_net,0) ?></td>
            </tr>
            <?php else: ?>
                <tr><td colspan="8">No employee salary data found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

</body>
</html>
