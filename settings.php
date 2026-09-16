<?php
// settings.php
require_once 'includes/header.php';

$message = '';

// Handle Profile Picture & Settings Form Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    // 1. Handle Profile Picture Upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newFileName = 'avatar_' . time() . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('profile_picture', ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$destPath]);
            }
        }
    }

    // 2. Save Text & Toggle Preferences
    $settings_to_update = [
        'store_name'          => trim($_POST['store_name']),
        'phone_number'        => trim($_POST['phone_number']),
        'currency'            => trim($_POST['currency']),
        'low_stock_threshold' => intval($_POST['low_stock_threshold']),
        'system_status'       => trim($_POST['system_status']),
        'notifications'       => isset($_POST['notifications']) ? 'enabled' : 'disabled',
        'theme_mode'          => isset($_POST['theme_mode']) ? 'dark' : 'light'
    ];

    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");

    foreach ($settings_to_update as $key => $val) {
        $stmt->execute([$key, $val]);
    }

    $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Settings updated successfully!</div>';
}

// Fetch Current Saved Settings
$raw_settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);

$store_name          = $raw_settings['store_name'] ?? 'Mwalimu Shopping Center';
$phone_number        = $raw_settings['phone_number'] ?? '+255 700 000 000';
$currency            = $raw_settings['currency'] ?? 'TSH';
$low_stock_threshold = $raw_settings['low_stock_threshold'] ?? '5';
$system_status       = $raw_settings['system_status'] ?? 'FULL SYSTEM';
$profile_picture     = $raw_settings['profile_picture'] ?? '';
$notifications       = $raw_settings['notifications'] ?? 'enabled';
$theme_mode          = $raw_settings['theme_mode'] ?? 'light';
?>

<!-- Settings & Profile Form -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;">
        <i class="fa-solid fa-sliders"></i> System & Profile Settings
    </h3>
    <?php echo $message; ?>
    
    <form action="settings.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Profile Picture Upload Preview -->
        <div style="display: flex; align-items: center; gap: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
            <?php if (!empty($profile_picture) && file_exists($profile_picture)): ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-green);">
            <?php else: ?>
                <div style="width: 60px; height: 60px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; border: 2px solid var(--primary-green); flex-shrink: 0;">
                    <i class="fa-solid fa-user" style="font-size: 28px; color: var(--primary-green);"></i>
                </div>
            <?php endif; ?>
            <div>
                <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 4px;">Profile Picture</label>
                <input type="file" name="profile_pic" accept="image/*" style="font-size: 12px;">
            </div>
        </div>

        <div>
            <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Store Name</label>
            <input type="text" name="store_name" value="<?php echo htmlspecialchars($store_name); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>

        <div>
            <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Phone Number / WhatsApp</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="width: 50%;">
                <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Currency Symbol</label>
                <input type="text" name="currency" value="<?php echo htmlspecialchars($currency); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="width: 50%;">
                <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Low Stock Limit</label>
                <input type="number" name="low_stock_threshold" value="<?php echo htmlspecialchars($low_stock_threshold); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div>
            <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">System Status Banner</label>
            <input type="text" name="system_status" value="<?php echo htmlspecialchars($system_status); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>

        <!-- Appearance & Theme Toggle Switch -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
            <div>
                <strong style="font-size: 13px; display: block;">Dark Mode</strong>
                <span style="font-size: 11px; color: var(--text-muted);" id="themeStatusText">
                    <?php echo $theme_mode === 'dark' ? 'Dark theme active' : 'Light theme active'; ?>
                </span>
            </div>
            <label class="theme-switch">
                <input type="checkbox" name="theme_mode" id="themeToggle" value="dark" <?php echo $theme_mode === 'dark' ? 'checked' : ''; ?> onchange="toggleTheme(this)">
                <span class="slider round">
                    <i class="fa-solid fa-sun icon-sun"></i>
                    <i class="fa-solid fa-moon icon-moon"></i>
                </span>
            </label>
        </div>

        <!-- Notifications Toggle -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
            <div>
                <strong style="font-size: 13px; display: block;">System Notifications</strong>
                <span style="font-size: 11px; color: var(--text-muted);">Receive stock alerts & status warnings</span>
            </div>
            <input type="checkbox" name="notifications" value="1" <?php echo $notifications === 'enabled' ? 'checked' : ''; ?> style="width: 18px; height: 18px; cursor: pointer;">
        </div>

        <button type="submit" name="save_settings" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; margin-top: 5px;">
            Save All Preferences
        </button>
    </form>
</div>

<!-- Instant Dark Mode Switch Script -->
<script>
function toggleTheme(checkbox) {
    const statusText = document.getElementById('themeStatusText');
    if (checkbox.checked) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        if(statusText) statusText.textContent = 'Dark theme active';
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
        if(statusText) statusText.textContent = 'Light theme active';
    }
}

// Maintain client theme on page load
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    const toggle = document.getElementById('themeToggle');
    if (toggle) toggle.checked = true;
}
</script>

<!-- Toggle Switch Component & Dark Mode Dynamic CSS -->
<style>
/* Switch Layout */
.theme-switch {
  position: relative;
  display: inline-block;
  width: 54px;
  height: 28px;
}

.theme-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .3s;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 6px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .3s;
  z-index: 2;
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2e7d32;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

.icon-sun {
  color: #f39c12;
  font-size: 12px;
}

.icon-moon {
  color: #f1c40f;
  font-size: 12px;
}

/* Dark Mode Override Rules */
body.dark-mode {
    background-color: #121212 !important;
    color: #e0e0e0 !important;
}
body.dark-mode .card {
    background-color: #1e1e1e !important;
    color: #ffffff !important;
    border-color: #333333 !important;
}
body.dark-mode input[type="text"], 
body.dark-mode input[type="number"] {
    background-color: #2c2c2c !important;
    color: #ffffff !important;
    border-color: #444444 !important;
}
</style>

<?php require_once 'includes/nav.php'; ?>