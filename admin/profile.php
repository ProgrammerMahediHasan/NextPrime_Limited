<?php
include_once("header.php");
global $db, $tx, $base_url, $uid;

$user = null;
if (!empty($uid)) {
    $stmt = $db->prepare("
        SELECT u.id, u.name, u.email, u.role_id, u.address, u.status, u.photo, u.created_at, u.updated_at,
               r.name AS role_name
        FROM {$tx}users u
        LEFT JOIN {$tx}roles r ON r.id = u.role_id
        WHERE u.id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
}

if (!$user) {
    echo "<div class='alert alert-danger m-3'>User profile not found.</div>";
    include("footer.php");
    exit;
}

$photo = trim($user['photo'] ?? "");
$photo_url = $photo !== "" ? "{$base_url}/img/{$photo}" : "";
$name_txt = trim($user['name'] ?? "");
$initial = $name_txt !== "" ? strtoupper(mb_substr($name_txt, 0, 1)) : "?";
$role_txt = strtolower(trim($user['role_name'] ?? ""));
$status_txt = strtolower(trim($user['status'] ?? ""));
$role_color = $role_txt === "admin" ? "#ef4444" : ($role_txt === "manager" ? "#2563eb" : "#6b7280");
$status_color = $status_txt === "active" ? "#16a34a" : "#ef4444";
?>

<style>
  .profile-wrap{max-width:1100px;margin:24px auto;padding:0 14px;font-family:'Plus Jakarta Sans',sans-serif;}
  .profile-card{background:#fff;border-radius:16px;box-shadow:0 12px 36px rgba(0,0,0,0.08);border:1px solid #e5e7eb;overflow:hidden}
  .cover{height:128px;background-image:linear-gradient(135deg,#0ea5e9,#6366f1);position:relative}
  .cover::after{content:"";position:absolute;inset:0;background:radial-gradient(600px 160px at 20% 0%,rgba(255,255,255,0.12),transparent)}
  .header{display:flex;gap:18px;align-items:center;padding:0 20px;transform:translateY(-48px)}
  .avatar{width:108px;height:108px;border-radius:50%;border:4px solid #ffffff;box-shadow:0 6px 16px rgba(0,0,0,0.10);background:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:42px;color:#334155;overflow:hidden}
  .avatar img{width:100%;height:100%;object-fit:cover;border-radius:50%}
  .title{flex:1;background:#fff;padding:14px 16px;border-radius:12px;box-shadow:0 4px 14px rgba(2,6,23,0.06);border:1px solid #f1f5f9}
  .name{margin:0;font-size:24px;font-weight:800;color:#0f172a;letter-spacing:.2px}
  .meta{display:flex;gap:10px;align-items:center;margin-top:6px}
  .badge{display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:999px;font-weight:700;font-size:13px;color:#fff}
  .status{display:inline-flex;align-items:center;padding:6px 10px;border-radius:999px;font-weight:700;font-size:13px;color:#fff}
  .body{padding:20px}
  .grid{display:grid;grid-template-columns:2fr 1fr;gap:18px}
  .panel{border:1px solid #e5e7eb;border-radius:12px;background:#ffffff}
  .panel .inner{padding:16px}
  .row{display:grid;grid-template-columns:160px 1fr;gap:8px 16px}
  .key{font-weight:700;color:#0f172a}
  .val{color:#111827}
  .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:12px}
  .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;border:2px solid #0f172a;font-weight:800;cursor:pointer}
  .btn-primary{background:#2563eb;color:#fff;border-color:#1e3a8a}
  .btn-outline{background:#fff;color:#111827}
  @media(max-width:860px){ .grid{grid-template-columns:1fr} .row{grid-template-columns:1fr} }
</style>

<div class="profile-wrap">
  <div class="profile-card">
    <div class="cover"></div>
    <div class="header">
      <div class="avatar">
        <?php if ($photo_url !== ""): ?>
          <img src="<?= htmlspecialchars($photo_url) ?>" alt="<?= htmlspecialchars($name_txt) ?>">
        <?php else: ?>
          <?= htmlspecialchars($initial) ?>
        <?php endif; ?>
      </div>
      <div class="title">
        <h3 class="name"><?= htmlspecialchars($name_txt) ?></h3>
        <div class="meta">
          <span class="badge" style="background:<?= $role_color ?>"><?= htmlspecialchars($user['role_name'] ?? '—') ?></span>
          <span class="status" style="background:<?= $status_color ?>"><?= htmlspecialchars($user['status'] ?? '—') ?></span>
        </div>
      </div>
    </div>
    <div class="body">
      <div class="grid">
        <div class="panel"><div class="inner">
          <div class="row"><div class="key">User ID</div><div class="val"><?= (int)$user['id'] ?></div></div>
          <div class="row"><div class="key">Email</div><div class="val"><a href="mailto:<?= htmlspecialchars($user['email'] ?? '') ?>"><?= htmlspecialchars($user['email'] ?? '—') ?></a></div></div>
          <div class="row"><div class="key">Role</div><div class="val"><?= htmlspecialchars($user['role_name'] ?? '—') ?></div></div>
          <div class="row"><div class="key">Address</div><div class="val"><?= htmlspecialchars($user['address'] ?? '—') ?></div></div>
          <div class="row"><div class="key">Created</div><div class="val"><?= htmlspecialchars($user['created_at'] ?? '—') ?></div></div>
          <div class="row"><div class="key">Updated</div><div class="val"><?= htmlspecialchars($user['updated_at'] ?? '—') ?></div></div>
          <div class="actions">
            <a class="btn btn-primary" href="<?= $base_url ?>/user/edit/<?= (int)$user['id'] ?>">Edit Profile</a>
            <a class="btn btn-outline" href="<?= $base_url ?>/user/show/<?= (int)$user['id'] ?>">View Details</a>
            <?php if ((strtolower($user['role_name'] ?? '') !== 'manager') && (($_SESSION['role_name'] ?? '') === 'Admin')): ?>
              <a class="btn btn-outline" href="<?= $base_url ?>/user/setrole/<?= (int)$user['id'] ?>?role=Manager">Make Manager</a>
            <?php endif; ?>
          </div>
        </div></div>
        <div class="panel"><div class="inner">
          <div class="row"><div class="key">Contact</div><div class="val"><a href="mailto:<?= htmlspecialchars($user['email'] ?? '') ?>"><?= htmlspecialchars($user['email'] ?? '—') ?></a></div></div>
          <div class="row"><div class="key">Status</div><div class="val" style="font-weight:700;color:<?= $status_color ?>"><?= htmlspecialchars($user['status'] ?? '—') ?></div></div>
        </div></div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
