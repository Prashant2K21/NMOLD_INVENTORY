<?php
//start the session
session_start();
if (!isset($_SESSION['user']))  header('location: login.php');


$user = $_SESSION['user'];
//get graph data - purchase order by status
include('database/po_status_pie_graph.php');
//get graph data - supplier product count
include('database/supplier_product_bar_graph.php');
//get line graph data - delivery history per day
include('database/delivery_history.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/8c7a3095b5.js"></script>
    <style>
        /* Styles for the card */
.card {
    
  width: 300px; /* Set the width of the card */
  border: 1px solid #ccc; /* Add a border for the card */
  border-radius: 8px; /* Rounded corners for the card */
  overflow: hidden; /* Ensure content within the card stays contained */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow for depth */
  margin: 20px; /* Add some margin around the card */
}

/* Styles for the card image */
.card-image {
  /* width: 100%; 
  height: auto; 
  display: block;  */
}

/* Styles for the card content */
.card-content {
  padding: 15px; /* Add padding inside the card */
}

/* Styles for the card title */
.card-title {
  margin-top: 0; /* Remove default margin */
  font-size: 1.25rem; /* Set the font size for the title */
}

/* Styles for the card description */
.card-description {
  color: #555; /* Set the color of the text */
}

/* Styles for the card link */
.card-link {
  display: inline-block; /* Display the link as inline block */
  text-decoration: none; /* Remove underline */
  color: #007bff; /* Set the color of the link */
  margin-top: 10px; /* Add spacing between text and link */
  padding: 5px 10px; /* Add padding to the link */
  border: 1px solid #007bff; /* Add border to the link */
  border-radius: 5px; /* Rounded corners for the link */
  transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

.card-link:hover {
  background-color: #007bff; /* Change background color on hover */
  color: #fff; /* Change text color on hover */
}

    </style>
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include 'partials/app-sidebar.php';
        ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include 'partials/app-topnav.php';
            ?>
            <div class="dashboard_content">
            <div class="card">
  <img src="images/data analytics.jpg" alt="Data Analytics" class="card-image">
  <div class="card-content">
    <h3 class="card-title">Data Analytics</h3>
    <p class="card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis libero a gravida semper.</p>
    <a href="dashboard1.php" class="card-link">Explore</a>
  </div>
</div>


            </div>
        </div>
    </div>
      


</body>

</html>