CREATE TABLE class_table(
    id serial PRIMARY KEY,
    parallel INT,
    grade char(1)
);

CREATE TABLE teacher(
    id serial PRIMARY KEY,
    name VARCHAR(40)
);

CREATE TABLE lesson(
    id serial PRIMARY KEY,
    teacher_id INT REFERENCES teacher(id),
    name VARCHAR(15)
);

CREATE TABLE audience(
    id serial PRIMARY KEY,
    name VARCHAR(15)
);

CREATE TABLE time_table(
    id serial PRIMARY KEY,
    name VARCHAR(15)
);

CREATE TABLE shedule(
    id serial PRIMARY KEY,
    data date,
    lesson_id INT REFERENCES lesson(id),
    audience_id INT REFERENCES audience(id),
    classes_id INT REFERENCES class_table(id),
    time_id INT REFERENCES time_table(id)
);

INSERT INTO class_table (parallel, grade)
VALUES (11, 'a'),(10, 'a'), (10, 'b');

INSERT INTO teacher (name)
VALUES ('Козлова'),('Соколова'), ('Луканина'),('Штульц');

INSERT INTO lesson (teacher_id, name)
VALUES (1, 'Математика'),(2, 'ОБЖ'), (2,'Биология'),(3,'Английский'),(3, 'Китайский'),(4, 'Немецкий');


INSERT INTO audience (name)
VALUES ('Первый'),('второй'), ('третий'),('четвертый');

INSERT INTO time_table (name)
VALUES ('8:00'),('9:00'), ('10:00'),('11:00'), ('12:00');

INSERT INTO shedule (data, lesson_id, audience_id, classes_id, time_id)
VALUES 
    (make_date(2023,08,28),1,1,1,1),
    (make_date(2023,08,28),3,2,2,1),
    (make_date(2023,08,28),5,3,3,1),
    (make_date(2023,08,28),2,2,1,2),
    (make_date(2023,08,28),1,1,2,2),  
    (make_date(2023,08,28),3,4,3,2),   
    (make_date(2023,08,29),3,2,1,1),
    (make_date(2023,08,29),1,3,2,1),   
    (make_date(2023,08,29),4,1,3,1),  
    (make_date(2023,08,29),1,1,1,2),
    (make_date(2023,08,29),2,3,2,2),
    (make_date(2023,08,29),4,2,3,2),
    (make_date(2023,08,30),1,3,1,1),
    (make_date(2023,08,30),3,2,2,1),
    (make_date(2023,08,30),4,4,3,1),
    (make_date(2023,08,30),4,3,1,2),
    (make_date(2023,08,30),2,1,2,2),
    (make_date(2023,08,30),6,4,3,2),
    (make_date(2023,08,31),3,2,1,1),
    (make_date(2023,08,31),1,3,2,1),
    (make_date(2023,08,31),6,1,3,1),
    (make_date(2023,08,31),4,1,1,2),
    (make_date(2023,08,31),3,2,2,2),
    (make_date(2023,08,31),1,3,3,2),
    (make_date(2023,09,01),1,2,1,1),
    (make_date(2023,09,01),2,3,2,1),
    (make_date(2023,09,01),4,4,3,1),
    (make_date(2023,09,01),1,2,1,2),
    (make_date(2023,09,01),6,3,2,2),
    (make_date(2023,09,01),4,1,3,2);


