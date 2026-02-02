<?php
class EmployeeController extends Controller {
    public function __construct() {}

    public function index() {
        view("employee");
    }

    public function create() {
        view("employee");
    }

    public function save($data, $file) {
        if(isset($data["btn_save"])) {
            $employee = new Employee();
            $employee->name = $data["name"];
            $employee->dept_id = $data["dept_id"];
            $employee->desig_id = $data["desig_id"];
            $employee->email = $data["email"];
            $employee->phone = $data["phone"];
            $employee->status = $data["status"];
            $employee->gender = $data["gender"];
            $employee->joining_date = $data["joining_date"];

            // ==================== PHOTO HANDLING ====================
            $photoName = null;
            if(isset($file["photo"]) && $file["photo"]["error"] == 0) {
                $ext = pathinfo($file["photo"]["name"], PATHINFO_EXTENSION);
                $photoName = uniqid("emp_").".".$ext;
                move_uploaded_file($file["photo"]["tmp_name"], "uploads/".$photoName);
            }
            $employee->photo = $photoName;
            // ========================================================

            $employee->save();
            redirect();
        }
    }

    public function edit($id) {
        view("employee", Employee::find($id));
    }

    public function update($data, $file) {
        if(isset($data["update"])) {
            $errors = [];

            // (optional validation can be added here)

            if(count($errors) == 0) {
                $employee = new Employee();
                $employee->id = $data["id"];
                $employee->name = $data["name"];
                $employee->dept_id = $data["dept_id"];
                $employee->desig_id = $data["desig_id"];
                $employee->email = $data["email"];
                $employee->phone = $data["phone"];
                $employee->status = $data["status"];
                $employee->gender = $data["gender"];
                $employee->joining_date = $data["joining_date"];

                // ==================== PHOTO HANDLING ====================
                $photoName = $data["existing_photo"] ?? null; // Keep existing if no new upload
                if(isset($file["photo"]) && $file["photo"]["error"] == 0) {
                    // Delete old photo if exists
                    if(!empty($photoName) && file_exists("uploads/".$photoName)) {
                        unlink("uploads/".$photoName);
                    }
                    $ext = pathinfo($file["photo"]["name"], PATHINFO_EXTENSION);
                    $photoName = uniqid("emp_").".".$ext;
                    move_uploaded_file($file["photo"]["tmp_name"], "uploads/".$photoName);
                }
                $employee->photo = $photoName;
                // ========================================================

                $employee->update();
                redirect();
            } else {
                print_r($errors);
            }
        }
    }

    public function confirm($id) {
        view("employee");
    }

    public function delete($id) {
        $employee = Employee::find($id);
        if($employee && !empty($employee->photo) && file_exists("uploads/".$employee->photo)) {
            unlink("uploads/".$employee->photo); // Delete photo file
        }
        Employee::delete($id);
        redirect();
    }

    public function show($id) {
        view("employee", Employee::find($id));
    }
}
?>
