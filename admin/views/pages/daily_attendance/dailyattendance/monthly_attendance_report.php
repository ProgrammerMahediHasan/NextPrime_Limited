<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hrm";

$db = new mysqli($host, $user, $pass, $dbname);
if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

// Initialize variables
$month = $_POST['month'] ?? '';
$year = $_POST['year'] ?? '';
$attendance = [];
$daysInMonth = 0;
$employees = [];

if($month && $year){
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Fetch employees
    $employeesResult = $db->query("SELECT id, name FROM rt_employees ORDER BY name ASC");
    while($e = $employeesResult->fetch_assoc()){
        $employees[$e['id']] = $e['name'];
    }

    // Fetch attendance data
    $attendanceResult = $db->query("
        SELECT emp_id, att_date, status, late_minutes, overtime_minutes
        FROM rt_daily_attendance
        WHERE MONTH(att_date) = $month AND YEAR(att_date) = $year
    ");
    while($row = $attendanceResult->fetch_assoc()){
        $day = (int)date('j', strtotime($row['att_date']));
        $attendance[$row['emp_id']][$day] = $row;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monthly Attendance Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', sans-serif; background: #f7f9fc; padding: 25px; }
h2 { text-align: center; color: #0d6efd; margin-bottom: 25px; }
.table-responsive { overflow-x:auto; }
table { border-collapse: collapse; width:100%; font-size: 13px; }
th, td { border:1px solid #ddd; padding:6px; text-align:center; min-width:35px; }
th { background:#0d6efd; color:#fff; position: sticky; top: 0; z-index:2; font-weight:600; }
td.present { background:#d4edda; color:#155724; font-weight:bold; }
td.absent { background:#f8d7da; color:#721c24; font-weight:bold; }
td.leave { background:#fff3cd; color:#856404; font-weight:bold; }
td.Weekend { background:#e2e3e5; color:#495057; font-weight:bold; }
.late-cell { background:#fff8e1; color:#856404; font-weight:bold; font-size:11px; }
.ot-cell { background:#e0f3ff; color:#0d6efd; font-weight:bold; font-size:11px; }
.summary { font-weight:bold; background:#e2e3e5; }
tr:hover td { background:#f1f5f9; }
.filter-form { margin-bottom: 20px; text-align:center; }
.off-day { background:#d6d8d9; color:#495057; font-weight:bold; font-style:italic; }
</style>
</head>
<body>

<h2>Monthly Attendance Report</h2>

<!-- Filter Form -->
<form method="post" class="filter-form row justify-content-center g-2">
    <div class="col-auto">
        <label for="month" class="form-label fw-bold">Select Month:</label>
        <input type="month" id="month" name="month_year" class="form-control" 
               value="<?= ($month && $year) ? sprintf('%04d-%02d',$year,$month) : '' ?>">
        <input type="hidden" id="monthInput" name="month" value="<?= $month ?>">
        <input type="hidden" id="yearInput" name="year" value="<?= $year ?>">
    </div>
    <div class="col-auto align-self-end">
        <button type="submit" class="btn btn-primary">Show Attendance</button>
    </div>
</form>

<script>
const monthYearInput = document.querySelector('input[name="month_year"]');
const monthInput = document.getElementById('monthInput');
const yearInput = document.getElementById('yearInput');
monthYearInput.addEventListener('change', function(){
    const parts = this.value.split('-');
    monthInput.value = parts[1];
    yearInput.value = parts[0];
});
</script>

<?php if($month && $year && !empty($employees)): ?>
<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>Employee Name</th>
            <?php for($d=1; $d<=$daysInMonth; $d++):
                $weekday = date('D', strtotime("$year-$month-$d"));
                $weekendClass = ($weekday == 'Fri') ? 'Weekend' : '';
                echo "<th class='$weekendClass'>$d<br><small>$weekday</small></th>";
            endfor; ?>
            <th class="summary">Total P</th>
            <th class="summary">Total A</th>
            <th class="summary">Total L</th>
            <th class="summary">Late (min)</th>
            <th class="summary">OT (min)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employees as $emp_id => $emp_name): 
            $totalPresent = $totalAbsent = $totalLeave = $totalLate = $totalOvertime = 0;
        ?>
        <tr>
            <td rowspan="3" style="vertical-align:middle; font-weight:bold;"><?= htmlspecialchars($emp_name) ?></td>
            <?php for($d=1; $d<=$daysInMonth; $d++):
                $weekday = date('D', strtotime("$year-$month-$d"));
                $cell = $attendance[$emp_id][$d] ?? null;

                if ($weekday == 'Fri') {
                    echo "<td class='off-day' rowspan='3'>Off Day</td>";
                    continue;
                }

                $status = $cell['status'] ?? 'Absent';
                $late = $cell['late_minutes'] ?? 0;
                $ot = $cell['overtime_minutes'] ?? 0;

                if(strtolower($status)=='present') $totalPresent++;
                if(strtolower($status)=='absent') $totalAbsent++;
                if(strtolower($status)=='leave') $totalLeave++;
                $totalLate += $late;
                $totalOvertime += $ot;

                $statusClass = strtolower($status);
                $displayStatus = strtoupper(substr($status,0,1));
                echo "<td class='$statusClass'>$displayStatus</td>";
            endfor; ?>
            <td class="summary" rowspan="3"><?= $totalPresent ?></td>
            <td class="summary" rowspan="3"><?= $totalAbsent ?></td>
            <td class="summary" rowspan="3"><?= $totalLeave ?></td>
            <td class="summary" rowspan="3"><?= $totalLate ?></td>
            <td class="summary" rowspan="3"><?= $totalOvertime ?></td>
        </tr>

        <!-- Late Row -->
        <tr>
            <?php for($d=1; $d<=$daysInMonth; $d++):
                $weekday = date('D', strtotime("$year-$month-$d"));
                if ($weekday == 'Fri') continue;
                $cell = $attendance[$emp_id][$d] ?? null;
                $late = $cell['late_minutes'] ?? 0;
                echo $late > 0 ? "<td class='late-cell'>L: {$late}m</td>" : "<td></td>";
            endfor; ?>
        </tr>

        <!-- Overtime Row -->
        <tr>
            <?php for($d=1; $d<=$daysInMonth; $d++):
                $weekday = date('D', strtotime("$year-$month-$d"));
                if ($weekday == 'Fri') continue;
                $cell = $attendance[$emp_id][$d] ?? null;
                $ot = $cell['overtime_minutes'] ?? 0;
                echo $ot > 0 ? "<td class='ot-cell'>OV: {$ot}m</td>" : "<td></td>";
            endfor; ?>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>

</body>
</html>
