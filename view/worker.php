<?php require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="author" content="Some Code pty ltd">
   <link rel="shortcut icon" href="../public/img/Logo/kunokharK.ico">
   <title>Kunokhar ctp (pty) Ltd</title>
   <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="../public/css/font-awesome/css/font-awesome.css">
   <link rel="stylesheet" type="text/css" href="../public/css/w3.css">
   <link rel="stylesheet" type="text/css" href="../public/css/style.css">
</head>
<body class="bg-work">
<?php
require_once('../model/User.class.php');
require_once('../model/Work.class.php');

$user = new User();
$work = new Work();
$u_details = $user->getUser($_SESSION['id']);

include 'partials/navbar_worker.php';
?>
<?php
if($u_details['w_type'] != "Admin")
{

?>
<div class="work-content">
  <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="">
  	      <div class="modal-header text-center">
  	        <h4 class="modal-title w-100 font-weight-bold">Client information</h4>
  	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  	          <span aria-hidden="true">&times;</span>
  	        </button>
  	      </div>
  	      <div id="status" class="ml-4 mr-4 mt-2 mb-2">

  	      </div>

  	      <div class="modal-body mx-3">
  	        <div class="md-form mb-3 row">
  				<div class="col-sm-6">
  					<i class="fa fa-circle-thin prefix grey-text"></i>
  					<select class="form-control" id="title">
  						<option value="">Title</option>
  						<option value="Mr">Mr</option>
  						<option value="Mrs">Mrs</option>
  						<option value="Dr.">Dr.</option>
  						<option value="Prof.">Prof.</option>
  					</select>
  					<label data-error="wrong" data-success="right" for="title">Title</label>
  	      		</div>
  	      		<div class="col-sm-6">
  					<i class="fa fa-user prefix grey-text"></i>
  					<input type="name" id="initials" class="form-control validate">
  					<label data-error="wrong" data-success="right" for="initials">Initials</label>
  	      		</div>
  	        </div>
  	        <div class="md-form mb-3 row">
  	          <div class="col-sm-6">
  	         	 <i class="fa fa-user prefix grey-text"></i>
  	          	<input type="name" id="fname" class="form-control validate">
  	          	<label data-error="wrong" data-success="right" for="fname">First name</label>
  	          </div>
  	          <div class="col-sm-6">
  		          <i class="fa fa-user prefix grey-text"></i>
  		          <input type="name" id="lname" class="form-control validate">
  		          <label data-error="wrong" data-success="right" for="lname">Last name</label>
  	          </div>
  	        </div>

  	        <div class="md-form mb-3 row">
  	        	<div class="col-sm-6">
  					<i class="fa fa-at prefix grey-text"></i>
  					<input type="email" id="email" class="form-control validate">
  					<label data-error="wrong" data-success="right" for="email">email address</label>
  				</div>
  				<div class="col-sm-6">
  					<i class="fa fa-phone-square prefix grey-text"></i>
  					<input type="number" id="cell_number" class="form-control validate">
  					<label data-error="wrong" data-success="right" for="cell_number">cell Number</label>
  				</div>
  	        </div>

  	        <div class="md-form mb-3 row">
  	          <div class="col-sm-6">
  		          <i class="fa fa-home prefix grey-text"></i>
  		          <input type="name" id="home_address" class="form-control validate">
  		          <label data-error="wrong" data-success="right" for="home_address">Home/postal address</label>
  		      </div>
  		      <div class="col-sm-6">
  		          <i class="fa fa-map-pin prefix grey-text"></i>
  		          <input type="name" id="city" class="form-control validate">
  		          <label data-error="wrong" data-success="right" for="city">City</label>
  		      </div>
  	        </div>
  	        <div class="md-form mb-3 row">
  	          <div class="col-sm-6">
  	          	  <i class="fa fa-info prefix grey-text"></i>
  		          <input type="number" id="zip_code" class="form-control validate">
  		          <label data-error="wrong" data-success="right" for="zip_code">Zip code</label>
  	          </div>
  	          <div class="col-sm-6">
  		          <i class="fa fa-gavel prefix grey-text"></i>
  		          <select class="form-control" id="person">
  		          	<option value="Juristic">Juristic</option>
  		          	<option value="Natural">Natural</option>
  		          </select>
  		          <label data-error="wrong" data-success="right" for="person">Person</label>
  	          </div>

  	        </div>

  	      </div>
  	      <div class="modal-footer d-flex justify-content-center">
  	        <button class="btn btn-success" id="add_client">Save</button>
  	      </div>
  	    </form>
      </div>
    </div>
  </div>

  <div class="text-center pt-3">
    <a href="" class="btn btn-tomato-o btn-rounded" data-toggle="modal" data-target="#modalLoginForm">Add Client</a>
  </div>

  <?php
  }
  ?>

  <div class="container">

  		<?php
  			if(sizeof($work->get_clients()) > 0)
  			{

  		?>
  		<div class="row mb-0 ml-4 mr-4">
  			<div class="col-lg-6 mx-auto">

  			</div>
  		<div class="col-lg-6">
  		  <div class="pl-5 py-5">

  		    <!-- Default search bars with input group -->
  		    <form action="">
  		      <div class="input-group mb-1">
  		        <input type="search" placeholder="Search person or company here..." aria-describedby="button-addon5" class="form-control border-tomato">
  		        <div class="input-group-append">
  		          <button id="button-addon5" type="submit" class="btn btn-tomato-o"><i class="fa fa-search"></i></button>
  		        </div>
  		      </div>
  		    </form>
  		    <!-- End -->

  		  </div>
  		</div>
  		</div>
  			<div class="row">
  		<?php
  				foreach($work->get_clients() as $client)
  				{
  		?>

  				<div class="col-2 m-3 folders">
            <a href="work_on_client.php?client_id=<?php print($client['client_id']);?>">
  					<div class="row d-flex justify-content-center">
  						<i class="fa fa-folder-open fa-5x " style="color: #D0BB96;" aria-hidden="true"></i>
  					</div>
  					<?php print($client['client_fname']);?> <?php print("  ".$client['client_lname']);?>
  						<?php
  							$juristic = $work->get_juristic($client['client_id']);
  							if(count($juristic) > 0)
  							{
  						?>
  							<div class="font-italic h6">
  								<?php print($juristic['j_company_name']);?>
  							</div>
  						<?php
  							}
  						?>
  					<div><?php print($work->time_elapsed_string($client['client_dateCreated']));?>
  							<?php
  							$ideas = $work->get_ideas($client['client_id']);
  							$docs = $work->getDocuments($client['client_id']);

  							if($client['client_person'] == "Juristic")
  							{
  								if(count($docs) < 7)
  								{
  								?>
  								<span class="jumbotron rounded-sm py-1 px-2">
  									<i class="fa fa-file-pdf-o text-danger" aria-hidden="true" style="font-size: 100%;"></i> <span class="ml-0 text-white badge badge-danger"><?php print(7- count($docs)); ?></span>
  								</span>

  								<?php
  								}else
  								{
  									if(count($ideas) > 0)
  									{
  									?>
  										<i class="fa fa-check-square-o text-success" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  									}else
  									{
  									?>
  										<i class="fa fa-minus-circle text-danger" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  									}
  								}
  							}

  							if($client['client_person'] == "Natural")
  							{
  								$natural = $work->get_natural($client['client_id']);
  								if($natural['n_marital_status'] == "Married")
  								{
  									if(count($docs) < 2)
  									{
  									?>
  										<span class="jumbotron rounded-sm py-1 px-2">
  											<i class="fa fa-file-pdf-o text-danger" aria-hidden="true" style="font-size: 100%;"></i> <span class="ml-0 text-white badge badge-danger"><?php print(2- count($docs)); ?></span>
  										</span>
  									<?php
  									}else
  									{
  										if(count($ideas) > 0)
  										{
  									?>
  											<i class="fa fa-check-square-o text-success" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  										}else
  										{
  									?>
  											<i class="fa fa-minus-circle text-danger" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  										}

  								}
  								}

  								if($natural['n_marital_status'] == "Single")
  								{

  									if(count($docs) < 2)
  									{
  									?>
  										<span class="jumbotron rounded-sm py-1 px-2">
  											<i class="fa fa-file-pdf-o text-danger" aria-hidden="true" style="font-size: 100%;"></i> <span class="ml-0 text-white badge badge-danger"><?php print(2- count($docs)); ?></span>
  										</span>
  									<?php
  									}else
  									{
  										if(count($ideas) > 0)
  										{
  									?>
  											<i class="fa fa-check-square-o text-success" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  										}else
  										{
  									?>
  											<i class="fa fa-minus-circle text-danger" aria-hidden="true" style="font-size: 120%;"></i>
  									<?php
  										}
  									}
  								}
  							}
  						?>

  					</div>
          </a>
  				</div>


  		<?php
  				}
  			}
  		?>
  	</div>
  </div>
</div>



<?php require 'partials/footer.php';?>