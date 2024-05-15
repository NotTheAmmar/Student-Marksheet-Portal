<?php
if (isset($_POST['role'])) {
  switch ($_POST['role']) {
    case 'admin':
      if ($_POST['password'] == 'admin') {
        header('Location: http://localhost/PHP/Student Marksheet Portal/admin_portal.php');
        exit;
      } else {
        echo <<<SCRIPT
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            let modal = new bootstrap.Modal(document.querySelector("#adminLoginFailed"));
            modal.show();
          });
        </script>
        SCRIPT;
      }
      break;
    case 'faculty':
      include_once 'database.php';

      if ($db->canFacultyLogin($_POST['name'], $_POST['password'])) {
        header("Location: http://localhost/PHP/Student Marksheet Portal/faculty_page.php?faculty={$_POST['name']}");
        exit;
      } else {
        echo <<<SCRIPT
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            let modal = new bootstrap.Modal(document.querySelector("#facultyLoginFailed"));
            modal.show();
          });
        </script>
        SCRIPT;
      }
      break;
    case 'student':
      include_once 'database.php';

      if ($db->canStudentLogin($_POST['enrollment'])) {
        header("Location: http://localhost/PHP/Student Marksheet Portal/student_page.php?student={$_POST['enrollment']}");
        exit;
      } else {
        echo <<<SCRIPT
        <script>
          document.addEventListener("DOMContentLoaded", function() {
            let modal = new bootstrap.Modal(document.querySelector("#studentLoginFailed"));
            modal.show();
          });
        </script>
        SCRIPT;
      }
  }
}
?>

<div class="vh-100 d-flex align-items-center justify-content-center">
  <div style="text-align: center; flex-direction: column;">
    <h1 class="display-3">Student Marksheet Portal</h1>
    <br>
    <h1>Login</h1>
    <br>
    <div class="d-flex justify-content-center">
      <form method="post" style="width: 50%;">
        <select class="form-select" name="role" required>
          <option selected disabled>Role</option>
          <option value="admin">Admin</option>
          <option value="faculty">Faculty</option>
          <option value="student">Student</option>
        </select>
        <br>
        <div class="input-group" style="display: none;" id="enroll">
          <span class="input-group-text">Enrollment No</span>
          <input class="form-control" type="number" placeholder="Enrollment No" name="enrollment">
        </div>
        <div class="input-group" style="display: none;" id="name">
          <span class="input-group-text">Name</span>
          <input class="form-control" type="text" placeholder="Name" name="name">
        </div>
        <div id="facultyLineBreak" style="display: none;">
          <br>
        </div>
        <div class="input-group" style="display: none;" id="password">
          <span class="input-group-text">Password</span>
          <input class="form-control" type="password" placeholder="Password" name="password">
        </div>
        <br>
        <input class="from-control btn btn-primary" type="submit" value="Submit">
      </form>
    </div>
  </div>
</div>

<!-- Modals -->
<div class="modal" id="adminLoginFailed">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6 text-danger">Login Failed</span>
      </div>
      <div class="modal-body">
        <p>Password is Incorrect, Please Try Again!</p>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="facultyLoginFailed">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6 text-danger">Login Failed</span>
      </div>
      <div class="modal-body">
        <p>Name or Password is Incorrect, Please Try Again!</p>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="studentLoginFailed">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <span class="display-6 text-danger">Login Failed</span>
      </div>
      <div class="modal-body">
        <p>Enrollment Number is Incorrect, Please Try Again!</p>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelector('select[name="role"]').addEventListener('change', function () {
    var role = this.value;

    if (role === 'admin') {
      document.querySelector('#enroll').style.display = 'none';
      document.querySelector('#name').style.display = 'none';
      document.querySelector('#password').style.display = 'flex';
      document.querySelector('#facultyLineBreak').style.display = 'none';

      document.querySelector('input[name="enrollment"]').required = false;
      document.querySelector('input[name="name"]').required = false;
      document.querySelector('input[name="password"]').required = true;
    } else if (role === 'faculty') {
      document.querySelector('#enroll').style.display = 'none';
      document.querySelector('#name').style.display = 'flex';
      document.querySelector('#password').style.display = 'flex';
      document.querySelector('#facultyLineBreak').style.display = 'block';

      document.querySelector('input[name="enrollment"]').required = false;
      document.querySelector('input[name="name"]').required = true;
      document.querySelector('input[name="password"]').required = true;
    } else if (role === 'student') {
      document.querySelector('#enroll').style.display = 'flex';
      document.querySelector('#name').style.display = 'none';
      document.querySelector('#password').style.display = 'none';
      document.querySelector('#facultyLineBreak').style.display = 'none';

      document.querySelector('input[name="enrollment"]').required = true;
      document.querySelector('input[name="name"]').required = false;
      document.querySelector('input[name="password"]').required = false;
    }

    document.querySelector('input[name="enrollment"]').value = "";
    document.querySelector('input[name="name"]').value = "";
    document.querySelector('input[name="password"]').value = "";
  });
</script>