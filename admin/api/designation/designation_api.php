<?php
class DesignationApi {
    public function __construct() {}

    // Return all designations
    function index() {
        echo json_encode(["designations" => Designation::getall()]);
    }

    // Pagination
    function pagination($data) {
        $page = $data["page"];
        $perpage = $data["perpage"];
        echo json_encode([
            "designations" => Designation::pagination($page, $perpage),
            "total_records" => Designation::count()
        ]);
    }

    // Find designation by ID
    function find($data) {
        echo json_encode(["designation" => Designation::find($data["id"])]);
    }

    // Delete designation
    function delete($data) {
        Designation::delete($data["id"]);
        echo json_encode(["success" => "yes"]);
    }

    // Save new designation
    function save($data, $file = []) {
        $designation = new Designation();
        $designation->dept_id = $data["dept_id"];
        $designation->name = $data["name"];
        $designation->description = $data["description"];
        $designation->save();
        echo json_encode(["success" => "yes"]);
    }

    // Update existing designation
    function update($data, $file = []) {
        $designation = new Designation();
        $designation->id = $data["id"];
        $designation->dept_id = $data["dept_id"];
        $designation->name = $data["name"];
        $designation->description = $data["description"];
        $designation->update();
        echo json_encode(["success" => "yes"]);
    }

    // ✅ New: Find designations by department id (for Employee AJAX)
    function find_by_dep_id($data) {
        $dept_id = isset($data["id"]) ? intval($data["id"]) : 0;
        if ($dept_id > 0) {
            $designations = Designation::getall($dept_id); // filtered by department
        } else {
            $designations = [];
        }
        echo json_encode($designations);
    }
}
?>
