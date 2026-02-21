<?php
class EmployeeSalaryController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("employee_salary");
	}
	public function create(){
		view("employee_salary");
	}
	public function payslip(){
		view("employee_salary");
	}

    public function compute_leave_deduct($data = []){
        $data = array_merge($_GET, $data);
        $emp_id = isset($data['emp_id']) ? intval($data['emp_id']) : 0;
        $basic  = isset($data['basic_salary']) ? floatval($data['basic_salary']) : 0.0;
        $mode   = isset($data['mode']) ? $data['mode'] : 'perday';
        $year   = isset($data['year']) ? $data['year'] : date("Y");
        if ($emp_id <= 0 || $basic <= 0) {
            echo json_encode(["status"=>false, "message"=>"emp_id and basic_salary required", "leave_deduct"=>"0.00"]);
            return;
        }
        $amount = EmployeeSalary::compute_leave_deduct($emp_id, $basic, $year, $mode);
        echo json_encode(["status"=>true, "leave_deduct"=>$amount]);
    }

    public function compute_late_deduct($data = []){
        $data = array_merge($_GET, $data);
        $emp_id = isset($data['emp_id']) ? intval($data['emp_id']) : 0;
        $basic  = isset($data['basic_salary']) ? floatval($data['basic_salary']) : 0.0;
        $mode   = isset($data['mode']) ? $data['mode'] : 'perday';
        $year   = isset($data['year']) ? $data['year'] : date("Y");
        if ($emp_id <= 0 || $basic <= 0) {
            echo json_encode(["status"=>false, "message"=>"emp_id and basic_salary required", "late_deduct"=>"0.00"]);
            return;
        }
        $amount = EmployeeSalary::compute_late_deduct($emp_id, $basic, $year, $mode);
        echo json_encode(["status"=>true, "late_deduct"=>$amount]);
    }





	function payrollsummary($data = []) {
    $data = array_merge($_GET, $data); // include GET params
    $emp_id = $data['emp_id'] ?? null;

    if (!$emp_id) {
        echo json_encode([
            "status" => false,
            "message" => "Employee emp_id is required",
            "employee_salary" => []
        ]);
        return;
    }

    $salary = EmployeeSalary::payroll_summary($emp_id);

    echo json_encode([
        "status" => true,
        "employee_salary" => $salary
    ]);
}









public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];

		if(count($errors)==0){
			$employeesalary=new EmployeeSalary();
		$employeesalary->emp_id=$data["emp_id"];
		$employeesalary->basic_salary=$data["basic_salary"];
		$employeesalary->hra=$data["hra"];
		$employeesalary->medical_allowance=$data["medical_allowance"];
		$employeesalary->tax_deduction=$data["tax_deduction"];
		$employeesalary->pf_deduction=$data["pf_deduction"];
		// Compute gross and net with auto deductions
		$empId = intval($data["emp_id"]);
		$basic = floatval($data["basic_salary"]);
		$hra   = floatval($data["hra"]);
		$med   = floatval($data["medical_allowance"]);
		$tax   = floatval($data["tax_deduction"]);
		$pf    = floatval($data["pf_deduction"]);
		$year  = isset($data["deduct_year"]) ? $data["deduct_year"] : date("Y");
		$gross = round($basic + $hra + $med);
		$leave = intval(EmployeeSalary::compute_leave_deduct($empId, $basic, $year, "perday"));
		$late  = intval(EmployeeSalary::compute_late_deduct($empId, $basic, $year, "perday"));
		$net   = round($gross - ($tax + $pf + $leave + $late));
		$employeesalary->gross_salary=$gross;
		$employeesalary->net_salary=$net;

			$employeesalary->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}


public function edit($id){
		view("employee_salary",EmployeeSalary::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];
		if(count($errors)==0){
			$employeesalary=new EmployeeSalary();
			$employeesalary->id=$data["id"];
		$employeesalary->emp_id=$data["emp_id"];
		$employeesalary->basic_salary=$data["basic_salary"];
		$employeesalary->hra=$data["hra"];
		$employeesalary->medical_allowance=$data["medical_allowance"];
		$employeesalary->tax_deduction=$data["tax_deduction"];
		$employeesalary->pf_deduction=$data["pf_deduction"];
		$employeesalary->gross_salary=$data["gross_salary"];
		$employeesalary->net_salary=$data["net_salary"];

		$employeesalary->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("employee_salary");
	}
	public function delete($id){
		EmployeeSalary::delete($id);
		redirect();
	}
	public function show($id){
		view("employee_salary",EmployeeSalary::find($id));
	}
}
?>
