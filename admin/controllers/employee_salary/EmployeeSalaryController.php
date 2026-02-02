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
		// $employeesalary->deduct_leave=$data["deduct_leave"];
		$employeesalary->medical_allowance=$data["medical_allowance"];
		$employeesalary->tax_deduction=$data["tax_deduction"];
		$employeesalary->pf_deduction=$data["pf_deduction"];
		$employeesalary->gross_salary=$data["gross_salary"];
		$employeesalary->net_salary=$data["net_salary"];

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
		// $employeesalary->deduct_leave=$data["deduct_leave"];
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
