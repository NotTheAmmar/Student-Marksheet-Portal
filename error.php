<?php
function showError($message) {
  include_once "header.php";
  importHeader("ERROR");

  echo <<<error
  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card">
      <div class="card-body">
        <p class="h1 text-danger">An Error Occurred</p>
        <br>
        <p class="h3 text-info">Cause: $message</p>
        <br>
        <a href="index.php" class="btn btn-secondary">Go Back</a>
      </div>
    </div>
  </div>
  error;
  exit;
}
