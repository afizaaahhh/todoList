<?php
$conn = mysqli_connect("localhost","root","","todo") 
			or die("Connection failed".mysqli_error($connection));

$error = "";

// add task
if (isset($_POST['submit'])) {
	if (empty($_POST['task'])) {
		$errors = "You must fill in the task!";
	}else{
		$task = $_POST['task'];
		$sql = "INSERT INTO task (name) VALUES ('$task')";
		mysqli_query($conn, $sql);
		header('location: 1page.php?success=1');
	}
}

// delete task
if (isset($_GET['del_task'])) {

	$id = $_GET['del_task'];

	mysqli_query($conn, "DELETE FROM task WHERE id=".$id);
	header('location: 1page.php');
}

// Mark Done
if(isset($_GET['m'])){

	$j = $_GET['m']; //ID column

	$sql1 = "UPDATE task 
			SET done = '1'
			WHERE id='$j'";

	$result = mysqli_query($conn,$sql1);

	header("location: 1page.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>To Do List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Exo&family=Merriweather:wght@700&family=Oswald&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
	body {
		background-image: url('images/bg.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
		font-family: 'Exo', sans-serif;
		font-size: 21px;
	}
</style>
<script type="text/javascript">
// function strikeme(){
// 	var ele = document.getElementsByClassName("task");
// 	var result = ele.strike();
	
//     for (var i in ele)
// 	 ele[i].style.textDecoration='line-through';
// 	document.getElementById("name").innerHTML = result;
// }

</script>

<body>
	<div class="card" align="center" >
		<div class="heading">
			<h2>My To Do List</h2>
		</div>
		
		<form method="post" action="1page.php" class="input_form">

		<!-- Success Button -->
			<?php
			if(isset($_GET['success'])&& $_GET['success']==1)
			{
				?>  <center>
				  		<div id="close" class="alert success">
				    	<span class="closebtn" onclick="document.getElementById('close').style.display='none'">&#215;</span>  
				    	<strong>Successfully added new task!</strong> 
				  	</div>
					</center>            
				<?php
			}
		
			// <!-- Error Message -->
			if (isset($errors)) { ?>
				<p><?php echo $errors; ?></p>
			<?php } ?>
			
			<input type="text" name="task" class="input_task" placeholder="What to do?">
			<button type="submit" name="submit" id="add_btn" class="add_btn" ><i class="fa fa-plus" style="font-size:15px"></i></button>
			
		</form>
		<br>
		<!-- ToDo List Table -->
		<table>
			<thead>
				<tr>
					<th style="padding-right: 15%;">No.</th>
					<th style="text-align: center;">Tasks</th>
					<th style="width: 60px;">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				// select all tasks if page is visited or refreshed
				$task = mysqli_query($conn, "SELECT * FROM task");

				if(!empty($task)){
				$i = 1; while ($row = mysqli_fetch_array($task)) { ?>
					<tr>
						<td > <?php echo $i; ?> </td>
						<?php //Add Strikethrough on done task
						if ($row['done']=='1'){
    						?><td class="name" style="text-decoration: line-through;"> <?php echo $row['name']; ?> </td>
    						<?php
						}
						else{?>
							<td class="name"> <?php echo $row['name']; ?> </td>
						<?php }
						?>
						<td class="button_action"> 	
						<a href="1page.php?m=<?php echo $row['id']?>" class="done_btn" id="done" ><i class="fa fa-check" style="font-size:17px"></i></a>					
						<a href="1page.php?del_task=<?php echo $row['id'] ?>" class="del" ><i class='fa fa-minus' style='font-size:15px'></i></a>
						</td>
					</tr>
				<?php $i++; } 
			} ?>
			</tbody>
		</table>
	</div>

</body>
</html>

