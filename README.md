🍪 cookieMOD for phpBB 3.3
cookieMOD is a utility for inspecting and updating phpBB's cookie and server configuration parameters directly from a standalone admin-accessible interface. Originally built for phpBB 2.x and IntegraMOD, this module has been modernized for phpBB 3.3.x with strict adherence to legacy formatting, translation discipline, and procedural integrity.
🔧 Purpose
• 	View and modify core cookie settings - (cookie_domain, cookie_path, cookie_name, cookie_secure)
• 	Adjust server-side parameters - (server_name, script_path, server_port)
• 	Enforce explicit field registration and translation alignment
• 	Operate independently from ACP, while respecting admin authentication and phpBB's DBAL constraints
🚀 Usage
1. 	Place  inside  at the forum root
2. 	Access via: 
3. 	Must be logged in as an admin with  permission
4. 	Submit changes via the form to update  values directly
🛡️ Compatibility
• 	Fully compliant with phpBB 3.3.x
• 	No use of deprecated globals (, , etc.)
• 	Uses , , , and  via core bootstrap
• 	Does not rely on PDO or prepared statements—uses native DBAL execution
