<?php
class UserController extends Controller{
	public function __construct(){
	}
	public function index(){
		view("users");
	}
	public function create(){
		view("users");
	}
public function save($data,$file){
	if(isset($data["create"])){
	$errors=[];
/*
	if(!preg_match("/^[\s\S]+$/",$_POST["txtUsername"])){
		$errors["username"]="Invalid username";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtPassword"])){
		$errors["password"]="Invalid password";
	}
	if(!is_valid_email($data["email"])){
		$errors["email"]="Invalid email";
	}
	if(!preg_match("/^[\s\S]+$/",$data["role_id"])){
		$errors["role_id"]="Invalid role_id";
	}
	if(!preg_match("/^[\s\S]+$/",$_POST["txtAddress"])){
		$errors["address"]="Invalid address";
	}
	if(!preg_match("/^[\s\S]+$/",$data["status"])){
		$errors["status"]="Invalid status";
	}
	if(!preg_match("/^[\s\S]+$/",$data["photo"])){
		$errors["photo"]="Invalid photo";
	}

*/
		if(count($errors)==0){
			$user=new User();
		$user->name=$data["name"];
		$user->password=password_hash(trim($data["password"]), PASSWORD_DEFAULT);
		$user->email=$data["email"];
		$user->role_id=$data["role_id"];
		$user->address=$data["address"];
		$user->status=$data["status"];
		// $user->created_at=$now;
		// $user->updated_at=$now;
		// $user->photo=File::upload($file["photo"], "img",$data["id"]);

			$user->save();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
public function edit($id){
		view("users",User::find($id));
}
public function update($data,$file){
	if(isset($data["update"])){
	$errors=[];

		if(count($errors)==0){
			$user=new User();
			$user->id=$data["id"];
		$user->name=$data["name"];
		// keep old password if empty; otherwise hash new one
		$incoming = trim($data["password"] ?? "");
		if ($incoming === "") {
			$existing = User::find($data["id"]);
			$user->password = $existing ? $existing->password : "";
		} else {
			$user->password = password_hash($incoming, PASSWORD_DEFAULT);
		}
		$user->email=$data["email"];
		$user->role_id=$data["role_id"];
		$user->address=$data["address"];
		$user->status=$data["status"];
		// $user->created_at=$now;
		// $user->updated_at=$now;
		if($file["photo"]["name"]!=""){
			// $user->photo=File::upload($file["photo"], "img",$data["id"]);
		}else{
			$user->photo=User::find($data["id"])->photo;
		}

		$user->update();
		redirect();
		}else{
			 print_r($errors);
		}
	}
}
	public function confirm($id){
		view("users");
	}
	public function delete($id){
		User::delete($id);
		redirect();
	}
	public function show($id){
		view("users",User::find($id));
	}

	// Set role by name for a given user id
	public function setrole($id){
		global $db, $tx;
		$roleGuard = strtolower($_SESSION['role_name'] ?? '');
		if ($roleGuard !== 'admin') {
			redirect();
			return;
		}
		$role = $_GET['role'] ?? 'Manager';
		$role = trim($role);
		if ($role === '') { redirect(); return; }
		$stmt = $db->prepare("SELECT id FROM {$tx}roles WHERE name = ? LIMIT 1");
		$stmt->bind_param("s", $role);
		$stmt->execute();
		$res = $stmt->get_result();
		$roleRow = $res->fetch_assoc();
		$stmt->close();
		if ($roleRow) {
			$rid = (int)$roleRow['id'];
			$upd = $db->prepare("UPDATE {$tx}users SET role_id=? WHERE id=?");
			$uid = (int)$id;
			$upd->bind_param("ii", $rid, $uid);
			$upd->execute();
			$upd->close();
		}
		redirect();
	}
}
?>
