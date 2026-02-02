<?php
class Role extends Model implements JsonSerializable{
	public $id;
	public $name;
	public $created_at;
	public $updated_at;

	public function __construct(){
	}
	public function set($id,$name,$created_at,$updated_at){
		$this->id=$id;
		$this->name=$name;
		$this->created_at=$created_at;
		$this->updated_at=$updated_at;

	}
	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}roles(name,created_at,updated_at)values('$this->name','$this->created_at','$this->updated_at')");
		return $db->insert_id;
	}
	public function update(){
		global $db,$tx;
		$db->query("update {$tx}roles set name='$this->name',created_at='$this->created_at',updated_at='$this->updated_at' where id='$this->id'");
	}
	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}roles where id={$id}");
	}
	public function jsonSerialize():mixed{
		return get_object_vars($this);
	}
	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,name,created_at,updated_at from {$tx}roles");
		$data=[];
		while($role=$result->fetch_object()){
			$data[]=$role;
		}
			return $data;
	}

	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,name,created_at,updated_at from {$tx}roles $criteria limit $top,$perpage");
		$data=[];
		while($role=$result->fetch_object()){
			$data[]=$role;
		}
			return $data;
	}

	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}roles $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}

	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,name,created_at,updated_at from {$tx}roles where id='$id'");
		$role=$result->fetch_object();
			return $role;
	}

	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}roles");
		$role =$result->fetch_object();
		return $role->last_id;
	}

	public function json(){
		return json_encode($this);
	}
	public function __toString(){
		return "		Id:$this->id<br> 
		Name:$this->name<br> 
		Created At:$this->created_at<br> 
		Updated At:$this->updated_at<br> 
";
	}

	//-------------HTML----------//

	static function html_select($name="cmbRole"){
		global $db,$tx;
		$html="<select id='$name' name='$name'> ";
		$result =$db->query("select id,name from {$tx}roles");
		while($role=$result->fetch_object()){
			$html.="<option value ='$role->id'>$role->name</option>";
		}
		$html.="</select>";
		return $html;
	}

static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true){
    global $db, $tx, $base_url;

    // -------- COUNT --------
    $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}roles $criteria");
    list($total_rows) = $count_result->fetch_row();
    $total_pages = ceil($total_rows / $perpage);
    $top = ($page - 1) * $perpage;

    // -------- DATA --------
    $result = $db->query("SELECT id, name, created_at, updated_at FROM {$tx}roles $criteria LIMIT $top, $perpage");

    /* ===== CSS same as Users table ===== */
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
    .btn-primary{ background:#3b82f6; }
    .btn-danger{ background:#ef4444; }
    .btn-info{ background:#0ea5e9; }
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
    }
    </style>";

    // Add New Role Button
    $colspan = $action ? 5 : 4;
    $html .= "<tr>
                <th colspan='{$colspan}' class='text-center'>" . Html::link([
                    "class" => "btn btn-success",
                    "route" => "role/create",
                    "text"  => "Add New Role"
                ]) . "</th>
              </tr>";

    $html .= "<div class='table-responsive'>";
    $html .= "<table class='table table-bordered table-striped table-hover'>";

    // Table Head
    $html .= "<thead><tr>
                
                <th>Name</th>
                <th>Created Time</th>
                <th>Updated Time</th>";
    if ($action) $html .= "<th>Action</th>";
    $html .= "</tr></thead><tbody>";

    // Table Rows
    while ($role = $result->fetch_object()) {
        $action_buttons = "";
        if ($action) {
            $action_buttons = "<td style='white-space:nowrap;'>
                                <div class='btn-group'>
                                   
                                    <button class='btn-primary' onclick=\"location.href='{$base_url}/role/edit/$role->id'\">Edit</button>
                                    <button class='btn-danger' onclick=\"if(confirm('Are you sure want to delete this role?')) location.href='{$base_url}/role/confirm/$role->id'\">Delete</button>
                                </div>
                              </td>";
        }

        $html .= "<tr>
                    
                    <td>$role->name</td>
                    <td>$role->created_at</td>
                    <td>$role->updated_at</td>
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
		$result =$db->query("select id,name,created_at,updated_at from {$tx}roles where id={$id}");
		$role=$result->fetch_object();
		$html="<table class='table'>";
		$html.="<tr><th colspan=\"2\">Role Show</th></tr>";
		$html.="<tr><th>Id</th><td>$role->id</td></tr>";
		$html.="<tr><th>Name</th><td>$role->name</td></tr>";
		$html.="<tr><th>Created At</th><td>$role->created_at</td></tr>";
		$html.="<tr><th>Updated At</th><td>$role->updated_at</td></tr>";

		$html.="</table>";
		return $html;
	}

}
?>
