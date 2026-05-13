<?php ob_start(); ?>

<div class="account-profile">
    <div class="welcome-header">
        <h2>Profile Settings</h2>
        <p>Manage your personal information and update your account password.</p>
    </div>

    <form id="profileUpdateForm" class="modern-form">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::getCsrfToken() ?>">
        
        <div class="form-section">
            <h3 class="form-section-title">Personal Information</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                <p class="form-help-text">Email address cannot be changed. Please contact support if you need to update it.</p>
            </div>
        </div>

        <div class="form-divider"></div>

        <div class="form-section">
            <h3 class="form-section-title">Security & Password</h3>
            <p class="form-description">Leave password fields blank if you don't want to change it.</p>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••">
                </div>
            </div>
        </div>

        <div class="form-footer mt-30">
            <button type="submit" class="btn btn-primary" id="saveProfileBtn">Save Changes</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('profileUpdateForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('saveProfileBtn');
            
            if (typeof UI !== 'undefined') UI.setLoading(btn, true);
            
            const formData = new FormData(form);
            
            try {
                const response = await fetch(`${BASE_URL}/api/account/update`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                    // Update user name in header/sidebar if changed
                    const nameFields = document.querySelectorAll('.user-name-text, .user-info h3');
                    nameFields.forEach(el => el.textContent = formData.get('fname'));
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            } catch (error) {
                if (typeof UI !== 'undefined') UI.setLoading(btn, false);
                Swal.fire('Error!', 'Failed to update profile. Please try again.', 'error');
            }
        });
    }
});
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
