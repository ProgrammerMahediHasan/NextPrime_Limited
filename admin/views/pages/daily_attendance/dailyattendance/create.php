<?php
// daily_attendance.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'hrm';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo "DB connection failed: " . $mysqli->connect_error;
    exit;
}

// Handle AJAX save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!$data || !isset($data['action']) || $data['action'] !== 'save') {
        echo json_encode(['success'=>false,'message'=>'Invalid request']);
        exit;
    }

    $att_date = $mysqli->real_escape_string($data['att_date'] ?? date('Y-m-d'));
    $attendance = $data['attendance'] ?? [];

    $insertSql = "INSERT INTO rt_daily_attendance 
        (emp_id, att_date, status, in_time, out_time, total_work_minutes, overtime_minutes, late_minutes, day_type)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
          status = VALUES(status),
          in_time = VALUES(in_time),
          out_time = VALUES(out_time),
          total_work_minutes = VALUES(total_work_minutes),
          overtime_minutes = VALUES(overtime_minutes),
          late_minutes = VALUES(late_minutes),
          day_type = VALUES(day_type)";

    $stmt = $mysqli->prepare($insertSql);
    if (!$stmt) {
        echo json_encode(['success'=>false,'message'=>'Prepare failed: '.$mysqli->error]);
        exit;
    }

    $errors = [];
    foreach ($attendance as $emp_id => $att) {
        $in_checked = !empty($att['in_checked']);
        $out_checked = !empty($att['out_checked']);
        if (!$in_checked && !$out_checked) continue;

        $status = $att['status'] ?? null;
        $in_time = $in_checked && !empty($att['in_time']) ? $att['in_time'] : null;
        $out_time = $out_checked && !empty($att['out_time']) ? $att['out_time'] : null;
        $total_work_minutes = intval($att['work_minutes'] ?? 0);
        $overtime_minutes = intval($att['overtime_minutes'] ?? 0);
        $late_minutes = intval($att['late_minutes'] ?? 0);
        $day_type = $att['day_type'] ?? null;

        $stmt->bind_param(
            'issssiiis',
            $emp_id,
            $att_date,
            $status,
            $in_time,
            $out_time,
            $total_work_minutes,
            $overtime_minutes,
            $late_minutes,
            $day_type
        );

        if (!$stmt->execute()) {
            $errors[] = "Emp {$emp_id}: " . $stmt->error;
        }
    }

    $stmt->close();
    $mysqli->close();

    if (count($errors) === 0) {
        echo json_encode(['success'=>true,'message'=>'Attendance saved successfully']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Some errors occurred','errors'=>$errors]);
    }
    exit;
}

// Fetch employees
$empRes = $mysqli->query("SELECT id, name FROM rt_employees ORDER BY name ASC");
$employees = [];
if ($empRes) while ($r = $empRes->fetch_assoc()) $employees[] = $r;
$mysqli->close();

$holidays = [
  "2025-02-15","2025-02-21","2025-03-26","2025-03-28","2025-03-29","2025-03-30","2025-03-31",
  "2025-04-01","2025-04-02","2025-04-03","2025-04-14","2025-05-01","2025-05-11",
  "2025-06-05","2025-06-06","2025-06-07","2025-06-08","2025-06-09","2025-06-10",
  "2025-07-06","2025-08-05","2025-08-16","2025-09-05","2025-10-01","2025-10-02",
  "2025-12-16","2025-12-25"
];

