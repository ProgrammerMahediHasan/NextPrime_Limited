<?php
class UserApi{
	public function __construct(){
	}
	
	function index(){
		echo json_encode(["users"=>User::all()]);
	}
	
	function pagination($data){
		$page=$data["page"];
		$perpage=$data["perpage"];
		echo json_encode(["users"=>User::pagination($page,$perpage),"total_records"=>User::count()]);
	}

	function find($data){
		echo json_encode(["user"=>User::find($data["id"])]);
	}
	
	function delete($data){
		User::delete($data["id"]);
		echo json_encode(["success" => "yes"]);
	}

	
	function save($data,$file=[]){
		$user=new User();
		$user->name=$data["name"];
		$user->password=$data["password"];
		$user->email=$data["email"];
		// $user->role_id=$data["role_id"];
		$user->address=$data["address"];
		$user->status=$data["status"];
		// $user->photo=upload($file["photo"], "../img",$data["username"]);
		$user->save();
		echo json_encode(["success" => "yes"]);
	}



	function update($data,$file=[]){
		// $data=$data["user"];
		$user=new User();
		$user->id=$data["id"];
		$user->name=$data["name"];
		$user->password=$data["password"];
		$user->email=$data["email"];
		$user->role_id=$data["role_id"];
		$user->address=$data["address"];
		$user->status=$data["status"];
		// $user->updated_at=$now;
		// if(isset($file["photo"]["name"])){
		// 	$user->photo=upload($file["photo"], "../img",$data["username"]);
		// }else{
		// 	$user->photo=User::find($data["id"])->photo;
		// }

		$user->update();
		echo json_encode(["success" => $data]);
	}
}
?>