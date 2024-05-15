INSERT INTO faculties (name, password) VALUES('Faculty A', 'A654');
INSERT INTO faculties (name, password) VALUES('Faculty B', 'B654');
INSERT INTO faculties (name, password) VALUES('Faculty C', 'C654');
INSERT INTO faculties (name, password) VALUES('Faculty D', 'D654');


INSERT INTO students VALUES(100, 'Student A', 1);
INSERT INTO students VALUES(101, 'Student B', 1);
INSERT INTO students VALUES(102, 'Student C', 1);

INSERT INTO students VALUES(200, 'Student D', 2);
INSERT INTO students VALUES(201, 'Student E', 2);
INSERT INTO students VALUES(202, 'Student F', 2);

INSERT INTO students VALUES(300, 'Student G', 3);
INSERT INTO students VALUES(301, 'Student H', 3);
INSERT INTO students VALUES(302, 'Student I', 3);

INSERT INTO students VALUES(400, 'Student J', 4);
INSERT INTO students VALUES(401, 'Student K', 4);
INSERT INTO students VALUES(402, 'Student L', 4);

INSERT INTO students VALUES(500, 'Student M', 5);
INSERT INTO students VALUES(501, 'Student N', 5);
INSERT INTO students VALUES(502, 'Student O', 5);

INSERT INTO students VALUES(600, 'Student P', 6);
INSERT INTO students VALUES(601, 'Student Q', 6);
INSERT INTO students VALUES(602, 'Student R', 6);


INSERT INTO courses VALUES(1001, 'Course A', 1);
INSERT INTO courses VALUES(1002, 'Course B', 1);

INSERT INTO courses VALUES(2001, 'Course C', 2);
INSERT INTO courses VALUES(2002, 'Course D', 2);

INSERT INTO courses VALUES(3001, 'Course E', 3);
INSERT INTO courses VALUES(3002, 'Course G', 3);

INSERT INTO courses VALUES(4001, 'Course H', 4);
INSERT INTO courses VALUES(4002, 'Course I', 4);

INSERT INTO courses VALUES(5001, 'Course J', 5);
INSERT INTO courses VALUES(5002, 'Course K', 5);

INSERT INTO courses VALUES(6001, 'Course L', 6);
INSERT INTO courses VALUES(6002, 'Course M', 6);


INSERT INTO faculty_courses (faculty, course) VALUES(1, 1001);
INSERT INTO faculty_courses (faculty, course) VALUES(1, 6002);
INSERT INTO faculty_courses (faculty, course) VALUES(1, 1002);

INSERT INTO faculty_courses (faculty, course) VALUES(2, 6001);
INSERT INTO faculty_courses (faculty, course) VALUES(2, 2001);
INSERT INTO faculty_courses (faculty, course) VALUES(2, 5002);

INSERT INTO faculty_courses (faculty, course) VALUES(3, 2002);
INSERT INTO faculty_courses (faculty, course) VALUES(3, 5001);
INSERT INTO faculty_courses (faculty, course) VALUES(3, 3001);

INSERT INTO faculty_courses (faculty, course) VALUES(4, 4002);
INSERT INTO faculty_courses (faculty, course) VALUES(4, 3002);
INSERT INTO faculty_courses (faculty, course) VALUES(4, 4001);

-- INSERT INTO marks (student, course, marks) VALUES();