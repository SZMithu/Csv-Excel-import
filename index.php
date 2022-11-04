<?php
session_start();
$data = file_get_contents('csv.json');
$data = json_decode($data, true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cvs Import</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>

<body style="background-color:black;">
    <div class="container">
        <div class="row mt-3 bg-success text-white py-3">
            <h1>Csv or excel file uplaod</h1>
        </div>
        <div class="row text-center card py-5 mt-2 position-relative">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-info alert-dismissible fade show col-4 position-absolute top-0" role="alert">
                    <strong>Message !</strong> <?php echo $_SESSION['message'];
                                                session_unset(); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <h6 class="mt-4">Select a csv/excel file</h6>
            <form action="logic.php" method="post" enctype="multipart/form-data">
                <div class="col-6 my-3 mx-auto">
                    <input type="file" name="file" class="form-control">
                    <span>Supported file format 'csv', 'xls', 'xlsx'.</span>
                </div>
                <div class="col-3 mx-auto">
                    <input type="submit" value="Upload File" name="submit" class="form-control btn btn-primary mb-3">
                </div>
                <div class="col-3 mx-auto">
                    <input type="submit" value="Reset All" name="reset" class="form-control btn btn-danger">
                </div>
            </form>
        </div>
        <div class="row bg-success mt-2 py-3 text-white">
            <h3>Uploded file's data will shows below as a tabel</h3>
        </div>
        <?php if ($data) {  ?>
            <div class="row card py-5 mt-2">
                <table class="table">
                    <tbody>
                        <?php for ($i = 0; $i < count($data); $i++) { ?>
                            <tr>
                                <?php for ($j = 0; $j < count($data[$i]); $j++) { ?>
                                    <td><?php echo $data[$i][$j] ?? 'No data found'; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>