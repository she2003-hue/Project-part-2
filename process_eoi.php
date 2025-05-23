<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['job_reference'])) {
    header("Location: apply.php");
    exit();
}

include 'settings.php';


function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function validate_name($name) {
    return preg_match("/^[a-zA-Z\s]{1,20}$/", $name);
}

function validate_date($date) {
    if (!preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $date, $matches)) {
        return false;
    }
    $day = (int)$matches[1];
    $month = (int)$matches[2];
    $year = (int)$matches[3];
    return checkdate($month, $day, $year);
}

function validate_postcode($postcode, $state) {
    if (!preg_match("/^\d{4}$/", $postcode)) {
        return false;
    }
    
    $valid_postcodes = [
        'VIC' => ['3', '8'],
        'NSW' => ['1', '2'],
        'QLD' => ['4', '9'],
        'NT' => ['0'],
        'WA' => ['6'],
        'SA' => ['5'],
        'TAS' => ['7'],
        'ACT' => ['0', '2']
    ];
    
    $first_digit = substr($postcode, 0, 1);
    return in_array($first_digit, $valid_postcodes[$state]);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    $phone = preg_replace('/\s/', '', $phone); 
    return preg_match("/^\d{8,12}$/", $phone);
}


$job_reference = sanitise_input($_POST['job_reference']);
$first_name = sanitise_input($_POST['first_name']);
$last_name = sanitise_input($_POST['last_name']);
$dob = sanitise_input($_POST['dob']);
$gender = sanitise_input($_POST['gender']);
$street_address = sanitise_input($_POST['street_address']);
$suburb = sanitise_input($_POST['suburb']);
$state = sanitise_input($_POST['state']);
$postcode = sanitise_input($_POST['postcode']);
$email = sanitise_input($_POST['email']);
$phone = sanitise_input($_POST['phone']);
$other_skills = sanitise_input($_POST['other_skills']);


$skills = isset($_POST['skills']) ? $_POST['skills'] : [];
$skill1 = isset($skills[0]) ? sanitise_input($skills[0]) : '';
$skill2 = isset($skills[1]) ? sanitise_input($skills[1]) : '';
$skill3 = isset($skills[2]) ? sanitise_input($skills[2]) : '';
$skill4 = isset($skills[3]) ? sanitise_input($skills[3]) : '';


$errors = [];


if (empty($job_reference)) $errors[] = "Job reference is required";
if (empty($first_name)) $errors[] = "First name is required";
if (empty($last_name)) $errors[] = "Last name is required";
if (empty($dob)) $errors[] = "Date of birth is required";
if (empty($gender)) $errors[] = "Gender is required";
if (empty($street_address)) $errors[] = "Street address is required";
if (empty($suburb)) $errors[] = "Suburb is required";
if (empty($state)) $errors[] = "State is required";
if (empty($postcode)) $errors[] = "Postcode is required";
if (empty($email)) $errors[] = "Email is required";
if (empty($phone)) $errors[] = "Phone number is required";
if (empty($skills)) $errors[] = "At least one skill must be selected";

// Format validation
if (!empty($first_name) && !validate_name($first_name)) {
    $errors[] = "First name must contain only letters and be max 20 characters";
}

if (!empty($last_name) && !validate_name($last_name)) {
    $errors[] = "Last name must contain only letters and be max 20 characters";
}

if (!empty($dob) && !validate_date($dob)) {
    $errors[] = "Date of birth must be in dd/mm/yyyy format";
}

if (!empty($street_address) && strlen($street_address) > 40) {
    $errors[] = "Street address must be max 40 characters";
}

if (!empty($suburb) && strlen($suburb) > 40) {
    $errors[] = "Suburb must be max 40 characters";
}

