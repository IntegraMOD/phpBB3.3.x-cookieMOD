🍪 cookieMOD for phpBB 3.3
cookieMOD is a utility for inspecting and updating phpBB's cookie and server configuration parameters directly from a standalone admin-accessible interface. Originally built for phpBB 2.x and IntegraMOD, this module has been modernized for phpBB 3.3.x with strict adherence to legacy formatting, translation discipline, and procedural integrity.<br>
🔧 Purpose<br>
• 	View and modify core cookie settings - (cookie_domain, cookie_path, cookie_name, cookie_secure)<br>
• 	Adjust server-side parameters - (server_name, script_path, server_port)<br>
• 	Enforce explicit field registration and translation alignment<br>
• 	Operate independently from ACP, while respecting admin authentication and phpBB's DBAL constraints<br>
🚀 Usage<br>
1. 	Place  cookieMOD/cookie.php  at the forum root<br>
2. 	Access via: https://yourdomain.com/cookieMOD/cookie.php<br>
3. 	Must be logged in as an admin with 'a_board' permission<br>
4. 	Submit changes via the form to update phpbb_config values directly<br>
5.  After running cookie.php delete the entire cookieMOD folder from your forum root<br>
🛡️ Compatibility<br>
• 	Fully compliant with phpBB 3.3.x<br>
• 	No use of deprecated globals -  ($_SERVER, $_POST, etc.)<br>
• 	Uses- $request, $auth, $user, and $db  and  via core bootstrap<br>
• 	Does not rely on PDO or prepared statements—uses native DBAL execution<br>
