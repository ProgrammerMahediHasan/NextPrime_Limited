<?php
class RoleApi{
	public function __construct(){
	}
	function index(){
		echo json_encode(["roles"=>Role::all()]);
	}
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["roles"=>Role::pagination($page,$perpage),"total_records"=>Role::count()]);
	}
	function find($data){
		echo json_encode(["role"=>Role::find($data["id"])]);
	}
	function delete($data){
		Role::delete($data["id"]);
		Role::delete($data["name"]);
		echo json_encode(["success" => "yes"]);
	}
	function save($data,$file=[]){
		global $now;
		// $data=$data['id'];
		$role=new Role();
		$role->name=$data["name"];
		$role->created_at=$now;
		$role->updated_at=$now;

		$role->save();
		echo json_encode(["success" => $data]);
	}

	
function update($data, $file = []) {
    $data = $data['role'];
    $role = new Role();

    // 🔹 পুরনো role-এর তথ্য নাও
    $oldRole = Role::find($data["id"]);

    // 🔹 এখন নতুন মানগুলো সেট করো
    $role->id = $data["id"];
    $role->name = $data["name"];

    // 🔹 পুরনো created_at রাখো
    $role->created_at = $oldRole->created_at;

    // 🔹 নতুন updated_at দাও
    $role->updated_at = date("Y-m-d H:i:s");

    // 🔹 আপডেট করো
    $role->update();

    echo json_encode(["success" => "yes"]);
}




	function empinfo(){
		echo json_encode(["empinfo"=>Employee::employeeinfo()]);
	}
}
?>
