<?php
// ---------------- FILTER INPUT ----------------
$selectedYear = htmlspecialchars($_GET['year'] ?? '', ENT_QUOTES);
$selectedEmp  = htmlspecialchars($_GET['emp_id'] ?? '', ENT_QUOTES);

// Fetch All Employees
$employees = Employee::all();

// 🔒 DEFAULT: no data
if (!empty($selectedYear) || !empty($selectedEmp)) {
    $leave_assign_all = LeaveAssign::all();
} else {
    $leave_assign_all = [];
}

// ---------------- APPLY FILTER ----------------
$leave_assign = array_filter($leave_assign_all, function($la) use ($selectedYear, $selectedEmp) {
    if ($selectedYear != '' && $la->year != $selectedYear) return false;
    if ($selectedEmp != '' && $la->emp_id != $selectedEmp) return false;
    return true;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Remaining Leave Summary</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f5f7fa;
    padding: 20px;
    margin:0;
}
h2 {
    text-align: center;
    color: #0d6efd;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* -------- FILTER FORM -------- */
.filter-box {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.filter-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 150px;
    min-width: 150px;
}

.filter-group label {
    font-weight: 500;
    margin-bottom: 6px;
    color: #333;
    font-size: 14px;
}

.filter-group select,
.filter-group button {
    padding: 10px 12px;
    font-size: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
    transition: all 0.3s ease;
}

.filter-group select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}

.filter-group button {
    background-color: #0d6efd;
    color: #fff;
    border: none;
    cursor: pointer;
    margin-top: 20px;
}

.filter-group button:hover {
    background-color: #0b5ed7;
}

/* -------- TABLE -------- */
.table-responsive { overflow-x:auto; margin-top:20px; }

.table-responsive table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    font-family:'Poppins',sans-serif;
    background:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.table-responsive table th{
    font-weight:700;
    text-align:center;
    background-color:#1f3d79ff;
    color:#ffffff;
    padding:12px;
    font-size:16px;
    border:1px solid #fff;
}

.table-responsive table td{
    text-align:center;
    vertical-align:middle;
    padding:10px;
    font-size:15px;
    color:#000;
    word-wrap:break-word;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
    border:1px solid #ccc;
}

.table-responsive table tr:nth-child(even){
    background: #f9f9f9;
}

.table-responsive table tr:hover{
    background:#f1f5f9;
    transition:.2s;
}

@media(max-width:768px){
    .filter-box { flex-direction: column; gap: 15px; }
    .table-responsive table th,
    .table-responsive table td{
        font-size:14px;
        padding:8px;
    }
}
</style>
</head>
<body>

<h2>Leave Summary Report</h2>

<!-- ================= FILTER FORM ================= -->
<form method="GET" class="filter-box">
    <div class="filter-group">
        <label for="year">Year</label>
        <select id="year" name="year">
            <option value="">All Year</option>
            <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                <option value="<?= $y ?>" <?= ($selectedYear == $y) ? 'selected' : '' ?>>
                    <?= $y ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="filter-group">
        <label for="emp_id">Employee</label>
        <select id="emp_id" name="emp_id">
            <option value="">All Employee</option>
            <?php foreach($employees as $emp): ?>
                <option value="<?= htmlspecialchars($emp->id) ?>" <?= ($selectedEmp == $emp->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($emp->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="filter-group" style="align-self:flex-end;">
        <button type="submit">Search</button>
    </div>
</form>

<!-- ================= TABLE ================= -->
<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Leave Type</th>
            <th>Allowed</th>
            <th>Used</th>
            <th>Remaining</th>
            <th>Year</th>
        </tr>
    </thead>

    <tbody>
    <?php if(!empty($leave_assign)): ?>
        <?php foreach($leave_assign as $la): 
            $employee  = Employee::find($la->emp_id);
            $leaveType = LeaveType::find($la->leave_type_id);
            $remaining = $la->allow_days - $la->used_days;
        ?>
        <tr>
            <td><?= htmlspecialchars($employee->name ?? 'Unknown') ?></td>
            <td><?= htmlspecialchars($leaveType->name ?? 'Unknown') ?></td>
            <td><?= $la->allow_days ?></td>
            <td><?= $la->used_days ?></td>
            <td style="color: <?= ($remaining < 0) ? 'red' : 'black' ?>;"><?= $remaining ?></td>
            <td><?= $la->year ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No data found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

</body>
</html>
