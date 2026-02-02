<?php
class LeaveAssign extends Model implements JsonSerializable{
	public $id;
	public $emp_id;
	public $leave_type_id;
	public $allow_days;
	public $used_days;
	public $year;
	// public $created_at;
	// public $updated_at;

	public function __construct(){
	}
	public function set($id,$emp_id,$leave_type_id,$allow_days,$used_days,$year){
		$this->id=$id;
		$this->emp_id=$emp_id;
		$this->leave_type_id=$leave_type_id;
		$this->allow_days=$allow_days;
		$this->used_days=$used_days;
		$this->year=$year;
		// $this->created_at=$created_at;
		// $this->updated_at=$updated_at;

	}

	public function save(){
		global $db,$tx;
		$db->query("insert into {$tx}leave_assign(emp_id,leave_type_id,allow_days,used_days,year)values('$this->emp_id','$this->leave_type_id','$this->allow_days','$this->used_days','$this->year')");
		return $db->insert_id;
	}

	public function update(){
		global $db,$tx;
		$db->query("update {$tx}leave_assign set emp_id='$this->emp_id',leave_type_id='$this->leave_type_id',allow_days='$this->allow_days',used_days='$this->used_days',year='$this->year' where id='$this->id'");
	}

	public static function delete($id){
		global $db,$tx;
		$db->query("delete from {$tx}leave_assign where id={$id}");
	}

	public function jsonSerialize():mixed{
		return get_object_vars($this);
	}

	public static function all(){
		global $db,$tx;
		$result=$db->query("select id,emp_id,leave_type_id,allow_days,used_days,year from {$tx}leave_assign");
		$data=[];
		while($leaveassign=$result->fetch_object()){
			$data[]=$leaveassign;
		}
			return $data;
	}

	public static function pagination($page=1,$perpage=10,$criteria=""){
		global $db,$tx;
		$top=($page-1)*$perpage;
		$result=$db->query("select id,emp_id,leave_type_id,allow_days,used_days,year from {$tx}leave_assign $criteria limit $top,$perpage");
		$data=[];
		while($leaveassign=$result->fetch_object()){
			$data[]=$leaveassign;
		}
			return $data;
	}

	public static function count($criteria=""){
		global $db,$tx;
		$result =$db->query("select count(*) from {$tx}leave_assign $criteria");
		list($count)=$result->fetch_row();
			return $count;
	}

	public static function find($id){
		global $db,$tx;
		$result =$db->query("select id,emp_id,leave_type_id,allow_days,used_days,year from {$tx}leave_assign where id='$id'");
		$leaveassign=$result->fetch_object();
			return $leaveassign;
	}

	static function get_last_id(){
		global $db,$tx;
		$result =$db->query("select max(id) last_id from {$tx}leave_assign");
		$leaveassign =$result->fetch_object();
		return $leaveassign->last_id;
	}

	public function json(){
		return json_encode($this);
	}

	public function __toString(){
		return "		Id:$this->id<br> 
		Emp Id:$this->emp_id<br> 
		Leave Type Id:$this->leave_type_id<br> 
		Allow Days:$this->allow_days<br> 
		Used Days:$this->used_days<br> 
		Year:$this->year<br> ";
	}

	//-------------HTML----------//

