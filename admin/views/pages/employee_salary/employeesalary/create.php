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

    <table class="salary-table">
        <tr>
            <th>Employee</th>
            <td>
                <?php
                echo Form::input([
                    "label"=>"",
                    "name"=>"emp_id",
                    "table"=>"employees",
                    "value_column"=>"id",
                    "text_column"=>"name"
                ]);
                ?>
            </td>
        </tr>

        <tr>
            <th>Basic Salary</th>
            <td><input type="number" id="basic_salary" name="basic_salary" step="0.01"></td>
        </tr>

        <tr>
            <th>House Rent</th>
            <td><input type="number" id="hra" name="hra" step="0.01"></td>
        </tr>

        <tr>
            <th>Medical Allowance</th>
            <td><input type="number" id="medical_allowance" name="medical_allowance" step="0.01"></td>
        </tr>

        <tr>
            <th>Tax Deduction</th>
            <td><input type="number" id="tax_deduction" name="tax_deduction" step="0.01"></td>
        </tr>

        <tr>
            <th>PF Deduction</th>
            <td><input type="number" id="pf_deduction" name="pf_deduction" step="0.01"></td>
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
function calculateSalary() {
    const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
    const hra = parseFloat(document.getElementById('hra').value) || 0;
    const medical = parseFloat(document.getElementById('medical_allowance').value) || 0;
    const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
    const pf = parseFloat(document.getElementById('pf_deduction').value) || 0;

    const gross = basic + hra + medical;
    const net = gross - (tax + pf);

    document.getElementById('gross_salary').value = gross.toFixed(2);
    document.getElementById('net_salary').value = net.toFixed(2);
}

['basic_salary','hra','medical_allowance','tax_deduction','pf_deduction'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculateSalary);
});
</script>
