<?php
$conn = pg_connect('host=localhost port=5432 dbname=root user=root password=root');



// Найти учителей, которые ведут больше всего различных предметов
$teachers_best = function($connect){
    $result = pg_query($connect, "
        select teacher.name, lesson.count
        from teacher join (
            select teacher_id , count(*) as count
            from lesson
            group by teacher_id
        ) as lesson on teacher.id = lesson.teacher_id
        where lesson.count = (
        select max(query_table.count)
            from (
                select teacher_id , count(*) as count
                from lesson
                group by teacher_id
            ) as query_table 
        )
    ");
    return pg_fetch_all($result);
};

// Найти аудиторию, которая меньше всего используется в дни недели, выбранные пользователем (при поиске могут быть выбрано несколько дней недели одновременно)
$audience_in_min_count_shedule = function($connect, $days_of_week = [2,3]) {

    $params = '';
    for ($i = 0; $i < count($days_of_week); $i++){
        $comma = ($i + 1) < count($days_of_week) ? ', ' : '';
        $params .= '$' . $i + 1 . $comma;
    }

    $query = "
        select audience.name, shedule.audience_count
        from audience join (
            select audience_id, count(audience_id) as audience_count
            from shedule
            where date_part('dow',data) in (". $params .")
            group by audience_id
        ) as shedule on audience.id = shedule.audience_id
        where shedule.audience_count = (
            select max(query_table.audience_count)
            from (
                select audience_id, count(audience_id) as audience_count
                from shedule
                where date_part('dow',data) in (". $params .")
                group by audience_id
            ) as query_table
        )
    ";

    $result = pg_query_params($connect, $query, $days_of_week);
    return pg_fetch_all($result);
};

// Для каждого класса подсчитать количество уроков за неделю и количество различных учителей
$class_info = function($connect, $start = '2023-08-28', $end = '2023-08-31') {
    $result = pg_query_params($connect, "
        select shedule.classes_id, count(shedule.classes_id) as count_lessons, count(distinct lesson.teacher_id) as count_teachers
        from shedule 
        left join 
        (
            select 
                lesson.id as lesson_id, 
                teacher.name as teacher_name, 
                teacher.id as teacher_id
            from lesson join teacher on lesson.teacher_id = teacher.id
        ) as lesson on shedule.lesson_id = lesson.lesson_id
        where data BETWEEN $1 and $2
        group by shedule.classes_id;
    ", [$start, $end]);
    return pg_fetch_all($result);
};

// Вывести список предметов и учителей для заданной пользователем параллели классов (например, 10-е классы)
$list_lessons_for_parallel = function($connect, $parallel = 10) {

    $result = pg_query_params($connect, "
        select teacher.name , string_agg(lesson.name, ', ') as lessons
        from lesson join teacher on lesson.teacher_id = teacher.id
        where lesson.id in (
            select lesson_id
            from shedule
            where classes_id in (
                select id   
                from class_table
                where parallel = $1
            )
            group by lesson_id 
        ) 
        group by teacher.name
    ", [$parallel]);
    return pg_fetch_all($result);
};








echo "<pre>";
var_dump($teachers_best($conn));


var_dump($audience_in_min_count_shedule($conn, [2,3]));


var_dump($class_info($conn, '2023-08-28', '2023-09-01'));


var_dump($list_lessons_for_parallel($conn, 11));
echo "</pre>";




















