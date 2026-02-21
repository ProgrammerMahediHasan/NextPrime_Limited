<?php
echo Page::body_open();
echo Page::context_open();
echo Form::open(["route"=>"employeesalary/save"]);
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
    .section-title {
        font-weight: 700;
        color: #0d3b66;
        padding: 8px 10px;
        background: #e2e8f0;
        border-radius: 8px;
        margin: 6px 0 4px 0;
    }
    .num { text-align: right; font-variant-numeric: tabular-nums; }

    .btn-submit {
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
</style>

<div class="salary-form">
    <h3>Employee Salary Entry</h3>
    <div style="display:flex;gap:10px;align-items:center;margin-bottom:15px;">
        <!-- <input type="month" id="payslip_month" value="<?= date('Y-m') ?>" style="padding:8px;border-radius:6px;border:1px solid #ccc;"> -->
        <!-- <a id="btn_generate_payslip" class="btn-submit" target="_blank" href="javascript:void(0)">Generate Payslip</a> -->
    </div>

    <table class="salary-table">
        <tr>
            <th>Employee</th>
            <td>
                <?php
                global $db, $tx;
                $res = $db->query("SELECT id,name FROM {$tx}employees ORDER BY name ASC");
                echo "<select name='emp_id' id='emp_id' class='form-select' style='width:100%'>";
                echo "<option value=''>Select Employee</option>";
                while(list($id,$name) = $res->fetch_row()){
                    echo "<option value='{$id}'>{$name}</option>";
                }
                echo "</select>";
                ?>
            </td>
        </tr>
        <tr>
            <th>Year</th>
            <td>
                <select id="deduct_year" name="deduct_year">
                    <?php
                        $cy = date("Y");
                        for($y = $cy-2; $y <= $cy+1; $y++){
                            $sel = ($y==$cy) ? "selected" : "";
                            echo "<option value='{$y}' {$sel}>{$y}</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <th>Basic Salary</th>
            <td><input type="number" id="basic_salary" name="basic_salary" step="0.01" class="num"></td>
        </tr>

        <tr>
            <th>House Rent</th>
            <td><input type="number" id="hra" name="hra" step="0.01" class="num"></td>
        </tr>

        <tr>
            <th>Medical Allowance</th>
            <td><input type="number" id="medical_allowance" name="medical_allowance" step="0.01" class="num"></td>
        </tr>

        <tr>
            <th>Tax Deduction</th>
            <td><input type="number" id="tax_deduction" name="tax_deduction" step="0.01" class="num"></td>
        </tr>

        <tr>
            <th>PF Deduction</th>
            <td><input type="number" id="pf_deduction" name="pf_deduction" step="0.01" class="num"></td>
        </tr>
        <tr style="display:none">
            <th>Leave Deduct</th>
            <td><input type="number" id="deduct_leave" name="deduct_leave" class="num" value="0" readonly></td>
        </tr>
        <tr style="display:none">
            <th>Late Deduct</th>
            <td><input type="number" id="deduct_late" name="deduct_late" class="num" value="0" readonly></td>
        </tr>

        <tr>
            <th>Gross Salary</th>
            <td><input type="number" id="gross_salary" name="gross_salary" readonly></td>
        </tr>

        <tr>
            <th>Net Salary</th>
            <td><input type="number" id="net_salary" name="net_salary" readonly></td>
        </tr>
    </table>

    <!-- Save + Back Button -->
    <div style="display: flex; justify-content: center; gap: 15px; margin-top: 25px;">
        <a href="javascript:history.back()" class="btn btn-secondary" 
            style="padding: 10px 25px; background: #6c757d; color:white; border-radius:8px; text-decoration:none;">
            Back
        </a>

        <input type="submit" name="create" value="Save Salary" class="btn-submit">
    </div>

</div>

<?php
echo Form::close();
echo Page::context_close();
echo Page::body_close();
?>

<script>
const baseUrl = "<?= $base_url ?>";
let leaveDeductAmt = 0;
let lateDeductAmt = 0;
function calculateSalary() {
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const hra = parseFloat(document.getElementById('hra').value) || 0;
    const medical = parseFloat(document.getElementById('medical_allowance').value) || 0;
    const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
    const pf = parseFloat(document.getElementById('pf_deduction').value) || 0;
    const leaveDeduct = leaveDeductAmt || 0;
    const lateDeduct  = lateDeductAmt || 0;

    const gross = Math.round(basic + hra + medical);
    const net = Math.round(gross - (tax + pf + leaveDeduct + lateDeduct));

    document.getElementById('gross_salary').value = String(gross);
    document.getElementById('net_salary').value = String(net);
    const dlEl = document.getElementById('deduct_leave'); if (dlEl) dlEl.value = String(Math.round(leaveDeduct));
    const dltEl = document.getElementById('deduct_late'); if (dltEl) dltEl.value = String(Math.round(lateDeduct));
}

['basic_salary','hra','medical_allowance','tax_deduction','pf_deduction'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculateSalary);
});

function updateLeaveDeduct() {
    const empInput = document.querySelector("[name='emp_id']");
    const empId = empInput ? parseInt(empInput.value) || 0 : 0;
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const year  = document.getElementById('deduct_year') ? document.getElementById('deduct_year').value : (new Date()).getFullYear();
    if (!empId || !basic) {
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
        // fallback: keep current value
        calculateSalary();
      });
}

function updateLateDeduct() {
    const empInput = document.querySelector("[name='emp_id']");
    const empId = empInput ? parseInt(empInput.value) || 0 : 0;
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const year  = document.getElementById('deduct_year') ? document.getElementById('deduct_year').value : (new Date()).getFullYear();
    if (!empId || !basic) {
        lateDeductAmt = 0;
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
        empInput.addEventListener('change', updateLeaveDeduct);
        empInput.addEventListener('change', updateLateDeduct);
    }
    document.getElementById('basic_salary').addEventListener('input', updateLeaveDeduct);
    document.getElementById('basic_salary').addEventListener('input', updateLateDeduct);
    const yearSel = document.getElementById('deduct_year');
    if (yearSel) {
        yearSel.addEventListener('change', updateLeaveDeduct);
        yearSel.addEventListener('change', updateLateDeduct);
    }
    const monthInput = document.getElementById('payslip_month');
    const btn = document.getElementById('btn_generate_payslip');
    function updatePayslipLink(){
        const m = monthInput.value || '<?= date('Y-m') ?>';
        const eid = parseInt(document.querySelector("[name='emp_id']").value) || 0;
        btn.href = "<?= $base_url ?>/employeesalary/payslip?employee_id=" + eid + "&salary_month=" + m;
        btn.classList.toggle('disabled', !eid);
    }
    monthInput.addEventListener('change', updatePayslipLink);
    if (empInput) empInput.addEventListener('change', updatePayslipLink);
    updatePayslipLink();
});
</script>
