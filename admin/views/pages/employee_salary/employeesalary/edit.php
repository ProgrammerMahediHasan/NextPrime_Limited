<?php
echo Page::body_open();
echo Page::context_open();
echo Form::open(["route"=>"employeesalary/update"]);
?>

<?php
global $db, $tx;
$empId = intval($employeesalary->emp_id ?? 0);
$currentYear = date("Y");
$salaryDays = 0.0;
$balanceOverflow = 0.0;
if ($empId > 0) {
    $q1 = $db->query("
        SELECT COALESCE(SUM(lr.total_days),0) AS salary_days
        FROM {$tx}leave_request lr
        LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
        WHERE lr.emp_id = {$empId}
          AND YEAR(lr.start_date) = '{$currentYear}'
          AND lr.status = 'Approved'
          AND lt.deduct_apply = 1
    ");
    if ($q1) {
        $r1 = $q1->fetch_object();
        $salaryDays = floatval($r1->salary_days);
    }
    $q2 = $db->query("
        SELECT la.allow_days, la.used_days
        FROM {$tx}leave_assign la
        LEFT JOIN {$tx}leave_types lt ON lt.id = la.leave_type_id
        WHERE la.emp_id = {$empId}
          AND la.year = '{$currentYear}'
          AND lt.deduct_apply = 0
    ");
    if ($q2) {
        while($ra = $q2->fetch_object()){
            $balanceOverflow += max(0.0, floatval($ra->used_days) - floatval($ra->allow_days));
        }
    }
}
$perDayRate = round((floatval($employeesalary->basic_salary ?? 0) / 30), 2);
$autoLeaveDeduct = round(($salaryDays + $balanceOverflow) * $perDayRate, 2);
// Late deduct bootstrap (yearly; 3 Late = 1 day)
$lateCountInit = 0;
if ($empId > 0) {
    $qLate = $db->query("SELECT COUNT(*) cnt FROM {$tx}daily_attendance WHERE emp_id={$empId} AND YEAR(att_date)='{$currentYear}' AND late_minutes > 0");
    if ($qLate) {
        $rLate = $qLate->fetch_row();
        $lateCountInit = intval($rLate[0] ?? 0);
    }
}
$autoLateDeduct = round(floor($lateCountInit / 3) * $perDayRate, 2);
?>

<style>
    /* ===== Container ===== */
    .salary-form {
        width: 100%;
        max-width: 900px;
        margin: 40px auto;
        background-color: #e6f0ff;
        border-radius: 15px;
        padding: 30px 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        font-family: "Poppins", sans-serif;
    }

    .salary-form h3 {
        text-align: center;
        color: #004aad;
        font-weight: 700;
        margin-bottom: 25px;
        text-transform: uppercase;
    }

    /* ===== Table ===== */
    .salary-table {
        width: 100%;
        border-collapse: collapse;
    }

    .salary-table th {
        background-color: #007bff;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    .salary-table td {
        background-color: #cce0ff;
        padding: 10px;
        border-bottom: 2px solid #b3d1ff;
    }

    .salary-table tr:hover td {
        background-color: #99c2ff;
    }

    .salary-table input,
    .salary-table select {
        width: 100%;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        outline: none;
        background-color: #f5f5f5;
    }

    .salary-table input:focus,
    .salary-table select:focus {
        border-color: #004aad;
        box-shadow: 0 0 5px rgba(0, 74, 173, 0.4);
        background-color: #ffffff;
    }

    .btn-submit {
        display: block;
        margin: 25px auto 0;
        padding: 10px 25px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        background-color: #004aad;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background-color: #007bff;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 15px;
        padding: 8px 15px;
        background-color: #6c757d;
        color: #fff;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
    }
    .btn-back:hover { background-color: #5a6268; }
</style>

<div class="salary-form">
    <a href="<?= $base_url ?>/employeesalary" class="btn-back">&larr; Back</a>
    <h3>Edit Employee Salary</h3>
    <div style="display:flex;gap:10px;align-items:center;margin-bottom:15px;">
        <!-- <input type="month" id="payslip_month" value="<?= date('Y-m') ?>" style="padding:8px;border-radius:6px;border:1px solid #ccc;">
        <a id="btn_generate_payslip" class="btn-submit" target="_blank" href="<?= $base_url ?>/employeesalary/payslip?employee_id=<?= intval($employeesalary->emp_id) ?>&salary_month=<?= date('Y-m') ?>">Generate Payslip</a> -->
    </div>
    <table class="salary-table">
        <!-- Hidden ID -->
        <input type="hidden" name="id" value="<?= $employeesalary->id ?>">

        <tr>
            <th>Employee</th>
            <td>
                <?php
                global $db, $tx;
                $res = $db->query("SELECT id,name FROM {$tx}employees ORDER BY name ASC");
                echo "<select name='emp_id' id='emp_id' class='form-select' style='width:100%'>";
                echo "<option value=''>Select Employee</option>";
                $curr = intval($employeesalary->emp_id ?? 0);
                while(list($id,$name) = $res->fetch_row()){
                    $sel = ($id==$curr) ? "selected" : "";
                    echo "<option value='{$id}' {$sel}>{$name}</option>";
                }
                echo "</select>";
                ?>
            </td>
        </tr>
        <tr>
            <th>Basic Salary</th>
            <td><input type="number" id="basic_salary" name="basic_salary" step="0.01" value="<?= $employeesalary->basic_salary ?>"></td>
        </tr>
        <tr>
            <th>HRA</th>
            <td><input type="number" id="hra" name="hra" step="0.01" value="<?= $employeesalary->hra ?>"></td>
        </tr>
        <tr>
            <th>Medical Allowance</th>
            <td><input type="number" id="medical_allowance" name="medical_allowance" step="0.01" value="<?= $employeesalary->medical_allowance ?>"></td>
        </tr>
        <tr>
            <th>Tax Deduction</th>
            <td><input type="number" id="tax_deduction" name="tax_deduction" step="0.01" value="<?= $employeesalary->tax_deduction ?>"></td>
        </tr>
        <tr>
            <th>PF Deduction</th>
            <td><input type="number" id="pf_deduction" name="pf_deduction" step="0.01" value="<?= $employeesalary->pf_deduction ?>"></td>
        </tr>
        <tr style="display:none">
            <th>Leave Deduct</th>
            <td><input type="number" id="deduct_leave" name="deduct_leave" step="1" value="<?= number_format(round($autoLeaveDeduct),0,'.','') ?>" readonly></td>
        </tr>
        <tr style="display:none">
            <th>Late Deduct</th>
            <td><input type="number" id="deduct_late" name="deduct_late" step="1" value="<?= number_format(round($autoLateDeduct),0,'.','') ?>" readonly></td>
        </tr>
        <tr>
            <th>Gross Salary</th>
            <td><input type="number" id="gross_salary" name="gross_salary" value="<?= $employeesalary->gross_salary ?>" readonly></td>
        </tr>
        <tr>
            <th>Net Salary</th>
            <td><input type="number" id="net_salary" name="net_salary" value="<?= $employeesalary->net_salary ?>" readonly></td>
        </tr>
    </table>

    <input type="submit" name="update" value="Save Changes" class="btn-submit">
</div>

<?php
echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>

<!-- <div style="max-width:900px;margin:10px auto 0;padding:12px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-family:'Poppins',sans-serif;">
    <strong style="color:#0f172a;">Leave Deduction Summary (<?= htmlspecialchars($currentYear) ?>)</strong>
    <div style="display:flex;gap:14px;margin-top:8px;flex-wrap:wrap;">
        <div style="background:#fee2e2;padding:8px 10px;border-radius:8px;">Salary-type days: <b><?= number_format($salaryDays,2) ?></b></div>
        <div style="background:#fde68a;padding:8px 10px;border-radius:8px;">Balance overflow days: <b><?= number_format($balanceOverflow,2) ?></b></div>
        <div style="background:#dcfce7;padding:8px 10px;border-radius:8px;">Per-day rate: <b><?= number_format($perDayRate,2) ?></b></div>
        <div style="background:#f5d0fe;padding:8px 10px;border-radius:8px;">Auto deduct ((Salary + Overflow) × Per-day): <b><?= number_format(round($autoLeaveDeduct),0) ?></b></div>
    </div>
    <small style="display:block;margin-top:6px;color:#64748b;">Note: Salary টাইপে সব দিন deduct হয়; Leave Balance টাইপে overflow দিন deduct হয়।</small>
</div> -->

<script>
const baseUrl = "<?= $base_url ?>";
let leaveDeductAmt = <?= number_format(round($autoLeaveDeduct),0,'.','') ?>;
let lateDeductAmt = <?= number_format(round($autoLateDeduct),0,'.','') ?>;
function calculateSalary() {
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const hra = parseFloat(document.getElementById('hra').value) || 0;
    const medical = parseFloat(document.getElementById('medical_allowance').value) || 0;
    const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
    const pf = parseFloat(document.getElementById('pf_deduction').value) || 0;
    const leaveDeduct = leaveDeductAmt || 0;
    const lateDeduct = lateDeductAmt || 0;

    const gross = Math.round(basic + hra + medical);
    const net = Math.round(gross - (tax + pf + leaveDeduct + lateDeduct));

    document.getElementById('gross_salary').value = String(gross);
    document.getElementById('net_salary').value = String(net);
    const dl = document.getElementById('deduct_leave'); if (dl) dl.value = String(Math.round(leaveDeduct));
    const dlt = document.getElementById('deduct_late'); if (dlt) dlt.value = String(Math.round(lateDeduct));
}

// Add event listeners
['basic_salary','hra','medical_allowance','tax_deduction','pf_deduction'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculateSalary);
});

function updateLeaveDeductEdit() {
    const empInput = document.querySelector("[name='emp_id']");
    const empId = empInput ? parseInt(empInput.value) || 0 : 0;
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const year = (new Date()).getFullYear();
    if (!empId || !basic) {
        leaveDeductAmt = 0;
        const dl = document.getElementById('deduct_leave'); if (dl) dl.value = "0";
        calculateSalary();
        return;
    }
    fetch(`${baseUrl}/employeesalary/compute_leave_deduct?emp_id=${empId}&basic_salary=${basic}&mode=perday&year=${year}`)
      .then(res => res.json())
      .then(data => {
        const amt = Math.round(parseFloat(data.leave_deduct) || 0);
        leaveDeductAmt = amt;
        const dl = document.getElementById('deduct_leave'); if (dl) dl.value = String(amt);
        calculateSalary();
      })
      .catch(() => {
        calculateSalary();
      });
}

function updateLateDeductEdit() {
    const empInput = document.querySelector("[name='emp_id']");
    const empId = empInput ? parseInt(empInput.value) || 0 : 0;
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const year = (new Date()).getFullYear();
    if (!empId || !basic) {
        lateDeductAmt = 0;
        const dlt = document.getElementById('deduct_late'); if (dlt) dlt.value = "0";
        calculateSalary();
        return;
    }
    fetch(`${baseUrl}/employeesalary/compute_late_deduct?emp_id=${empId}&basic_salary=${basic}&mode=perday&year=${year}`)
      .then(res => res.json())
      .then(data => {
        const amt = Math.round(parseFloat(data.late_deduct) || 0);
        lateDeductAmt = amt;
        const dlt = document.getElementById('deduct_late'); if (dlt) dlt.value = String(amt);
        calculateSalary();
      })
      .catch(() => {
        calculateSalary();
      });
}

document.addEventListener('DOMContentLoaded', () => {
    const empInput = document.querySelector("[name='emp_id']");
    if (empInput) {
        empInput.addEventListener('change', updateLeaveDeductEdit);
        empInput.addEventListener('change', updateLateDeductEdit);
    }
    document.getElementById('basic_salary').addEventListener('input', updateLeaveDeductEdit);
    document.getElementById('basic_salary').addEventListener('input', updateLateDeductEdit);
    const monthInput = document.getElementById('payslip_month');
    const btn = document.getElementById('btn_generate_payslip');
    function updatePayslipLink(){
        const m = monthInput.value || '<?= date('Y-m') ?>';
        const eid = parseInt(document.querySelector("[name='emp_id']").value) || <?= intval($employeesalary->emp_id) ?>;
        btn.href = "<?= $base_url ?>/employeesalary/payslip?employee_id=" + eid + "&salary_month=" + m;
    }
    monthInput.addEventListener('change', updatePayslipLink);
    if (empInput) empInput.addEventListener('change', updatePayslipLink);
    updatePayslipLink();
});
</script>
