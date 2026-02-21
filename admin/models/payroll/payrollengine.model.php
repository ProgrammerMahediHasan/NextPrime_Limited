<?php
class PayrollEngine {
    public static function calculateMonthlySalary($emp_id, $salary_month){
        global $db, $tx;
        $emp_id = intval($emp_id);
        if ($emp_id <= 0) return null;
        // month format: YYYY-MM
        $year = intval(substr($salary_month,0,4));
        $month = intval(substr($salary_month,5,2));
        $first = sprintf("%04d-%02d-01",$year,$month);
        $last  = date("Y-m-t", strtotime($first));

        // Base salary and allowances: only from configuration table
        $sal = $db->query("SELECT * FROM {$tx}employee_salary WHERE emp_id={$emp_id} ORDER BY id DESC LIMIT 1")->fetch_object();
        if (!$sal) {
            return null;
        }
        $basic  = floatval($sal->basic_salary);
        $hra    = floatval($sal->hra);
        $medical= floatval($sal->medical_allowance);
        $tax    = floatval($sal->tax_deduction);
        $pf     = floatval($sal->pf_deduction);
        $gross  = $basic + $hra + $medical;

        // Working Days Used: fixed 30 days basis for per-day rate
        $working_days = 30;
        $per_day = ($basic > 0) ? round($basic / 30.0) : 0.0;

        // Require month data presence: attendance or approved leave in selected month
        $month_att_q = $db->query("SELECT COUNT(*) cnt FROM {$tx}daily_attendance WHERE emp_id={$emp_id} AND att_date BETWEEN '{$first}' AND '{$last}'");
        $month_att_cnt = ($month_att_q && ($ma=$month_att_q->fetch_row())) ? intval($ma[0]) : 0;
        $month_leave_q = $db->query("SELECT COUNT(*) cnt FROM {$tx}leave_request WHERE emp_id={$emp_id} AND status='Approved' AND start_date BETWEEN '{$first}' AND '{$last}'");
        $month_leave_cnt = ($month_leave_q && ($ml=$month_leave_q->fetch_row())) ? intval($ml[0]) : 0;
        if (($month_att_cnt + $month_leave_cnt) === 0) {
            return null;
        }

        // Approved leave requests in month
        $lr_res = $db->query("
            SELECT lr.leave_id, lr.total_days, lt.deduct_apply
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            WHERE lr.emp_id={$emp_id}
              AND lr.status='Approved'
              AND lr.start_date BETWEEN '{$first}' AND '{$last}'
        ");
        $lwp_days = 0;
        $lwp_salary_days = 0;
        $lwp_balance_overflow_days = 0;
        while($lr = $lr_res->fetch_object()){
            $deductType = intval($lr->deduct_apply);
            if ($deductType === 1) {
                // Salary deduction for all approved days
                $days = floatval($lr->total_days);
                $lwp_days += $days;
                $lwp_salary_days += $days;
            } else {
                // None: no salary deduction
                $lwp_days += 0.0;
            }
        }

        $assign_q = $db->query("SELECT allow_days, used_days FROM {$tx}leave_assign WHERE emp_id={$emp_id} AND year={$year}");
        $overused = 0.0;
        while($as = $assign_q->fetch_object()){
            $overused += max(0.0, floatval($as->used_days) - floatval($as->allow_days));
        }
        $lwp_balance_overflow_days = $overused;

        // Absent days from attendance (no record or status=Absent)
        $abs_res = $db->query("SELECT COUNT(*) cnt FROM {$tx}daily_attendance WHERE emp_id={$emp_id} AND att_date BETWEEN '{$first}' AND '{$last}' AND status='Absent'");
        $absent_days = ($abs_res && ($r=$abs_res->fetch_row())) ? intval($r[0]) : 0;

        // Late penalty: 3 late occurrences = 1 day (count by late_minutes > 0)
        $late_res = $db->query("SELECT COUNT(*) cnt FROM {$tx}daily_attendance WHERE emp_id={$emp_id} AND att_date BETWEEN '{$first}' AND '{$last}' AND COALESCE(late_minutes,0) > 0");
        $late_count = ($late_res && ($lr=$late_res->fetch_row())) ? intval($lr[0]) : 0;
        $late_deduct_days = intdiv($late_count, 3);

        // Overtime minutes to amount (optional, placeholder 0)
        $ot_res = $db->query("SELECT COALESCE(SUM(overtime_minutes),0) mins FROM {$tx}daily_attendance WHERE emp_id={$emp_id} AND att_date BETWEEN '{$first}' AND '{$last}'");
        $ot_minutes = ($ot_res && ($om=$ot_res->fetch_row())) ? intval($om[0]) : 0;
        $overtime_amount = 0.0; // can map via settings later

        $salary_type_deduct_amount = round($lwp_salary_days * $per_day);
        $balance_overflow_deduct_amount = round($lwp_balance_overflow_days * $per_day);
        $late_deduct_amount = round($late_deduct_days * $per_day);
        $absent_deduct_amount = round($absent_days * $per_day);
        $unpaid_deduction = round($salary_type_deduct_amount + $balance_overflow_deduct_amount + $late_deduct_amount + $absent_deduct_amount);
        $net = $gross + $overtime_amount - ($unpaid_deduction + $tax + $pf);

        return [
            "emp_id" => $emp_id,
            "salary_month" => $salary_month,
            "basic_salary" => $basic,
            "hra" => $hra,
            "medical_allowance" => $medical,
            "tax_deduction" => $tax,
            "pf_deduction" => $pf,
            "gross_salary" => $gross,
            "per_day_salary" => round($per_day,2),
            "lwp_days" => $lwp_days,
            "lwp_salary_days" => $lwp_salary_days,
            "lwp_balance_overflow_days" => $lwp_balance_overflow_days,
            "absent_days" => $absent_days,
            "late_count" => $late_count,
            "late_deduct_days" => $late_deduct_days,
            "overtime_amount" => $overtime_amount,
            "salary_type_deduct_amount" => round($salary_type_deduct_amount),
            "balance_overflow_deduct_amount" => round($balance_overflow_deduct_amount),
            "late_deduct_amount" => round($late_deduct_amount),
            "absent_deduct_amount" => round($absent_deduct_amount),
            "unpaid_deduction" => $unpaid_deduction,
            "net_salary" => round($net)
        ];
    }
}
?>
