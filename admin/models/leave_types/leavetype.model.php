<?php
class LeaveType extends Model implements JsonSerializable{
    public $id;
    public $name;
    public $leave_code;
    public $total_days;
    public $deduct_apply;
    public $description;
    public $status;

    public function __construct(){}

    public function set($id,$name,$leave_code,$total_days,$deduct_apply,$description,$status){
        $this->id = $id;
        $this->name = $name;
        $this->leave_code = $leave_code;
        $this->total_days = $total_days;
        $this->deduct_apply = $deduct_apply;
        $this->description = $description;
        $this->status = $status;
    }

    public function save(){
        global $db,$tx;
        $db->query("INSERT INTO {$tx}leave_types(name,leave_code,total_days,deduct_apply,description,status)
                    VALUES('$this->name','$this->leave_code','$this->total_days','$this->deduct_apply','$this->description','$this->status')");
        return $db->insert_id;
    }

    public function update(){
        global $db,$tx;
        $query = "
            UPDATE {$tx}leave_types SET
                name='{$this->name}',
                leave_code='{$this->leave_code}',
                total_days='{$this->total_days}',
                description='{$this->description}',
                status='{$this->status}',
                deduct_apply='{$this->deduct_apply}'
            WHERE id='{$this->id}'
        ";
        $db->query($query);
    }

    public static function delete($id){
        global $db,$tx;
        $db->query("DELETE FROM {$tx}leave_types WHERE id={$id}");
    }

    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }

    public static function all(){
        global $db,$tx;
        $result = $db->query("SELECT id,name,leave_code,total_days,deduct_apply,description,status FROM {$tx}leave_types");
        $data = [];
        while($leavetype = $result->fetch_object()){
            $data[] = $leavetype;
        }
        return $data;
    }

    public static function find($id){
        global $db,$tx;
        $result = $db->query("SELECT id,name,leave_code,total_days,deduct_apply,description,status FROM {$tx}leave_types WHERE id='$id'");
        return $result->fetch_object();
    }

    public static function count($criteria=""){
        global $db,$tx;
        $result = $db->query("SELECT COUNT(*) FROM {$tx}leave_types $criteria");
        list($count) = $result->fetch_row();
        return $count;
    }

    public static function pagination($page=1,$perpage=10,$criteria=""){
        global $db,$tx;
        $top = ($page-1)*$perpage;
        $result = $db->query("SELECT id,name,leave_code,total_days,deduct_apply,description,status 
                              FROM {$tx}leave_types $criteria LIMIT $top,$perpage");
        $data = [];
        while($leavetype = $result->fetch_object()){
            $data[] = $leavetype;
        }
        return $data;
    }

    static function get_last_id(){
        global $db,$tx;
        $result = $db->query("SELECT MAX(id) last_id FROM {$tx}leave_types");
        $leavetype = $result->fetch_object();
        return $leavetype->last_id;
    }

    public function json(){
        return json_encode($this);
    }

    public function __toString(){
        return "Id:$this->id<br>
        Leave Name:$this->name<br>
        Leave Code:$this->leave_code<br>
        Total Days:$this->total_days<br>
        Deduct Leave:$this->deduct_apply<br>
        Description:$this->description<br>
        Status:$this->status<br>";
    }

    // ------------- HTML Helpers ---------------- //

    static function html_select($name="cmbLeaveType"){
        global $db,$tx;
        $html = "<select id='$name' name='$name'> ";
        $result = $db->query("SELECT id,name FROM {$tx}leave_types");
        while($leavetype = $result->fetch_object()){
            $html .= "<option value ='$leavetype->id'>$leavetype->name</option>";
        }
        $html .= "</select>";
        return $html;
    }

    static function html_status_select($name="status", $selected=null, $class="form-control"){
        $options = ["active" => "Active","inactive" => "Inactive"];
        $html = "<select name='{$name}' id='{$name}' class='{$class}'>";
        foreach($options as $value => $label){
            $isSelected = ($selected !== null && $selected == $value) ? "selected" : "";
            $html .= "<option value='{$value}' {$isSelected}>{$label}</option>";
        }
        $html .= "</select>";
        return $html;
    }

    // Modern HTML Table
    static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true){
        global $db,$tx,$base_url;

        $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}leave_types $criteria");
        list($total_rows) = $count_result->fetch_row();
        $total_pages = ceil($total_rows / $perpage);
        $top = ($page-1)*$perpage;

