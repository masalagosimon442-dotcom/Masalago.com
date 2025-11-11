<?php
// nav.php — Machibya Simon Masalago Portfolio (with DB integration)
include 'database.php';

// Detect selected page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Handle contact form submission<?php
// nav.php — Machibya Simon Masalago Portfolio (with DB integration)
include 'database.php';

// Detect selected page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Handle contact form submission
if (isset($_POST['submit_contact'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
    if ($conn->query($sql)) {
        $msg = "<p style='color:green;'>Thank you, your message has been sent successfully.</p>";
    } else {
        $msg = "<p style='color:red;'>Error: Unable to send your message.</p>";
    }
}

// Insert three sample projects if table is empty
$check = $conn->query("SELECT COUNT(*) AS total FROM portfolio");
$row = $check->fetch_assoc();
if ($row['total'] == 0) {
    $conn->query("INSERT INTO portfolio (project_name, description, image, created_at) VALUES
    ('Project One', 'Description for Project One.', '/my project/uploads/project1.jpg', NOW()),
    ('Project Two', 'Description for Project Two.', '/my project/uploads/project2.jpg', NOW()),
    ('Project Three', 'Description for Project Three.', '/my project/uploads/project3.jpg', NOW())");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Machibya Simon Masalago | Portfolio</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body { background-color: #f4f4f4; color: #333; display: flex; flex-direction: column; min-height: 100vh; }

    header {
      background: #222;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      z-index: 1000;
    }

    .name {
      font-size: 22px;
      font-weight: bold;
      border: 2px solid #FFD700; /* gold border */
      padding: 8px 15px;
      border-radius: 10px;
      background-color: #444;
    }

    .passport {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }

    nav {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      font-size: 18px;
      transition: background 0.3s;
    }

    nav a:hover { background: rgba(255,255,255,0.2); border-radius: 4px; }

    main {
      padding: 140px 20px 40px;
      flex: 1; /* allow footer to stick at bottom */
      text-align: center;
    }

    section {
      max-width: 1000px;
      margin: 0 auto;
      padding: 30px;
      background: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      border-radius: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px 12px;
      text-align: left;
    }

    th { background-color: #f0f0f0; }

    img.project-img {
      width: 100px;
      height: auto;
      border-radius: 4px;
    }

    form { display: flex; flex-direction: column; gap: 10px; margin-top: 15px; }
    input, textarea {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 100%;
    }

    button {
      background: #222;
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      border-radius: 4px;
      transition: background 0.3s;
    }

    button:hover { background: #555; }

    .email {
      text-align: center;
      margin: 20px 0 10px;
      font-size: 16px;
      color: #222;
    }

    footer {
      background-color: #222;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: auto;
    }
  </style>
</head>
<body>
  <header>
    <div class="name">Machibya, Simon Masalago</div>
    <nav>
      <a href="?page=home">Home</a>
      <a href="?page=about">About</a>
      <a href="?page=services">Services</a>
      <a href="?page=portfolio">Portfolio</a>
      <a href="?page=contact">Contact</a>
    </nav>
    <img src="/my project/uploads/passport.jpg" alt="Passport" class="passport">
  </header>

  <main>
    <section>
      <?php
      switch ($page) {
        case 'about':
          echo "<h1>About Me</h1>
                <p>Hello! I'm <strond>Machibya,Simon Masalago</strong>, a third year student at <strong>Sokoine University of Agriculture (SUA)</strong>, with a strong educational journey from <strong>Ilalo Primary School, Igusule Secondary School (O-Level), to Inyonga High School (A-Level)</strong>. Passionate about <strong>web development</strong> and <strong> data analyst</strong>, I build responsive, user friendly websites using <strong>PHP, MySQL, HTML, CSS,</strong> and <strong>JavaScript</strong>, and analyze data with <strong>Excel, SPSS, Power BI</strong>, and <strong>Python</strong>. Combining technical expertise, analytical thinking, and creativity, I deliver digital solutions that are visually appealing, functional, and data driven, empowering businesses and individuals to achieve their goals.</p>";
          break;

        case 'services':
          echo "<h1></h1>
                <ul style='list-style:none; padding:0;'>
                  <li>Web Design and Development</li>
                  <li>Database Integration</li>
                  <li> IT Consultancy</li>
                  <li> Apps Analysis </li>
                  <li> Apps Design</li>
                  <li> Data Analyst</li>
                </ul>";
          break;

        case 'portfolio':
          echo "<h1>My Portfolio</h1>";
          $query = "SELECT id, project_name, description, image, created_at FROM portfolio ORDER BY created_at DESC";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0) {
              echo "<table>
                      <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Created At</th>
                      </tr>";
              while ($row = $result->fetch_assoc()) {
                  $imgPath = htmlspecialchars($row['image']);
                  echo "<tr>
                          <td>" . htmlspecialchars($row['id']) . "</td>
                          <td>" . htmlspecialchars($row['project_name']) . "</td>
                          <td>" . htmlspecialchars($row['description']) . "</td>
                          <td><img src='$imgPath' alt='Project Image' class='project-img'></td>
                          <td>" . htmlspecialchars($row['created_at']) . "</td>
                        </tr>";
              }
              echo "</table>";
          } else {
              echo "<p>No portfolio projects found in the database.</p>";
          }
          break;

        case 'contact':
          echo "<h1>Contact Me</h1>";
          if (isset($msg)) echo $msg;
          echo '<form method="POST" action="?page=contact">
                  <input type="text" name="name" placeholder="Your Name" required>
                  <input type="email" name="email" placeholder="Your Email" required>
                  <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                  <button type="submit" name="submit_contact">Send Message</button>
                </form>';
          break;

        default:
          echo "<h1>Welcome to My website</h1>
                <p>Welcome! I'm <strong>Machibya, Simon Masalago</strong> a professional <strong>Web Developer</strong> and <strong>Data Analyst</strong> with expertise in PHP, MySQL, responsive web design, and data analysis. As a data analyst, I collect, organize, and interpret data to uncover actionable insights that help businesses,Banks,Hospitals,Education,Hotels,NGOs, and Water Services Provider make informed decisions. I combine this analytical expertise with web development to create websites and applications that are not only visually appealing but also optimized for performance and user experience. With a passion for turning ideas into digital solutions, I help individuals and businesses build a strong online presence. Explore my portfolio to see my projects undertaken and ongoing, and get in touch if you want a website and data driven solutions that truly stand out!</b>.</p>";
          $result = $conn->query("SELECT COUNT(*) AS total FROM portfolio");
          if ($result && $row = $result->fetch_assoc()) {

          }
          break;
      }
      ?>
    </section>
    <?php
// Social media links
$social_links = [
    "Instagram" => "https://www.instagram.com/yourusername",
    "YouTube" => "https://www.youtube.com/yourchannel",
    "TikTok" => "https://www.tiktok.com/@yourusername",
    "LinkedIn" => "https://www.linkedin.com/in/yourusername",
    "Facebook" => "https://www.facebook.com/yourusername",
    "X" => "https://x.com/yourusername"
];

// Social media colors for each platform
$social_colors = [
    "Instagram" => "#E1306C",
    "YouTube" => "#FF0000",
    "TikTok" => "#000000",
    "LinkedIn" => "#0077B5",
    "Facebook" => "#1877F2",
    "X" => "#1DA1F2"
];
?>
<div class="social-media" style="text-align:center; margin:20px 0;">
    <h3>Connect with Me</h3>
    <?php
    foreach ($social_links as $platform => $link) {
        $color = $social_colors[$platform];
        echo "<a href='$link' target='_blank' style='margin:0 10px; text-decoration:none; color:$color; font-weight:bold;'>$platform</a>";
   }
    ?>
</div>
    <div class="email">Email: <a href="mailto:masalagosimon442@gmail.com">masalagosimon442@gmail.com</a></div>
    <div class="phone">Phone: <a href="mailto:+255694911391/ +255769141091"></a>+255694911391/+255769141091</div>
  </main>

  <footer>
    &copy; <?php echo date('Y'); ?> Machibya, Simon Masalago. All Rights Reserved.
  </footer>
</body>
</html>
