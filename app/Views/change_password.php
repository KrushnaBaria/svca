<div class="col-12 col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="card-title text-white mb-0">Change Password</h4>
        </div>
        <div class="card-body">
            <form action="">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="hidden" id="user_id" value="<?= $user_id ?>">
                    <button type="submit" class="btn btn-primary" id="update_btn">Update Password</button>
                </div>           
            </form>
        </div>
    </div>
</div>