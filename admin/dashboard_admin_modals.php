<!-- Modal: Tambah Admin -->
<div class="modal fade" id="modalAddAdmin">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="admin_add.php">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Username</label>
                <input type="text" name="username" class="form-control mb-2" required>

                <label>Password</label>
                <input type="password" name="password" class="form-control mb-2" required>

                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal: Edit Admin -->
<div class="modal fade" id="modalEditAdmin">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="admin_edit.php">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">

                <label>Username</label>
                <input type="text" name="username" id="edit_username" class="form-control mb-2" required>

                <label>Role</label>
                <select name="role" id="edit_role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-warning">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal: Reset Password -->
<div class="modal fade" id="modalResetPass">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="admin_reset_password.php">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="reset_id">

                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info">Reset</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal: Delete Admin -->
<div class="modal fade" id="modalDeleteAdmin">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="admin_delete.php">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Admin</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="delete_id">
                <p>Yakin ingin menghapus admin ini?</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>


<script>
function editAdmin(a) {
    document.getElementById("edit_id").value = a.id;
    document.getElementById("edit_username").value = a.username;
    document.getElementById("edit_role").value = a.role;
    new bootstrap.Modal(document.getElementById('modalEditAdmin')).show();
}

function deleteAdmin(id) {
    document.getElementById("delete_id").value = id;
    new bootstrap.Modal(document.getElementById('modalDeleteAdmin')).show();
}

function resetPassword(id) {
    document.getElementById("reset_id").value = id;
    new bootstrap.Modal(document.getElementById('modalResetPass')).show();
}
</script>
