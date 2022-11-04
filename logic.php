<?php
session_start();
require 'vendor/autoload.php';

use \PhpOffice\PhpSpreadsheet\IOFactory;
// For dabase purpose
// try {
//     $connect = new PDO("mysql:host=localhost;dbname=csv_import", 'root', '');
//     // set the PDO error mode to exception
//     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }


if (isset($_POST["submit"])) {
    if (!empty($_FILES['file']['name'])) {
        $fileName = $_FILES['file']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allow_ext = ['csv', 'xls', 'xlsx'];

        if (in_array($file_ext, $allow_ext)) {
            $filePath = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($filePath);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $msg = file_put_contents('csv.json', json_encode($data, JSON_FORCE_OBJECT));
            //for insert into database column must be matched with following
            // foreach ($data as $row) {
            //     $name = $row['0'];
            //     $roll = $row['1'];
            //     $reg = $row['2'];
            //     $email = $row['3'];
            //     $sql = "INSERT INTO students (name, roll, reg, email) VALUES (?,?,?,?)";
            //     $stmt = $connect->prepare($sql);
            //     $stmt->execute([$name, $roll, $reg, $email]);               
            //     $msg = true;
            // }
            if ($msg) {
                $_SESSION['message'] = $file_ext . ' File Imported successfully';
                header('Location:index.php');
            } else {
                $_SESSION['message'] = $file_ext . ' File Uploaded failed';
                header('Location:index.php');
            }
        } else {
            $_SESSION['message'] = $file_ext . ' File Not Allowed';
            header('Location:index.php');
        }
    } else {
        $_SESSION['message'] = ' File Not Found';
        header('Location:index.php');
    }
}

if (isset($_POST["reset"])) {
    file_put_contents('csv.json', '');
    header('Location:index.php');
}
