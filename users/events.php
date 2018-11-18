<?php
include('_authCheck.php');
include('connection.php');

function isResponseReceived($eventid)
{
	include('connection.php');
	$sql = "select * from event_response where eventid='".$eventid."' and thaliid = '".$_SESSION['thaliid']."'";
	$result= mysqli_query($link,$sql);
	if (mysqli_num_rows($result) > 0)
		return true;
	else
		return false;
}
function getResponse($eventid)
{
	include('connection.php');
	$sql = "select * from event_response where eventid='".$eventid."' and thaliid = '".$_SESSION['thaliid']."'";
	$result= mysqli_query($link,$sql);
	if (mysqli_num_rows($result) > 0)
		return mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Event Registration</title>
	<?php include('_head.php'); ?>
	<?php include('_bottomJS.php'); ?>
</head>
<body>
	<?php include('_nav.php'); ?>

	<!-- Modal Window to add friends -->
	<div class="modal" id="modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <form method="post" action="event_add_friend.php">
	      <div class="modal-header">
	        <h5 class="modal-title">Add a friend</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			  <fieldset>
			    <div class="form-group">
			      <label>ITS</label>
			      <input type="text" class="form-control" name="its" required placeholder="Enter ITS" pattern="[0-9]{8}">
			    </div>
			    <div class="form-group">
			      <label>Full Name</label>
			      <input type="text" class="form-control" name="name" required placeholder="Enter Full Name">
			    </div>
			    <div class="form-group">
			      <label>Mobile</label>
			      <input type="text" class="form-control" name="mobile" required placeholder="Enter Mobile" pattern="[0-9]{10}">
			    </div>
			    <input type="hidden" name="reference_id" id="add_friend_refid">
			    <input type="hidden" name="eventid" id="add_friend_eventid">
			  </fieldset>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Save changes</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="container">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col">Event Name</th>
		      <th scope="col">Date/Venue/Time</th>
		      <th scope="col">Confirmation</th>
		      <th scope="col">Actions</th>
		      <?php if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('nationalminerals52@gmail.com','mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','mustafamnr@gmail.com')))
				{
			  ?>
		      <th scope="col">Admin</th>
		  	  <?php } ?>
		    </tr>
		  </thead>
		  <tbody>
				<?php
				$result=mysqli_query($link,"SELECT * FROM events");
		      while($values = mysqli_fetch_assoc($result))
		      {
		    ?>
		    <tr>
		      <th scope="row"><?php echo $values['name']; ?></th>
		      <td><?php echo $values['venue']; ?></td>
		      <td>Will You Attend?
				<button type="button" <?php echo isResponseReceived($values['id']) ? 'disabled' : ''; ?> data-eventid="<?php echo $values['id']; ?>" data-thaliid="<?php echo $_SESSION['thaliid']; ?>" data-response="yes" class="btn btn-primary btn-sm btn-response action-<?php echo $values['id']; ?>">Yes</button>
				<button type="button" <?php echo isResponseReceived($values['id']) ? 'disabled' : ''; ?>  data-eventid="<?php echo $values['id']; ?>" data-thaliid="<?php echo $_SESSION['thaliid']; ?>" data-response="no" class="btn btn-primary btn-sm btn-response action-<?php echo $values['id']; ?>">No</button>
				<p <?php echo isResponseReceived($values['id']) ? '' : 'hidden'; ?> class="text-muted"><small>
				<?php
					$response = getResponse($values['id']);
					echo "You said [".$response['response']."] on ".$response['date'];
				?>
				</small></p>
		      </td>
		      <td>
		      	<button type="button" data-eventid="<?php echo $values['id']; ?>" data-thaliid="<?php echo $_SESSION['thaliid']; ?>" class="btn btn-primary btn-sm add_friend">Add Friend</button>
		      	<?php
		      		$result1=mysqli_query($link,"select * from event_response where reference_id=".$_SESSION['thaliid']." and eventid=".$values['id']);
		      		echo "<br>Registered Friends:<br>";
		      		echo "<p class=\"text-muted\">";
		      		while($values1 = mysqli_fetch_assoc($result1)) {
		      			echo $values1['name']."<br>";
		      		}
		      		echo "</p>";
		      	?>
		      </td>
		      <?php if (!is_null($_SESSION['fromLogin']) && in_array($_SESSION['email'], array('nationalminerals52@gmail.com','mesaifee52@gmail.com','murtaza52@gmail.com','murtaza.sh@gmail.com','yusuf4u52@gmail.com','mustafamnr@gmail.com')))
				{
			  ?>
		      <td><a href="event_get_not_registered_users.php?eventid=<?php echo $values['id']; ?>">Not Registered</a></td>
		  	  <?php } ?>
		    </tr>
		    <?php } ?>
		  </tbody>
		</table>
	</div>
</body>
<script>
$(document).ready(function(){
    $(".btn-response").click(function(){
    	$(".action-" + $(this).data("eventid")).attr("disabled", true);
    	$.ajaxSetup({
		    beforeSend: function(xhr) {
		        xhr.setRequestHeader('User-Agent', 'Googlebot/2.1 (+http://www.google.com/bot.html)');
		    }
		});
        $.post("event_response.php",
        {
          Response: $(this).data("response"),
          Thaliid: $(this).data("thaliid"),
          Eventid: $(this).data("eventid")
        },
        function(data,status){
            alert("Response Submitted Successfully");
        });
    });

    $(".add_friend").click(function(){
    	$('#add_friend_refid').val($(this).data('thaliid'));
    	$('#add_friend_eventid').val($(this).data('eventid'));
    	$("#modal").modal();
    });
});
</script>
</html>