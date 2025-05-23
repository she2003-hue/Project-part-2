<?php
// about.php - About Us page for TechCorp Solutions
$page_title = "About Us - TechCorp Solutions";
$page_description = "About TechCorp Solutions - Meet our development team";
$page_keywords = "team, developers, group, students, about us";
$page_author = "Group 5 - TechCorp Solutions";

include 'settings.php';
include 'header.inc';
include 'nav.inc';
?>

<main>
    <section class="about-content">
        <h1>About Our Team</h1>
        
        <h2>Group 5 - Wednesday 2:30 PM Class</h2>
        
        <h3>Team Structure</h3>
        <ul>
            <li>Development Team
                <ul>
                    <li>Frontend Developers</li>
                    <li>Backend Developers</li>
                    <li>UI/UX Designers</li>
                </ul>
            </li>
            <li>Project Management
                <ul>
                    <li>Scrum Master</li>
                    <li>Product Owner</li>
                </ul>
            </li>
        </ul>
        
        <div class="student-ids">
            <h3>Student IDs</h3>
            <ul>
                <li>Student ID: 105549359</li>
                <li>Student ID: 105305593</li>
                <li>Student ID: 105507535</li>
                <li>Student ID: 105299159</li>
            </ul>
        </div>

        <h3>Our Tutor</h3>
        <p><strong>Tutor Name:</strong> Mr. Rahul Raghavan</p>

        <figure class="group-photo">
            <img src="images/group-photo.jpg" alt="Group 5 team photo showing four students working together">
            <figcaption>Our development team working together on the TechCorp Solutions project</figcaption>
        </figure>

        <h3>Project Contributions - Updated for Part 2</h3>
        <dl class="contributions">
            <dt>Chanuth Senviru (105549359)</dt>
            <dd>
                <strong>Part 1:</strong> Frontend development and CSS styling. Responsible for the home page and overall visual design consistency.<br>
                <strong>Part 2:</strong> Converted home page to PHP, implemented database connection components, created dynamic content integration.
            </dd>
            
            <dt>Ravindu Dilshan (105299159)</dt>
            <dd>
                <strong>Part 1:</strong> Designed the Job Description pages and ensured accessibility compliance.<br>
                <strong>Part 2:</strong> Developed jobs.php with dynamic database content, implemented job listing functionality, created job management features.
            </dd>

            <dt>Chamath Lakshitha (105507535)</dt>
            <dd>
                <strong>Part 1:</strong> Created application forms and user interface design.<br>
                <strong>Part 2:</strong> Developed process_eoi.php, implemented server-side validation, created EOI database processing and data sanitization.
            </dd>

            <dt>Shehan Ariyarathna (105305593) - My Individual Contributions</dt>
            <dd class="my-contribution">
                <strong>Part 1:</strong> About page development and WCAG compliance review.<br>
                <strong>Part 2 - My Specific Contributions:</strong>
                <ul>
                    <li><strong>About Page Conversion:</strong> Successfully converted about.html to about.php using PHP includes</li>
                    <li><strong>PHP Include Files:</strong> Created header.inc, nav.inc, and footer.inc for modular code structure</li>
                    <li><strong>Dynamic Navigation:</strong> Implemented active page highlighting using PHP</li>
                    <li><strong>Team Information Updates:</strong> Enhanced member contribution details for Part 2 requirements</li>
                    <li><strong>Code Modularity:</strong> Ensured all common HTML elements are properly included via .inc files</li>
                    <li><strong>File Structure Compliance:</strong> Organized files according to project specifications</li>
                    <li><strong>Documentation:</strong> Updated team member information and project details</li>
                </ul>
            </dd>
        </dl>

        <h3>Team Interests</h3>
        <table class="interests-table">
            <caption>Our Team's Diverse Interests and Hobbies</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Programming Languages</th>
                    <th>Hobbies</th>
                    <th>Career Goals</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Chanuth Senviru</td>
                    <td>JavaScript, Python, CSS, PHP</td>
                    <td>Photography, Gaming</td>
                    <td rowspan="2">Frontend Development</td>
                </tr>
                <tr>
                    <td>Shehan Ariyarathna</td>
                    <td>Java, PHP, SQL, CSS</td>
                    <td>Cooking, Reading</td>
                </tr>
                <tr>
                    <td>Chamath Lakshitha</td>
                    <td>HTML, CSS, JavaScript, PHP</td>
                    <td colspan="2">Technical Writing and UI/UX Design</td>
                </tr>
                <tr>
                    <td>Ravindu Dilshan</td>
                    <td>Python, Java, C++, PHP, HTML, CSS</td>
                    <td>Yoga, Traveling</td>
                    <td>Full-Stack Web Development</td>
                </tr>
            </tbody>
        </table>

        <h3>Our Background</h3>
        <p>We are a diverse group of Computer Science students from Swinburne University, each bringing unique skills and perspectives to web development. Our team combines technical expertise with creative problem-solving to deliver innovative solutions. In Project Part 2, we've successfully transitioned from static HTML pages to dynamic PHP-powered web applications with database integration.</p>
        
        <h4>Demographic Information</h4>
        <p>Our team represents students from different cultural backgrounds, including Australia, China, Mexico, and India. This diversity enriches our collaborative approach and brings varied perspectives to our projects, especially when implementing server-side technologies and database solutions.</p>
        
        <h4>Part 2 Learning Outcomes</h4>
        <p>Through Project Part 2, our team has gained valuable experience in PHP development, MySQL database integration, and server-side web programming. Each member has contributed to different aspects of the dynamic web application while maintaining our collaborative approach.</p>
        
        <h4>Favorite Resources</h4>
        <p><strong>Books:</strong> "Clean Code" by Robert Martin, "The Pragmatic Programmer" by Andy Hunt, "PHP: The Right Way" documentation</p>
        <p><strong>Music:</strong> Lo-fi hip hop, Classical, Rock, and Bollywood</p>
        <p><strong>Films:</strong> "The Social Network", "Ex Machina", "Hidden Figures"</p>
    </section>
</main>

<?php
include 'footer.inc';
?>