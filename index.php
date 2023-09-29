<?php
require_once 'config/untils.php';
$conn = connect();
onSes();
$reses = [];

// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
//     echo "<script>alert('You are not allow to do this -_-. Please log in to continue.')
//     window.location='login.php'</script>";
//     die();
// }
if (isset($_GET['bar'])) {
    $sr = $_GET['bar'];
    $sql = "select * from products where pro_name='$sr'";
    echo $sql;
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['pro_name'];
        $price = $row['pro_price'];
        $item_img = $row['pro_image'];

        $res = "<div class='col-lg-3 mb-4'>
                    <form>
                        <div class='card'>
                        <img src='images/$item_img' class='card-img-top'>                    
                            <div class='card-body text-center'>
                                <h5 class='card-title'>$name</h5>
                                <p class='card-text'>Price: $price$</p>
                            </div>
                        </div>
                    </form>
                </div>";

        $reses[] = $res;
    }
}
if (isset($_POST['search'])) {
    $sr = $_POST['bar'];
    $sql = "select * from products where pro_name='$sr'";
    echo $sql;
    $result = mysqli_query($conn, $sql);

    // Check for errors in the query execution
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch and display the data
    if (($result->num_rows) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $name = $row[1];
            $price = $row[2];
            $item_img = $row[3];

            $res = "<div class='col-lg-3 mb-4'>
                <form>
                    <div class='card'>
                    <img src='images/$item_img' class='card-img-top'>                    
                        <div class='card-body text-center'>
                            <h5 class='card-title'>$name</h5>
                            <p class='card-text'>Price: $price$</p>
                        </div>
                    </div>
                </form>
            </div>";

            $reses[] = $res;
        }
    }
    // if (empty($reses)) {
    //     $res = "<h2>Find something??</h2>";
    //     $reses[] = $res;
    // }
    unset($_POST['search']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Shopping :3</title>

    <!-- Prevent Form Resubmission alert POST -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Shopping</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="account.php">Notthing here :3</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="" method="post">
                <input class="form-control mr-sm-2" type="search" name="bar" placeholder="Find your product">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <?php
            if (isset($reses) && !empty($reses)) {
                foreach ($reses as $res) {
                    echo $res;
                }
                echo "<h2>Find something??</h2>";
            } else {
                echo "<h2>Find something??</h2>";
            }

            // $res = sqlSelect($conn, "select * from products order by 'id'");
            // if ($res && $res->num_rows >= 1) {
            //     while ($row = $res->fetch_assoc()) {
            //         $item_id = $row['id'];
            //         $item_name = $row['pro_name'];
            //         $item_price = $row['pro_price'];
            //         $item_img = $row['pro_image'];

            //         echo "<div class='col-lg-3 mb-4'>
            //     <form>
            //         <div class='card'>
            //             <img src='product/images/$item_img' class='card-img-top'>
            //             <div class='card-body text-center'>
            //                 <h5 class='card-title'>$item_name</h5>
            //                 <p class='card-text'>Price: $item_price$</p>
            //             </div>
            //         </div>
            //     </form>
            // </div>";
            //     }
            // } else {
            //     echo "<h3 style='color:red'>No Products Found</h3>";
            // }
            ?>
        </div>
    </div>
</body>

<!-- ' or if((substring((select password from users where username='sondeptrai'),1,1)='a'), sleep(5), 1)-- - -->