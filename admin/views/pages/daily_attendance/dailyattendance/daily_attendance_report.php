<?php
ob_start();
global $db, $tx;

$report_date = isset($_GET['date']) ? $_GET['date'] : '';
$selected_emp = isset($_GET['emp_id']) ? $_GET['emp_id'] : '';

$employees = $db->query("SELECT id, name FROM {$tx}employees ORDER BY name ASC");

// Only fetch data if Search button clicked
$result = null;
if($report_date){
    $where_date = "d.att_date = '$report_date'";
    $where_emp = $selected_emp ? "AND e.id = '$selected_emp'" : "";

    $sql = "
        SELECT e.id AS emp_id, e.name AS emp_name, 
               d.att_date, d.in_time, d.out_time, 
               d.total_work_minutes, d.status, d.late_minutes, d.overtime_minutes
        FROM {$tx}employees e
        LEFT JOIN {$tx}daily_attendance d 
               ON e.id = d.emp_id AND $where_date
        WHERE 1=1 $where_emp
        ORDER BY e.name ASC
    ";
    $result = $db->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Daily Attendance Report</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
body { font-family: 'Poppins', sans-serif; padding:20px; background:#f5f7fa; }

h1 { text-align:center; color:#0d3b66; margin-bottom:30px; font-weight:700; }

.filter .card {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    background: #fff;
}
.filter label { font-weight: 600; }
.filter button { 
    background: linear-gradient(135deg,#0d6efd,#004bba); 
    color:#fff; border:none; font-weight:600; 
}

.attendance-table { width:100%; border-collapse:collapse; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
.attendance-table th, .attendance-table td { border:1px solid #d0d0d0; padding:12px; text-align:center; }
.attendance-table th { background: linear-gradient(135deg,#122f4ee7,#1c3046e7); color:#fff; font-weight:bold; }
.attendance-table tr:nth-child(even) { background:#f9faff; }
.attendance-table tr:hover td { background:#eef5ff; transition:0.3s; }

/* 🔴 Only Absent status will be red */
.status-absent{
    color:#dc3545;
    font-weight:700;
}
</style>
</head>
<body>

<h1>Employee Daily Attendance<?= $report_date ? " - ".date("d-M-Y", strtotime($report_date)) : "" ?></h1>

<div class="filter mb-4">
    <div class="card p-4" style="max-width:950px; margin:auto;">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Employee</label>
                <select name="emp_id" class="form-select">
                    <option value="">All Employees</option>
                    <?php while($emp = $employees->fetch_object()): ?>
                        <option value="<?= $emp->id ?>" <?= ($selected_emp == $emp->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($emp->name) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Select Date</label>
                <input type="date" name="date" value="<?= $report_date ?>" class="form-control">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Search</button>
            </div>
        </form>
    </div>
</div>

<?php if($report_date): ?>
<div class="table-responsive">
<table class="attendance-table">
    <thead>
        <tr>
            <th>Emp ID</th>
            <th>Employee Name</th>
            <th>Date</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Total Work Minutes</th>
            <th>Status</th>
            <th>Late Minutes</th>
            <th>Overtime Minutes</th>
        </tr>
    </thead>
    <tbody>
        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_object()): 
                $isAbsent = strtolower($row->status ?? 'absent') === 'absent';
            ?>
            <tr>
                <td><?= $row->emp_id ?></td>
                <td><?= $row->emp_name ?></td>
                <td><?= $row->att_date ? date("d-M-Y", strtotime($row->att_date)) : "0" ?></td>
                <td><?= $row->in_time ?? "0" ?></td>
                <td><?= $row->out_time ?? "0" ?></td>
                <td><?= $row->total_work_minutes ?? "0" ?></td>
                <td class="<?= $isAbsent ? 'status-absent' : '' ?>">
                    <?= $row->status ?? "Absent" ?>
                </td>
                <td><?= $row->late_minutes ?? "0" ?></td>
                <td><?= $row->overtime_minutes ?? "0" ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center">No data found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
<?php endif; ?>

</body>
</html>
