<?php
$page_title = "Apply for Position - Job Application System";

require_once 'settings.php'; 

$conn = new mysqli($host, $user, $pwd, $sql_db);

if ($conn->connect_error) {
    echo "<div style='background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;'>";
    echo "<p><strong>Database connection failed!</strong> Please check your database settings and ensure the MySQL server is running.</p>";
    echo "<p>Error: " . $conn->connect_error . "</p>";
    echo "</div>";
    exit(); 
} 

$jobs_query = "SELECT JobReference, JobTitle FROM jobs ORDER BY JobReference";
$jobs_result = $conn->query($jobs_query);

include 'header.inc'; 
include 'nav.inc';    
?>

<main>
    <div class="form-container">
        <h2>Job Application Form</h2>
        <p>Please fill out all required fields to submit your application.</p>

        <form action="process_eoi.php" method="post" novalidate="novalidate">

            <fieldset>
                <legend>Position Information</legend>

                <div class="form-group">
                    <label for="job_reference">Job Reference Number: <span class="required">*</span></label>
                    <select name="job_reference" id="job_reference" required>
                        <option value="">Please Select...</option>
                        <?php
                        
                        if ($jobs_result && $jobs_result->num_rows > 0) {
                            while($row = $jobs_result->fetch_assoc()) {
                                
                                echo "<option value=\"" . htmlspecialchars($row["JobReference"]) . "\">" .
                                     htmlspecialchars($row["JobReference"]) . " - " . htmlspecialchars($row["JobTitle"]) . "</option>";
                            }
                        } else {
                            echo "<option value=\"\">No jobs available</option>";
                        }
                        ?>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend>Personal Information</legend>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name: <span class="required">*</span></label>
                        <input type="text" name="first_name" id="first_name" maxlength="20" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name: <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" maxlength="20" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth: <span class="required">*</span></label>
                    <input type="text" name="dob" id="dob" placeholder="dd/mm/yyyy" required>
                    <small>Format: dd/mm/yyyy (e.g., 15/03/1990)</small>
                </div>

                <fieldset class="gender-fieldset">
                    <legend>Gender: <span class="required">*</span></legend>
                    <div class="radio-group">
                        <input type="radio" name="gender" id="male" value="Male" required>
                        <label for="male">Male</label>

                        <input type="radio" name="gender" id="female" value="Female" required>
                        <label for="female">Female</label>

                        <input type="radio" name="gender" id="other" value="Other" required>
                        <label for="other">Other</label>
                    </div>
                </fieldset>
            </fieldset>

            <fieldset>
                <legend>Address Information</legend>

                <div class="form-group">
                    <label for="street_address">Street Address: <span class="required">*</span></label>
                    <input type="text" name="street_address" id="street_address" maxlength="40" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="suburb">Suburb/Town: <span class="required">*</span></label>
                        <input type="text" name="suburb" id="suburb" maxlength="40" required>
                    </div>

                    <div class="form-group">
                        <label for="state">State: <span class="required">*</span></label>
                        <select name="state" id="state" required>
                            <option value="">Please Select...</option>
                            <option value="VIC">Victoria</option>
                            <option value="NSW">New South Wales</option>
                            <option value="QLD">Queensland</option>
                            <option value="NT">Northern Territory</option>
                            <option value="WA">Western Australia</option>
                            <option value="SA">South Australia</option>
                            <option value="TAS">Tasmania</option>
                            <option value="ACT">Australian Capital Territory</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode: <span class="required">*</span></label>
                    <input type="text" name="postcode" id="postcode" maxlength="4" required>
                    <small>Must be exactly 4 digits</small>
                </div>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>

                <div class="form-group">
                    <label for="email">Email Address: <span class="required">*</span></label>
                    <input type="email" name="email" id="email" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number: <span class="required">*</span></label>
                    <input type="text" name="phone" id="phone" maxlength="12" required>
                    <small>8-12 digits, spaces allowed</small>
                </div>
            </fieldset>

            <fieldset>
                <legend>Skills and Experience</legend>

                <div class="form-group">
                    <label>Technical Skills: <span class="required">*</span></label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="skills[]" id="html" value="HTML">
                        <label for="html">HTML</label>

                        <input type="checkbox" name="skills[]" id="css" value="CSS">
                        <label for="css">CSS</label>

                        <input type="checkbox" name="skills[]" id="javascript" value="JavaScript">
                        <label for="javascript">JavaScript</label>

                        <input type="checkbox" name="skills[]" id="php" value="PHP">
                        <label for="php">PHP</label>

                        <input type="checkbox" name="skills[]" id="mysql" value="MySQL">
                        <label for="mysql">MySQL</label>

                        <input type="checkbox" name="skills[]" id="python" value="Python">
                        <label for="python">Python</label>

                        <input type="checkbox" name="skills[]" id="java" value="Java">
                        <label for="java">Java</label>

                        <input type="checkbox" name="skills[]" id="other_check" value="Other">
                        <label for="other_check">Other</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="other_skills">Other Skills (please describe):</label>
                    <textarea name="other_skills" id="other_skills" rows="4" placeholder="Describe any additional skills, experience, or qualifications..."></textarea>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Submit Application</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </div>
        </form>
    </div>
</main>

<?php

$conn->close();


include 'footer.inc'; 
?>
