<?php

class EmployeeSalaryApi{
	public function __construct(){
	}

	function index(){
		echo json_encode(["employee_salary"=>EmployeeSalary::all()]);
	}
	function payslip($data){
		echo json_encode(["employee_salary"=>Employee::payslip($data['employee_id'], $data['salary_month'])]);
		// echo json_encode(["employee_salary"=> $data]);
	}

	

function payroll_summary($data = []) {
    // Merge GET parameters if not already set
    $data = array_merge($_GET, $data);

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







	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["employee_salary"=>EmployeeSalary::pagination($page,$perpage),"total_records"=>EmployeeSalary::count()]);
	}

	function find($data){
		echo json_encode(["employeesalary"=>EmployeeSalary::find($data["id"])]);
	}

	function delete($data){
		EmployeeSalary::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}

	function save($data,$file=[]){
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
		echo json_encode(["success" => "yes"]);
	}

	function update($data,$file=[]){
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
		echo json_encode(["success" => "yes"]);
	}

}
?>
