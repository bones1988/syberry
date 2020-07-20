<?php
require_once 'connection_properties.php';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$max_size = 0;
$sunday_result = get_days_result($conn, 0);
$sunday_top = convert_result_to_string($sunday_result);
if (strlen($sunday_top) > $max_size) {
    $max_size = strlen($sunday_top);
}
$monday_result = get_days_result($conn, 1);
$monday_top = convert_result_to_string($monday_result);
if (strlen($monday_top) > $max_size) {
    $max_size = strlen($monday_top);
}
$tuesday_result = get_days_result($conn, 2);
$tuesday_top = convert_result_to_string($tuesday_result);
if (strlen($tuesday_top) > $max_size) {
    $max_size = strlen($tuesday_top);
}
$wednesday_result = get_days_result($conn, 3);
$wednesday_top = convert_result_to_string($wednesday_result);
if (strlen($wednesday_top) > $max_size) {
    $max_size = strlen($wednesday_top);
}
$thursday_result = get_days_result($conn, 4);
$thursday_top = convert_result_to_string($thursday_result);
if (strlen($thursday_top) > $max_size) {
    $max_size = strlen($thursday_top);
}
$friday_result = get_days_result($conn, 5);
$friday_top = convert_result_to_string($friday_result);
if (strlen($friday_top) > $max_size) {
    $max_size = strlen($friday_top);
}
$saturday_result = get_days_result($conn, 6);
$saturday_top = convert_result_to_string($saturday_result);
if (strlen($saturday_top) > $max_size) {
    $max_size = strlen($saturday_top);
}

$mask = "|%10.10s |%-{$max_size}.{$max_size}s |\n";
printf($mask, 'Monday', $monday_top);
printf($mask, 'Tuesday', $tuesday_top);
printf($mask, 'Wednesday', $wednesday_top);
printf($mask, 'Thursday', $thursday_top);
printf($mask, 'Friday', $friday_top);
printf($mask, 'Saturday', $saturday_top);
printf($mask, 'Sunday', $sunday_top);

$conn->close();


function get_days_result($connection, $day)
{
    $query = "select round(avg(hours),2) as avg_hours, employee_id, name from time_reports join employees on employee_id=employees.id where weekday(date) = {$day} group by employee_id order by avg_hours desc limit 3";
    return $connection->query($query);
}


function convert_result_to_string($result)
{
    $result_string = ' ';
    while ($row = $result->fetch_assoc()) {
        $result_string = $result_string . ' ' . $row['name'] . " ({$row["avg_hours"]}),";
    }
    return substr($result_string, 0, -1);
}
