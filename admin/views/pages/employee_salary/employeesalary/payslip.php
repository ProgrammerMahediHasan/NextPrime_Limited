<?php
echo '<h1 class="text-center fw-bold my-4" style="color:#0d6efd;">Employee Payslip</h1>';

// $mysqli = new mysqli("localhost", "mahedi", "1358@;;", "wdfp66_mahedi");
// if ($mysqli->connect_error) {
//     die("Connection failed: " . $mysqli->connect_error);
// }
global $db;
$mysqli = $db ;

$data = null;
$employee_id  = $_GET['employee_id'] ?? '';
$salary_month = $_GET['salary_month'] ?? '';

if ($employee_id && $salary_month) {

    $stmt = $mysqli->prepare("
        SELECT
            es.emp_id,
            es.basic_salary,
            es.hra,
            es.medical_allowance,
            es.tax_deduction,
            es.pf_deduction,
            es.gross_salary,
            es.net_salary,

            e.id   AS employee_id,
            e.name AS employee_name,
            e.email,
            e.phone,

            d.name   AS department_name,
            des.name AS designation_name,

            ? AS salary_month,
            CURDATE() AS generated_at,

            COALESCE(SUM(
                CASE 
                    WHEN la.used_days > lt.total_days 
                    THEN ((la.used_days - lt.total_days) / 30) * es.basic_salary
                    ELSE 0
                END
            ),0) AS leave_deduct

        FROM rt_employee_salary es
        JOIN rt_employees e ON es.emp_id = e.id
        LEFT JOIN rt_department d ON e.dept_id = d.id
        LEFT JOIN rt_designations des ON e.desig_id = des.id
        LEFT JOIN rt_leave_assign la ON la.emp_id = es.emp_id
        LEFT JOIN rt_leave_types lt ON lt.id = la.leave_type_id

        WHERE es.emp_id = ?

        GROUP BY es.id
        ORDER BY es.id DESC
        LIMIT 1
    ");

    $stmt->bind_param("si", $salary_month, $employee_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payslip</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: #f4f6f8;
        margin: 0;
        padding: 0;
        color: #374151;
    }

    /* ================= Professional Filter Form ================= */
    .filter-form {
        width: 600px;
        margin: 50px auto;
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-form .form-group {
        flex: 1 1 100%;
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 8px;
        color: #4b5563;
    }

    select,
    input {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        color: #1f2937;
        outline: none;
        transition: 0.3s;
    }

    select:focus,
    input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 8px rgba(37, 99, 235, 0.2);
    }

    .btn-view {
        background: #2563eb;
        border: none;
        color: #fff;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-view:hover {
        background: #1d4ed8;
    }

    <?php if($data): ?>.filter-form {
        display: none;
    }

    <?php endif;
    ?>

    /* ================= Payslip ================= */
    .payslip {
        width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 35px 45px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        color: #374151;
    }

    .header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid #d1d5db;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .header p {
        margin: 2px 0;
        font-size: 13px;
        color: #4b5563;
    }

    .section-title {
        background: #1F284D;
        color: #fff;
        padding: 8px;
        margin-top: 25px;
        text-align: center;
        font-weight: 600;
        border-radius: 4px;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 14px;
        color: #374151;
    }

    td,
    th {
        padding: 10px;
        border: 1px solid #d1d5db;
    }

    th {
        background: #f3f4f6;
        font-weight: 600;
        color: #1f2937;
    }

    .flex {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .flex table {
        width: 50%;
    }

    .flex td {
        color: #4b5563;
    }

    .flex th {
        background: #e5e7eb;
        color: #1f2937;
    }

    .summary td {
        font-size: 15px;
        font-weight: 500;
        color: #111827;
    }

    .btn-wrap {
        display: flex;
        justify-content: space-between;
        margin: 30px auto;
        width: 900px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-back {
        background: #6b7280;
        color: #fff;
    }

    .btn-print {
        background: #16a34a;
        color: #fff;
    }

    .signature {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }

    .signature div {
        text-align: center;
    }

    .signature p {
        margin-top: 60px;
        border-top: 1px solid #000;
        width: 150px;
        margin-left: auto;
        margin-right: auto;
    }

    .footer {
        text-align: center;
        margin-top: 30px;
        font-size: 12px;
        color: #4b5563;
    }

    @media print {
        body {
            background: #fff;
        }

        .btn-wrap {
            display: none;
        }
    }
    </style>
</head>

<body>

    <form method="GET" class="filter-form">
        <div class="form-group">
            <label>Employee</label>
            <select name="employee_id" required>
                <option value="">Select Employee</option>
                <?php
            $r=$mysqli->query("SELECT id,name FROM rt_employees");
            while($e=$r->fetch_assoc()){
                $s=($employee_id==$e['id'])?'selected':''; 
                echo "<option value='{$e['id']}' $s>{$e['name']}</option>";
            }
            ?>
            </select>
        </div>
        <div class="form-group">
            <label>Salary Month</label>
            <input type="month" name="salary_month" value="<?=$salary_month?>" required>
        </div>
        <button class="btn-view">View Payslip</button>
    </form>

    <?php if($data): ?>
    <div class="btn-wrap">
        <button class="btn btn-back" onclick="history.back()">← Back</button>
        <button class="btn btn-print" onclick="window.print()">Print Payslip</button>
    </div>

    <div class="payslip">
        <div class="header">
            <div>
                <h2>NextPrime Limited</h2>
                <p>Dhaka, Mohakhali Dhos</p>
                <p>+8801632606872</p>
            </div>
            <div>
                <center><b>Payslip</b></center><br>
                Salary: <?=date('F Y',strtotime($data['salary_month'].'-01'))?><br>
                Pay Date: <?=date('d M Y',strtotime($data['generated_at']))?>
            </div>
        </div>

        <div class="section-title">Employee Information</div>
        <table>
            <tr>
                <td>Employee ID</td>
                <td><?=$data['employee_id']?></td>
                <td>Name</td>
                <td><?=$data['employee_name']?></td>
            </tr>
            <tr>
                <td>Department</td>
                <td><?=$data['department_name']??'N/A'?></td>
                <td>Designation</td>
                <td><?=$data['designation_name']??'N/A'?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?=$data['email']?></td>
                <td>Phone</td>
                <td><?=$data['phone']?></td>
            </tr>
        </table>

        <div class="section-title">Employee Salary Calculations</div>
        <div class="flex">
            <table>
                <tr>
                    <th>Earnings</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td><?=$data['basic_salary']?></td>
                </tr>
                <tr>
                    <td>HRA</td>
                    <td><?=$data['hra']?></td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td><?=$data['medical_allowance']?></td>
                </tr>
                <tr>
                    <td><b>Total Earnings</b></td>
                    <td><b><?=($data['basic_salary']+$data['hra']+$data['medical_allowance'])?></b></td>
                </tr>
            </table>

            <table>
                <tr>
                    <th>Deductions</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td><?=$data['tax_deduction']?></td>
                </tr>
                <tr>
                    <td>Provident Fund</td>
                    <td><?=$data['pf_deduction']?></td>
                </tr>
                <tr>
                    <td>Leave Deduction</td>
                    <td><?=round($data['leave_deduct'],2)?></td>
                </tr>
                <tr>
                    <td><b>Total Deductions</b></td>
                    <td><b><?=($data['tax_deduction']+$data['pf_deduction']+round($data['leave_deduct'],2))?></b></td>
                </tr>
            </table>
        </div>

        <div class="section-title">Net Pay</div>
        <table class="summary">
            <tr>
                <td>Gross Salary</td>
                <td><?=$data['gross_salary']?></td>
            </tr>
            <tr>
                <td>Net Pay</td>
                <td><?=round($data['net_salary']-$data['leave_deduct'],2)?></td>
            </tr>
        </table>

        <div class="signature">
            <div>
                <p>Employer Signature</p>
            </div>
            <div>
                <p>Employee Signature</p>
            </div>
        </div>

        <div class="footer">This is a system generated payslip</div>
    </div>
    <?php endif; ?>
</body>

</html>