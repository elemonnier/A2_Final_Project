<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wonder'airlines</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style2.css"  />
    <link rel="icon" type="image/png" href="../img/avion.png" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<div  class="bs-example" id="top_side">

    <nav style="border-bottom: solid;"  class="navbar navbar-expand-md navbar-light bg-light">
        <img style="width: 7%; margin-right: 40%;" id="logo" src="../img/logo2.png">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav" >
                <a class="nav-item nav-link active" id="flight_res" href="../flight_reservation.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Flight reservation</a>
                <a class="nav-item nav-link active" id="my-flight_res" href="my_flyght_auth.php">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    My Flight</a>
                <a class="nav-item nav-link active" id="about_us" href="../contact_us.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Contact us
                </a>
                <a class="nav-item nav-link active" id="accueil" href="../index.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Home
                </a>
            </div>
        </div>
    </nav>
</div>
<br>
<br>
<div id="booking2" class="section">

    <div style="margin-left: 10%; margin-top: 10%" class="row">
        <h1 style="margin-top: 150px; margin-right: 20px;">Authentication</h1>
        <div  class="col-md-7 col-md-offset-1">
            <div style="border: solid black 1px" class="booking-form">
                <form action="my_flyght.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Name</span>
                                <input name="nom" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Firstname</span>
                                <input name="prenom" class="form-control" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group1">
                                <span class="form-label">Mail</span>
                                <input name="email" class="form-control" type="email" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group1">
                                <span class="form-label">Ticket date</span>
                                <input name="date" class="form-control" type="date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-btn">
                        <button class="submit-btn">Show</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<br>
</body>
</html>