$today = date('Y-m-d');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Employee Daily Attendance</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
body { font-family: 'Poppins', sans-serif; background:#f4f6f9; }
.container { max-width: 1500px; }
h3 { font-weight:600; color:#1f3d79; margin-bottom:20px; }
.table-wrapper { background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); overflow-x:auto; }
table { width:100%; border-collapse:collapse; table-layout:auto; min-width:1300px; }
thead th { background: linear-gradient(135deg,#1f3d79,#122f4e); color:#fff; font-weight:600; text-align:center; padding:12px; font-size:13px; position: sticky; top:0; z-index:2; }
tbody td { text-align:center; vertical-align:middle; padding:10px 8px; font-size:13px; white-space:nowrap; border-bottom:1px solid #e5e7eb; }
tbody tr:hover { background:#eef2f7; transition:0.3s; }
input[type="time"] { border-radius:6px; border:1px solid #cbd5e1; padding:4px 6px; font-size:13px; text-align:center; width:120px; }
.dayType, .statusTd { font-weight:600; }
.dayType.Weekend { color:red; }
.dayType.Holiday { color:green; }
.statusTd.Absent { color:red; }
.btn { border-radius:6px; font-weight:500; }
.btn-success { background:#16a34a; }
.btn-success:hover { background:#15803d; }
.btn-danger { background:#ef4444; }
.btn-danger:hover { background:#dc2626; }
.btn-secondary { background:#6c757d; color:#fff; }
@media(max-width:1400px){ input[type="time"]{ width:100px; } }
@media(max-width:1200px){ input[type="time"]{ width:90px; } }
@media(max-width:992px){ input[type="time"]{ width:80px; font-size:11px; } }
@media(max-width:768px){ input[type="time"]{ width:70px; font-size:10px; } }
</style>
</head>
<body>
<div class="container mt-4">
  
  <h3 class="text-center">Employee Daily Attendance</h3>
  <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
    <input type="date" id="attDate" class="form-control w-auto" value="<?php echo $today; ?>">
    <button type="button" id="clearBtn" class="btn btn-danger">Clear</button>
  </div>
  <div class="table-wrapper">
    <table class="table table-bordered text-center">
      <thead>
        <tr >
          <th style="color: white;">SL</th>
          <th style="color: white;">Employee Name</th>
          <th style="color: white;">IN All<br/><input type="checkbox" id="inAll"></th>
          <th style="color: white;">IN Time</th>
          <th style="color: white;">OUT All<br/><input type="checkbox" id="outAll"></th>
          <th style="color: white;">OUT Time</th>
          <th style="color: white;">Work(Min)</th>
          <th style="color: white;">Late(Min)</th>
          <th style="color: white;">Over Time</th>
          <th style="color: white;">Day Type</th>
          <th style="color: white;">Status</th>
        </tr>
      </thead>
      <tbody id="tbody"></tbody>
    </table>
  </div>
  <div class="text-center mt-4 mb-5">
   
  <button id="saveBtn" class="btn btn-success px-5">✅ Save Attendance</button>
  <button onclick="history.back()" class="btn btn-secondary mb-3">Back</button>
  <br>
  </div>
  <br>
</div>
<br>
<script>
const EMPLOYEES = <?php echo json_encode($employees, JSON_HEX_TAG); ?>;
const HOLIDAYS = <?php echo json_encode($holidays); ?>;
const TODAY = "<?php echo $today; ?>";
</script>

<script>
(function(){
let attDateEl = document.getElementById('attDate');
let tbody = document.getElementById('tbody');
let inAll = document.getElementById('inAll');
let outAll = document.getElementById('outAll');
let clearBtn = document.getElementById('clearBtn');
let saveBtn = document.getElementById('saveBtn');

let attDate = attDateEl.value || TODAY;
let employees = EMPLOYEES;
let attendance = {};

function getDayType(dateStr) {
  const d = new Date(dateStr);
  const day = d.getDay();
  if (HOLIDAYS.includes(dateStr)) return "Holiday";
  if (day === 5) return "Weekend";
  return "Working";
}

function calculateWorkTime(inTime, outTime){
  if(!inTime || !outTime) return {minutes:0,text:"0 hr 0 min",overtime:0};
  const [inH,inM]=inTime.split(":").map(Number);
  const [outH,outM]=outTime.split(":").map(Number);
  const inDate=new Date(2000,0,1,inH,inM);
  const outDate=new Date(2000,0,1,outH,outM);
  if(outDate<inDate) return {minutes:0,text:"0 hr 0 min",overtime:0};
  const diffMin=Math.floor((outDate-inDate)/60000);
  const regularEnd=new Date(2000,0,1,17,30);
  const overtime=outDate>regularEnd?Math.floor((outDate-regularEnd)/60000):0;
  return {minutes:diffMin,text:`${Math.floor(diffMin/60)} hr ${diffMin%60} min`,overtime};
}

function initAttendance(){
  attendance={};
  employees.forEach(emp=>{
    attendance[emp.id]={
      in_checked:false,
      out_checked:false,
      in_time:"09:00",
      out_time:"17:30",
      work_time:"0 hr 0 min",
      work_minutes:0,
      overtime_minutes:0,
      late_minutes:0,
      day_type:getDayType(attDate),
      status:null
    };
  });
}

function renderRows(){
  tbody.innerHTML='';
  employees.forEach((emp,i)=>{
    const att=attendance[emp.id];
    const tr=document.createElement('tr');
    tr.innerHTML=`
      <td>${i+1}</td>
      <td style="text-align:center; white-space:normal;">${emp.name}</td>
      <td><input type="checkbox" class="inChk" data-id="${emp.id}" ${att.in_checked?'checked':''}></td>
      <td style="text-align:center;">
      <input type="time"class="inTime form-control form-control-sm" data-id="${emp.id}" value="${att.in_time}" 
      style="text-align:center; margin:auto; display:block; width:120px;">
      </td>

      <td><input type="checkbox" class="outChk" data-id="${emp.id}" ${att.out_checked?'checked':''}></td>
            <td style="text-align:center;">
      <input type="time"class="outTime form-control form-control-sm" data-id="${emp.id}" value="${att.out_time}" 
      style="text-align:center; margin:auto; display:block; width:120px;">
      </td>
      <td class="workTime" data-id="${emp.id}">${att.work_time}</td>
      <td class="lateMin" data-id="${emp.id}">${att.late_minutes}</td>
      <td class="overMin" data-id="${emp.id}">${att.overtime_minutes}</td>
      <td class="dayType" data-id="${emp.id}">${att.day_type}</td>
      <td class="statusTd" data-id="${emp.id}">${att.status||''}</td>
    `;
    tbody.appendChild(tr);
  });
  attachListeners();
}

function attachListeners(){
  document.querySelectorAll('.inChk').forEach(el=>el.onchange=e=>handleChange(e.target.dataset.id,'in_checked',e.target.checked));
  document.querySelectorAll('.outChk').forEach(el=>el.onchange=e=>handleChange(e.target.dataset.id,'out_checked',e.target.checked));
  document.querySelectorAll('.inTime').forEach(el=>el.onchange=e=>handleChange(e.target.dataset.id,'in_time',e.target.value));
  document.querySelectorAll('.outTime').forEach(el=>el.onchange=e=>handleChange(e.target.dataset.id,'out_time',e.target.value));
}

function handleChange(empId,field,value){
  const updated={...attendance[empId]};
  updated[field]=value;
  updated.day_type=getDayType(attDate);

  if((updated.day_type==="Weekend"||updated.day_type==="Holiday")&&(updated.in_checked||updated.out_checked)){
    updated.status="Day Off";
    updated.in_time=null;
    updated.out_time=null;
    updated.work_time="0 hr 0 min";
    updated.work_minutes=0;
    updated.overtime_minutes=0;
    updated.late_minutes=0;
    attendance[empId]=updated;
    renderSingleRow(empId);
    return;
  }

  const inTime=updated.in_checked?updated.in_time:null;
  const outTime=updated.out_checked?updated.out_time:null;
  const work=calculateWorkTime(inTime,outTime);

  updated.work_time=work.text;
  updated.work_minutes=work.minutes;
  updated.overtime_minutes=work.overtime;

  let late=0,status=null;
  if(updated.in_checked&&updated.in_time){
    const [h,m]=updated.in_time.split(':').map(Number);
    const inMin=h*60+m;
    if(inMin<=540) status="Present";
    else if(inMin<=600){ late=inMin-540; status="Present"; }
    else status="Absent";
  }
  updated.late_minutes=late;
  updated.status=status;

  attendance[empId]=updated;
  renderSingleRow(empId);
}

function renderSingleRow(empId){
  const att=attendance[empId];
  const workCell=document.querySelector('.workTime[data-id="'+empId+'"]');
  const lateCell=document.querySelector('.lateMin[data-id="'+empId+'"]');
  const overCell=document.querySelector('.overMin[data-id="'+empId+'"]');
  const dayCell=document.querySelector('.dayType[data-id="'+empId+'"]');
  const statusCell=document.querySelector('.statusTd[data-id="'+empId+'"]');
  const inTimeInput=document.querySelector('.inTime[data-id="'+empId+'"]');
  const outTimeInput=document.querySelector('.outTime[data-id="'+empId+'"]');
  const inChk=document.querySelector('.inChk[data-id="'+empId+'"]');
  const outChk=document.querySelector('.outChk[data-id="'+empId+'"]');

  if(inTimeInput) inTimeInput.value=att.in_time||'';
  if(outTimeInput) outTimeInput.value=att.out_time||'';
  if(inChk) inChk.checked=!!att.in_checked;
  if(outChk) outChk.checked=!!att.out_checked;
  if(workCell) workCell.textContent=att.work_time;
  if(lateCell) lateCell.textContent=att.late_minutes;
  if(overCell) overCell.textContent=att.overtime_minutes;
  if(dayCell){ 
    dayCell.textContent=att.day_type;
    dayCell.className='dayType '+att.day_type;
  }
  if(statusCell){
    statusCell.textContent=att.status||'';
    statusCell.className='statusTd '+att.status;
  }
}

// All IN/OUT checkboxes
function handleAllCheck(type, value){
  employees.forEach(emp=>{
    if(type==='in') handleChange(emp.id,'in_checked',value);
    if(type==='out') handleChange(emp.id,'out_checked',value);
  });
}
inAll.onchange = e => handleAllCheck('in', e.target.checked);
outAll.onchange = e => handleAllCheck('out', e.target.checked);

// Clear Attendance
function handleClearAttendance(){
  initAttendance();
  inAll.checked=false;
  outAll.checked=false;
  renderRows();
}
clearBtn.onclick=()=>{if(confirm('Clear all attendance entries?')) handleClearAttendance();}

// Save Attendance
async function handleSaveAttendance(){
  const selected=employees.filter(emp=>attendance[emp.id].in_checked||attendance[emp.id].out_checked);
  if(!selected.length) return;
  try{
    saveBtn.disabled=true;
    saveBtn.textContent='Saving...';
    const payload={action:'save',att_date:attDate,attendance:{}};
    selected.forEach(emp=>payload.attendance[emp.id]=attendance[emp.id]);
    const res=await fetch(location.href,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
    const json=await res.json();
    if(json.success){ alert('✅ Attendance Saved Successfully!'); }
    else{ alert('❌ Some error occurred'); }
  }
  catch(err){ console.error(err); alert('✅ Attendance Saved Successfully!'); }
  finally{ saveBtn.disabled=false; saveBtn.textContent='Save Attendance'; }
}
saveBtn.onclick=handleSaveAttendance;

// Change Date
attDateEl.onchange=e=>{
  attDate=e.target.value;
  employees.forEach(emp=>{
    attendance[emp.id].day_type=getDayType(attDate);
    handleChange(emp.id,'in_checked',attendance[emp.id].in_checked);
  });
};

initAttendance();
renderRows();
})();
</script>
</body>
</html>
