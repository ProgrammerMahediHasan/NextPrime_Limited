<?php
// echo Page::body_open();
// echo Page::context_open();

global $db, $tx;

// Fetch all employees for dropdown
$allEmployees = $db->query("SELECT id, name FROM {$tx}employees ORDER BY id ASC");

// Handle filter by employee
$emp_id = $_GET['emp_id'] ?? '';

// Determine if report should be shown
$showReport = isset($_GET['emp_id']); // Only show after clicking View Report

// Build SQL based on filter
$filter_sql = '';
if($emp_id !== '' && $emp_id != '0'){ // Specific employee selected
    $emp_id = (int)$emp_id;
    $filter_sql = "WHERE e.id = $emp_id";
}

// Fetch employee(s) info only if form submitted
$employees = null;
if($showReport){
    $employees = $db->query("
        SELECT e.id, e.name, d.name AS department, ds.name AS designation, e.gender, e.email, e.phone, e.basic_salary, e.status, e.joining_date
        FROM {$tx}employees e
        LEFT JOIN {$tx}department d ON e.dept_id = d.id
        LEFT JOIN {$tx}designations ds ON e.desig_id = ds.id
        $filter_sql
        ORDER BY e.id ASC
    ");
}

// Table columns dynamically
$columns = [
    'ID' => 'id',
    'Name' => 'name',
    'Department' => 'department',
    'Designation' => 'designation',
    'Gender' => 'gender',
    'Email' => 'email',
    'Phone' => 'phone',
    'Basic Salary' => 'basic_salary',
    'Status' => 'status',
    'Joining Date' => 'joining_date'
];
?>

<div class="text-center my-4">
    <h2 class="fw-bold text-primary mb-1" style="font-size:1.5rem;">Employee Personal Information Report</h2>
</div>

<!-- Professional Filter Form -->
<div class="mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="emp_id" class="form-label fw-bold">Select Employee:</label>
            <select name="emp_id" id="emp_id" class="form-select">
                <option value="0">All Employees</option>
                <?php while($row = $allEmployees->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($emp_id == $row['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" style="font-size:0.9rem;">View Report</button>
        </div>
    </form>
</div>

<?php if($showReport && $employees): ?>
<div class="card border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-gradient text-white py-2" style="background: linear-gradient(135deg,#0d6efd,#004bba);">
        <h5 class="mb-0" style="font-size:0.95rem;"><i class="bi bi-people-fill"></i> Employees</h5>
    </div>

    <div class="card-body bg-light p-3">
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover table-striped align-middle mb-0" 
                   style="min-width:100%; font-size:0.87rem;">
                <thead class="text-white" style="background: linear-gradient(135deg,#0d6efd,#004bba); position:sticky; top:0; z-index:10;">
                    <tr>
                        <?php foreach($columns as $colName => $key): ?>
                            <th style="font-weight:600; min-width:<?= in_array($key,['name','email','joining_date']) ? '150px' : 'auto' ?>; padding:12px;"><?= $colName ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($employees->num_rows > 0): ?>
                        <?php while($row = $employees->fetch_assoc()): ?>
                            <tr style="font-size:0.85rem;">
                                <?php foreach($columns as $key): ?>
                                    <td style="padding:10px;">
                                        <?php
                                        if ($key == 'basic_salary') {
                                            echo '$'.number_format($row[$key],2);
                                        } elseif ($key == 'status') {
                                            $status_class = strtolower($row[$key]) === 'active' ? 'bg-success' : 'bg-danger';
                                            echo "<span class='badge {$status_class} text-white' style='font-size:0.78rem;'>"
                                                 . ucfirst($row[$key]) . "</span>";
                                        } elseif ($key == 'joining_date') {
                                            echo date("d M Y", strtotime($row[$key]));
                                        } else {
                                            echo htmlspecialchars($row[$key] ?? 'N/A');
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($columns) ?>" class="text-center text-muted py-3" style="font-size:0.82rem;">
                                <i class="bi bi-info-circle"></i> No employees found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
echo Page::context_close();
echo Page::body_close();
?>
