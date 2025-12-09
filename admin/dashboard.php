<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Dashboard</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DATATABLES (jQuery DataTables) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
    body {
        background: #eef1f6;
        display: flex;
        font-family: 'Segoe UI', sans-serif;
        transition: background 0.3s ease;
    }

    /* Sidebar */
    .sidebar {
        width: 260px;
        background: #1f2937;
        height: 100vh;
        color: white;
        transition: .35s ease-in-out;
        position: fixed;
        box-shadow: 4px 0 15px rgba(0,0,0,0.15);
    }
    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        padding: 15px;
        border-bottom: 1px solid #374151;
        display:flex;
        justify-content:space-between;
        align-items:center;
        animation: fadeDown .6s ease;
    }

    .sidebar a {
        display:flex;
        gap:12px;
        padding:12px 20px;
        text-decoration:none;
        color:#d1d5db;
        align-items: center;
        position: relative;
        transition: .25s;
    }
    .sidebar a:hover {
        background: #2d3a50;
        padding-left: 28px;
    }
    .sidebar a.active {
        background:#3b82f6;
        color:white;
        box-shadow: inset 0 0 10px rgba(255,255,255,0.1);
    }

    /* Content */
    .content {
        margin-left:260px;
        width:calc(100% - 260px);
        padding:30px;
        transition:.35s ease-in-out;
        opacity: 0;
        animation: fadeIn .45s forwards;
    }
    .content.collapsed {
        margin-left:80px;
        width:calc(100% - 80px);
    }

    /* Statistik Card */
    .stat-card {
        background:white;
        padding:25px;
        border-radius:14px;
        box-shadow:0 6px 14px rgba(0,0,0,.08);
        text-align:center;
        transform: translateY(0);
        transition: .25s ease;
        animation: fadeUp .5s ease;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow:0 10px 20px rgba(0,0,0,.12);
    }

    /* Table */
    table td {
        white-space: normal !important;
        transition: .2s ease;
    }
    #dataTable tbody tr:hover {
        background-color: #f3f7ff !important;
        transform: scale(1.005);
    }

    /* Buttons upgrade */
    button, .btn {
        border-radius: 8px !important;
        transition: .25s ease-in-out;
    }
    button:hover, .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    /* Badge */
    .notif-badge {
        background:red;
        color:white;
        padding:2px 7px;
        font-size:11px;
        border-radius:50%;
        margin-left:5px;
        transition: .3s;
        animation: pulse 1s infinite;
    }

    /* Modal smooth animation */
    .modal-content {
        border-radius: 15px;
        animation: popIn .35s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    /* 🎬 Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes popIn {
        from { transform: scale(0.85); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.25); }
        100% { transform: scale(1); }
    }
</style>

</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-speedometer2"></i> <span>Admin Panel</span></h4>
        <button class="btn btn-secondary btn-sm" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    </div>

    <a href="#" id="menu-home" class="menu-btn active" onclick="showHome()"><i class="bi bi-house"></i> <span>Beranda</span></a>

    <a href="#" id="menu-contact" onclick="loadTable('contact')" class="menu-btn"><i class="bi bi-envelope"></i> <span>Kontak Masuk</span>
        <span id="notifContact" class="notif-badge" style="display:none;">0</span></a>

    <a href="#" id="menu-cekpt" onclick="loadTable('cekpt')" class="menu-btn"><i class="bi bi-building"></i> <span>Cek PT</span>
        <span id="notifCekPT" class="notif-badge" style="display:none;">0</span></a>

    <a href="#" id="menu-admin" onclick="loadAdmin()" class="menu-btn"><i class="bi bi-people"></i> <span>Kelola Admin</span></a>

    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
</div>

<div class="content" id="content">
    <h2 id="pageTitle">Beranda</h2>

    <!-- HOME -->
    <div id="homeSection">
        <div class="row g-3">
            <div class="col-md-4"><div class="stat-card"><h4>Kontak Masuk</h4><h2 id="countContact">0</h2></div></div>
            <div class="col-md-4"><div class="stat-card"><h4>Permohonan Cek PT</h4><h2 id="countCekPT">0</h2></div></div>
            <div class="col-md-4"><div class="stat-card"><h4>Admin Terdaftar</h4><h2 id="countAdmin">0</h2></div></div>
        </div>
    </div>

    <!-- EXPORT -->
    <div id="exportSection" style="display:none;" class="mb-3">
        <a href="../data/export_all.php" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
    </div>

    <!-- CONTROLS -->
    <div id="tableControls" style="display:none;" class="mb-2">
        <button id="btnMarkAll" class="btn btn-sm btn-outline-primary" onclick="markAllRead()">Mark All Read</button>
        <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#adminAddModal">Tambah Admin</button>
    </div>

    <!-- TABLE -->
    <div id="tableSection" style="display:none;">
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%;">
            <thead id="tableHead"></thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal"><div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Detail Data</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body" id="detailBody"></div>
    <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
</div></div></div>

<!-- Admin Add Modal -->
<div class="modal fade" id="adminAddModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Tambah Admin</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form id="formAddAdmin">
            <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="admin">admin</option>
                    <option value="superadmin">superadmin</option>
                </select>

            </div>
            <div id="addAdminMsg" class="text-danger small"></div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnAddAdmin">Simpan</button>
    </div>
</div></div></div>

<!-- Admin Edit Modal -->
<div class="modal fade" id="adminEditModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Edit Admin</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form id="formEditAdmin">
            <input type="hidden" name="id" />
            <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Role</label>
                <select name="role" class="form-select"><option value="admin">admin</option><option value="super">super</option></select>
            </div>
            <div id="editAdminMsg" class="text-danger small"></div>
        </form>
    </div>
    <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnEditAdmin">Simpan</button>
    </div>
</div></div></div>

<!-- Reset Password Modal -->
<div class="modal fade" id="adminResetModal"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Reset Password</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form id="formResetAdmin"><input type="hidden" name="id" />
            <div class="mb-3"><label class="form-label">Password Baru</label><input type="password" name="new_password" class="form-control" required></div>
            <div id="resetAdminMsg" class="text-danger small"></div>
        </form>
    </div>
    <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnResetAdmin">Reset</button>
    </div>
</div></div></div>

<!-- JS libs -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
let dt = null;
let currentTableType = null;

// UI helpers
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("content").classList.toggle("collapsed");
}
function showHome() {
    document.querySelectorAll(".menu-btn").forEach(a => a.classList.remove("active"));
    document.getElementById("menu-home").classList.add("active");
    document.getElementById("homeSection").style.display = "block";
    document.getElementById("tableSection").style.display = "none";
    document.getElementById("exportSection").style.display = "none";
    document.getElementById("tableControls").style.display = "none";
    document.getElementById("pageTitle").innerText = "Beranda";
}

/* =========== load table (contact / cekpt) =========== */
const columns = {
    contact: ["id","nama_pengirim","email","no_hp","pesan","tanggal_dibuat","is_read"],
    cekpt: ["id","nama_pt","nama_pemohon","email","no_hp","pertanyaan","tanggal_dibuat","is_read"]
};

function loadTable(type) {
    currentTableType = type;

    document.querySelectorAll(".menu-btn").forEach(a => a.classList.remove("active"));
    document.getElementById("menu-"+type).classList.add("active");

    document.getElementById("homeSection").style.display = "none";
    document.getElementById("tableSection").style.display = "block";
    document.getElementById("exportSection").style.display = "block";
    document.getElementById("tableControls").style.display = "block";

    // ⚠ FIX UTAMA: 
    // Hanya tampilkan tombol Mark All Read
    document.querySelector("#btnMarkAll").style.display = "inline-block";
    document.querySelector("[data-bs-target='#adminAddModal']").style.display = "none";

    document.getElementById("pageTitle").innerText =
        (type === "contact") ? "Kontak Masuk" : "Cek PT";

    fetch("dashboard_load.php?type="+type)
        .then(r=>r.json())
        .then(data=>{
            const cols = columns[type];

            if (dt) {
                try { dt.destroy(); } catch(e) {}
                dt = null;
            }

            document.querySelector("#dataTable").innerHTML =
                `<thead id="tableHead"></thead><tbody id="tableBody"></tbody>`;

            let theadHTML = "<tr>";
            cols.forEach(c => theadHTML += `<th>${c}</th>`);
            theadHTML += "<th>Aksi</th></tr>";
            document.getElementById("tableHead").innerHTML = theadHTML;

            let tbodyHTML = "";
            data.forEach(row => {
                tbodyHTML += "<tr>";
                cols.forEach(c => {
                    if (c === "is_read") {
                        tbodyHTML += `<td>${row[c] == 1
                            ? 'Read'
                            : '<span class="badge bg-danger">New</span>'}</td>`;
                    } else {
                        let val = row[c] ?? "";
                        tbodyHTML += `<td>${String(val).replace(/</g,'&lt;')}</td>`;
                    }
                });

                tbodyHTML += `
                    <td>
                        <button class='btn btn-sm btn-primary'
                            onclick='showDetail(${JSON.stringify(row)}, "${type}")'>
                            Detail
                        </button>
                        ${row.is_read == 0
                            ? `<button class='btn btn-sm btn-success ms-1'
                                onclick='markAsRead("${type}", ${row.id}, this)'>
                                Mark as Read
                               </button>`
                            : ""
                        }
                    </td>
                `;

                tbodyHTML += "</tr>";
            });

            document.getElementById("tableBody").innerHTML = tbodyHTML;
            dt = $('#dataTable').DataTable({ autoWidth:false });
            updateNotifications();
        });
}


function showDetail(data, type) {
    let html = "";
    for (let k in data) html += `<p><strong>${k}:</strong> ${String(data[k]).replace(/</g,'&lt;')}</p>`;
    document.getElementById("detailBody").innerHTML = html;
    new bootstrap.Modal(document.getElementById("detailModal")).show();

    // mark read when detail opened
    if (data.id) markAsRead(type, data.id);
}

/* =========== mark read =========== */
function markAsRead(type, id, btnElem=null) {
    fetch(`set_read.php?type=${type}&id=${encodeURIComponent(id)}`)
    .then(r=>r.json()).then(resp=>{
        if (resp.success) {
            updateNotifications();
            if (btnElem) btnElem.remove();
            if (currentTableType) loadTable(currentTableType);
        }
    });
}

function markAllRead() {
    if (!currentTableType) return;
    if (!confirm("Mark all messages as read?")) return;
    fetch(`set_read.php?type=${currentTableType}`).then(r=>r.json()).then(resp=>{
        if (resp.success) { updateNotifications(); if (currentTableType) loadTable(currentTableType); }
    });
}

/* =========== DASHBOARD SUMMARY & NOTIFICATIONS =========== */
function updateDashboardSummary() {
    fetch("dashboard_summary.php").then(r=>r.json()).then(d=>{
        document.getElementById("countContact").innerText = d.contact;
        document.getElementById("countCekPT").innerText = d.cekpt;
        document.getElementById("countAdmin").innerText = d.admin;
    });
}

function updateNotifications() {
    fetch("dashboard_notifications.php").then(r=>r.json()).then(n=>{
        document.getElementById("notifContact").innerText = n.contact;
        document.getElementById("notifContact").style.display = n.contact>0 ? "inline-block" : "none";
        document.getElementById("notifCekPT").innerText = n.cekpt;
        document.getElementById("notifCekPT").style.display = n.cekpt>0 ? "inline-block" : "none";
    });
}

setInterval(updateDashboardSummary, 3000);
setInterval(updateNotifications, 3000);
updateDashboardSummary();
updateNotifications();

/* =========== ADMIN CRUD AJAX =========== */

// load admin list
function loadAdmin() {
    currentTableType = null;

    document.querySelectorAll(".menu-btn").forEach(a=>a.classList.remove("active"));
    document.getElementById("menu-admin").classList.add("active");

    document.getElementById("homeSection").style.display = "none";
    document.getElementById("tableSection").style.display = "block";
    document.getElementById("exportSection").style.display = "none";
    document.getElementById("tableControls").style.display = "block";

    // ⚠ FIX UTAMA:
    // Hanya tampilkan tombol Tambah Admin
    document.querySelector("#btnMarkAll").style.display = "none";
    document.querySelector("[data-bs-target='#adminAddModal']").style.display = "inline-block";

    document.getElementById("pageTitle").innerText = "Kelola Admin";

    if (dt) {
        try { dt.destroy(); } catch(e){}
        dt = null;
    }

    document.querySelector("#dataTable").innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    `;

    fetch("admin_list.php")
        .then(r=>r.json())
        .then(data=>{
            let rows = "";
            data.forEach(a=>{
                rows += `
                    <tr>
                        <td>${a.id}</td>
                        <td>${a.username.replace(/</g,'&lt;')}</td>
                        <td>${a.role}</td>
                        <td>${a.created_at}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick='openEditAdmin(${JSON.stringify(a)})'>
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm"
                                onclick='deleteAdmin(${a.id})'>
                                Delete
                            </button>
                            <button class="btn btn-info btn-sm"
                                onclick='openReset(${a.id})'>
                                Reset Pass
                            </button>
                        </td>
                    </tr>
                `;
            });

            document.querySelector("#dataTable tbody").innerHTML = rows;
            dt = $('#dataTable').DataTable({ autoWidth:false });
        });
}



// add admin
$('#btnAddAdmin').on('click', function(e){
    e.preventDefault();
    let form = $('#formAddAdmin');
    let data = form.serialize();
    $('#addAdminMsg').text('');
    $.post('admin_add.php', data, function(resp){
        if (resp === 'success') {
            $('#adminAddModal').modal('hide');
            loadAdmin();
            updateDashboardSummary();
        } else {
            $('#addAdminMsg').text(resp);
        }
    }).fail(()=>$('#addAdminMsg').text('Server error'));
});

// open edit modal
function openEditAdmin(a) {
    $('#adminEditModal input[name=id]').val(a.id);
    $('#adminEditModal input[name=username]').val(a.username);
    $('#adminEditModal select[name=role]').val(a.role);
    $('#editAdminMsg').text('');
    new bootstrap.Modal(document.getElementById('adminEditModal')).show();
}

// submit edit
$('#btnEditAdmin').on('click', function(e){
    e.preventDefault();
    let data = $('#formEditAdmin').serialize();
    $('#editAdminMsg').text('');
    $.post('admin_edit.php', data, function(resp){
        if (resp === 'success') {
            $('#adminEditModal').modal('hide');
            loadAdmin();
            updateDashboardSummary();
        } else {
            $('#editAdminMsg').text(resp);
        }
    }).fail(()=>$('#editAdminMsg').text('Server error'));
});

// open reset modal
function openReset(id) {
    $('#adminResetModal input[name=id]').val(id);
    $('#resetAdminMsg').text('');
    new bootstrap.Modal(document.getElementById('adminResetModal')).show();
}

// submit reset
$('#btnResetAdmin').on('click', function(e){
    e.preventDefault();
    let data = $('#formResetAdmin').serialize();
    $('#resetAdminMsg').text('');
    $.post('admin_reset_password.php', data, function(resp){
        if (resp === 'success') {
            $('#adminResetModal').modal('hide');
            loadAdmin();
        } else {
            $('#resetAdminMsg').text(resp);
        }
    }).fail(()=>$('#resetAdminMsg').text('Server error'));
});

// delete admin
function deleteAdmin(id) {
    if (!confirm('Hapus admin ini?')) return;
    $.post('admin_delete.php', { id: id }, function(resp){
        if (resp === 'success') {
            loadAdmin();
            updateDashboardSummary();
        } else if (resp === 'error:self') {
            alert('Tidak bisa menghapus akun yang sedang login');
        } else {
            alert('Error: ' + resp);
        }
    }).fail(()=>alert('Server error'));
}

</script>
</body>
</html>