	static function html_select($name="cmbLeaveAssign"){
    global $db, $tx;
    $html = "<select id='$name' name='$name'> ";
    $result = $db->query("SELECT id, name FROM {$tx}leave_types");
    while($leave = $result->fetch_object()){
        $html .= "<option value='$leave->id'>$leave->name</option>";
    }
    $html .= "</select>";
    return $html;
}



	
static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true)
{
    global $db, $tx, $base_url;

    // -------- COUNT --------
    $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}leave_assign $criteria");
    list($total_rows) = $count_result->fetch_row();
    $total_pages = ceil($total_rows / $perpage);
    $top = ($page - 1) * $perpage;

    // -------- DATA --------
    $result = $db->query("
        SELECT la.id, la.emp_id, la.leave_type_id, la.allow_days, la.used_days, la.year,
               e.name AS emp_name, lt.name AS leave_type_name
        FROM {$tx}leave_assign la
        LEFT JOIN {$tx}employees e ON la.emp_id = e.id
        LEFT JOIN {$tx}leave_types lt ON la.leave_type_id = lt.id
        $criteria
        LIMIT $top, $perpage
    ");

    /* ===== CSS (ONLY td border added) ===== */
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
        border:1px solid #000;   /* ✅ ONLY change */
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

    $colspan = $action ? 7 : 6;
    $html .= "<tr>
        <th colspan='{$colspan}' class='text-center'>
            " . Html::link([
                'class' => 'btn btn-success',
                'route' => 'leaveassign/create',
                'text'  => '+ Add Leave Assign'
            ]) . "
        </th>
    </tr>";

    $html .= "<div class='table-responsive'>";
    $html .= "<table class='table table-bordered table-striped table-hover'>";

    // -------- HEAD --------
    $html .= "<thead>
        <tr>
            <th>Employee Name</th>
            <th>Leave Name</th>
            <th>Allow Days</th>
            <th>Used Days</th>
            <th>Year</th>";
    if($action) $html .= "<th>Action</th>";
    $html .= "</tr>
    </thead><tbody>";

    // -------- ROWS --------
    while($la = $result->fetch_object()){
        $action_buttons = "";
        if($action){
            $action_buttons = "
            <td style='white-space:nowrap;'>
                <div class='btn-group'>
                    <button class='btn-primary' onclick=\"location.href='{$base_url}/leaveassign/edit/$la->id'\">
                        <i class='fas fa-edit'></i>
                    </button>
                    <button class='btn-danger' onclick=\"if(confirm('Are you sure want to delete this Leave Assign?'))
                        location.href='{$base_url}/leaveassign/confirm/$la->id'\">
                        <i class='fas fa-trash-alt'></i>
                    </button>
                </div>
            </td>";
        }

        $html .= "<tr>
            <td>{$la->emp_name}</td>
            <td>{$la->leave_type_name}</td>
            <td>{$la->allow_days}</td>
            <td>{$la->used_days}</td>
            <td>{$la->year}</td>
            $action_buttons
        </tr>";
    }

    $html .= "</tbody></table></div>";

    // -------- PAGINATION --------
    $html .= pagination($page, $total_pages);

    return $html;
}





static function html_row_details($id){
    global $db, $tx, $base_url;

    $id = (int)$id;

    $result = $db->query("
        SELECT id, emp_id, leave_type_id, allow_days, used_days, year 
        FROM {$tx}leave_assign 
        WHERE id = {$id}
        LIMIT 1
    ");

    if(!$result || $result->num_rows == 0){
        return "<div style='text-align:center;color:red;'>No data found</div>";
    }

    $leaveassign = $result->fetch_object();

    $html = "<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        .details-table {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            background: #fff;
        }

        .details-table th, .details-table td {
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            text-align: left;
            font-size: 14px;
            color: #000;
        }

        .details-table th {
            background: #1f3d79ff;
            color: #fff;
            font-weight: 600;
            width: 35%;
        }

        .details-table tr:nth-child(even) {
            background: #f2f2f2;
        }

        .details-table tr:hover {
            background: #f1f5f9;
            transition: 0.2s;
        }

        .details-table caption {
            caption-side: top;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #0d6efd;
        }
    </style>";

    $html .= "<table class='details-table'>";
    // $html .= "<caption>Leave Assign Details</caption>";
    // $html .= "<tr><th>ID</th><td>{$leaveassign->id}</td></tr>";
    $html .= "<tr><th>Employee ID</th><td>{$leaveassign->emp_id}</td></tr>";
    $html .= "<tr><th>Leave Type ID</th><td>{$leaveassign->leave_type_id}</td></tr>";
    $html .= "<tr><th>Allowed Days</th><td>{$leaveassign->allow_days}</td></tr>";
    $html .= "<tr><th>Used Days</th><td>{$leaveassign->used_days}</td></tr>";
    $html .= "<tr><th>Year</th><td>{$leaveassign->year}</td></tr>";
    $html .= "</table>";

    return $html;
}



}
?>
