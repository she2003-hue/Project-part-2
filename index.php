<?php
$page_title = "Home - CDS Solutions";

require_once 'settings.php'; 


$conn = new mysqli($host, $user, $pwd, $sql_db);

if ($conn->connect_error) {
    echo "<div style='background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;'>";
    echo "<p><strong>Database connection failed!</strong> Please check your database settings and ensure the MySQL server is running.</p>";
    echo "<p>Error: " . $conn->connect_error . "</p>";
    echo "</div>";
    exit(); 
} 

include 'header.inc';
include 'nav.inc';
?>

<main>
    <section class="welcome-banner">
        <div class="container">
            <h2>Welcome to CDS Solutions</h2>
            <p class="lead-paragraph">
                We are a dynamic and innovative IT company, dedicated to creating cutting-edge solutions
                and fostering a collaborative work environment. We believe in empowering our employees
                to reach their full potential and are always looking for talented individuals to join our team.
            </p>
        </div>
    </section>

    <div class="container">
        <section class="why-choose-us">
            <h2>Why Choose CDS Solutions?</h2>
            <div class="benefits-grid">
                <?php
                $benefits = [
                    ["icon" => "chart-line", "title" => "Career Growth", "desc" => "We invest in your development with continuous learning opportunities and clear career paths."],
                    ["icon" => "users", "title" => "Collaborative Culture", "desc" => "Join a supportive team where ideas are valued and collaboration thrives."],
                    ["icon" => "lightbulb", "title" => "Innovative Projects", "desc" => "Work on exciting, cutting-edge projects that challenge and inspire you."],
                    ["icon" => "hand-holding-heart", "title" => "Work-Life Balance", "desc" => "Enjoy flexible work options and a commitment to your well-being."]
                ];

                foreach ($benefits as $b) {
                    echo "<div class='benefit-item'>
                            <i class='fas fa-{$b['icon']}'></i>
                            <h3>{$b['title']}</h3>
                            <p>{$b['desc']}</p>
                          </div>";
                }
                ?>
            </div>
        </section>

        <section class="featured-jobs">
            <h2>Featured Jobs</h2>
            <div class="job-card">
                <h3>Senior Software Engineer</h3>
                <p>Develop and maintain complex software systems.</p>
                <a href="jobs.php#senior-software-engineer" class="apply-button">Learn More & Apply</a>
            </div>
            <div class="job-card">
                <h3>Data Scientist</h3>
                <p>Analyze and interpret complex data sets to drive business decisions.</p>
                <a href="jobs.php#data-scientist" class="apply-button">Learn More & Apply</a>
            </div>
        </section>

        <section class="company-values">
            <h2>Our Core Values</h2>
            <div class="values-grid">
                <?php
                $values = [
                    ["icon" => "rocket", "title" => "Innovation", "desc" => "We encourage creative thinking and continuous improvement."],
                    ["icon" => "handshake", "title" => "Collaboration", "desc" => "We believe in the power of teamwork and mutual respect."],
                    ["icon" => "gem", "title" => "Excellence", "desc" => "We strive for the highest standards in everything we do."]
                ];

                foreach ($values as $v) {
                    echo "<div class='value-item'>
                            <i class='fas fa-{$v['icon']}'></i>
                            <h3>{$v['title']}</h3>
                            <p>{$v['desc']}</p>
                          </div>";
                }
                ?>
            </div>
        </section>
    </div>
</main>

<?php
$conn->close();
include 'footer.inc';
?>
