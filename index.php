<?php

require("db.php");

$pilot = new Pilot();

if($_REQUEST)
{
    if(isset($_POST["submit"]))
    {
        if($_FILES["file"]["error"] === UPLOAD_ERR_OK)
        {
            $rand = uniqid();
            $file = $_FILES["file"]["tmp_name"];
            $image = $rand . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            move_uploaded_file($file, "images/" . $image);
        }
        else
        {
            $image = "";
        }
        $pilot->name = $_POST["name"];
        $pilot->surname = $_POST["surname"];
        $pilot->email = $_POST["email"];
        $pilot->tel = $_POST["tel"];
        $pilot->image = $image;
        $pilot->store();
    }
    if(isset($_GET["destroy"]) && isset($_GET["id"]) && isset($_GET["image"]))
    {
        $pilot->id = $_GET["id"];
        $pilot->destroy();
        unlink("images/" . $_GET["image"]);
        header("location: index.php");
    }
}

$pilots = new Pilot();
$pilots = $pilots->index();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilots</title>
    <!---->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!---->
    <section>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div>
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <br>
                                <div>
                                    <label class="form-label">Tel</label>
                                    <input type="tel" class="form-control" name="tel">
                                </div>
                                <br>
                                <input type="file" class="form-control" name="file">
                                <br>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-dark" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover border">
                            <tr>
                                <td>Id</td>
                                <td>Name</td>
                                <td>Surname</td>
                                <td>Email</td>
                                <td>Tel</td>
                                <td>Image</td>
                                <td></td>
                                <td></td>
                            </tr>

                            <?php foreach($pilots as $i): ?>

                            <tr>
                                <td><?php echo $i->id; ?></td>
                                <td><?php echo $i->name; ?></td>
                                <td><?php echo $i->surname; ?></td>
                                <td><?php echo $i->email; ?></td>
                                <td><?php echo $i->tel; ?></td>
                                <td>
                                    <img src="images/<?php echo $i->image; ?>" class="img-fluid rounded" width="70">
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $i->id; ?>&image=<?php echo $i->image; ?>" class="btn btn-link">Edit</a>
                                </td>
                                <td>
                                    <a href="index.php?destroy&id=<?php echo $i->id; ?>&image=<?php echo $i->image; ?>" class="btn btn-link">Delete</a>
                                </td>
                            </tr>

                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>