<?php
if (isset($_POST['logout'])) {
  session_destroy();
  session_unset();

  header('Location: index.php');
  exit;
}

include_once 'database.php';

include_once 'header.php';
importHeader("Faculty Page");

session_start();
if (isset($_SESSION['faculty'])) {
  $faculty = $_SESSION['faculty'];
} else {
  $faculty = $db->getFacultyId($_GET['faculty']);
  $_SESSION['faculty'] = $faculty;
}
?>

<nav class="navbar nav-pills fixed-top bg-primary-subtle" data-bs-theme="dark">
  <ul class="nav container">
    <li class="nav-item">
      <a class="navbar-brand active" href="#home" data-bs-toggle="tab">
        Welcome <?php echo $db->getFacultyName($faculty) ?>
      </a>
    </li>
    <div class="d-flex">
      <li class="nav-item">
        <a class="nav-link" href="#sem1" data-bs-toggle="tab">Sem 1</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sem2" data-bs-toggle="tab">Sem 2</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sem3" data-bs-toggle="tab">Sem 3</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sem4" data-bs-toggle="tab">Sem 4</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sem5" data-bs-toggle="tab">Sem 5</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#sem6" data-bs-toggle="tab">Sem 6</a>
      </li>
    </div>
  </ul>
</nav>

<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="tab-content">
    <!-- Home Tab -->
    <div class="tab-pane active" id="home">
      <?php
      $courses = $db->getCoursesCount($faculty);
      $students = $db->getFacultyStudentCount($faculty);

      echo <<<INFO
      <h1 class="display-1">Analytics</h1>
      <br>
      <div style="text-align: center;">
        <h2>Total Courses: $courses</h2>
        <h2>Total Students: $students</h2>
        <br>
        <br>
        <form method="post">
          <input class="btn btn-danger" type="submit" name="logout" value="Log Out">
        </form>
      </div>
      INFO;
      ?>
    </div>

    <!-- Sem Tabs -->
    <?php
    for ($i = 1; $i <= 6; $i++) {
      echo <<<TAB
      <div class="tab-pane text-center" id="sem$i" style="width: 500px">
        <h1>Semester $i</h1>
        <br>
      TAB;

      $courses = $db->getFacultySemCourses($faculty, $i);
      if (count($courses) == 0) {
        echo "<h3>You Don't Teach any Subjects Yet for this Semester</h3>";
      } else {
        echo '<div class="row">';
        
        $courses = array_map(function ($element) {
          return $element['course'];
        }, $courses);
        foreach ($courses as $course) {
          echo <<<COL
          <div class="col-4">
            <div class="card" style="width="100px" height="100px">
            <div class="card-body text-center">
                <form method="POST" action="marks_entry.php" style="margin: 0;">
                  <input type="submit" name="course" value="{$db->getCourseName($course)}" style="background: none; border: none;">
                </form>
              </div>
            </div>
          </div>
          COL;
        }
        echo "</div>";
      }
      echo "</div>";
    }
    ?>
  </div>
</div>