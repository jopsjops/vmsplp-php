<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>Reference</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <style>
        body, * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .topbar {
            position: fixed;
            background: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08);
            width: 100%;
            height: 60px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 10fr 0.4fr 1fr;
            align-items: center;
            z-index: 1;
        }

        .topbar .logo h2 {
            color: #059212;
        }

        .sidebar {
            position: fixed;
            top: 60px;
            width: 200px;
            height: calc(100% - 60px);
            background: #fff;
            overflow-x: hidden;
            overflow-y: auto;
            white-space: nowrap;
            z-index: 1;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar list */
        .sidebar ul {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar list items */
        .sidebar ul li {
            width: 100%;
            list-style: none;
            margin: 5px;
            position: relative;
        }

        /* Sidebar icons */
        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        /* Sidebar links */
        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #333; /* Always dark font */
            height: 60px;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            border-radius: 10px 0 0 10px;
            padding-left: 10px;
        }

        .sidebar ul li a::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
            opacity: 0;
            transform: scaleY(0);
            transition: all 0.3s ease;
        }

                /* Hover effect */
        .sidebar ul li a:hover::before {
            opacity: 1;
            transform: scaleY(1);
        }

        /* ✅ Active tab: Only shows a green side bar */
        .sidebar ul li.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        .profile-logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%; /* Makes the logo circular */
            object-fit: cover;
        }

        .profile-info span {
            font-size: 12px;
            color: #777;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }


        .logout {
            position: absolute;  /* Use absolute to anchor within the sidebar */
            bottom: 25px;         /* Same visual offset as translateY(70px) */
            width: 100%;          /* Optional: full width of sidebar */
            text-align: center;
            padding: 10px;
        }

        .logout a {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .logout i {
            margin-right: 8px;
        }


        .main {
            margin-left: 200px;
            padding: 100px 40px 40px;
            background-color: #f4f4f4;
            min-height: 100vh;
        }

        .main h1 {
            color: #059212;
            margin-bottom: 30px;
        }

        .history-section {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }

        .history-section h2 {
            color: #059212;
            margin-top: 0;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .history-section p {
            line-height: 1.8;
            color: #333;
            text-align: justify;
            margin-bottom: 15px;
        }

        .vision-mission-container {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .vision-box, .mission-box {
            flex: 1;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            min-width: 300px;
        }

        .vision-box h2, .mission-box h2 {
            margin-top: 0;
            text-align: center;
            color: #059212;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .vision-box p, .mission-box p {
            margin: 0;
            color: #444;
            text-align: justify;
            line-height: 1.8;
            font-size: 15px;
        }

        .accordion {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .accordion-header {
            padding: 18px 24px;
            background-color: #f9f9f9;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .accordion-content {
            display: none;
            padding: 25px 30px;
            background: #fff;
            color: #333;
            line-height: 1.75;
        }

        .accordion-content h3,
        .accordion-content h4 {
            color: #059212;
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .accordion-content p,
        .accordion-content ul li {
            font-size: 15px;
            margin-bottom: 10px;
        }

        .accordion-content ul {
            padding-left: 20px;
            margin-bottom: 20px;
            list-style: disc;
        }

        .accordion.active .accordion-content {
            display: block;
        }

        .accordion-header i {
            transition: transform 0.2s ease;
        }

        .accordion.active .accordion-header i {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 20px;
            }

            .vision-mission-container {
                flex-direction: column;
            }
        }

        .violations-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .violation-box {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            min-width: 280px;
        }
        .violation-box h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .violation-box ul {
            padding-left: 20px;
        }

        .accordion-content h3,
        .accordion-content h4 {
            color: #059212;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .accordion-content p {
            margin-bottom: 15px;
            line-height: 1.7;
            text-align: justify;
        }

        .accordion-content ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .accordion-content ul li {
            margin-bottom: 6px;
        }

        .accordion-content .section-break {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .vision-box p, .mission-box p {
            margin-top: 0;
            text-align: center;
            line-height: 1.6;
            margin:10px; 
            color:rgb(0, 0, 0);
        }
        .accordion {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .accordion-header {
            padding: 18px 20px;
            background-color: #f1f1f1;
            cursor: pointer;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-content h3,
        .accordion-content h4 {
            color: #059212;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .accordion-content p {
            margin-bottom: 15px;
            line-height: 1.7;
            text-align: justify;
        }

        .accordion-content {
            display: none;
            padding: 20px;
            background: #fff;
            color: #333;
            line-height: 1.6;
        }

        .accordion-content ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .accordion-content ul li {
            margin-bottom: 6px;
        }

        .accordion-content .section-break {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .accordion.active .accordion-content {
            display: block;
        }

        .accordion-header i {
            transition: transform 0.2s ease;
        }

        .accordion.active .accordion-header i {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 20px;
            }

            .vision-mission-container {
                flex-direction: column;
            }
        }

        .violations-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .violation-box {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            min-width: 280px;
        }
        .violation-box h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .violation-box ul {
            padding-left: 20px;
        }
        .history-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="topbar">
        <div class="logo">
            <h2>VMS.</h2>
        </div>
    </div>

    <div class="sidebar">
        <div class="profile">
            <div class="profile-logo">
                <img src="img/plp.png" alt="Logo">
            </div>
            <div class="profile-info">
                <span>Welcome,</span>
                <h4>Admin</h4>
            </div>
        </div>
       <ul>
            <li>
                <a href="dashboarddb.php">
                    <i class='bx bxs-dashboard'></i>
                    <div>Dashboard</div>
                </a>
            </li>
            <li>
                <a href="students_page.php">
                    <i class='bx bxs-group'></i>
                    <div>Students</div>
                </a>
            </li>
            <li>
                <a href="prediction.php">
                    <i class='fas fa-chart-line'></i>
                    <div>Data Analysis</div>
                </a>
            </li>
            <li class="archive">
                <a href="archive.php">
                    <i class='bx bxs-archive'></i>
                    <div>Archive</div>
                </a>
            </li>
            <li class="tables">
                <a href="view_semviolation.php">
                    <i class='bx bx-table'></i>
                    <div>View Tables</div>
                </a>
            </li>
            <li class="active">
                <a href="reference_page.php">
                    <i class='bx bx-book-open'></i>
                    <div>Reference</div>
                </a>
            </li>
            <li>
                <a href="audit_trail.php">
                    <i class='bx bx-history'></i>
                    <div>Audit Trail</div>
                </a>
            </li>
        </ul>
        <div class="logout">
            <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
                <i class='bx bx-log-out'></i>Logout
            </a>
        </div>
    </div>    
    <div class="main">
            <h1><i class="fas fa-book-open"></i> STUDENT HANDBOOK REFERENCE</h1>
            <div class="history-section" >
                <h2>HISTORY OF PLP</h2>
                <p>
                    The Pamantasan ng Lungsod ng Pasig (PLP) was established on March 15, 1999, through the approval of City Ordinance No. 11, Series of 1999,
                    signed by then Mayor Vicente P. Eusebio. The founding of PLP was driven by a vision to provide accessible and affordable quality education to
                    the citizens of Pasig City.
                </p>
                <p>
                    Classes officially began on June 14, 2000, with an initial offering of six degree programs. Over the years, PLP has grown in student population,
                    faculty strength, and academic offerings. It now provides a wide range of courses in various disciplines such as engineering, business, education,
                    health sciences, and the liberal arts.
                </p>
                <p>
                    The university continues to uphold its commitment to educational excellence, service, and nation-building, producing graduates who are globally
                    competitive and socially responsible.
                </p>
            </div>

        <div class="vision-mission-container">
            <div class="vision-box">
                <h2>VISION</h2>
                <p>PLP is the leading center for academic excellence among the locally funded colleges and universities that produces responsible and productive individuals who are responsive to the changing demands of development locally and globally.
</p>
            </div>
            <div class="mission-box">
                <h2>MISSION</h2>
                <p>We, a community of service oriented individuals supported by the city government of Pasig, committed to lifelong learning and to produce graduates strong in their global outlook, cultural identity, and social responsibility through teaching strategies, methodologies, relevant research and dedicated public service.
</p>
            </div>
        </div>

        <div class="accordion">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                VIOLATIONS AND SANCTIONS
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="accordion-content">
                <div class="violations-container">
                                        <div class="violation-box">
                        <h3>MINOR VIOLATIONS</h3>
                        <ul>
                            <li>Violating the dress protocol</li>
                            <li>Wearing incomplete uniform</li>
                            <li>Littering</li>
                            <li>Loitering
                                <ul>
                                    <li>Along corridor, hallway during school hours</li>
                                    <li>Standing on the chairs</li>
                                    <li>Sitting on the arm chairs</li>
                                    <li>Sitting on the tables</li>
                                </ul>
                            </li>
                            <li>Disturbing classes
                                <ul>
                                    <li>Shouting and howling</li>
                                    <li>Using cellular phones, etc.</li>
                                    <li>Eating inside the classrooms</li>
                                </ul>
                            </li>
                            <li>Public display of affection
                                <ul>
                                    <li>Lips to lips greetings</li>
                                    <li>Placing the hand around the shoulder or waist</li>
                                    <li>Reclining against the body of the other</li>
                                    <li>Sharing one chair</li>
                                    <li>Sitting on the lap</li>
                                    <li>Embracing</li>
                                    <li>Kissing</li>
                                    <li>Holding, touching or fondling delicate parts</li>
                                    <li>Suggestive, vulgar indecent poses</li>
                                </ul>
                            </li>
                            <li>Not wearing ID card inside the campus</li>
                            <li>Lending or using someone else’s ID</li>
                            <li>Wearing of caps or scarves inside the building</li>
                            <li>Violating the silence of designated areas</li>
                            <li>Discourtesy to any member of the school community and visitors</li>
                            <li>Making malicious cat calls or whistling</li>
                            <li>Refusal or non-presentation of ID when asked</li>
                            <li>Sitting on stairs or blocking passageways</li>
                            <li>Unauthorized charging of electronic devices</li>
                            <li>Violation of academic policies</li>
                        </ul>
                        <p><strong>Sanctions:</strong></p>
                        <ul>
                            <li><strong>First Offense:</strong> Non-compliance slip and apology letter</li>
                            <li><strong>Second Offense:</strong> 8 hours community service with counseling</li>
                            <li><strong>Third Offense:</strong> Considered a major offense</li>
                        </ul>
                    </div>
                    <div class="violation-box">
                        <h3>MAJOR VIOLATIONS</h3>
                        <ul>
                            <li>Cheating</li>
                            <li>Forgery & Plagiarism</li>
                            <li>False Representation</li>
                            <li>Theft, hazing, vandalism</li>
                            <li>False Representation</li>
                            <li>Defamation</li>
                            <li>Alcohol Influence</li>
                            <li>Unauthorized Entry</li>
                            <li>Theft</li>
                            <li>Drug Possession/Use</li>
                            <li>Insubordination</li>
                            <li>Physical Injury</li>
                            <li>Threats & Bullying</li>
                            <li>Gambling</li>
                            <li>Hazing</li>
                            <li>Unauthorized Name Use</li>
                            <li>Financial Misconduct</li>
                            <li>Unauthorized Sales</li>
                            <li>Extortion</li>
                            <li>Vandalism</li>
                            <li>Degrading Treatment</li>
                            <li>Deadly Weapons</li>
                            <li>Abusive Behavior</li>


                        </ul>
                        <p><strong>Sanctions:</strong></p>
                        <ul>
                            <li><strong>First Offense:</strong> Suspension (not exceeding 20% of school days)</li>
                            <li><strong>Preventive Suspension:</strong> Up to 60 days during investigation</li>
                            <li><strong>Second Offense:</strong>
                                <ul>
                                    <li>Dismissal: Dropped from enrollment with credentials released</li>
                                    <li>Expulsion: Banned from enrolling in any public/private school</li>
                                </ul>
                            </li>
                        </ul>
                        <p><strong>Note:</strong> Students must make restitution for damaged property. Disciplinary records affect scholarship eligibility and awards.</p>
                    </div>
            </div>
        </div>
    </div>
    <div class="accordion">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        CODE OF CONDUCT AND DISCIPLINARY PROCEDURES
        <i class="fas fa-chevron-down"></i>
    </div>
    <div class="accordion-content">
        <h3>Section I. Basis of Imposing Discipline</h3>
        <p>Every student shall observe the laws of the land, the rules and regulations of the University, and the standards of good society. Disciplinary proceedings shall only be instituted against conduct deemed unbecoming and prohibited by law or university rules.</p>

        <h4>Office of the Prefect of Discipline</h4>
        <p>Maintains discipline and harmony within campus and off-campus activities, enforcing all policies related to student conduct. Handles both major and minor student cases.</p>

        <h4>Discipline Related Units</h4>
        <p>The Grievance Committee (BOR Resolution No. 4 s. 2012) hears major cases affecting student status or academic integrity.</p>

        <h4>Loco Parentis</h4>
        <p>University officials and faculty act in "loco parentis," holding special authority to discipline and refer student misconduct to the Student Affairs Office.</p>

        <h4>Community Responsibility</h4>
        <p>All community members are responsible for enforcing university discipline policies and apprehending violations as appropriate.</p>

        <div class="section-break"></div>

        <h3>Section II. Procedures in Filing a Complaint</h3>
        <ul>
            <li>Complaints must be filed within 3 school days of the incident.</li>
            <li>The Prefect of Discipline sends notice and requires a response within 3 school days.</li>
            <li>Three notices are given before proceeding without a response.</li>
            <li>Cases are evaluated and investigated by the Student Affairs Office for resolution or formal action.</li>
        </ul>

        <div class="section-break"></div>

        <h3>Section III. Conduct and Decorum</h3>

        <h4>Use of School Name</h4>
        <p>Requires written permission from the President or VP.</p>

        <h4>Student Identification Card</h4>
        <ul>
            <li>ID is required at all times.</li>
            <li>Only one replacement allowed (P200 fee).</li>
            <li>Tampering or lending ID is punishable.</li>
        </ul>

        <h4>Uniform and Attire</h4>
        <ul>
            <li>Official uniforms required on school days.</li>
            <li>Washday (Fri-Sat): College/PLP shirts allowed.</li>
            <li>Unauthorized OJT uniform must have letter of approval.</li>
        </ul>

        <h4>Footwear</h4>
        <ul>
            <li>Men: Black leather shoes with socks</li>
            <li>Women: Closed black leather shoes, max 2-inch heels</li>
        </ul>

        <h4>Strictly Prohibited Attire</h4>
        <ul>
            <li>Shorts, miniskirts, ripped jeans, spaghetti tops, slippers, etc.</li>
            <li>Leggings, pedal pushers, jogging pants (except for P.E.)</li>
        </ul>

        <h4>Norms and Decorum</h4>
        <ul>
            <li>Courtesy, respect, and silence in hallways</li>
            <li>Gadgets not allowed during class hours</li>
            <li>No headsets or earphones inside the campus</li>
            <li>CLAYGO policy in eating areas</li>
            <li>Posting notices must be approved and on designated boards only</li>
        </ul>

        <div class="section-break"></div>

        <h3>Section IV. Disciplinary Process</h3>
        <p>The Department of Student Affairs, upon verified reports of major offenses, initiates investigation via the Prefect of Discipline and may convene a fact-finding or grievance committee (BOR Resolution No. 4 s. 2012).</p>
    </div>
</div>
<div class="accordion">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        ANTI-BULLYING ACT OF 2013 (RA 10627)
        <i class="fas fa-chevron-down"></i>
    </div>
    <div class="accordion-content">
        <h3>Section 1. Short Title</h3>
        <p>This Act shall be known as the “Anti-Bullying Act of 2013”.</p>

        <h3>Section 2. Acts of Bullying</h3>
        <p>Bullying includes written, verbal, electronic, or physical acts that cause fear, emotional harm, or disrupt school operations. Examples:</p>
        <ul>
            <li>Unwanted physical contact (punching, pushing, etc.)</li>
            <li>Psychological or emotional damage</li>
            <li>Slander, name-calling, tormenting</li>
            <li>Cyber-bullying through technology</li>
        </ul>

        <h3>Section 3. Adoption of Policies</h3>
        <p>Schools must adopt and update anti-bullying policies that:</p>
        <ul>
            <li>Prohibit bullying on school grounds or through school-owned technology</li>
            <li>Define disciplinary actions and rehabilitation</li>
            <li>Outline reporting and investigation procedures</li>
            <li>Provide counseling and protection for involved parties</li>
            <li>Allow anonymous reporting (but no action based on anonymous report alone)</li>
            <li>Educate students and parents</li>
            <li>Maintain public record (with confidentiality)</li>
        </ul>

        <h3>Section 4. Mechanisms to Address Bullying</h3>
        <p>The school principal or designee must:</p>
        <ul>
            <li>Investigate reported acts</li>
            <li>Notify law enforcement if necessary</li>
            <li>Inform parents/guardians of all parties</li>
            <li>Coordinate with other schools if applicable</li>
        </ul>

        <h3>Section 5. Reporting Requirement</h3>
        <p>Schools must report policies to their division superintendent within 6 months and annually report bullying incidents. DepEd compiles national reports for Congress.</p>

        <h3>Section 6. Sanctions for Noncompliance</h3>
        <p>School administrators failing to comply may face administrative sanctions. Private schools may face suspension of permits.</p>

        <h3>Section 7–10</h3>
        <ul>
            <li><strong>Section 7:</strong> DepEd must issue implementing rules within 90 days.</li>
            <li><strong>Section 8:</strong> If parts are invalid, others remain in effect.</li>
            <li><strong>Section 9:</strong> Inconsistent laws are repealed/amended.</li>
            <li><strong>Section 10:</strong> Act takes effect 15 days after publication.</li>
        </ul>
    </div>
</div>
<script>
function toggleAccordion(header) {
    const accordion = header.parentElement;
    accordion.classList.toggle("active");
}
</script>
</body>
</html>
