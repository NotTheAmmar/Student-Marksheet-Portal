<?php
include_once 'error.php';

const DB_NAME = 'marksheet';

class DB
{
  private $connection;

  public function __construct()
  {
    $this->connection = new mysqli('localhost', 'root');

    if ($this->connection->connect_error) {
      showError($this->connection->connect_error);
    }

    // $this->connection->execute_query('DROP DATABASE ' . DB_NAME);
    if (!$this->connection->execute_query('CREATE DATABASE IF NOT EXISTS ' . DB_NAME)) {
      showError($this->connection->error);
    }

    if (!$this->connection->select_db(DB_NAME)) {
      showError($this->connection->error);
    }

    $this->createTables();
  }

  private function createTables()
  {
    try {
      $this->connection->execute_query(<<<'sql'
      CREATE TABLE IF NOT EXISTS faculties (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        name TEXT NOT NULL,
        password TEXT NOT NULL,
        UNIQUE (name(200)) 
      )
      sql);

      $this->connection->execute_query(<<<'sql'
      CREATE TABLE IF NOT EXISTS students (
        enrollment_number INTEGER(10) PRIMARY KEY,
        name TEXT NOT NULL,
        sem INTEGER CHECK (sem > 0 and sem < 7),
        UNIQUE (name(200))
      )
      sql);

      $this->connection->execute_query(<<<'sql'
      CREATE TABLE IF NOT EXISTS courses (
        code INTEGER PRIMARY KEY,
        name TEXT NOT NULL,
        sem INTEGER CHECK (sem > 0 and sem < 7),
        UNIQUE (name(200))
      )
      sql);

      $this->connection->execute_query(<<<'sql'
      CREATE TABLE IF NOT EXISTS faculty_courses (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        faculty INTEGER,
        course INTEGER,
        FOREIGN KEY (faculty) REFERENCES faculties(id),
        FOREIGN KEY (course) REFERENCES courses(code),
        UNIQUE (faculty, course)
      )
      sql);

      $this->connection->execute_query(<<<'sql'
      CREATE TABLE IF NOT EXISTS marks (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        student INTEGER,
        course INTEGER,
        marks INTEGER CHECK (marks >= 0 AND marks <= 100),
        FOREIGN KEY (student) REFERENCES students(id),
        FOREIGN KEY (course) REFERENCES courses(id),
        UNIQUE (student, course)
      )
      sql);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Faculty Functions
  public function getFacultyCount()
  {
    try {
      return $this->connection->execute_query('SELECT COUNT(*) FROM faculties')->fetch_all()[0][0];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getFaculties()
  {
    try {
      return $this->connection->execute_query('SELECT id, name FROM faculties')->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function addFaculty($name, $password)
  {
    try {
      $this->connection->execute_query('INSERT INTO faculties (name, password) VALUES (?,?)', [$name, $password]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
  public function removeFaculty($id)
  {
    try {
      $this->connection->execute_query('DELETE FROM faculties WHERE id = ?', [$id]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getFacultyName($id)
  {
    try {
      return $this->connection->execute_query('SELECT name FROM faculties WHERE id = ?', [$id])->fetch_all(MYSQLI_BOTH)[0]['name'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function canFacultyLogin($name, $password)
  {
    try {
      return isset($this->connection->execute_query('SELECT id FROM faculties WHERE name = ? AND password = ?', [$name, $password])->fetch_all(MYSQLI_BOTH)[0]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getFacultyId($name)
  {
    try {
      return $this->connection->execute_query('SELECT id FROM faculties WHERE name = ?', [$name])->fetch_all(MYSQLI_BOTH)[0]['id'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Student Functions
  public function getStudentCount()
  {
    try {
      return $this->connection->execute_query('SELECT COUNT(*) FROM students')->fetch_all()[0][0];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getStudents()
  {
    try {
      return $this->connection->execute_query('SELECT * FROM students')->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function addStudent($enrollment, $name, $sem)
  {
    try {
      $this->connection->execute_query('INSERT INTO students VALUES (?,?, ?)', [$enrollment, $name, $sem]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
  public function removeStudent($enrollment)
  {
    try {
      $this->connection->execute_query('DELETE FROM students WHERE enrollment_number = ?', [$enrollment]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getStudentName($enrollment)
  {
    try {
      return $this->connection->execute_query('SELECT name FROM students WHERE enrollment_number = ?', [$enrollment])->fetch_all(MYSQLI_BOTH)[0]['name'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function canStudentLogin($enrollment)
  {
    try {
      return count($this->connection->execute_query('SELECT name FROM students WHERE enrollment_number = ?', [$enrollment])->fetch_all(MYSQLI_BOTH)) == 1;
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Courses
  public function getCourseCount()
  {
    try {
      return $this->connection->execute_query('SELECT COUNT(*) FROM courses')->fetch_all()[0][0];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getCourses()
  {
    try {
      return $this->connection->execute_query('SELECT * FROM courses')->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function addCourse($code, $name, $sem)
  {
    try {
      $this->connection->execute_query('INSERT INTO courses VALUES (?, ?, ?)', [$code, $name, $sem]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
  public function removeCourse($code)
  {
    try {
      $this->connection->execute_query('DELETE FROM courses WHERE code = ?', [$code]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getCoursesName()
  {
    try {
      return $this->connection->execute_query('SELECT code, name FROM courses ORDER BY name')->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getCourseName($code)
  {
    try {
      return $this->connection->execute_query('SELECT name FROM courses WHERE code = ?', [$code])->fetch_all(MYSQLI_BOTH)[0]['name'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getCourseID($course)
  {
    try {
      return $this->connection->execute_query('SELECT code FROM courses WHERE name = ?', [$course])->fetch_all(MYSQLI_BOTH)[0]['code'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Faculty Courses Function
  public function getCoursesCount($faculty)
  {
    try {
      return $this->connection->execute_query('SELECT COUNT(*) FROM faculty_courses WHERE faculty = ?', [$faculty])->fetch_all()[0][0];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
  public function getFacultyCourses()
  {
    try {
      return $this->connection->execute_query('SELECT * FROM faculty_courses')->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function addFacultyCourse($faculty, $course)
  {
    try {
      $this->connection->execute_query('INSERT INTO faculty_courses (faculty, course) VALUES (?, ?)', [$faculty, $course]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
  public function removeFacultyCourse($id)
  {
    try {
      $this->connection->execute_query('DELETE FROM faculty_courses WHERE id = ?', [$id]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Marks
  public function isStudentGivenMarks($student, $course)
  {
    try {
      return count($this->connection->execute_query('SELECT id FROM marks WHERE student = ? AND course = ?', [$student, $course])->fetch_all(MYSQLI_BOTH)) > 0;
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getStudentMarks($student, $course)
  {
    try {
      return $this->connection->execute_query('SELECT marks FROM marks WHERE student = ? AND course = ?', [$student, $course])->fetch_all(MYSQLI_BOTH)[0]['marks'];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function markStudent($student, $course, $marks)
  {
    try {
      $this->connection->execute_query('INSERT INTO marks (student, course, marks) VALUES(?, ?, ?)', [$student, $course, $marks]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function setStudentMarks($student, $course, $marks)
  {
    try {
      $this->connection->execute_query('UPDATE marks SET marks = ? WHERE student = ? AND course = ?', [$marks, $student, $course]);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  // Joins
  public function getFacultySemCourses($faculty, $sem)
  {
    try {
      return $this->connection->execute_query(<<<'QUERY'
      SELECT FC.course
      FROM faculty_courses FC
      INNER JOIN courses C
      ON FC.course = C.code
      WHERE FC.faculty = ? AND C.sem = ?
      QUERY, [$faculty, $sem])->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getCourseStudents($course)
  {
    try {
      return $this->connection->execute_query(<<<'QUERY'
      SELECT S.enrollment_number
      FROM students S
      INNER JOIN courses C
      ON S.sem = C.sem
      WHERE C.code = ?
      QUERY, [$course])->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getStudentResult($enrollment)
  {
    try {
      return $this->connection->execute_query(<<<'QUERY'
      SELECT C.code as course, M.marks
      FROM courses C
      LEFT JOIN marks M
      ON M.student = ? AND M.course = C.code
      WHERE sem = (
          SELECT sem FROM students
          WHERE enrollment_number = ?
      )
      QUERY, [$enrollment, $enrollment])->fetch_all(MYSQLI_BOTH);
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }

  public function getFacultyStudentCount($faculty)
  {
    try {
      return $this->connection->execute_query(<<<'QUERY'
      SELECT COUNT(*)
      FROM students
      WHERE sem IN (
        SELECT DISTINCT sem
        FROM courses
        WHERE code IN (
          SELECT course
          FROM faculty_courses
          WHERE faculty = ?
        )
      )
      QUERY, [$faculty])->fetch_all()[0][0];
    } catch (\Throwable $th) {
      showError($th->getMessage());
    }
  }
}

$db = new DB();