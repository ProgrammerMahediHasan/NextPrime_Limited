<?php
class Designation extends Model implements JsonSerializable {
    public $id;
    public $dept_id;
    public $name;
    public $description;

    public function __construct(){}

    // Set values
    public function set($id, $dept_id, $name, $description){
        $this->id = $id;
        $this->dept_id = $dept_id;
        $this->name = $name;
        $this->description = $description;
    }

    // Save new designation
    public function save(){
        global $db, $tx;
        $dept_id = intval($this->dept_id);
        $name = $db->real_escape_string($this->name);
        $description = $db->real_escape_string($this->description);

        $db->query("INSERT INTO {$tx}designations(dept_id, name, description)
                    VALUES('$dept_id', '$name', '$description')");
        return $db->insert_id;
    }

    // Update existing designation
    public function update(){
        global $db, $tx;
        $id = intval($this->id);
        $dept_id = intval($this->dept_id);
        $name = $db->real_escape_string($this->name);
        $description = $db->real_escape_string($this->description);

        $db->query("UPDATE {$tx}designations
                    SET dept_id='$dept_id', name='$name', description='$description'
                    WHERE id='$id'");
    }

    // Delete designation
    public static function delete($id){
        global $db, $tx;
        $id = intval($id);
        $db->query("DELETE FROM {$tx}designations WHERE id=$id");
    }

    // Get all designations (optional filter by department)
    public static function getAll($dept_id = null){
        global $db, $tx;
        $sql = "SELECT * FROM {$tx}designations";
        if($dept_id !== null){
            $dept_id = intval($dept_id);
            $sql .= " WHERE dept_id=$dept_id";
        }
        $result = $db->query($sql);
        $data = [];
        while($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    // Find by ID
    public static function find($id){
        global $db, $tx;
        $id = intval($id);
        $result = $db->query("
            SELECT d.id, d.name, d.description, d.dept_id, dep.name AS dept_name
            FROM {$tx}designations d
            JOIN {$tx}department dep ON dep.id=d.dept_id
            WHERE d.id='$id'
        ");
        return $result->fetch_object();
    }

    // Count rows
    public static function count($criteria=""){
        global $db, $tx;
        $result = $db->query("SELECT COUNT(*) FROM {$tx}designations $criteria");
        list($count) = $result->fetch_row();
        return $count;
    }

    // JSON serialization
    public function json(){
        return json_encode($this);
    }

    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }

    // ==================== HTML Helpers ====================

    // Designation dropdown
    static function html_select($name="cmbDesignation", $dept_id=null){
        global $db, $tx;
        $html = "<select id='$name' name='$name' class='form-control'>";
        $html .= "<option value=''>Select Designation</option>";

        $sql = "SELECT id, name FROM {$tx}designations";
        if($dept_id !== null){
            $dept_id = intval($dept_id);
            $sql .= " WHERE dept_id=$dept_id";
        }

        $result = $db->query($sql);
        while($desg = $result->fetch_object()){
            $html .= "<option value='$desg->id'>$desg->name</option>";
        }
        $html .= "</select>";
        return $html;
    }

    // Designation table with department name and delete confirmation
    static function html_table($page=1, $perpage=10, $criteria="", $action=true){
        global $db, $tx, $base_url;

        $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}designations $criteria");
        list($total_rows) = $count_result->fetch_row();
        $total_pages = ceil($total_rows / $perpage);
        $top = ($page-1)*$perpage;

        $result = $db->query("
            SELECT d.id, d.name, d.description, d.dept_id, dep.name AS dept_name
            FROM {$tx}designations d
            JOIN {$tx}department dep ON dep.id=d.dept_id
            $criteria
            LIMIT $top, $perpage
        ");

        $html = "<style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
            .desg-table{width:100%;border-collapse:collapse;}
            .desg-table th,.desg-table td{padding:10px;border:1px solid #e2e8f0;text-align:center;}
            .desg-table th{background:#1f3d79;color:#fff;font-weight:600;}
            .btn-group{display:flex;justify-content:center;gap:6px;}
            .btn-primary{background:#3b82f6;color:#fff;border:none;padding:6px 10px;cursor:pointer;}
            .btn-danger{background:#ef4444;color:#fff;border:none;padding:6px 10px;cursor:pointer;}
            .desg-table tr:hover{background:#f1f5f9;transition:0.2s;}
        </style>";

        $html .= "<div style='margin-bottom:10px;text-align:left;'>
                    <a href='{$base_url}/designation/create' class='btn btn-success' style='padding:6px 12px;'>+ Add Designation</a>
                  </div>";

        $html .= "<table class='desg-table'>";
        $html .= "<tr><th>ID</th><th>Department</th><th>Designation</th><th>Description</th>";
        if($action) $html .= "<th>Action</th>";
        $html .= "</tr>";

        while($desg = $result->fetch_object()){
            $html .= "<tr>
                        <td>$desg->id</td>
                        <td>$desg->dept_name</td>
                        <td>$desg->name</td>
                        <td>$desg->description</td>";
            if($action){
                $html .= "<td>
                            <div class='btn-group'>
                                <button class='btn-primary' onclick=\"location.href='{$base_url}/designation/edit/$desg->id'\"><i class='fas fa-edit'></i></button>
                                <button class='btn-danger' onclick=\"if(confirm('Are you sure to delete this designation?')) location.href='{$base_url}/designation/delete/$desg->id'\"><i class='fas fa-trash-alt'></i></button>
                            </div>
                          </td>";
            }
            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }
}
?>
