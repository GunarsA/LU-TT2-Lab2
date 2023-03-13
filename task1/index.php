<?php
//TODO: set up Mysql connection;
$server = "127.0.0.1:3306";
$database = "mobile";
$user = "root";
$password = "password";
$mysqli = new mysqli($server, $user, $password, $database);

//TODO: Fill the array of manufacturer IDs and titles (e.g. "33" => "Alfa Romeo")
$manufacturers = array();
$manufacturer_handle = $mysqli->query("select id, title from manufacturers
order by title");
while ($row = $manufacturer_handle->fetch_assoc()) {
    $manufacturers[$row["id"]] = $row["title"];
}

//TODO: Fill the array of color IDs and titles (e.g. "19" => "Tumši pelēka" (dark grey)) 
$colors = array();
$colors_handle = $mysqli->query("select id, title from colors
order by title");
while ($row = $colors_handle->fetch_assoc()) {
    $colors[$row["id"]] = $row["title"];
}


//TODO: collect and sanitize the current inputs from GET data
$year = "";
$manufacturer = "";
$color = "";

$error = "";

if (
    isset($_GET['year']) && $_GET['year']
    && isset($_GET['manufacturer']) && $_GET['manufacturer'] &&
    isset($_GET['color']) && $_GET['color']
) {
    $year = $_GET['year'];
    $manufacturer = $_GET['manufacturer'];
    $color = $_GET['color'];
} else {
    $error = "Parameter(s) missing!";
}

if (!$error && !is_numeric($year)) {
    $error = "Year not a numeric!";
}

//TODO: connect to database, make a query, collect results, save it to $results array as objects
$results = array();

if (!$error) {
    $statement = $mysqli->prepare(
        "SELECT
            manufacturers.title AS manufacturer,
            models.title AS model,
            count(*) AS count
        FROM
            manufacturers
            INNER JOIN models ON manufacturer_id = manufacturers.id
            INNER JOIN cars ON cars.model_id = models.id
        WHERE
            manufacturer_id = ?
            AND color_id = ?
            AND cars.registration_year = ?
        GROUP BY
            manufacturers.title,
            models.title
        ORDER BY
            count DESC"
    );

    $statement->bind_param("iii", $manufacturer, $color, $year);
    $statement->execute();

    $temp = $statement->get_result();
    while ($row = $temp->fetch_assoc()) {
        $results[] = $row;
    }
}

//TODO: complete the view file
require("view.php");

require("../task2/logger.php");
$logger = new Logger(getcwd() . "\..\log.txt");
if ($error) {
    $logger->log("ERROR");
} else {
    $logger->log("OK");
}
