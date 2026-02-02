<?php
echo Page::title(["title" => "Daily Attendance - OUT"]);
echo Page::body_open();
echo Html::link([
    "class" => "btn btn-success mb-3",
    "route" => "dailyattendance",
    "text"  => "← Back to Attendance List"
]);
echo Page::context_open();

global $db, $tx;

// Get selected attendance date or default to today
$att_date = $_POST['att_date'] ?? date("Y-m-d");

// Fetch employees who have IN records for this date and have NOT punched OUT yet
$employees = $db->query("
    SELECT e.id, e.name, da.in_time
    FROM {$tx}employees e
    JOIN {$tx}daily_attendance da ON da.emp_id = e.id
    WHERE da.att_date = '$att_date' AND da.out_time IS NULL
    ORDER BY e.name ASC
");
?>

<style>
.attendance-table { table-layout: fixed; width: 100%; }
.attendance-table th, .attendance-table td { text-align: center; vertical-align: middle; padding: 6px; }
.attendance-table th { background-color: #0d6efd; color: white; }
.attendance-table input[type="checkbox"] { width: 22px; height: 22px; cursor: pointer; margin: auto; display: block; transform: scale(1.2); }
.form-section { background-color: #f8f9fa; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
</style>

<div class="form-section">
    <h3 class="text-center mb-4">Employee Attendance (OUT)</h3>

    <!-- Form to select date -->
    <form method="post" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <label for="att_date" class="form-label fw-bold">Attendance Date:</label>
                <input 
                    type="date" 
                    class="form-control border-primary shadow-sm rounded-3 fw-semibold text-center" 
                    name="att_date" 
                    id="att_date" 
                    value="<?= $att_date ?>" 
                    onchange="this.form.submit()"
                >
            </div>
        </div>
    </form>

    <form action="<?= $base_url ?>/DailyAttendance/outtimesave" method="post">
        <input type="hidden" name="att_date" value="<?= $att_date ?>">

        <table class="table table-bordered table-striped table-hover attendance-table">
            <thead>
                <tr>
                    <th style="width:10%">SL</th>
                    <th style="width:60%">Employee Name</th>
                    <th style="width:15%">Punch OUT</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($employees->num_rows > 0):
                    $sl = 1;
                    while ($emp = $employees->fetch_object()): ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td>
                                <?= htmlspecialchars($emp->name); ?>
                                <input type="hidden" name="attendance[<?= $emp->id; ?>][id]" value="<?= $emp->id; ?>">
                            </td>
                            <td>
                                <input type="checkbox" name="attendance[<?= $emp->id; ?>][p]" value="1">
                            </td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr>
                        <td colspan="3">No employees found for this date.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if($employees->num_rows > 0): ?>
            <div class="text-center mt-3">
                <button name="create" type="submit" class="btn btn-primary px-5 py-2 shadow-sm">Save Attendance</button>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php echo Page::context_close(); ?>
