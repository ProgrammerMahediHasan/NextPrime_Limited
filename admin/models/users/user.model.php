<?php
class User extends Model implements JsonSerializable{
	public $id;
	public $name;
	public $password;
	public $email;
	public $role_id;
	public $address;
	public $status;
	public $created_at;
	public $updated_at;
	public $photo;

	public function __construct(){
	}
	public function set($id,$name,$password,$email,$role_id,$address,$status,$created_at,$updated_at,$photo){
		$this->id=$id;
		$this->name=$name;
		$this->password=$password;
		$this->email=$email;
		$this->role_id=$role_id;
		$this->address=$address;
		$this->status=$status;
		$this->created_at=$created_at;
		$this->updated_at=$updated_at;
		$this->photo=$photo;

	}
	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}users(name,password,email,role_id,address,status,created_at,updated_at,photo)values('$this->name','$this->password','$this->email','$this->role_id','$this->address','$this->status','$this->created_at','$this->updated_at','$this->photo')");
		return $db->insert_id;
	}
	public function update(){
		global $db,$tx;
		$db->query("update {$tx}users set name='$this->name',password='$this->password',email='$this->email',role_id='$this->role_id',address='$this->address',status='$this->status',created_at='$this->created_at',updated_at='$this->updated_at',photo='$this->photo' where id='$this->id'");
	}
	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}users where id={$id}");
	}
	public function jsonSerialize():mixed{
		return get_object_vars($this);
	}
	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,name,password,email,role_id,address,status,created_at,updated_at,photo from {$tx}users");
		$data=[];
		while($user=$result->fetch_object()){
			$data[]=$user;
		}
			return $data;
	}

	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,name,password,email,role_id,address,status,created_at,updated_at,photo from {$tx}users $criteria limit $top,$perpage");
		$data=[];
		while($user=$result->fetch_object()){
			$data[]=$user;
		}
			return $data;
	}

	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}users $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}
	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,name,password,email,role_id,address,status,created_at,updated_at,photo from {$tx}users where id='$id'");
		$user=$result->fetch_object();
			return $user;
	}
	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}users");
		$user =$result->fetch_object();
		return $user->last_id;
	}
	public function json(){
		return json_encode($this);
	}
	public function __toString(){
		return "		Id:$this->id<br> 
		name:$this->name<br> 
		Password:$this->password<br> 
		Email:$this->email<br> 
		Role Id:$this->role_id<br> 
		Address:$this->address<br> 
		Status:$this->status<br> 
		Created At:$this->created_at<br> 
		Updated At:$this->updated_at<br> 
		Photo:$this->photo<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbUser"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}users");
		while($user=$result->fetch_object()){
			$html.="<option value ='$user->id'>$user->name</option>";
		}
		$html.="</select>";
		return $html;
	}


static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true) {
    global $db, $tx, $base_url;

    // -------- COUNT --------
    $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}users $criteria");
    list($total_rows) = $count_result->fetch_row();
    $total_pages = ceil($total_rows / $perpage);
    $top = ($page - 1) * $perpage;

    // -------- DATA --------
    $result = $db->query("SELECT id, name, password, email, role_id, address, status, created_at, updated_at, photo 
                          FROM {$tx}users $criteria LIMIT $top, $perpage");

    /* ===== CSS same as leave_assign table ===== */
    $html = "<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    .table-responsive { overflow-x:auto; }
    .table-responsive table{
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
        font-family:'Poppins',sans-serif;
    }
    .table-responsive th{
        background:#1f3d79ff;
        color:#ffffff !important;
        font-weight:700;
        text-align:center;
        padding:8px;
        font-size:13px;
    }
    .table-responsive td{
        text-align:center;
        vertical-align:middle;
        padding:6px 8px;
        font-size:12px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        border:1px solid #000;
    }
    .table-responsive tr:hover{
        background:#f1f5f9;
        transition:0.2s;
    }
    .btn-group{
        display:flex !important;
        justify-content:center;
        gap:6px;
        flex-wrap:nowrap;
    }
    .btn-group button{
        padding:6px 10px !important;
        font-size:14px !important;
        border-radius:4px;
        border:2px solid #000;
        cursor:pointer;
        color:#fff;
        font-weight:700;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .btn-group i{ font-weight:900; }
    .btn-primary{ background:#3b82f6; }
    .btn-danger{ background:#ef4444; }
    @media(max-width:768px){
        .table-responsive table th,
        .table-responsive table td{
            font-size:11px;
            padding:5px 6px;
        }
        .btn-group button{
            font-size:10px !important;
            width:26px;
            height:26px;
            padding:2px 5px !important;
        }
        .btn-group i{
            font-size:12px;
        }
    }
    </style>";

    // Add New User Button
    $colspan = $action ? 8 : 7;
    $html .= "<tr>
                <th colspan='{$colspan}' class='text-center'>" . Html::link([
                    "class" => "btn btn-success",
                    "route" => "user/create",
                    "text"  => "Add New User"
                ]) . "</th>
              </tr>";

    $html .= "<div class='table-responsive'>";
    $html .= "<table class='table table-bordered table-striped table-hover'>";

    // Table Head
    $html .= "<thead><tr>
                <th>Id</th>
                <th>name</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role Id</th>
                <th>Address</th>
                <th>Status</th>";
    if ($action) $html .= "<th>Action</th>";
    $html .= "</tr></thead><tbody>";

    // Table Rows
    while ($user = $result->fetch_object()) {
        $action_buttons = "";
        if ($action) {
            $action_buttons = "<td style='white-space:nowrap;'>
                                <div class='btn-group'>
                                    <button class='btn-primary' onclick=\"location.href='{$base_url}/user/edit/$user->id'\">
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button class='btn-danger' onclick=\"if(confirm('Are you sure want to delete this user?')) location.href='{$base_url}/user/confirm/$user->id'\">
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </div>
                              </td>";
        }

        $html .= "<tr>
                    <td>$user->id</td>
                    <td>$user->name</td>
                    <td>$user->password</td>
                    <td>$user->email</td>
                    <td>$user->role_id</td>
                    <td>$user->address</td>
                    <td>$user->status</td>
                    $action_buttons
                  </tr>";
    }

    $html .= "</tbody></table></div>";

    // Pagination
    $html .= pagination($page, $total_pages);

    return $html;
}




	static function html_row_details($id){
		global $db,$tx,$base_url;
		$result =$db->query("select id,name,password,email,role_id,address,status,created_at,updated_at,photo from {$tx}users where id={$id}");
		$user=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">User Show</th></tr>";
		$html.="<tr><th>Id</th><td>$user->id</td></tr>";
		$html.="<tr><th>name</th><td>$user->name</td></tr>";
		$html.="<tr><th>Password</th><td>$user->password</td></tr>";
		$html.="<tr><th>Email</th><td>$user->email</td></tr>";
		$html.="<tr><th>Role Id</th><td>$user->role_id</td></tr>";
		$html.="<tr><th>Address</th><td>$user->address</td></tr>";
		$html.="<tr><th>Status</th><td>$user->status</td></tr>";
		$html.="<tr><th>Created At</th><td>$user->created_at</td></tr>";
		$html.="<tr><th>Updated At</th><td>$user->updated_at</td></tr>";
		$html.="<tr><th>Photo</th><td><img src='$base_url/img/$user->photo' width='100' /></td></tr>";

		$html.="</table>";
		return $html;
	}
}
?>
