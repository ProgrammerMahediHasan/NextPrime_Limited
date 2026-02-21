<?php
// echo Page::title(["title"=>"Edit LeaveAssign"]);
echo Page::body_open();
echo Page::context_open();
echo Form::open(["route"=>"leaveassign/update"]);
	echo Form::input(["label"=>"Id","type"=>"hidden","name"=>"id","value"=>"$leaveassign->id"]);
echo Form::input([
  "name" => "emp_id",
  "label" => "Employee",
  "table" => "employees",
  "value_column" => "id",
  "display_column" => "name",
  "value" => $leaveassign->emp_id   // ✅ FIX
]);



	echo Form::input(["label"=>"Leave Type","name"=>"leave_type_id","table"=>"leave_types","value"=>"$leaveassign->leave_type_id"]);
	echo Form::input(["label"=>"Allow Days","type"=>"text","name"=>"allow_days","value"=>"$leaveassign->allow_days"]);
	// echo Form::input(["label"=>"Used Days","type"=>"text","name"=>"used_days","value"=>"$leaveassign->used_days"]);
	echo Form::input(["label"=>"Year","type"=>"text","name"=>"year","value"=>"$leaveassign->year"]);

	$usedDays = floatval($leaveassign->used_days);
	$allowDays = floatval($leaveassign->allow_days);
	$remainingCalc = max(0, $allowDays - $usedDays);
	$overusedCalc = max(0, $usedDays - $allowDays);
	echo "<div style='display:flex;gap:16px;align-items:center;justify-content:flex-start;margin:8px 0 4px 0;padding-left:16.66%;'>";
	echo "<div><span style='font-weight:600;'>Remaining:</span> <span id='remaining_val' style='color:#16a34a;font-weight:700;'>$remainingCalc</span></div>";
	echo "<div><span style='font-weight:600;'>Overused:</span> <span id='overused_val' style='color:#dc2626;font-weight:700;'>$overusedCalc</span></div>";
	echo "</div>";

echo "<div style='display:flex;justify-content:center;gap:10px;margin-top:12px;'>";
echo Html::link([
    "class" => "btn btn-dark",
    "route" => "leaveassign",
    "text"  => "Back"
]);
echo "<button type='submit' name='update' class='btn btn-primary'>Update</button>";
echo "</div>";
echo Form::close();
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var allowInput = document.getElementById('allow_days');
  var used = <?php echo json_encode($leaveassign->used_days); ?>;
  var remEl = document.getElementById('remaining_val');
  var overEl = document.getElementById('overused_val');
  function recalc() {
    var allow = parseFloat(allowInput.value || 0);
    var usedDays = parseFloat(used || 0);
    var remaining = Math.max(0, allow - usedDays);
    var overused = Math.max(0, usedDays - allow);
    remEl.textContent = remaining;
    remEl.style.color = '#16a34a';
    overEl.textContent = overused;
    overEl.style.color = overused > 0 ? '#dc2626' : '#111827';
  }
  if(allowInput){
    allowInput.addEventListener('input', recalc);
  }
});
</script>
<?php
echo Page::context_close();
echo Page::body_close();
