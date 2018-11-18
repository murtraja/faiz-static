<?php
include('connection.php');
error_reporting(0);
session_start();

if(!is_null($_SESSION['fromLogin']) && !in_array($_SESSION['email'], array('yusuf4u52@gmail.com','mustafamnr@gmail.com'))) {
  header("Location: index.php"); 
}

if($_POST)
{
  mysqli_query($link, "INSERT INTO `amount_received` (`email`,`amount`) values ('".addslashes($_POST['email'])."','".addslashes($_POST['amount'])."')") or die(mysqli_error($link));
  header('location: amount_received_by.php');
}
    $amount_received_already = mysqli_query($link, "SELECT email,sum(amount) as total_amount FROM `amount_received` GROUP BY email") or die(mysqli_error($link));
    $amount_received_already_keyval = array();
    while($received = mysqli_fetch_assoc($amount_received_already))
    {
      $amount_received_already_keyval[$received['email']] = $received['total_amount'];
    }
    // print_r($amount_received_already_keyval); exit();
    $amount_received = mysqli_query($link, "SELECT received_by,sum(Amount) as total_amount FROM `receipts` where received_by != '' GROUP BY received_by") or die(mysqli_error($link));
 ?>
<html>
<head>
<?php include('_head.php'); ?>
</head>
  <body>
<?php include('_nav.php'); ?>



<div class="container">


<table class="table table-striped table-hover table-responsive table-bordered">

                <thead>

                  <tr>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>

                    <?php
                    while($valuesnew = mysqli_fetch_assoc($amount_received))
                    {
                    ?>
                    <tr>
                    <td><?php echo $valuesnew['received_by']; ?></td>
                    <td><?php echo (int)$valuesnew['total_amount'] - (int)$amount_received_already_keyval[$valuesnew['received_by']]; ?></td>
                    <td><form method="post">
                          <input type="hidden" name="email" value="<?php echo $valuesnew['received_by']; ?>">
                          <input type="text" name="amount" class="form-control">
                          <button type="submit" class="btn btn-primary btn-sm" type="button">Receive</button>
                    </form></td>
                  </tr>                 
                   <?php } ?>
              
                </tbody>
              </table>


</div>
</body>
<?php include('_bottomJS.php'); ?>
</html>