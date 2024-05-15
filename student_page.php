<?php
if (isset($_POST['logout'])) {
  header('Location: index.php');
  exit;
}

include_once 'header.php';
importHeader('Student Page');

include_once 'database.php';

function getGrade($marks)
{
  if ($marks >= 85) {
    return "AA";
  } else if ($marks >= 75) {
    return "AB";
  } else if ($marks >= 65) {
    return "BB";
  } else if ($marks >= 55) {
    return "BC";
  } else if ($marks >= 45) {
    return "CC";
  } else if ($marks >= 40) {
    return "CD";
  } else if ($marks >= 35) {
    return "DD";
  } else {
    return "FF";
  }
}

echo <<<DOC
<nav class="navbar sticky-top bg-primary-subtle" data-bs-theme="dark">
  <div class="container">
    <span class="navbar-brand">Welcome {$db->getStudentName($_GET['student'])}</span>
  </div>
</nav>

<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="text-center">
    <p class="display-3">Your Result</p>
    <br>
DOC;

$result = $db->getStudentResult($_GET['student']);

echo <<<HEAD
<table class="table">
  <tr>
    <th>Course</th>
    <th>Marks</th>
    <th>Grade</th>
  </tr>
HEAD;

foreach ($result as $row) {
  if (isset($row['marks'])) {
    $marks = $row['marks'];
    $grade = getGrade($row['marks']);
  } else {
    $marks = "Not Given";
    $grade = "Not Given";
  }

  echo <<<ROW
  <tr>
    <td>{$db->getCourseName($row['course'])}</td>
    <td>$marks</td>
    <td>$grade</td>
  </tr>
  ROW;
}
echo <<<FOOT
    </table>
    <br>
    <form method="POST">
      <input type="submit" name="logout" value="Log Out" class="btn btn-danger">
    </form>
  </div>
</div>
FOOT;