<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>
<h1>Enhancements</h1>

<h2>1. Secure Manager Login with Password Hashing</h2>
<p>We used PHP’s <code>password_hash()</code> to store passwords securely and <code>password_verify()</code> to check them during login. This prevents plain-text passwords from being stored in the database.</p>

<h2>2. Login Lockout After Failed Attempts</h2>
<p>To protect from brute-force login attacks, we track login attempts and block login if a user tries more than 3 times unsuccessfully. We use the <code>login_attempts</code> and <code>last_attempt</code> fields in the <code>managers</code> table.</p>

<h2>3. Server-Side Validation with Error Messages</h2>
<p>All form fields in <code>apply.php</code> are validated on the server in <code>process_eoi.php</code> with appropriate error messages shown to users if data is missing or invalid.</p>

<h2>4. Dynamic Job Listings from Database</h2>
<p>In <code>jobs.php</code>, we use a MySQL query to pull job descriptions from the <code>jobs</code> table instead of hardcoding them into HTML.</p>

<h2>5. Manager Logout Feature</h2>
<p>A logout link on <code>manage.php</code> allows the manager to end their session securely using <code>session_destroy()</code>.</p>

<h2>6. Clean, Responsive UI</h2>
<p>The website layout adapts to different screen sizes using responsive CSS. Forms, tables, and navigation are designed to work on phones and desktops.</p>

<?php include("footer.inc"); ?>
