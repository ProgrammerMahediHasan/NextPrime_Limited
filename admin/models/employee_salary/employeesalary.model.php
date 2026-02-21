<?php
class EmployeeSalary extends Model implements JsonSerializable{
	public $id;
	public $emp_id;
	public $basic_salary;
	public $hra;
	public $medical_allowance;
	public $tax_deduction;
	public $pf_deduction;
	public $gross_salary;
	public $net_salary;

	public function __construct(){
	}
	public function set($id,$emp_id,$basic_salary,$hra,$medical_allowance,$tax_deduction,$pf_deduction,$gross_salary,$net_salary){
		$this->id=$id;
		$this->emp_id=$emp_id;
		$this->basic_salary=$basic_salary;
		$this->hra=$hra;
		$this->medical_allowance=$medical_allowance;
		$this->tax_deduction=$tax_deduction;
		$this->pf_deduction=$pf_deduction;
		$this->gross_salary=$gross_salary;
		$this->net_salary=$net_salary;

	}


	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}employee_salary(emp_id,basic_salary,hra,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary)values('$this->emp_id','$this->basic_salary','$this->hra','$this->medical_allowance','$this->tax_deduction','$this->pf_deduction','$this->gross_salary','$this->net_salary')");
		return $db->insert_id;
	}


	public function update(){
		global $db,$tx;
		$db->query("update {$tx}employee_salary set emp_id='$this->emp_id',basic_salary='$this->basic_salary',hra='$this->hra',medical_allowance='$this->medical_allowance',tax_deduction='$this->tax_deduction',pf_deduction='$this->pf_deduction',gross_salary='$this->gross_salary',net_salary='$this->net_salary' where id='$this->id'");
	}


	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}employee_salary where id={$id}");
	}


	public function jsonSerialize():mixed{
		return get_object_vars($this);
	}


	
	
	public static function payroll_summary($emp_id = null)
{
    global $db, $tx;

    // Escape input for safety
    $emp_id = $emp_id ? $db->real_escape_string($emp_id) : null;

    // Base SQL
    $sql = "
        SELECT 
            e.id AS emp_id,
            e.name AS emp_name,
            COALESCE(MAX(es.basic_salary), 0) AS basic_salary,
            COALESCE(MAX(es.hra), 0) AS hra,
            COALESCE(MAX(es.medical_allowance), 0) AS medical_allowance,
            COALESCE(MAX(es.tax_deduction), 0) AS tax_deduction,
            COALESCE(MAX(es.pf_deduction), 0) AS pf_deduction,
            COALESCE(MAX(es.gross_salary), 0) AS gross_salary,
            COALESCE(MAX(es.net_salary), 0) AS net_salary
        FROM {$tx}employees e
        LEFT JOIN {$tx}employee_salary es 
            ON e.id = es.emp_id
    ";

    // Filter using employee ID
    if ($emp_id) {
        $sql .= " WHERE e.id = '{$emp_id}' ";
    }

    $sql .= "
        GROUP BY e.id, e.name
        ORDER BY e.name ASC
    ";

    $result = $db->query($sql);

    $data = [];
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }

    return $data;
}






	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,emp_id,basic_salary,hra,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary from {$tx}employee_salary");
		$data=[];
		while($employeesalary=$result->fetch_object()){
			$data[]=$employeesalary;
		}
			return $data;
	}


	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,emp_id,basic_salary,hra,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary from {$tx}employee_salary $criteria limit $top,$perpage");
		$data=[];
		while($employeesalary=$result->fetch_object()){
			$data[]=$employeesalary;
		}
			return $data;
	}


	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}employee_salary $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}


	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,emp_id,basic_salary,hra,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary from {$tx}employee_salary where id='$id'");
		$employeesalary=$result->fetch_object();
			return $employeesalary;
	}


	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}employee_salary");
		$employeesalary =$result->fetch_object();
		return $employeesalary->last_id;
	}


	public function json(){
		return json_encode($this);
	}


	public function __toString(){
		return "		Id:$this->id<br> 
		Emp Id:$this->emp_id<br> 
		Basic Salary:$this->basic_salary<br> 
		Hra:$this->hra<br> 
		Medical Allowance:$this->medical_allowance<br> 
		Tax Deduction:$this->tax_deduction<br> 
		Pf Deduction:$this->pf_deduction<br> 
		Gross Salary:$this->gross_salary<br> 
		Net Salary:$this->net_salary<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbEmployeeSalary"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}employee_salary");
		while($employeesalary=$result->fetch_object()){
			$html.="<option value ='$employeesalary->id'>$employeesalary->name</option>";
		}
		$html.="</select>";
		return $html;
	}



	static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true){
    global $db, $tx, $base_url;

    // Count total rows
    $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}employee_salary $criteria");
    list($total_rows) = $count_result->fetch_row();
    $total_pages = ceil($total_rows / $perpage);
    $top = ($page - 1) * $perpage;

    // Fetch salary records with employee name
    $query = "
        SELECT es.*, e.name AS emp_name
        FROM {$tx}employee_salary es
        LEFT JOIN {$tx}employees e ON e.id = es.emp_id
        $criteria
        ORDER BY es.id DESC
        LIMIT $top, $perpage
    ";
    $result = $db->query($query);

    // Start table container
    $html = "<div class='table-responsive'>";

    // Add "Add Salary" button above table
    $html .= "<div style='margin-bottom:10px; text-align:left;'>";
    $html .= Html::link([
        "class" => "btn btn-success btn-sm",
        "route" => "employeesalary/create",
        "text" => "+ Add Salary Configuration"
    ]);
    $html .= "</div>";

    // Start table
    $html .= "<table class='table table-bordered table-hover w-100 salary-index-table'>";

    // Table header styling
    $html .= "<style>
        .salary-index-table {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        .salary-index-table thead th {
            background: linear-gradient(90deg, #0d3b66, #1d4ed8);
            color: #ffffff;
            text-align: center;
            font-weight: 700;
            padding: 12px;
            border-bottom: 0;
        }
        .salary-index-table tbody td {
            background-color: #f8fafc;
            border-color: #e5e7eb;
            vertical-align: middle;
        }
        .salary-index-table tbody tr:nth-child(odd) td {
            background-color: #eef2ff;
        }
        .salary-index-table tbody tr:hover td {
            background-color: #dbeafe;
        }
        .salary-index-table td.num {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }
        .btn-group .btn {
            margin-right: 5px;
        }
				    .btn-group {
    display: flex !important;
    justify-content: center;
    gap: 6px; /* হালকা gap */
    flex-wrap: nowrap;
}

.btn-group {
    display: flex !important;
    justify-content: center;
    gap: 6px; /* হালকা gap */
    flex-wrap: nowrap;
}

.btn-primary { background: #3b82f6; }
    .btn-danger { background: #ef4444; }
    @media (max-width: 768px) {
        .table-responsive th, .table-responsive td {
            font-size: 12px;
            padding: 6px 8px;
        }
        .btn-group button {
            font-size: 10px;
            padding: 3px 6px;
        }

.btn-group button {
    padding: 6px 10px !important; 
    font-size: 14px !important;  
    border-radius: 4px;
    border: 2px solid #000;    
    outline: none;
    cursor: pointer;
    color: #fff;
    font-weight: 700;            
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-group i {
    font-weight: 900; /* icon আরও bold */
}


.btn-group button:focus {
    outline: none;
    border: 1px solid rgba(0,0,0,0.3);
    box-shadow: none;
}
    </style>";

    // Table headers
    $html .= "<thead>
                <tr>
                    <th>Employee</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allowance</th>
                    <th>Gross Salary</th>
                    <th>Tax Deduction</th>
                    <th>PF Deduction</th>
                    <th>Leave Deduct</th>
                    <th>Late Deduct</th>
                    <th>Net Salary</th>";
    if($action) $html .= "<th>Action</th>";
    $html .= "</tr>
              </thead>";

    // Table rows
    while($salary = $result->fetch_object()){
        $action_buttons = "";
        if($action){
            $currentMonth = date("Y-m");
            $action_buttons = "<td style='white-space: nowrap;'>
                                <div class='btn-group'>
                                    <button class='btn-primary' onclick=\"location.href='{$base_url}/employeesalary/edit/$salary->id'\"><i class='fas fa-edit'></i></button>
                                    <button class='btn-danger' onclick=\"if(confirm('Are you sure?')) location.href='{$base_url}/employeesalary/confirm/$salary->id'\"><i class='fas fa-trash-alt'></i></button>

                                </div>
                              </td>";
        }

        $deduct_amount = self::compute_leave_deduct($salary->emp_id, $salary->basic_salary);
        $late_deduct_amount = self::compute_late_deduct($salary->emp_id, $salary->basic_salary);
        $html .= "<tr>
                    <td>$salary->emp_name</td>
                    <td class='num'>".number_format(round($salary->basic_salary),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->hra),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->medical_allowance),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->gross_salary),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->tax_deduction),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->pf_deduction),0,'.','')."</td>
                    <td class='num'>".number_format(round(floatval($deduct_amount)),0,'.','')."</td>
                    <td class='num'>".number_format(round(floatval($late_deduct_amount)),0,'.','')."</td>
                    <td class='num'>".number_format(round($salary->net_salary),0,'.','')."</td>
                    $action_buttons
                  </tr>";
    }

    $html .= "</table></div>";

    // Pagination
    if(function_exists('pagination')){
        $html .= pagination($page, $total_pages);
    }

    return $html;
}







	
	static function html_row_details($id){
		global $db,$tx,$base_url;
		$result =$db->query("select id,emp_id,basic_salary,hra,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary from {$tx}employee_salary where id={$id}");
		$employeesalary=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">EmployeeSalary Show</th></tr>";
		$html.="<tr><th>Id</th><td>$employeesalary->id</td></tr>";
		$html.="<tr><th>Emp Id</th><td>$employeesalary->emp_id</td></tr>";
		$html.="<tr><th>Basic Salary</th><td>$employeesalary->basic_salary</td></tr>";
		$html.="<tr><th>Hra</th><td>$employeesalary->hra</td></tr>";
        $deduct_amount = self::compute_leave_deduct($employeesalary->emp_id, $employeesalary->basic_salary);
        $late_deduct_amount = self::compute_late_deduct($employeesalary->emp_id, $employeesalary->basic_salary);
		$html.="<tr><th>Leave Deduct</th><td>$deduct_amount</td></tr>";
        $html.="<tr><th>Late Deduct</th><td>$late_deduct_amount</td></tr>";
		$html.="<tr><th>Medical Allowance</th><td>$employeesalary->medical_allowance</td></tr>";
		$html.="<tr><th>Tax Deduction</th><td>$employeesalary->tax_deduction</td></tr>";
		$html.="<tr><th>Pf Deduction</th><td>$employeesalary->pf_deduction</td></tr>";
		$html.="<tr><th>Gross Salary</th><td>$employeesalary->gross_salary</td></tr>";
		$html.="<tr><th>Net Salary</th><td>$employeesalary->net_salary</td></tr>";

		$html.="</table>";
		return $html;
	}

    static function compute_leave_deduct($emp_id, $basic_salary, $year = null, $mode = 'perday'){
        global $db, $tx;
        $emp_id = intval($emp_id);
        $year = $year ?: date("Y");
        if ($emp_id <= 0) return number_format(0,2,'.','');
        $rq1 = $db->query("
            SELECT COALESCE(SUM(lr.total_days),0) AS salary_days
            FROM {$tx}leave_request lr
            LEFT JOIN {$tx}leave_types lt ON lt.id = lr.leave_id
            WHERE lr.emp_id = {$emp_id}
              AND YEAR(lr.start_date) = '{$year}'
              AND lr.status = 'Approved'
              AND lt.deduct_apply = 1
        ");
        $salary_days = 0.0;
        if ($rq1) {
            $r1 = $rq1->fetch_object();
            $salary_days = floatval($r1->salary_days);
        }
        $overflow_days = 0.0;
        $rq2 = $db->query("
            SELECT la.allow_days, la.used_days
            FROM {$tx}leave_assign la
            LEFT JOIN {$tx}leave_types lt ON lt.id = la.leave_type_id
            WHERE la.emp_id = {$emp_id}
              AND la.year = '{$year}'
              AND lt.deduct_apply = 0
        ");
        if ($rq2) {
            while($ra = $rq2->fetch_object()){
                $overflow_days += max(0.0, floatval($ra->used_days) - floatval($ra->allow_days));
            }
        }
        $total_days = max(0.0, $salary_days + $overflow_days);
        $rate = 0.0;
        if ($mode === 'full') {
            $rate = (floatval($basic_salary) > 0) ? floatval($basic_salary) : 0.0;
        } else {
            $rate = (floatval($basic_salary) > 0) ? round(floatval($basic_salary)/30.0) : 0.0;
        }
        return number_format(round($total_days * $rate), 0, '.', '');
    }

    static function compute_late_deduct($emp_id, $basic_salary, $year = null, $mode = 'perday'){
        global $db, $tx;
        $emp_id = intval($emp_id);
        $year = $year ?: date("Y");
        if ($emp_id <= 0) return number_format(0,2,'.','');
        $rq = $db->query("
            SELECT COUNT(*) AS late_count
            FROM {$tx}daily_attendance
            WHERE emp_id = {$emp_id}
              AND YEAR(att_date) = '{$year}'
              AND late_minutes > 0
        ");
        $late_count = 0;
        if ($rq) {
            $r = $rq->fetch_row();
            $late_count = intval($r[0] ?? 0);
        }
        $late_days = floor($late_count / 3);
        $rate = 0.0;
        if ($mode === 'full') {
            $rate = (floatval($basic_salary) > 0) ? floatval($basic_salary) : 0.0;
        } else {
            $rate = (floatval($basic_salary) > 0) ? round(floatval($basic_salary)/30.0) : 0.0;
        }
        return number_format(round($late_days * $rate), 0, '.', '');
    }
}
?>
