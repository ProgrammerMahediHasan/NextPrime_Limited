<?php
// payroll_summary.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hrm";

// Database connection
$db = new mysqli($host, $user, $pass, $dbname);
if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

// Employee filter
$emp_id = isset($_GET['emp_id']) ? intval($_GET['emp_id']) : -1; // -1 means form not submitted

// Fetch employees for dropdown
$emp_query = "SELECT id, name FROM rt_employees ORDER BY name ASC";
$emp_result = $db->query($emp_query);

// Only fetch payroll summary if form submitted
$showReport = ($emp_id >= 0);
$result = null;

if($showReport){
    $filter_sql = ($emp_id > 0) ? "WHERE e.id = $emp_id" : "";
    $query = "
        SELECT 
            e.id AS emp_id,
            e.name AS emp_name,
            COALESCE(MAX(es.basic_salary),0) AS basic_salary,
            COALESCE(MAX(es.hra),0) AS hra,
            COALESCE(MAX(es.medical_allowance),0) AS medical_allowance,
            COALESCE(MAX(es.tax_deduction),0) AS tax_deduction,
            COALESCE(MAX(es.pf_deduction),0) AS pf_deduction,
            COALESCE(MAX(es.gross_salary),0) AS gross_salary,
            COALESCE(MAX(es.net_salary),0) AS net_salary
        FROM rt_employees e
        LEFT JOIN rt_employee_salary es ON e.id = es.emp_id
        $filter_sql
        GROUP BY e.id, e.name
        ORDER BY e.name ASC
    ";
    $result = $db->query($query);
}

$db->close();
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
                <option value="0" <?= ($emp_id === 0) ? "selected" : "" ?>>All Employees</option>
                <?php while($emp = $emp_result->fetch_assoc()): 
                    $selected = ($emp['id'] == $emp_id) ? "selected" : ""; ?>
                    <option value="<?= $emp['id'] ?>" <?= $selected ?>><?= htmlspecialchars($emp['name']) ?></option>
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
                <th>Basic Salary</th>
                <th>HRA</th>
                <th>Medical</th>
                <th>Tax</th>
                <th>PF</th>
                <th>Gross Salary</th>
                <th>Net Salary</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_basic = $total_hra = $total_medical = $total_tax = $total_pf = $total_gross = $total_net = 0;

            if($result->num_rows > 0):
                while($row = $result->fetch_assoc()):
                    $total_basic += $row['basic_salary'];
                    $total_hra += $row['hra'];
                    $total_medical += $row['medical_allowance'];
                    $total_tax += $row['tax_deduction'];
                    $total_pf += $row['pf_deduction'];
                    $total_gross += $row['gross_salary'];
                    $total_net += $row['net_salary'];
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['emp_name']) ?></td>
                    <td><?= number_format($row['basic_salary'],2) ?></td>
                    <td><?= number_format($row['hra'],2) ?></td>
                    <td><?= number_format($row['medical_allowance'],2) ?></td>
                    <td><?= number_format($row['tax_deduction'],2) ?></td>
                    <td><?= number_format($row['pf_deduction'],2) ?></td>
                    <td><?= number_format($row['gross_salary'],2) ?></td>
                    <td><?= number_format($row['net_salary'],2) ?></td>
                </tr>
            <?php endwhile; ?>
            <!-- Totals Row -->
            <tr class="totals-row">
                <td>Total</td>
                <td><?= number_format($total_basic,2) ?></td>
                <td><?= number_format($total_hra,2) ?></td>
                <td><?= number_format($total_medical,2) ?></td>
                <td><?= number_format($total_tax,2) ?></td>
                <td><?= number_format($total_pf,2) ?></td>
                <td><?= number_format($total_gross,2) ?></td>
                <td><?= number_format($total_net,2) ?></td>
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
