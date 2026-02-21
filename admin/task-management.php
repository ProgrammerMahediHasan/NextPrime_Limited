<?php
include_once("header.php");
global $base_url, $uid;
?>
<style>
  .tm-wrap{max-width:1200px;margin:20px auto;padding:0 12px;font-family:'Plus Jakarta Sans',sans-serif}
  .tm-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
  .tm-title{font-size:22px;font-weight:800;color:#0f172a}
  .tm-controls{display:flex;gap:8px}
  .tm-columns{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
  .tm-col{background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 16px rgba(2,6,23,.06);display:flex;flex-direction:column;min-height:320px}
  .tm-col-head{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-bottom:1px solid #eef2f7}
  .tm-col-title{font-weight:800;color:#111827}
  .tm-count{background:#0ea5e9;color:#fff;border-radius:999px;padding:4px 10px;font-weight:800;font-size:12px}
  .tm-list{padding:12px;display:flex;flex-direction:column;gap:10px;min-height:240px}
  .tm-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:10px;box-shadow:0 4px 12px rgba(2,6,23,.05);display:flex;gap:10px;align-items:flex-start}
  .tm-card-title{margin:0;font-size:14px;font-weight:800;color:#0f172a;flex:1}
  .tm-meta{display:flex;gap:8px;align-items:center;margin-top:6px}
  .tm-badge{border-radius:999px;padding:4px 8px;font-size:11px;font-weight:800}
  .tm-pri-low{background:#f1f5f9;color:#334155}
  .tm-pri-med{background:#fde68a;color:#92400e}
  .tm-pri-high{background:#fecaca;color:#7f1d1d}
  .tm-actions{display:flex;gap:8px}
  .tm-btn{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:10px;border:2px solid #0f172a;font-weight:800;cursor:pointer}
  .tm-btn-primary{background:#2563eb;color:#fff;border-color:#1e3a8a}
  .tm-inputs{display:flex;gap:8px;flex-wrap:wrap}
  .tm-inputs input,.tm-inputs select{border:1px solid #e5e7eb;border-radius:8px;padding:8px 10px}
  @media(max-width:980px){.tm-columns{grid-template-columns:1fr 1fr}}
  @media(max-width:680px){.tm-columns{grid-template-columns:1fr}}
</style>

<div class="tm-wrap">
  <div class="tm-header">
    <div class="tm-title">Task Management</div>
    <div class="tm-controls">
      <div class="tm-inputs">
        <input type="text" id="tm-title" placeholder="Task title">
        <select id="tm-priority">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
        <input type="date" id="tm-due">
      </div>
      <button class="tm-btn tm-btn-primary" id="tm-add">Add Task</button>
    </div>
  </div>

  <div class="tm-columns">
    <div class="tm-col">
      <div class="tm-col-head"><div class="tm-col-title">Backlog</div><div class="tm-count" id="count-backlog">0</div></div>
      <div class="tm-list" id="taskWrapper1" data-status="backlog"></div>
    </div>
    <div class="tm-col">
      <div class="tm-col-head"><div class="tm-col-title">To Do</div><div class="tm-count" id="count-todo">0</div></div>
      <div class="tm-list" id="taskWrapper2" data-status="todo"></div>
    </div>
    <div class="tm-col">
      <div class="tm-col-head"><div class="tm-col-title">In Progress</div><div class="tm-count" id="count-inprogress">0</div></div>
      <div class="tm-list" id="taskWrapper3" data-status="inprogress"></div>
    </div>
    <div class="tm-col">
      <div class="tm-col-head"><div class="tm-col-title">Done</div><div class="tm-count" id="count-done">0</div></div>
      <div class="tm-list" id="taskWrapper4" data-status="done"></div>
    </div>
  </div>
</div>

<script>
  const uid = <?= json_encode((int)$uid) ?>;
  const storeKey = "tm_tasks_" + uid;
  const byId = s => document.getElementById(s);
  const lists = ["taskWrapper1","taskWrapper2","taskWrapper3","taskWrapper4"];
  const statusMap = {taskWrapper1:"backlog",taskWrapper2:"todo",taskWrapper3:"inprogress",taskWrapper4:"done"};
  const countIds = {backlog:"count-backlog",todo:"count-todo",inprogress:"count-inprogress",done:"count-done"};

  function readStore(){
    try{ return JSON.parse(localStorage.getItem(storeKey) || "[]"); }catch(e){ return []; }
  }
  function writeStore(data){
    localStorage.setItem(storeKey, JSON.stringify(data));
    updateCounts(data);
  }
  function updateCounts(data){
    const c = {backlog:0,todo:0,inprogress:0,done:0};
    data.forEach(x=>{ c[x.status] = (c[x.status]||0)+1; });
    Object.keys(c).forEach(k=>{ const el = byId(countIds[k]); if(el) el.textContent = c[k]; });
  }
  function render(){
    const data = readStore();
    lists.forEach(id=> byId(id).innerHTML = "");
    data.forEach(t=> appendCard(t));
    updateCounts(data);
  }
  function appendCard(t){
    const wrap = byId(Object.keys(statusMap).find(k=> statusMap[k]===t.status));
    if(!wrap) return;
    const card = document.createElement("div");
    card.className = "tm-card";
    card.setAttribute("data-id", t.id);
    const title = document.createElement("h4");
    title.className = "tm-card-title";
    title.textContent = t.title;
    const meta = document.createElement("div");
    meta.className = "tm-meta";
    const pri = document.createElement("span");
    pri.className = "tm-badge " + (t.priority==="high"?"tm-pri-high":t.priority==="medium"?"tm-pri-med":"tm-pri-low");
    pri.textContent = t.priority.charAt(0).toUpperCase() + t.priority.slice(1);
    const due = document.createElement("span");
    due.className = "tm-badge tm-pri-low";
    due.textContent = t.due ? t.due : "No due";
    const actions = document.createElement("div");
    actions.className = "tm-actions";
    const del = document.createElement("button");
    del.className = "tm-btn";
    del.textContent = "Delete";
    del.addEventListener("click", ()=>{ removeTask(t.id); });
    actions.appendChild(del);
    meta.appendChild(pri);
    meta.appendChild(due);
    card.appendChild(title);
    card.appendChild(meta);
    card.appendChild(actions);
    wrap.appendChild(card);
  }
  function addTask(){
    const title = byId("tm-title").value.trim();
    const priority = byId("tm-priority").value;
    const due = byId("tm-due").value;
    if(!title) return;
    const data = readStore();
    const id = Date.now();
    data.push({id, title, priority, due, status:"todo"});
    writeStore(data);
    byId("tm-title").value = "";
    render();
  }
  function removeTask(id){
    const data = readStore().filter(x=> x.id !== id);
    writeStore(data);
    render();
  }
  function onMoved(evt){
    const el = evt.item;
    const id = parseInt(el.getAttribute("data-id"));
    const parentId = evt.to.getAttribute("id");
    const status = statusMap[parentId] || "backlog";
    const data = readStore().map(x=> x.id===id ? {...x, status} : x);
    writeStore(data);
    render();
  }
  document.getElementById("tm-add").addEventListener("click", addTask);
  ["taskWrapper1","taskWrapper2","taskWrapper3","taskWrapper4"].forEach(id=>{
    new Sortable(byId(id), {group:"shared", animation:150, onEnd:onMoved});
  });
  render();
</script>

<?php include("footer.php"); ?>
