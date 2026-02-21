<?php
// echo '<h2 style="text-align:center; color:#0d6efd; font-family:Poppins, sans-serif;">Leave Types</h2>';
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$type_id = isset($_GET["type_id"]) ? trim($_GET["type_id"]) : "";
$status = isset($_GET["status"]) ? trim($_GET["status"]) : "";

echo "<form method='GET' class='mb-3' style='display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;'>
  <div>
    <label style='display:block;font-weight:600;'>Leave Name</label>";
echo LeaveType::html_select("type_id","form-select","All Leave Types",$type_id);
echo "
  </div>
  <div>
    <label style='display:block;font-weight:600;'>Status</label>
    <select name='status' class='form-select'>
      <option value=''>All</option>
      <option value='active' ".($status=='active'?'selected':'').">Active</option>
      <option value='inactive' ".($status=='inactive'?'selected':'').">Inactive</option>
    </select>
  </div>
  <div>
    <button type='submit' class='btn btn-primary'>Filter</button>
  </div>
</form>";

$criteria = " WHERE 1=1 ";
if($type_id!==''){ $idq = intval($type_id); $criteria .= " AND id = {$idq} "; }
if($status!==''){ $criteria .= " AND status='{$status}' "; }

echo LeaveType::html_table($page, 10, $criteria);
echo Page::context_close();
echo Page::body_close();
?>
