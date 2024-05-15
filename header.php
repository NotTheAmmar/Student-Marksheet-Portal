<?php
function importHeader($title)
{
  echo <<<header
  <head>
    <link rel="stylesheet" href="Bootstrap 5.3.3/css/bootstrap.min.css">
    <script src="Bootstrap 5.3.3/js/bootstrap.bundle.min.js"></script>
    <title>$title</title>
  </head>
  header;
}

