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

// Month & Year
$month = isset($_GET['month']) ? $_GET['month'] : '';
$year  = isset($_GET['year']) ? $_GET['year'] : '';

// Only fetch summary if form submitted
$showSummary = isset($_GET['month']) && isset($_GET['year']);

$result = null;
if($showSummary){
    $month = (int)$month;
    $year  = (int)$year;

    $query = "
    SELECT 
        e.id as emp_id,
        e.name as emp_name,
        SUM(CASE WHEN LOWER(d.status)='present' THEN 1 ELSE 0 END) as total_attendance,
        SUM(COALESCE(d.late_minutes,0)) as total_late,
        SUM(COALESCE(d.overtime_minutes,0)) as total_overtime,
        SUM(CASE WHEN LOWER(d.status)='absent' THEN 1 ELSE 0 END) as total_absent,
        SUM(CASE WHEN LOWER(d.status)='leave' THEN 1 ELSE 0 END) as total_leave
    FROM rt_employees e
    LEFT JOIN rt_daily_attendance d 
        ON e.id = d.emp_id 
        AND MONTH(d.att_date) = $month 
        AND YEAR(d.att_date) = $year
    GROUP BY e.id, e.name
    ORDER BY e.name ASC";

    $result = $db->query($query);
}

$db->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Monthly Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background:#f5f6fa; }
        h2 { text-align:center; margin-bottom:30px; color:#0d3b66; }

        .filter-card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08); margin-bottom:30px; }
        .form-label { font-weight:600; color:#122f4e; }
        .btn-primary { background: linear-gradient(135deg,#0d6efd,#004bba); border:none; }

        .summary-table { width:100%; border-collapse:collapse; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        .summary-table th, .summary-table td { border:1px solid #d0d0d0; padding:12px; text-align:center; }
        .summary-table th { background:#122f4e; color:#fff; }

        .summary-table tr:nth-child(even){ background:#f9faff; }

        .totals-row td { font-weight:700; color:green; }

        /* red color only when absent > 0 */
        .absent-red{
            color:#dc3545;
            font-weight:700;
        }
    </style>
</head>
<body class="p-4">

<h2>Employee Attendance Summary Report</h2>

<div class="filter-card container">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Select Month:</label>
            <select name="month" class="form-select" required>
                <?php
                for($m=1; $m<=12; $m++){
                    $selected = ($m == $month) ? "selected" : "";
                    echo "<option value='$m' $selected>".date("F", mktime(0,0,0,$m,1))."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Select Year:</label>
            <select name="year" class="form-select" required>
                <?php
                $currentYear = date("Y");
                for($y=$currentYear-5; $y<=$currentYear; $y++){
                    $selected = ($y == $year) ? "selected" : "";
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary w-100">Generate Summary</button>
        </div>
    </form>
</div>

<?php if($showSummary): ?>
<div class="table-responsive container">
    <table class="summary-table">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Total Present</th>
                <th>Total Late</th>
                <th>Total Overtime</th>
                <th>Total Absent</th>
                <th>Total Leave</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result && $result->num_rows > 0):
            $total_present=$total_late=$total_overtime=$total_absent=$total_leave=0;

            while($row = $result->fetch_assoc()):
                $total_present += $row['total_attendance'];
                $total_late += $row['total_late'];
                $total_overtime += $row['total_overtime'];
                $total_absent += $row['total_absent'];
                $total_leave += $row['total_leave'];

                $absentClass = ($row['total_absent'] > 0) ? 'absent-red' : '';
        ?>
            <tr>
                <td><?= htmlspecialchars($row['emp_name']) ?></td>
                <td><?= $row['total_attendance'] ?></td>
                <td><?= $row['total_late'] ?></td>
                <td><?= $row['total_overtime'] ?></td>
                <td class="<?= $absentClass ?>"><?= $row['total_absent'] ?></td>
                <td><?= $row['total_leave'] ?></td>
            </tr>
        <?php endwhile; 
            $totalAbsentClass = ($total_absent > 0) ? 'absent-red' : '';
        ?>
            <tr class="totals-row">
                <td>Total</td>
                <td><?= $total_present ?></td>
                <td><?= $total_late ?></td>
                <td><?= $total_overtime ?></td>
                <td class="<?= $totalAbsentClass ?>"><?= $total_absent ?></td>
                <td><?= $total_leave ?></td>
            </tr>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No data found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

</body>
</html>
