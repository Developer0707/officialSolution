<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "problemsolver";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['problem-title']);
    $description = $conn->real_escape_string($_POST['problem-description']);
    $solution = $conn->real_escape_string($_POST['solution']);

    $sql = "INSERT INTO problems (title, description, solution) VALUES ('$title', '$description', '$solution')";

    if ($conn->query($sql) === TRUE) {
        echo "New problem added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch problems
$sql = "SELECT * FROM problems ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Problem Solver</title>
  <style>
    /* Include your CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }
    .navbar {
      background-color: #333;
      color: #fff;
      padding: 1em;
      text-align: center;
    }
    .navbar .logo {
      display: inline-block;
      margin-right: 20px;
    }
    .navbar .nav-links {
      list-style: none;
      margin: 0;
      padding: 0;
      display: inline-block;
    }
    .navbar .nav-links li {
      display: inline-block;
      margin-right: 20px;
    }
    .navbar .nav-links a {
      color: #fff;
      text-decoration: none;
    }
    .problem-section, .submit-problem-section {
      padding: 2em;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      margin: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .problem {
      background-color: #f7f7f7;
      padding: 20px;
      margin: 20px 0;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .problem h3 {
      margin-top: 0;
    }
    footer {
      background-color: #333;
      color: #fff;
      padding: 1em;
      text-align: center;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <img src="logo.png" alt="Problem Solver Logo">
    </div>
    <ul class="nav-links">
      <li><a href="#">Tasks</a></li>
      <li><a href="#">Reviews</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <section class="problem-section">
    <h2>Problems</h2>
    <div class="problem-container">
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo "<div class='problem'>";
              echo "<h3>" . $row['title'] . "</h3>";
              echo "<p>" . $row['description'] . "</p>";
              echo "<h4>Solution:</h4>";
              echo "<p>" . $row['solution'] . "</p>";
              echo "</div>";
          }
      } else {
          echo "<p>No problems submitted yet.</p>";
      }
      ?>
    </div>
  </section>

  <section class="submit-problem-section">
    <h2>Submit a Problem</h2>
    <form method="POST" action="">
      <label for="problem-title">Problem Title:</label>
      <input type="text" id="problem-title" name="problem-title" required><br><br>
      <label for="problem-description">Problem Description:</label>
      <textarea id="problem-description" name="problem-description" required></textarea><br><br>
      <label for="solution">Solution:</label>
      <textarea id="solution" name="solution" required></textarea><br><br>
      <button type="submit">Submit</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2023 Problem Solver</p>
    <p>Contact: <a href="mailto:help@problemsolver.com">help@problemsolver.com</a></p>
  </footer>
</body>
</html>

<?php
$conn->close();
?>
