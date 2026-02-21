<?php
// echo Page::title(["title"=>"Manage LeaveRequest"]);
// echo Page::body_open();
// echo Page::context_open();
$page = isset($_GET["page"]) ?$_GET["page"]:1;

$emp = isset($_GET['emp']) ? trim($_GET['emp']) : '';
$lt  = isset($_GET['leave']) ? trim($_GET['leave']) : '';
$st  = isset($_GET['status']) ? trim($_GET['status']) : '';
$ap  = isset($_GET['approver']) ? trim($_GET['approver']) : '';

echo "<form method='GET' class='mb-3' style='display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;'>
  <div>
    <label style='display:block;font-weight:600;'>Employee</label>
    <input type='text' name='emp' value='".htmlspecialchars($emp)."' class='form-control' placeholder='Name'>
  </div>
  <div>
    <label style='display:block;font-weight:600;'>Leave Type</label>
    <input type='text' name='leave' value='".htmlspecialchars($lt)."' class='form-control' placeholder='Type'>
  </div>
  <div>
    <label style='display:block;font-weight:600;'>Status</label>
    <select name='status' class='form-select'>
      <option value=''>All</option>
      <option value='Pending' ".($st=='Pending'?'selected':'').">Pending</option>
      <option value='Approved' ".($st=='Approved'?'selected':'').">Approved</option>
      <option value='Rejected' ".($st=='Rejected'?'selected':'').">Rejected</option>
    </select>
  </div>
  <div>
    <label style='display:block;font-weight:600;'>Approver</label>
    <input type='text' name='approver' value='".htmlspecialchars($ap)."' class='form-control' placeholder='Name'>
  </div>
  <div>
    <button type='submit' class='btn btn-primary'>Filter</button>
  </div>
</form>";

$criteria = " WHERE 1=1 ";
if($emp!==''){ $empq = addslashes($emp); $criteria .= " AND e.name LIKE '%{$empq}%' "; }
if($lt!==''){ $ltq = addslashes($lt); $criteria .= " AND lt.name LIKE '%{$ltq}%' "; }
if($st!==''){ $stq = addslashes($st); $criteria .= " AND lr.status = '{$stq}' "; }
if($ap!==''){ $apq = addslashes($ap); $criteria .= " AND u.name LIKE '%{$apq}%' "; }

echo LeaveRequest::html_table($page,10,$criteria);
echo Page::context_close();
echo Page::body_close();
