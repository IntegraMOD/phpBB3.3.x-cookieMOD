<?php
/***************************************************************************
 *                             cookies.php
 *                        ---------------------
 *   begin                : Sunday, May 7, 2023
 *   copyright            : (C) 2023 Integramod
 *   email                : integramod@integramod.com
 *   update               : updated for phpBB3.x by Helter 
 *						 
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Prevent direct access
define('IN_PHPBB', true);

// Require core phpBB configuration
require_once('../config.php');
global $phpbb_root_path, $phpEx;

$phpbb_root_path = '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

require($phpbb_root_path . 'common.' . $phpEx);
require($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Verify admin authentication
if (!$auth->acl_get('a_board')) {
    trigger_error('NO_ADMIN', E_USER_ERROR);
}

// Language strings (simplified)
$lang = [
    'cookie_settings_title' => 'Cookie Settings Configuration',
    'cookie_domain' => 'Cookie Domain',
    'cookie_path' => 'Cookie Path',
    'cookie_name' => 'Cookie Name',
    'cookie_secure' => 'Secure Cookies',
    'server_name' => 'Server Name',
    'script_path' => 'Script Path',
    'server_port' => 'Server Port',
    'save_settings' => 'Save Settings',
    'settings_updated' => 'Cookie settings have been successfully updated.',
    'settings_error' => 'Failed to update cookie settings.',
    'clear_browser_cache' => 'Please clear your browser cache after updating settings.'
];

// Process form submission
if ($request->server('REQUEST_METHOD') === 'POST') {
    try {
        // Sanitize input
        $cookie_domain = filter_input(INPUT_POST, 'cookie_domain', FILTER_SANITIZE_STRING);
        $cookie_path = filter_input(INPUT_POST, 'cookie_path', FILTER_SANITIZE_STRING);
        $cookie_name = filter_input(INPUT_POST, 'cookie_name', FILTER_SANITIZE_STRING);
        $cookie_secure = filter_input(INPUT_POST, 'cookie_secure', FILTER_VALIDATE_INT);
        $server_name = filter_input(INPUT_POST, 'server_name', FILTER_SANITIZE_STRING);
        $script_path = filter_input(INPUT_POST, 'script_path', FILTER_SANITIZE_STRING);
        $server_port = filter_input(INPUT_POST, 'server_port', FILTER_VALIDATE_INT);

        // Update configuration in database
		$sql_updates = [
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'cookie_domain'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'cookie_path'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'cookie_name'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'cookie_secure'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'server_name'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'script_path'",
			"UPDATE " . CONFIG_TABLE . " SET config_value = '%s' WHERE config_name = 'server_port'"
		];

        $params = [
            $cookie_domain, 
            $cookie_path, 
            $cookie_name, 
            $cookie_secure, 
            $server_name, 
            $script_path, 
            $server_port
        ];

		foreach ($sql_updates as $index => $sql_template)
		{
			$escaped_param = $db->sql_escape($params[$index]);
			$sql = sprintf($sql_template, $escaped_param);
			$db->sql_query($sql);
		}

        // Redirect with success message
        trigger_error($lang['settings_updated'] . '<br />' . $lang['clear_browser_cache'], E_USER_NOTICE);
    } catch (Exception $e) {
        trigger_error($lang['settings_error'] . ': ' . $e->getMessage(), E_USER_ERROR);
    }
}

// Default configuration retrieval
$config_data = [
    'cookie_domain' => $config['cookie_domain'],
    'cookie_path' => $config['cookie_path'],
    'cookie_name' => $config['cookie_name'],
    'cookie_secure' => $config['cookie_secure'],
    'server_name' => $config['server_name'],
    'script_path' => $config['script_path'],
    'server_port' => $config['server_port']
];

// HTML Output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $lang['cookie_settings_title']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <?php echo $lang['cookie_settings_title']; ?>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['cookie_domain']; ?></label>
                                <input type="text" name="cookie_domain" class="form-control" value="<?php echo htmlspecialchars($config_data['cookie_domain']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['cookie_path']; ?></label>
                                <input type="text" name="cookie_path" class="form-control" value="<?php echo htmlspecialchars($config_data['cookie_path']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['cookie_name']; ?></label>
                                <input type="text" name="cookie_name" class="form-control" value="<?php echo htmlspecialchars($config_data['cookie_name']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['cookie_secure']; ?></label>
                                <select name="cookie_secure" class="form-select">
                                    <option value="0" <?php echo $config_data['cookie_secure'] == 0 ? 'selected' : ''; ?>>Disabled</option>
                                    <option value="1" <?php echo $config_data['cookie_secure'] == 1 ? 'selected' : ''; ?>>Enabled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['server_name']; ?></label>
                                <input type="text" name="server_name" class="form-control" value="<?php echo htmlspecialchars($config_data['server_name']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['script_path']; ?></label>
                                <input type="text" name="script_path" class="form-control" value="<?php echo htmlspecialchars($config_data['script_path']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo $lang['server_port']; ?></label>
                                <input type="number" name="server_port" class="form-control" value="<?php echo htmlspecialchars($config_data['server_port']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo $lang['save_settings']; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