if (!empty($state) && !in_array($state, ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'])) {
    $errors[] = "Please select a valid state";
}

if (!empty($postcode) && !empty($state) && !validate_postcode($postcode, $state)) {
    $errors[] = "Postcode must be 4 digits and match the selected state";
}

if (!empty($email) && !validate_email($email)) {
    $errors[] = "Please enter a valid email address";
}

if (!empty($phone) && !validate_phone($phone)) {
    $errors[] = "Phone number must be 8-12 digits";
}


if (in_array("Other", $skills) && empty($other_skills)) {
    $errors[] = "Please describe your other skills when 'Other' is selected";
}

$page_title = "Application Result - Job Application System";
include 'header.inc';
include 'nav.inc';


if (!empty($errors)) {
    echo "<div class='error-container'>";
    echo "<h2>Application Error</h2>";
    echo "<p>Please correct the following errors and try again:</p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
    echo "<p><a href='apply.php' class='btn btn-primary'>Back to Application Form</a></p>";
    echo "</div>";
} else {
    
    $conn = new mysqli($host, $user, $pwd, $sql_db);
    
    if ($conn->connect_error) {
        die("<div class='error-container'><h2>Database Connection Error</h2><p>Sorry, we're experiencing technical difficulties. Please try again later.</p></div>");
    }
    
    
    $create_table_sql = "CREATE TABLE IF NOT EXISTS eoi (
        EOInumber INT AUTO_INCREMENT PRIMARY KEY,
        JobReference VARCHAR(10) NOT NULL,
        FirstName VARCHAR(20) NOT NULL,
        LastName VARCHAR(20) NOT NULL,
        DateOfBirth DATE NOT NULL,
        Gender VARCHAR(10) NOT NULL,
        StreetAddress VARCHAR(40) NOT NULL,
        Suburb VARCHAR(40) NOT NULL,
        State VARCHAR(3) NOT NULL,
        Postcode VARCHAR(4) NOT NULL,
        EmailAddress VARCHAR(100) NOT NULL,
        PhoneNumber VARCHAR(12) NOT NULL,
        Skill1 VARCHAR(50),
        Skill2 VARCHAR(50),
        Skill3 VARCHAR(50),
        Skill4 VARCHAR(50),
        OtherSkills TEXT,
        Status VARCHAR(10) DEFAULT 'New',
        ApplicationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->query($create_table_sql);
    
    
    $date_parts = explode('/', $dob);
    $mysql_date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    
    
    $stmt = $conn->prepare("INSERT INTO eoi (JobReference, FirstName, LastName, DateOfBirth, Gender, StreetAddress, Suburb, State, Postcode, EmailAddress, PhoneNumber, Skill1, Skill2, Skill3, Skill4, OtherSkills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')");
    
    $stmt->bind_param("ssssssssssssssss", $job_reference, $first_name, $last_name, $mysql_date, $gender, $street_address, $suburb, $state, $postcode, $email, $phone, $skill1, $skill2, $skill3, $skill4, $other_skills);
    
    if ($stmt->execute()) {
        $eoi_number = $conn->insert_id;
        echo "<div class='success-container'>";
        echo "<h2>Application Submitted Successfully!</h2>";
        echo "<p>Thank you for your application. Your submission has been received and assigned the following reference number:</p>";
        echo "<div class='eoi-number'>EOI #" . $eoi_number . "</div>";
        echo "<p>Please keep this reference number for your records. You will be contacted if your application is shortlisted.</p>";
        echo "<div class='application-summary'>";
        echo "<h3>Application Summary:</h3>";
        echo "<p><strong>Position:</strong> " . $job_reference . "</p>";
        echo "<p><strong>Applicant:</strong> " . $first_name . " " . $last_name . "</p>";
        echo "<p><strong>Email:</strong> " . $email . "</p>";
        echo "<p><strong>Application Date:</strong> " . date('d/m/Y H:i:s') . "</p>";
        echo "</div>";
        echo "<p><a href='jobs.php' class='btn btn-primary'>View Other Positions</a> ";
        echo "<a href='index.php' class='btn btn-secondary'>Return to Home</a></p>";
        echo "</div>";
    } else {
        echo "<div class='error-container'>";
        echo "<h2>Submission Error</h2>";
        echo "<p>Sorry, there was an error processing your application. Please try again later.</p>";
        echo "<p><a href='apply.php' class='btn btn-primary'>Back to Application Form</a></p>";
        echo "</div>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<style>
.success-container, .error-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 30px;
    border-radius: 8px;
    text-align: center;
}

.success-container {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.error-container {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.eoi-number {
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
    padding: 15px;
    background: #fff;
    border: 2px solid #28a745;
    border-radius: 5px;
    color: #28a745;
}

.application-summary {
    background: #fff;
    padding: 20px;
    margin: 20px 0;
    border-radius: 5px;
    text-align: left;
}

.error-container ul {
    text-align: left;
    margin: 20px 0;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    margin: 10px 5px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}
</style>

<?php include 'footer.inc'; ?>