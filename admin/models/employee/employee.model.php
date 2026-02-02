<?php
class Employee extends Model implements JsonSerializable
{
    public $id;
    public $name;
    public $dept_id;
    public $desig_id;
    public $email;
    public $phone;
    public $status;
    public $gender;
    public $joining_date;
    public $photo; // New column added

    public function __construct() {}

    public function set($id, $name, $dept_id, $desig_id, $email, $phone, $status, $gender, $joining_date, $photo = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dept_id = $dept_id;
        $this->desig_id = $desig_id;
        $this->email = $email;
        $this->phone = $phone;
        $this->status = $status;
        $this->gender = $gender;
        $this->joining_date = $joining_date;
        $this->photo = $photo;
    }

    // ===================== SAVE =====================
    public function save()
    {
        global $db, $tx;

        $name = $db->real_escape_string($this->name);
        $dept_id = intval($this->dept_id);
        $desig_id = intval($this->desig_id);
        $email = $db->real_escape_string($this->email);
        $phone = $db->real_escape_string($this->phone);
        $status = $db->real_escape_string($this->status);
        $gender = $db->real_escape_string($this->gender);
        $joining_date = $db->real_escape_string($this->joining_date);
        $photo = $db->real_escape_string($this->photo);

        $db->query("INSERT INTO {$tx}employees(name, dept_id, desig_id, email, phone, status, gender, joining_date, photo)
                    VALUES('$name', '$dept_id', '$desig_id', '$email', '$phone', '$status', '$gender', '$joining_date', '$photo')");

        return $db->insert_id;
    }

    // ===================== UPDATE =====================
    public function update()
    {
        global $db, $tx;

        $name = $db->real_escape_string($this->name);
        $dept_id = intval($this->dept_id);
        $desig_id = intval($this->desig_id);
        $email = $db->real_escape_string($this->email);
        $phone = $db->real_escape_string($this->phone);
        $status = $db->real_escape_string($this->status);
        $gender = $db->real_escape_string($this->gender);
        $joining_date = $db->real_escape_string($this->joining_date);
        $photo = $db->real_escape_string($this->photo);

        $db->query("UPDATE {$tx}employees 
                    SET name='$name', dept_id='$dept_id', desig_id='$desig_id', 
                        email='$email', phone='$phone', status='$status', 
                        gender='$gender', joining_date='$joining_date', photo='$photo'
                    WHERE id='$this->id'");
    }

    // ===================== DELETE =====================
    public static function delete($id)
    {
        global $db, $tx;
        $id = intval($id);
        $db->query("DELETE FROM {$tx}employees WHERE id=$id");
    }

    // ===================== JSON SERIALIZE =====================
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    // ===================== FIND =====================
    public static function find($id)
    {
        global $db, $tx;
        $id = intval($id);
        $result = $db->query("SELECT * FROM {$tx}employees WHERE id='$id'");
        return $result->fetch_object();
    }

    // ===================== GET ALL =====================
    public static function all()
    {
        global $db, $tx;
        $result = $db->query("SELECT * FROM {$tx}employees");
        $data = [];
        while ($employee = $result->fetch_object()) {
            $data[] = $employee;
        }
        return $data;
    }

    // ===================== HTML SELECT =====================
    static function html_select($name = "cmbEmployee", $dept_id = null)
    {
        global $db, $tx;

        $html = "<select id='$name' name='$name' class='form-control'>";
        $html .= "<option value=''>Select Employee</option>";
        $sql = "SELECT id, name FROM {$tx}employees";
        if ($dept_id !== null) {
            $dept_id = intval($dept_id);
            $sql .= " WHERE dept_id=$dept_id";
        }

        $result = $db->query($sql);
        while ($employee = $result->fetch_object()) {
            $html .= "<option value='$employee->id'>$employee->name</option>";
        }

        $html .= "</select>";
        return $html;
    }

    // ===================== HTML TABLE =====================
  static function html_table($page = 1, $perpage = 5, $criteria = "", $action = true)
{
    global $db, $tx, $base_url;

    // ======= Pagination Setup =======
    $count_result = $db->query("SELECT COUNT(*) total FROM {$tx}employees $criteria");
    list($total_rows) = $count_result->fetch_row();
    $total_pages = ceil($total_rows / $perpage);
    $top = ($page - 1) * $perpage;

    // ======= Fetch Employee Data =======
    $result = $db->query("
        SELECT e.id, e.name, e.email, e.phone, e.status, e.gender, e.joining_date, e.photo,
               d.name AS dept_name,
               ds.name AS desig_name
        FROM {$tx}employees e
        LEFT JOIN {$tx}department d ON e.dept_id = d.id
        LEFT JOIN {$tx}designations ds ON e.desig_id = ds.id
        $criteria
        ORDER BY e.id DESC
        LIMIT $top, $perpage
    ");

    // ======= Table CSS & Card Design =======
    $html = "
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        .dept-card { max-width: 1200px; margin: 30px auto; background: #fff; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); font-family: 'Poppins', sans-serif; overflow: hidden; border: 1px solid #e2e8f0; }
        .dept-card-body { padding: 20px 25px; overflow-x: auto; }
        .dept-table { width: 100%; border-collapse: collapse; }
        .dept-table th, .dept-table td { padding: 12px 15px; text-align: center; font-size: 14px; border: 1px solid #e2e8f0; word-wrap: break-word; }
        .dept-table th { background-color: #1f3d79ff; color: #ffffff; font-weight: 600; }
        .dept-table tr:hover { background: #f1f5f9; transition: 0.2s; }
        .btn-group { display: flex !important; justify-content: center; gap: 6px; }
        .btn-group button { padding: 6px 12px !important; font-size: 14px !important; border-radius: 5px; border: 2px solid #000; outline: none; cursor: pointer; color: #fff; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .btn-primary { background: #3b82f6; }
        .btn-danger { background: #ef4444; }
        .photo-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc; }
        .add-btn { display: inline-block; margin-bottom: 15px; padding: 8px 16px; background: #10b981; color: #fff; font-weight: 600; border-radius: 6px; text-decoration: none; }
        .pagination { display: flex; justify-content: center; gap: 6px; margin-top: 15px; }
        .pagination a { padding: 6px 12px; border-radius: 5px; border: 1px solid #1f3d79ff; text-decoration: none; color: #1f3d79ff; font-weight: 500; }
        .pagination a.active { background: #1f3d79ff; color: #fff; }
        .pagination a:hover { background: #3b82f6; color: #fff; }
    </style>
    ";

    // ======= Card & Table Start =======
    $html .= "<div class='dept-card'>
                <div class='dept-card-body'>
                    <a href='{$base_url}/employee/create' class='add-btn'>+ Add Employee</a>
                    <table class='dept-table'>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Gender</th>
                            <th>Photo</th>
                            <th>Joining Date</th>";
    if($action) $html .= "<th>Action</th>";
    $html .= "</tr>";

    // ======= Table Rows =======
    while($employee = $result->fetch_object()) {
        $photo = $employee->photo && file_exists("uploads/".$employee->photo) 
                  ? "<img src='{$base_url}/uploads/{$employee->photo}' class='photo-img' />" 
                  : "-";

        $html .= "<tr>
                    <td>$employee->id</td>
                    <td>$employee->name</td>
                    <td>$employee->dept_name</td>
                    <td>$employee->desig_name</td>
                    <td>$employee->email</td>
                    <td>$employee->phone</td>
                    <td>$employee->status</td>
                    <td>$employee->gender</td>
                    <td>$photo</td>
                    <td>$employee->joining_date</td>";

        if($action){
            $html .= "<td style='white-space: nowrap;'>
                        <div class='btn-group'>
                            <button class='btn-primary' onclick=\"location.href='{$base_url}/employee/edit/$employee->id'\"><i class='fas fa-edit'></i></button>
                            <button class='btn-danger' onclick=\"if(confirm('Are you sure you want to delete this employee?')){ window.location='{$base_url}/employee/delete/$employee->id'; }\"><i class='fas fa-trash-alt'></i></button>
                        </div>
                      </td>";
        }

        $html .= "</tr>";
    }

    $html .= "</table>";

    // ======= Pagination =======
    $html .= "<div class='pagination'>" . self::pagination($page, $total_pages) . "</div>";
    $html .= "</div></div>";

    return $html;
}


    // ===================== PAGINATION =====================
    static function pagination($current_page, $total_pages)
    {
        $html = "<ul style='list-style:none; display:flex; justify-content:center; gap:5px; padding:0;'>";
        $prev = $current_page - 1;
        $html .= "<li>";
        if($current_page > 1){
            $html .= "<a href='?page=$prev' style='padding:6px 12px; border:1px solid #1f3d79; color:#1f3d79; text-decoration:none;'>Prev</a>";
        } else {
            $html .= "<a href='?page=1' style='padding:6px 12px; border:1px solid #ccc; color:#ccc; text-decoration:none;'>Prev</a>";
        }
        $html .= "</li>";

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                $html .= "<li><span style='padding:6px 12px; border:1px solid #1f3d79; background:#1f3d79; color:#fff;'>{$i}</span></li>";
            } else {
                $html .= "<li><a href='?page=$i' style='padding:6px 12px; border:1px solid #1f3d79; color:#1f3d79; text-decoration:none;'>{$i}</a></li>";
            }
        }

        $next = $current_page + 1;
        $html .= "<li>";
        if($current_page < $total_pages){
            $html .= "<a href='?page=$next' style='padding:6px 12px; border:1px solid #1f3d79; color:#1f3d79; text-decoration:none;'>Next</a>";
        } else {
            $html .= "<a href='?page=$total_pages' style='padding:6px 12px; border:1px solid #ccc; color:#ccc; text-decoration:none;'>Next</a>";
        }
        $html .= "</li>";

        $html .= "</ul>";
        return $html;
    }
}
?>
