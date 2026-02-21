<?php
// echo Page::title(["title"=>"Create Leave Assign"]);
echo Page::body_open();
echo Page::context_open();
echo Form::open(["route"=>"leaveassign/save"]);
echo Form::input([
  "label" => "Emp",
  "name"  => "emp_id",
  "table" => "employees",
  "placeholder" => "Select Employee"
]);

echo Form::input([
  "label" => "Leave Type",
  "name"  => "leave_type_id",
  "table" => "leave_types",
  "placeholder" => "Select Leave"
]);


	echo Form::input(["label"=>"Allow Days","type"=>"text","name"=>"allow_days","id"=>"allow_days"]);
	// echo Form::input(["label"=>"Used Days","type"=>"hidden","name"=>"used_days"]);
	echo Form::input(["label"=>"Year","type"=>"text","name"=>"year","id"=>"year","value"=>date("Y")]);

echo "<div style='display:flex;justify-content:center;gap:10px;margin-top:12px;'>";
echo Html::link([
  "class" => "btn btn-dark",
  "route" => "leaveassign",
  "text"  => "Back"
]);
echo Form::input(["name"=>"create","class"=>"btn btn-primary", "value"=>"Save", "type"=>"submit"]);
echo "</div>";
echo Form::close();
echo Page::context_close();
echo Page::body_close();

?><?php
// Build Leave Type -> Total Days map
global $db, $tx;
$lt_map = [];
$rs = $db->query("SELECT id, total_days FROM {$tx}leave_types");
while($row = $rs->fetch_assoc()){
  $lt_map[$row['id']] = (int)$row['total_days'];
}
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const leaveType = document.getElementById('leave_type_id');
  const allowDays = document.getElementById('allow_days');
  const yearInput = document.getElementById('year');
  const LT_MAP = <?php echo json_encode($lt_map); ?>;

  function setAllowFromLeave(){
    if(!leaveType || !allowDays) return;
    const id = leaveType.value;
    if(id && LT_MAP[id] !== undefined){
      allowDays.value = LT_MAP[id];
    }
  }

  if(leaveType){
    leaveType.addEventListener('change', setAllowFromLeave);
    setAllowFromLeave();
  }

  if(yearInput && !yearInput.value){
    yearInput.value = new Date().getFullYear();
  }
});
</script>
