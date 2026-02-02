<?php

class Leave {
    public $leave_id;
    public $id;
    public $leave_type;
    public $start_date;
    public $end_date;
    public $total_days;
    public $is_half_day;
    public $reason;
    public $attachment;
    public $status;
    public $applied_date;
    public $approved_by;
    public $approved_date;
    public $remarks;
    public $leave_balance;

    // Constructor
    public function __construct(
        $leave_id,
        $id,
        $leave_type,
        $start_date,
        $end_date,
        $total_days,
        $is_half_day,
        $reason,
        $attachment,
        $status,
        $applied_date,
        $approved_by,
        $approved_date,
        $remarks,
        $leave_balance
    ) {
        $this->leave_id       = $leave_id;
        $this->id         = $id;
        $this->leave_type     = $leave_type;
        $this->start_date     = $start_date;
        $this->end_date       = $end_date;
        $this->total_days     = $total_days;
        $this->is_half_day    = $is_half_day;
        $this->reason         = $reason;
        $this->attachment     = $attachment;
        $this->status         = $status;
        $this->applied_date   = $applied_date;
        $this->approved_by    = $approved_by;
        $this->approved_date  = $approved_date;
        $this->remarks        = $remarks;
        $this->leave_balance  = $leave_balance;
    }

    // Fetch all leave applications
    public static function getAll() {
        global $db, $tx;
        $stmt = $db->prepare("SELECT * FROM {$tx}leave_application ORDER BY leave_id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Save new leave application
    public function save() {
        global $db, $tx;

        $stmt = $db->prepare("INSERT INTO {$tx}leave_application 
            (id, leave_type, start_date, end_date, total_days, is_half_day, reason, attachment, status, applied_date, approved_by, approved_date, remarks, leave_balance) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // ✅ Corrected bind_param types (14 params total)
        $stmt->bind_param(
            "isssiisssssisd",
            $this->id,
            $this->leave_type,
            $this->start_date,
            $this->end_date,
            $this->total_days,
            $this->is_half_day,
            $this->reason,
            $this->attachment,
            $this->status,
            $this->applied_date,
            $this->approved_by,
            $this->approved_date,
            $this->remarks,
            $this->leave_balance
        );

        return $stmt->execute();
    }

    // Update leave application
    public function update() {
        global $db, $tx;

        $stmt = $db->prepare("UPDATE {$tx}leave_application SET
            leave_type = ?, 
            start_date = ?, 
            end_date = ?, 
            total_days = ?, 
            is_half_day = ?, 
            reason = ?, 
            attachment = ?, 
            status = ?, 
            approved_by = ?, 
            approved_date = ?, 
            remarks = ?, 
            leave_balance = ?
            WHERE leave_id = ?");

            $sql = "UPDATE leave_application 
        SET id=?, leave_type=?, start_date=?, end_date=?, total_days=?, 
            is_half_day=?, reason=?, attachment=?, status=?, applied_date=?, 
            approved_by=?, approved_date=?, leave_balance=? 
        WHERE leave_id=?";


        // ✅ Corrected bind_param types (13 params total)
        $stmt->bind_param(
            "sssiisssssidi",
            $this->leave_type,
            $this->start_date,
            $this->end_date,
            $this->total_days,
            $this->is_half_day,
            $this->reason,
            $this->attachment,
            $this->status,
            $this->approved_by,
            $this->approved_date,
            $this->remarks,
            $this->leave_balance,
            $this->leave_id
        );

        return $stmt->execute();
    }

    // Find leave by ID
    public static function find($leave_id) {
        global $db, $tx;
        $stmt = $db->prepare("SELECT * FROM {$tx}leave_application WHERE leave_id = ?");
        $stmt->bind_param("i", $leave_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Delete leave by ID
    public static function delete($leave_id) {
        global $db, $tx;
        $stmt = $db->prepare("DELETE FROM {$tx}leave_application WHERE leave_id = ?");
        $stmt->bind_param("i", $leave_id);
        return $stmt->execute();
    }
}

?>
