<?php
class Department extends Model implements JsonSerializable {
    public $id;
    public $name;
    public $description;
    public $status;

    public function __construct(){}

    // Set values
    public function set($id, $name, $description, $status){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    // Save new department
    public function save(){
        global $db, $tx;
        $name = $db->real_escape_string($this->name);
        $description = $db->real_escape_string($this->description);
        $status = $db->real_escape_string($this->status);

        $db->query("INSERT INTO {$tx}department(name, description, status) 
                    VALUES('$name', '$description', '$status')");
        return $db->insert_id;
    }

    // Update existing department
    public function update(){
        global $db, $tx;
        $id = intval($this->id);
        $name = $db->real_escape_string($this->name);
        $description = $db->real_escape_string($this->description);
        $status = $db->real_escape_string($this->status);

        $db->query("UPDATE {$tx}department 
                    SET name='$name', description='$description', status='$status' 
                    WHERE id='$id'");
    }

    // Delete department
    public static function delete($id){
        global $db, $tx;
        $id = intval($id);
        $db->query("DELETE FROM {$tx}department WHERE id=$id");
    }

    // Get all departments
    public static function getAll(){
        global $db, $tx;
        $result = $db->query("SELECT * FROM {$tx}department");
        $data = [];
        while($dept = $result->fetch_object()){
            $data[] = $dept;
        }
        return $data;
    }

    // Find by ID
    public static function find($id){
        global $db, $tx;
        $id = intval($id);
        $result = $db->query("SELECT * FROM {$tx}department WHERE id='$id'");
        return $result->fetch_object();
    }

    // Count rows
    public static function count($criteria=""){
        global $db, $tx;
        $result = $db->query("SELECT COUNT(*) FROM {$tx}department $criteria");
        list($count) = $result->fetch_row();
        return $count;
    }

    // Get last inserted ID
    public static function get_last_id(){
        global $db, $tx;
        $result = $db->query("SELECT MAX(id) last_id FROM {$tx}department");
        $obj = $result->fetch_object();
        return $obj->last_id;
    }

    // Convert to JSON
    public function json(){
        return json_encode($this);
    }

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }

    public function __toString(){
        return "Id: $this->id<br>
                Name: $this->name<br>
                Description: $this->description<br>
                Status: $this->status<br>";
    }

    // ==================== HTML Helpers ====================

    // Department dropdown select
    static function html_select($name="cmbDepartment"){
        global $db, $tx;
        $html = "<select id='$name' name='$name' class='form-control'>";
        $html .= "<option value=''>Select Department</option>";
        $result = $db->query("SELECT id, name FROM {$tx}department");
        while($dept = $result->fetch_object()){
            $html .= "<option value='$dept->id'>$dept->name</option>";
        }
        $html .= "</select>";
        return $html;
    }

    // Department table with delete confirmation
    static function html_table($page = 1, $perpage = 10, $criteria = "", $action = true){
        global $db, $tx, $base_url;

        $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}department $criteria");
        list($total_rows) = $count_result->fetch_row();
        $total_pages = ceil($total_rows / $perpage);
        $top = ($page - 1) * $perpage;

        $result = $db->query("SELECT id, name, description, status 
                              FROM {$tx}department $criteria 
                              LIMIT $top, $perpage");

        $html = "<style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
            .dept-table { width: 100%; border-collapse: collapse; }
            .dept-table th, .dept-table td { padding: 10px; border: 1px solid #e2e8f0; text-align: center; }
            .dept-table th { background-color: #1f3d79ff; color: #fff; font-weight: 600; }
            .btn-group { display: flex; justify-content: center; gap: 6px; }
            .btn-primary { background: #3b82f6; color: #fff; padding: 6px 10px; border: none; cursor: pointer; }
            .btn-danger { background: #ef4444; color: #fff; padding: 6px 10px; border: none; cursor: pointer; }
        </style>";

        $html .= "<div style='margin-bottom:10px; text-align:left;'>
                    <a href='{$base_url}/department/create' class='btn btn-success' style='padding:6px 12px;'>+ Add Department</a>
                  </div>";

        $html .= "<table class='dept-table'>";
        $html .= "<tr><th>ID</th><th>Name</th><th>Description</th><th>Status</th>";
        if($action) $html .= "<th>Action</th>";
        $html .= "</tr>";

        while($dept = $result->fetch_object()){
            $html .= "<tr>
                        <td>$dept->id</td>
                        <td>$dept->name</td>
                        <td>$dept->description</td>
                        <td>$dept->status</td>";
            if($action){
                $html .= "<td>
                            <div class='btn-group'>
                                <button class='btn-primary' onclick=\"location.href='{$base_url}/department/edit/$dept->id'\"><i class='fas fa-edit'></i></button>
                                <!-- Delete with confirmation alert -->
                                <button class='btn-danger' onclick=\"if(confirm('Are you sure to delete this department?')) location.href='{$base_url}/department/delete/$dept->id'\"><i class='fas fa-trash-alt'></i></button>
                            </div>
                          </td>";
            }
            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }

    // Single department details (HTML)
    static function html_row_details($id){
        global $db, $tx;
        $result = $db->query("SELECT id, name, description, status FROM {$tx}department WHERE id=".intval($id));
        $dept = $result->fetch_object();

        $html = "<table class='table'>";
        $html .= "<tr><th colspan='2'>Department Details</th></tr>";
        $html .= "<tr><th>ID</th><td>$dept->id</td></tr>";
        $html .= "<tr><th>Name</th><td>$dept->name</td></tr>";
        $html .= "<tr><th>Description</th><td>$dept->description</td></tr>";
        $html .= "<tr><th>Status</th><td>$dept->status</td></tr>";
        $html .= "</table>";

        return $html;
    }
}
?>
