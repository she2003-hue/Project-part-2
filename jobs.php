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

<style>
.jobs-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

.jobs-intro {
    text-align: center;
    margin-bottom: 30px;
    font-size: 18px;
    color: #666;
}

.jobs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.job-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.job-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.job-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.job-header h3 {
    margin: 0;
    color: #333;
    font-size: 24px;
}

.job-ref {
    background: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.job-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 20px;
}

.job-info {
    display: flex;
    gap: 8px;
}

.info-label {
    font-weight: bold;
    color: #555;
    min-width: 80px;
}

.info-value {
    color: #333;
}

.job-description, .job-requirements {
    margin: 20px 0;
}

.job-description h4, .job-requirements h4 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 16px;
    border-left: 4px solid #007bff;
    padding-left: 10px;
}

.job-description p, .job-requirements p {
    line-height: 1.6;
    color: #666;
    margin: 0;
}

.job-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn {
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.2s;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.posted-date {
    font-size: 14px;
    color: #888;
}

.no-jobs {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-top: 30px;
}

.no-jobs h3 {
    color: #666;
    margin-bottom: 15px;
}

.no-jobs a {
    color: #007bff;
    text-decoration: none;
}

.no-jobs a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .jobs-grid {
        grid-template-columns: 1fr;
    }
    
    .job-details {
        grid-template-columns: 1fr;
    }
    
    .job-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .job-actions {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>

<?php
$conn->close();
include 'footer.inc';
?>