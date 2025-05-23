<?php
// jobs.php - Display job listings from database
$page_title = "Available Positions - Job Application System";

include 'settings.php';
include 'header.inc';
include 'nav.inc';

// Connect to database
$conn = new mysqli($host, $user, $pwd, $sql_db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all jobs from database
$sql = "SELECT * FROM jobs ORDER BY DatePosted DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="jobs.css">

<div class="jobs-container">
    <h2>Available Positions</h2>
    <p class="jobs-intro">Explore our current job openings and find your perfect career opportunity.</p>
    
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="jobs-grid">
            <?php while($job = $result->fetch_assoc()): ?>
                <div class="job-card">
                    <div class="job-header">
                        <h3><?php echo htmlspecialchars($job['JobTitle']); ?></h3>
                        <span class="job-ref">Ref: <?php echo htmlspecialchars($job['JobReference']); ?></span>
                    </div>
                    
                    <div class="job-details">
                        <div class="job-info">
                            <span class="info-label">Location:</span>
                            <span class="info-value"><?php echo htmlspecialchars($job['Location']); ?></span>
                        </div>
                        
                        <div class="job-info">
                            <span class="info-label">Type:</span>
                            <span class="info-value"><?php echo htmlspecialchars($job['Position_type']); ?></span>
                        </div>
                        
                        <?php if (!empty($job['Salary'])): ?>
                        <div class="job-info">
                            <span class="info-label">Salary:</span>
                            <span class="info-value"><?php echo htmlspecialchars($job['Salary']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="job-info">
                            <span class="info-label">Close Date:</span>
                            <span class="info-value"><?php echo date('d/m/Y', strtotime($job['ApplicationCloseDate'])); ?></span>
                        </div>
                    </div>
                    
                    <div class="job-description">
                        <h4>Job Description:</h4>
                        <p><?php echo htmlspecialchars($job['JobDescription']); ?></p>
                    </div>
                    
                    <div class="job-requirements">
                        <h4>Requirements:</h4>
                        <p><?php echo htmlspecialchars($job['Requirements']); ?></p>
                    </div>
                    
                    <div class="job-actions">
                        <a href="apply.php" class="btn btn-primary">Apply Now</a>
                        <span class="posted-date">Posted: <?php echo date('d/m/Y', strtotime($job['DatePosted'])); ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-jobs">
            <h3>No positions currently available</h3>
            <p>Please check back later for new opportunities, or <a href="apply.php">submit your expression of interest</a> for future positions.</p>
        </div>
    <?php endif; ?>
</div>

<?php
$conn->close();
include 'footer.inc';
?>