<?php

class Attendence {
    public $atten_id;
    public $id;
    public $atten_date;
    public $emp_status;
    public $time_in;
    public $time_out;
    public $remarks;
    public $created_time;

    // Constructor
    public function __construct($atten_id, $emp_id, $atten_date, $emp_status, $time_in, $time_out, $remarks, $created_time)
    {
        $this->atten_id       = $atten_id;
        $this->emp_id         = $emp_id;
        $this->atten_date     = $atten_date;
        $this->emp_status     = $emp_status;
        $this->time_in        = $time_in;
        $this->time_out       = $time_out;
        $this->remarks        = $remarks;
        $this->created_time   = $created_time;
    }

    // Fetch all attendance records
    public static function getAll()
    {
        global $db, $tx;
        $stmt = $db->prepare("SELECT * FROM {$tx}attendence ORDER BY atten_id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Save new attendance record
    public function save()
    {
        global $db, $tx;
        $stmt = $db->prepare("INSERT INTO {$tx}attendence 
            (emp_id, atten_date, emp_status, time_in, time_out, remarks, created_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "issssss",
            $this->emp_id,
            $this->atten_date,
            $this->emp_status,
            $this->time_in,
            $this->time_out,
            $this->remarks,
            $this->created_time
        );

        return $stmt->execute();
    }

    // Update existing attendance record
    public function update()
    {
        global $db, $tx;
        $stmt = $db->prepare("UPDATE {$tx}attendence SET
            emp_id = ?, 
            atten_date = ?, 
            emp_status = ?, 
            time_in = ?, 
            time_out = ?, 
            remarks = ?, 
            created_time = ?
            WHERE atten_id = ?");
        
        $stmt->bind_param(
            "issssssi",
            $this->emp_id,
            $this->atten_date,
            $this->emp_status,
            $this->time_in,
            $this->time_out,
            $this->remarks,
            $this->created_time,
            $this->atten_id
        );

        return $stmt->execute();
    }

    // Find attendance record by atten_id (fixed, was id before)
    public static function find($atten_id)
    {
        global $db, $tx;
        $stmt = $db->prepare("SELECT * FROM {$tx}attendence WHERE atten_id = ?");
        $stmt->bind_param("i", $atten_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Delete attendance record by atten_id (fixed, was id before)
    public static function delete($atten_id)
    {
        global $db, $tx;
        $stmt = $db->prepare("DELETE FROM {$tx}attendence WHERE atten_id = ?");
        $stmt->bind_param("i", $atten_id);
        return $stmt->execute();
    }
}

?>
