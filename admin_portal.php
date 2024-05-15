<?php
if (isset($_POST['logout'])) {
  header('Location: index.php');
  exit;
}

include_once 'database.php';

if (isset($_POST['addFaculty'])) {
  $db->addFaculty($_POST['facultyName'], $_POST['facultyPassword']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
} else if (isset($_POST['removeFaculty'])) {
  $db->removeFaculty($_POST['facultyID']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
}

if (isset($_POST['addStudent'])) {
  $db->addStudent($_POST['studentEnrollmentNumber'], $_POST['studentName'], $_POST['studentSem']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
} else if (isset($_POST['removeStudent'])) {
  $db->removeStudent($_POST['studentEnrollmentNumber']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
}


if (isset($_POST['addCourse'])) {
  $db->addCourse($_POST['courseCode'], $_POST['courseName'], $_POST['courseSem']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
} else if (isset($_POST['removeCourse'])) {
  $db->removeCourse($_POST['courseCode']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
}

if (isset($_POST['addFacultyCourse'])) {
  $db->addFacultyCourse($_POST['faculty'], $_POST['course']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
} else if (isset($_POST['removeFacultyCourse'])) {
  $db->removeFacultyCourse($_POST['facultyCourseID']);
  header("Location: {$_SERVER['PHP_SELF']}");
  exit;
}

include_once 'header.php';
importHeader("Admin Portal");
?>

<nav class="navbar nav-pills sticky-top bg-primary-subtle" data-bs-theme="dark">
  <ul class="nav container">
    <li class="nav-item">
      <a class="navbar-brand active" href="#home" data-bs-toggle="tab">Welcome Admin</a>
    </li>
    <div class="d-flex">
      <li class="nav-item">
        <a class="nav-link" href="#faculty" data-bs-toggle="tab">Faculty</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#student" data-bs-toggle="tab">Student</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#course" data-bs-toggle="tab">Course</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#facultyCourses" data-bs-toggle="tab">Faculty Courses</a>
      </li>
    </div>
  </ul>
</nav>

<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="tab-content" style="max-height: 95%;">
    <!-- Home Tab -->
    <div class="tab-pane active" id="home">
      <?php
      $faculties = $db->getFacultyCount();
      $students = $db->getStudentCount();
      $courses = $db->getCourseCount();

      echo <<<INFO
      <h1 class="display-1">Analytics</h1>
      <br>
      <div style="text-align: center;">
        <h2>Total Faculties: $faculties</h2>
        <h2>Total Students: $students</h2>
        <h2>Total Courses: $courses</h2>
        <br>
        <br>
        <form method="post">
          <input class="btn btn-danger" type="submit" name="logout" value="Log Out">
        </form>
      </div>
      INFO;
      ?>
    </div>

    <!-- Faculty Tab -->
    <div class="tab-pane" id="faculty">
      <?php
      $faculties = $db->getFaculties();

      if (count($faculties) == 0) {
        echo <<<INFO
        <div style="text-align: center;">
          <h1>Wow So Empty!</h1>
          <br>
          <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addFaculty">Add</button>
        </div>
        INFO;
      } else {
        echo <<<TABLE
        <table class="table">
          <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>
              <a style="color: green;" data-bs-toggle="modal" data-bs-target="#addFaculty">+ Faculty</a>
            </th>
          </tr>
        TABLE;
        foreach ($faculties as $faculty) {
          echo <<<row
          <tr>
            <td>{$faculty['id']}</td>
            <td>{$faculty['name']}</td>
            <td class="text-center">
              <form method="post">
                <input type="hidden" name="facultyID" value="{$faculty['id']}">
                <input class="btn btn-danger p-0" style="width: 28px; height: 28px;" type="submit" name="removeFaculty" value="-">
              </form>
            </td>
          </tr>
          row;
        }
        echo '</table>';
      }
      ?>
    </div>

    <!-- Students Tab -->
    <div class="tab-pane" id="student">
      <?php
      $students = $db->getStudents();

      if (count($students) == 0) {
        echo <<<INFO
        <div style="text-align: center;">
          <h1>Wow So Empty!</h1>
          <br>
          <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addStudent">Add</button>
        </div>
        INFO;
      } else {
        echo <<<TABLE
        <table class="table">
          <tr class="text-center">
            <th>Enrollment Number</th>
            <th>Name</th>
            <th>Sem</th>
            <th>
              <a style="color: green;" data-bs-toggle="modal" data-bs-target="#addStudent">+ Student</a>
            </th>
          </tr>
        TABLE;
        foreach ($students as $student) {
          echo <<<row
          <tr>
            <td>{$student['enrollment_number']}</td>
            <td>{$student['name']}</td>
            <td>{$student['sem']}</td>
            <td class="text-center">
              <form method="post">
                <input type="hidden" name="studentEnrollmentNumber" value="{$student['enrollment_number']}">
                <input class="btn btn-danger p-0" style="width: 28px; height: 28px;" type="submit" name="removeStudent" value="-">
              </form>
            </td>
          </tr>
          row;
        }
        echo '</table>';
      }
      ?>
    </div>

    <!-- Courses Tab -->
    <div class="tab-pane" id="course">
      <?php
      $courses = $db->getCourses();

      if (count($courses) == 0) {
        echo <<<INFO
        <div style="text-align: center;">
          <h1>Wow So Empty!</h1>
          <br>
          <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCourse">Add</button>
        </div>
        INFO;
      } else {
        echo <<<TABLE
        <table class="table">
          <tr class="text-center">
            <th>Code</th>
            <th>Name</th>
            <th>Sem</th>
            <th>
              <a style="color: green;" data-bs-toggle="modal" data-bs-target="#addCourse">+ Course</a>
            </th>
          </tr>
        TABLE;
        foreach ($courses as $course) {
          echo <<<row
          <tr>
            <td>{$course['code']}</td>
            <td>{$course['name']}</td>
            <td>{$course['sem']}</td>
            <td class="text-center">
              <form method="post">
                <input type="hidden" name="courseCode" value="{$course['code']}">
                <input class="btn btn-danger p-0" style="width: 28px; height: 28px;" type="submit" name="removeCourse" value="-">
              </form>
            </td>
          </tr>
          row;
        }
        echo '</table>';
      }
      ?>
    </div>

    <!-- Faculty Courses Tab -->
    <div class="tab-pane" id="facultyCourses">
      <?php
      $facultyCourses = $db->getFacultyCourses();

      if (count($facultyCourses) == 0) {
        echo <<<INFO
        <div style="text-align: center;">
          <h1>Wow So Empty!</h1>
          <br>
          <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addFacultyCourse">Add</button>
        </div>
        INFO;
      } else {
        echo <<<TABLE
        <table class="table">
          <tr class="text-center">
            <th>ID</th>
            <th>Faculty</th>
            <th>Course</th>
            <th>
              <a style="color: green;" data-bs-toggle="modal" data-bs-target="#addFacultyCourse">Assign Course To Faculty</a>
            </th>
          </tr>
        TABLE;
        foreach ($facultyCourses as $studentID) {
          $faculty = $db->getFacultyName($studentID['faculty']);
          $course = $db->getCourseName($studentID['course']);

          echo <<<row
          <tr>
            <td>{$studentID['id']}</td>
            <td>$faculty</td>
            <td>$course</td>
            <td class="text-center">
              <form method="post">
                <input type="hidden" name="facultyCourseID" value="{$studentID['id']}">
                <input class="btn btn-danger p-0" style="width: 28px; height: 28px;" type="submit" name="removeFacultyCourse" value="-">
              </form>
            </td>
          </tr>
          row;
        }
        echo '</table>';
      }
      ?>
    </div>
  </div>
</div>

<!-- Faculty Modals -->
<div class="modal" id="addFaculty">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6">Add Faculty</span>
      </div>
      <div class="modal-body">
        <form method="post">
          <input class="form-control" type="text" name="facultyName" placeholder="Name" required>
          <br>
          <input class="form-control" type="password" name="facultyPassword" placeholder="Password" required>
          <br>
          <input class="btn btn-primary" type="submit" name="addFaculty" value="Add">
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<!-- Student Modals -->
<div class="modal" id="addStudent">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6">Add Student</span>
      </div>
      <div class="modal-body">
        <form method="post">
          <input class="form-control" type="number" name="studentEnrollmentNumber" placeholder="Enrollment Number"
            required>
          <br>
          <input class="form-control" type="text" name="studentName" placeholder="Name" required>
          <br>
          <input class="form-control" type="number" name="studentSem" placeholder="Sem" required>
          <br>
          <input class="btn btn-primary" type="submit" name="addStudent" value="Add">
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<!-- Courses Modals -->
<div class="modal" id="addCourse">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6">Add Course</span>
      </div>
      <div class="modal-body">
        <form method="post">
          <input class="form-control" type="number" name="courseCode" placeholder="Code" required>
          <br>
          <input class="form-control" type="text" name="courseName" placeholder="Name" required>
          <br>
          <input class="form-control" type="number" name="courseSem" placeholder="Sem" required>
          <br>
          <input class="btn btn-primary" type="submit" name="addCourse" value="Add">
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<!-- Faculty Courses Modals -->
<div class="modal" id="addFacultyCourse">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6">Add Faculty Course</span>
      </div>
      <div class="modal-body">
        <form method="post">
          <table class="w-100">
            <tr>
              <td>Faculty: </td>
              <td>
                <select class="form-select" name="faculty" required>
                  <?php
                  $faculties = $db->getFaculties();

                  usort($faculties, function ($a, $b) {
                    return strcasecmp($a["name"], $b['name']);
                  });

                  foreach ($faculties as $faculty) {
                    echo "<option value=\"{$faculty['id']}\">{$faculty['name']}</option>";
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>Course: </td>
              <td>
                <select class="form-select" name="course" required>
                  <?php
                  $courses = $db->getCoursesName();

                  foreach ($courses as $course) {
                    echo "<option value=\"{$course['code']}\">{$course['name']}</option>";
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr class="text-center">
              <td rowspan="2" colspan="2">
                <br>
                <input class="btn btn-primary" type="submit" name="addFacultyCourse" value="Add">
              </td>
            </tr>
          </table>
        </form>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>