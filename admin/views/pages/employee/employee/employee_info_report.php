<?php
// echo Page::body_open();
// echo Page::context_open();

global $db, $tx;

// Fetch all employees for dropdown
$allEmployees = $db->query("SELECT id, name FROM {$tx}employees ORDER BY id ASC");
$allDepartments = $db->query("SELECT id, name FROM {$tx}department ORDER BY name ASC");
$allDesignations = $db->query("SELECT id, name FROM {$tx}designations ORDER BY name ASC");

// Handle filter by employee
$emp_id = $_GET['emp_id'] ?? '';
$dept_id = $_GET['dept_id'] ?? '';
$desig_id = $_GET['desig_id'] ?? '';
$status = $_GET['status'] ?? '';
$q = $_GET['q'] ?? '';

// Determine if report should be shown
$showReport = isset($_GET['emp_id']); // Only show after clicking View Report

// Build SQL based on filter
$filter_sql = '';
if($showReport){
    $conds = [];
    if($emp_id !== '' && $emp_id != '0'){ $conds[] = "e.id = ".intval($emp_id); }
    if($dept_id !== '' && $dept_id != '0'){ $conds[] = "e.dept_id = ".intval($dept_id); }
    if($desig_id !== '' && $desig_id != '0'){ $conds[] = "e.desig_id = ".intval($desig_id); }
    if($status !== ''){ $conds[] = "e.status = '".$db->real_escape_string($status)."'"; }
    if($q !== ''){ $qs = $db->real_escape_string($q); $conds[] = "(e.name LIKE '%$qs%' OR e.email LIKE '%$qs%' OR e.phone LIKE '%$qs%')"; }
    if(count($conds)>0){ $filter_sql = "WHERE ".implode(" AND ", $conds); }
}

// Fetch employee(s) info only if form submitted
$employees = null;
if($showReport){
    $employees = $db->query("
        SELECT 
            e.id, 
            e.name, 
            d.name AS department, 
            ds.name AS designation, 
            e.gender, 
            e.email, 
            e.phone, 
            COALESCE(es.basic_salary, 0) AS basic_salary, 
            e.status, 
            e.joining_date
        FROM {$tx}employees e
        LEFT JOIN {$tx}department d ON e.dept_id = d.id
        LEFT JOIN {$tx}designations ds ON e.desig_id = ds.id
        LEFT JOIN (
            SELECT s.emp_id, s.basic_salary
            FROM {$tx}employee_salary s
            INNER JOIN (
                SELECT emp_id, MAX(id) AS max_id
                FROM {$tx}employee_salary
                GROUP BY emp_id
            ) m ON m.max_id = s.id
        ) es ON es.emp_id = e.id
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
        <div class="col-md-3">
            <label for="emp_id" class="form-label fw-bold">Employee</label>
            <select name="emp_id" id="emp_id" class="form-select">
                <option value="0" <?= ($emp_id==='0' || $emp_id==='') ? 'selected' : '' ?>>All Employees</option>
                <?php while($row = $allEmployees->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($emp_id == $row['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="dept_id" class="form-label fw-bold">Department</label>
            <select name="dept_id" id="dept_id" class="form-select">
                <option value="0" <?= ($dept_id==='0' || $dept_id==='') ? 'selected' : '' ?>>All Departments</option>
                <?php while($d = $allDepartments->fetch_assoc()): ?>
                    <option value="<?= $d['id'] ?>" <?= ($dept_id == $d['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="desig_id" class="form-label fw-bold">Designation</label>
            <select name="desig_id" id="desig_id" class="form-select">
                <option value="0" <?= ($desig_id==='0' || $desig_id==='') ? 'selected' : '' ?>>All Designations</option>
                <?php while($ds = $allDesignations->fetch_assoc()): ?>
                    <option value="<?= $ds['id'] ?>" <?= ($desig_id == $ds['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ds['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label fw-bold">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="" <?= ($status==='') ? 'selected' : '' ?>>All Status</option>
                <option value="Active" <?= ($status==='Active') ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= ($status==='Inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="q" class="form-label fw-bold">Search</label>
            <input type="text" name="q" id="q" value="<?= htmlspecialchars($q) ?>" class="form-control" placeholder="Search by name, email, phone">
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
                                            echo '৳'.number_format($row[$key],2);
                                        } elseif ($key == 'status') {
                                            $status_class = strtolower($row[$key]) === 'active' ? 'bg-success' : 'bg-danger';
                                            echo "<span class='badge {$status_class} text-white' style='font-size:0.78rem; padding:6px 10px;'>"
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