        $result = $db->query("SELECT id,name,leave_code,total_days,deduct_apply,description,status 
                              FROM {$tx}leave_types $criteria LIMIT $top,$perpage");

        // Professional CSS
        $html = "<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        .leave-card {
            max-width: 1100px;
            margin: 25px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .leave-card-header {
            background: linear-gradient(135deg,#2563eb,#1d4ed8);
            color: #fff;
            padding: 18px 25px;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }
        .leave-card-body { padding: 20px 25px; overflow-x:auto; }
        .leave-table { width:100%; border-collapse: collapse; }
        .leave-table th, .leave-table td { padding:10px 12px; text-align:center; border:1px solid #e2e8f0; word-wrap: break-word; }
        .leave-table th { background:#1f3d79ff; font-weight:600; color:#e7e8eba9; }
        .leave-table tr:hover { background:#f1f5f9; transition:0.2s; }
        .btn-group { display:flex !important; justify-content:center; gap:6px; flex-wrap:nowrap; }
        .btn-group button { padding:6px 10px !important; font-size:14px !important; border-radius:4px; border:2px solid #000; outline:none; cursor:pointer; color:#fff; font-weight:700; display:flex; align-items:center; justify-content:center; }
        .btn-group i { font-weight:900; }
        .btn-group button:focus { outline:none; border:1px solid rgba(0,0,0,0.3); box-shadow:none; }
        .btn-primary { background:#3b82f6; }
        .btn-danger { background:#ef4444; }
        @media(max-width:768px) { .leave-table th,.leave-table td{ font-size:12px; padding:6px 8px; } .btn-group button{ font-size:10px; padding:3px 5px; } }
        </style>";

        // $html .= "<div class='leave-card'>";
        // $html .= "<div class='leave-card-header'>Leave Types</div>";
        // $html .= "<div class='leave-card-body'>";

        $html .= "<div style='margin-bottom:10px; text-align:left;'>
                    <a href='{$base_url}/leavetype/create' class='btn btn-success' style='padding:6px 12px;'>+ Add Leave Type</a>
                  </div>";

        $html .= "<table class='leave-table'>";
        $html .= "<thead><tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Total Days</th>
                    <th>Deduct</th>
                    <th>Description</th>
                    <th>Status</th>";
        if($action) $html .= "<th>Action</th>";
        $html .= "</tr></thead><tbody>";

        while($lt = $result->fetch_object()){
            $deduct = ($lt->deduct_apply == 1) ? "<span style='color:red;font-weight:bold;'>Unpaid</span>" 
                                               : "<span style='color:green;font-weight:bold;'>Paid</span>";
            $buttons = "";
            if($action){
                $buttons = "<td style='white-space:nowrap;'>
                                <div class='btn-group'>
                                    <button class='btn-primary' onclick=\"location.href='{$base_url}/leavetype/edit/$lt->id'\"><i class='fas fa-edit'></i></button>
                                    <button class='btn-danger' onclick=\"if(confirm('Are you sure want to delete this Leave Type?')) location.href='{$base_url}/leavetype/confirm/$lt->id'\"><i class='fas fa-trash-alt'></i></button>
                                </div>
                            </td>";
            }

            $html .= "<tr>
                        <td>{$lt->name}</td>
                        <td>{$lt->leave_code}</td>
                        <td>{$lt->total_days}</td>
                        <td>{$deduct}</td>
                        <td>{$lt->description}</td>
                        <td>{$lt->status}</td>
                        $buttons
                      </tr>";
        }

        $html .= "</tbody></table>";
        $html .= "<div style='margin-top:10px;text-align:center;'>" . pagination($page,$total_pages) . "</div>";
        $html .= "</div></div>";

        return $html;
    }

    // Modern row details view
    static function html_row_details($id){
        global $db,$tx;
        $result = $db->query("SELECT id,name,leave_code,total_days,deduct_apply,description,status FROM {$tx}leave_types WHERE id={$id}");
        $lt = $result->fetch_object();

        $html = "<style>
        .details-table { max-width:600px; margin:15px auto; border-collapse:collapse; font-family:'Poppins',sans-serif; }
        .details-table th, .details-table td { padding:10px 12px; border:1px solid #e2e8f0; text-align:left; }
        .details-table th { background:#1f3d79ff; color:#fff; font-weight:600; }
        </style>";

        $html .= "<table class='details-table'>";
        $html .= "<tr><th>Leave Name</th><td>$lt->name</td></tr>";
        $html .= "<tr><th>Leave Code</th><td>$lt->leave_code</td></tr>";
        $html .= "<tr><th>Total Days</th><td>$lt->total_days</td></tr>";
        $html .= "<tr><th>Deduct Leave</th><td>" . (($lt->deduct_apply==1)?"Unpaid":"Paid") . "</td></tr>";
        $html .= "<tr><th>Description</th><td>$lt->description</td></tr>";
        $html .= "<tr><th>Status</th><td>$lt->status</td></tr>";
        $html .= "</table>";

        return $html;
    }
}
?>
