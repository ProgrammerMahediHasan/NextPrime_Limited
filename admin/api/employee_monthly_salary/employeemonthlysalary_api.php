<?php
class EmployeeMonthlySalaryApi{
	public function __construct(){
	}
	function index(){
		echo json_encode(["employee_monthly_salary"=>EmployeeMonthlySalary::all()]);
	}
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["employee_monthly_salary"=>EmployeeMonthlySalary::pagination($page,$perpage),"total_records"=>EmployeeMonthlySalary::count()]);
	}
	function find($data){
		echo json_encode(["employeemonthlysalary"=>EmployeeMonthlySalary::find($data["id"])]);
	}
	function delete($data){
		EmployeeMonthlySalary::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}
	function save($data,$file=[]){
		$employeemonthlysalary=new EmployeeMonthlySalary();
		$employeemonthlysalary->emp_id=$data["emp_id"];
		$employeemonthlysalary->salary_month=$data["salary_month"];
		$employeemonthlysalary->generated_at=$data["generated_at"];

		$employeemonthlysalary->save();
		echo json_encode(["success" => "yes"]);
	}
	function update($data,$file=[]){
		$employeemonthlysalary=new EmployeeMonthlySalary();
		$employeemonthlysalary->id=$data["id"];
		$employeemonthlysalary->emp_id=$data["emp_id"];
		$employeemonthlysalary->salary_month=$data["salary_month"];
		$employeemonthlysalary->generated_at=$data["generated_at"];

		$employeemonthlysalary->update();
		echo json_encode(["success" => "yes"]);
	}
}
?>
