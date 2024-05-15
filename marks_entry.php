<?php
include_once 'database.php';

include_once 'header.php';
importHeader("Marks Entry");

session_start();
if (isset($_POST['logout'])) {
  unset($_SESSION['course']);

  header('Location: faculty_page.php');
  exit;
}

if (isset($_POST['course'])) {
  $_SESSION['course'] = $db->getCourseID($_POST['course']);
}

$course = $_SESSION['course'];

if (isset($_POST['operation'])) {
  if ($_POST['marked']) {
    $db->setStudentMarks($_POST['student'], $course, $_POST['marks']);
  } else {
    $db->markStudent($_POST['student'], $course, $_POST['marks']);
  }
}

$students = array_map(function ($element) {
  return $element['enrollment_number'];
}, $db->getCourseStudents($course));

echo <<<HEAD
<nav class="navbar sticky-top bg-primary-subtle" data-bs-theme="dark">
  <div class="container">
    <span class="navbar-brand">{$db->getCourseName($course)} Marks Entry</span>
  </div>
</nav>

<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="text-center">
    <form method="post">
      <input type="submit" name="logout" value="Back To Dashboard" class="btn btn-danger">
    </form>
    <br>
    <table class="table">
      <tr>
        <th>Enrollment Number</th>
        <th>Name</th>
        <th colspan="2">Marks</th>
      </tr>
HEAD;

foreach ($students as $studentID) {
  $student = $db->getStudentName($studentID);

  $marksGiven = $db->isStudentGivenMarks($studentID, $course);
  if ($marksGiven) {
    $marks = $db->getStudentMarks($studentID, $course);
  } else {
    $marks = "Not Given";
  }

  $operation = $marksGiven ? "Edit" : "Mark";
  echo <<<ROW
    <tr>
      <td>$studentID</td>
      <td>$student</td>
      <td>$marks</td>
      <td><button class="btn btn-secondary p-1 m-1" data-bs-toggle="modal" data-bs-target="#editMarks$studentID">$operation</button></td>
    </tr>
    ROW;

  if (gettype($marks) == 'string') {
    $marks = 0;
  }

  echo <<<MODAL
  <div class="modal" id="editMarks$studentID">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-header">
          <span class="display-6">Mark $student</span>
        </div>
        <div class="modal-body">
          <form method="post">
            <input type="hidden" name="marked" value="$marksGiven">
            <input type="hidden" name="student" value="$studentID">
            <input class="form-control" type="number" name="marks" placeholder="Marks" value="$marks" required>
            <br>
            <input class="btn btn-primary" type="submit" name="operation" value="Mark">
          </form>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
        </div>
      </div>
    </div>
  </div>
  MODAL;
}

echo <<<FOOT
    </table>
  </div>
</div>
FOOT;