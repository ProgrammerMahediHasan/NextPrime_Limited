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

    // Fetch salary records
    $query = "SELECT * FROM {$tx}employee_salary $criteria ORDER BY id DESC LIMIT $top, $perpage";
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
    $html .= "<table class='table table-bordered table-striped table-hover w-100'>";

    // Table header styling
    $html .= "<style>
        .table thead th {
            background-color: #0d3b66; /* Deep blue */
            color: #d1d5db; /* Light ash */
            text-align: center;
            font-weight: 600;
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
                    <th>Emp Id</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allowance</th>
                    <th>Tax Deduction</th>
                    <th>PF Deduction</th>
                    <th>Gross Salary</th>
                    <th>Net Salary</th>";
    if($action) $html .= "<th>Action</th>";
    $html .= "</tr>
              </thead>";

    // Table rows
    while($salary = $result->fetch_object()){
        $action_buttons = "";
        if($action){
            $action_buttons = "<td style='white-space: nowrap;'>
                                <div class='btn-group'>
                                    <button class='btn-primary' onclick=\"location.href='{$base_url}/employeesalary/edit/$salary->id'\"><i class='fas fa-edit'></i></button>
                                    <button class='btn-danger' onclick=\"if(confirm('Are you sure?')) location.href='{$base_url}/employeesalary/confirm/$salary->id'\"><i class='fas fa-trash-alt'></i></button>
                                </div>
                              </td>";
        }

        $html .= "<tr>
                    <td>$salary->emp_id</td>
                    <td>$salary->basic_salary</td>
                    <td>$salary->hra</td>
                    <td>$salary->medical_allowance</td>
                    <td>$salary->tax_deduction</td>
                    <td>$salary->pf_deduction</td>
                    <td>$salary->gross_salary</td>
                    <td>$salary->net_salary</td>
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
		$result =$db->query("select id,emp_id,basic_salary,hra,leave_deduct,medical_allowance,tax_deduction,pf_deduction,gross_salary,net_salary from {$tx}employee_salary where id={$id}");
		$employeesalary=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">EmployeeSalary Show</th></tr>";
		$html.="<tr><th>Id</th><td>$employeesalary->id</td></tr>";
		$html.="<tr><th>Emp Id</th><td>$employeesalary->emp_id</td></tr>";
		$html.="<tr><th>Basic Salary</th><td>$employeesalary->basic_salary</td></tr>";
		$html.="<tr><th>Hra</th><td>$employeesalary->hra</td></tr>";
		$html.="<tr><th>Medical Allowance</th><td>$employeesalary->medical_allowance</td></tr>";
		$html.="<tr><th>Tax Deduction</th><td>$employeesalary->tax_deduction</td></tr>";
		$html.="<tr><th>Pf Deduction</th><td>$employeesalary->pf_deduction</td></tr>";
		$html.="<tr><th>Gross Salary</th><td>$employeesalary->gross_salary</td></tr>";
		$html.="<tr><th>Net Salary</th><td>$employeesalary->net_salary</td></tr>";

		$html.="</table>";
		return $html;
	}
}
?>
