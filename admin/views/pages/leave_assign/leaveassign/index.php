<?php
echo '<h2 style="text-align:center; color:#0d6efd; font-family:Poppins, sans-serif;">Manage Leave Assign</h2>';

$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$emp_id  = isset($_GET["emp_id"]) ? trim($_GET["emp_id"]) : "";
$year = isset($_GET["year"]) ? trim($_GET["year"]) : "";
$sort = isset($_GET["sort"]) ? strtolower($_GET["sort"]) : "emp";
$dir  = isset($_GET["dir"]) ? strtolower($_GET["dir"]) : "asc";

echo "<form method='GET' class='mb-3' style='display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;'>";
echo "<div>";
echo "<label style='display:block;font-weight:600;'>Employee</label>";
echo Form::input([
  "name" => "emp_id",
  "label" => "",
  "table" => "employees",
  "value_column" => "id",
  "display_column" => "name",
  "placeholder_option" => "All Employee",
  "placeholder_value" => "",
  "order_by" => "name asc",
  "value" => $emp_id
]);
echo "</div>";
echo "<div>";
echo "<label style='display:block;font-weight:600;'>Year</label>";
echo "<input type='text' name='year' value='".htmlspecialchars($year)."' class='form-control' placeholder='e.g. 2026'>";
echo "</div>";
echo "<div>";
echo "<label style='display:block;font-weight:600;'>Sort By</label>";
echo "<select name='sort' class='form-select'>";
echo "<option value='emp' ".($sort==='emp'?'selected':'').">Employee</option>";
echo "<option value='type' ".($sort==='type'?'selected':'').">Leave Type</option>";
echo "<option value='remaining' ".($sort==='remaining'?'selected':'').">Remaining</option>";
echo "</select>";
echo "</div>";
echo "<div>";
echo "<label style='display:block;font-weight:600;'>Direction</label>";
echo "<select name='dir' class='form-select'>";
echo "<option value='asc' ".($dir==='asc'?'selected':'').">Ascending</option>";
echo "<option value='desc' ".($dir==='desc'?'selected':'').">Descending</option>";
echo "</select>";
echo "</div>";
echo "<div>";
echo "<button type='submit' class='btn btn-primary'>Filter</button>";
echo "</div>";
echo "</form>";

$criteria = " WHERE 1=1 ";
if($emp_id!==''){ $eid = intval($emp_id); $criteria .= " AND la.emp_id = {$eid} "; }
if($year!==''){ $yearq = addslashes($year); $criteria .= " AND la.year = '{$yearq}' "; }

echo LeaveAssign::html_table($page, 10, $criteria);

echo Page::context_close();
echo Page::body_close();
?>
