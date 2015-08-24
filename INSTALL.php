<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Install ShoppingList</title>
  </head>
  <body>
    <div class="row">
      <div class="col-md-4 col-md-offset-5">  
      <?php
      //Start on submit form
        if(isset($_POST['createConfig']))
        {
          //set vars
          //hash api key with bcrypt
          $apikey = password_hash($_POST['apikey'], PASSWORD_BCRYPT);
          $dbtype = $_POST['type'];
          $dbhost = $_POST['hostname'];
          $dbname = $_POST['database'];
          $dbuser = $_POST['dbuser'];
          $dbpassword = $_POST['dbpassword'];
          
          //create config file value
          $config = '
<?php
  $authKey = \''.$apikey.'\';

  $dataBase = "'.$dbtype.'";
  //only for SQLite
  $SQLiteConfig = [
    \'file\' => "shoppinglist.sqlite",
  ];
  //only for MySQL
  $MySQLConfig = [
    \'host\' => "'.$dbhost.'",
    \'db\' => "'.$dbname.'",
    \'user\' => "'.$dbuser.'",
    \'password\' => "'.$dbpassword.'",
  ];
?>';
      
          //mysql dump
          $dbdump = "
            CREATE TABLE ShoppingList (
            item VARCHAR(255),
            count VARCHAR(255),
            RID int(11) NOT NULL auto_increment,
            primary KEY (RID))
            ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci;";


          //try to open/create config.php file
          //success: write config value
          //error: message and get out config.php value
          if($handler = fopen('config.php', 'w')) {
      
            fwrite($handler, $config);
            fclose($handler);      
          }
          else
          {
            echo <<<EOCONFIG
                <h2>Config.php</h2>
                <div class="alert alert-danger" role="alert">It was not possible to create the config.php file. Please copy the code and paste it in the file.</div>
                <div class="form-group">
                  <label for="msg_config">config.php</label>
                  <textarea class="form-control" rows="15" min-height="300px" id="msg_config">
                    {$config}
                  </textarea>
  
EOCONFIG;
          }
        //when DB Type MySQL create table    
        if($dbtype == "MySQL")
        {
          $handler = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
          
          //check if connection successful
          if ($handler->connect_error) {
          	die('
          <div class="alert alert-danger" role="alert">
            No Connection to your Database. Please correct your Informations!
          </div>	
          	');
          }
          
          //prepare query
          $stmt = $handler->prepare($dbdump);
          
          //execute query and check if successful
          if ($stmt->execute())
            echo '<div class="alert alert-success" role="alert">All done! Please delete the INSTALL.php file!</div>';
          else 
            echo '<div class="alert alert-danger" role="alert">
            There was an Error in the MySQL Statment!
          </div>';
          
          //close connection
          $stmt->close();
        }
        else
        {
          echo '<div class="alert alert-success" role="alert">All done! Please delete the INSTALL.php file!</div>';
        }
        }
        else
        {
      ?>
    <script>
jQuery(document).ready(function(){
          jQuery('#type').change(function(){
              if(jQuery('#type').val() == 'SQLite') {
                  jQuery('#MySQL').hide(); 
              } else {
                  jQuery('#MySQL').show(); 
              } 
          });
    	jQuery('#createDBUser').change(function(){
        	if(this.checked)
            		$('#createDBMessage').show();
        	else
          		$('#createDBMessage').hide();

    	});
		     

	});
    </script>
    <h2>Install ShoppingList Database</h2>
    <h2><small>API Key</small></h2>
    <form class="form-inline" action="INSTALL.php" method="post">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-key"></i></div>
          <input type="password" class="form-control" name="apikey" placeholder="API Key" size="35">
        </div>
      </div>
      
    <h2><small>Database Setup</small></h2>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-database"></i></div>
    <select class="form-control" id="type" name="type">
      <option value="MySQL" selected>MySQL</option>
      <option value="SQLite">SQLite</option>
    </select>
        </div>
      </div><br style="font-size:5px"/>
    <div id="MySQL">
	    <h3><small><input type="checkbox" name="createDBUser" id="createDBUser" />&nbsp;Do you want to create a user and database for that App? </small></h3>
		<div class="alert alert-info" role="alert" id="createDBMessage" style="display:none;">Please fill the form with your root MySQL data. After this installation this data will delete and the app will ta    ke the new created user for the operations.</div>

      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-globe"></i></div>
          <input type="text" class="form-control" name="hostname" placeholder="Host" size="35">
        </div>
      </div><br /><br style="font-size:5px"/>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-database"></i></div>
          <input type="text" class="form-control" name="database" placeholder="Database Name" size="35">
        </div>
      </div><br /><br style="font-size:5px"/>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-user"></i></div>
          <input type="text" class="form-control" name="dbuser" placeholder="Database User" size="35">
        </div>
      </div><br /><br style="font-size:5px"/>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-key"></i></div>
          <input type="password" class="form-control" name="dbpassword" placeholder="Database Password" size="35">
        </div>
      </div>
    </div><br /><br style="font-size:5px"/>
    <small>This Step will write the config in the config.php file. When the script have no write access it will display the value of the config.php. You must copy then this value and put it by yourself in the config.php. The script also create the table with the SQL Dump.</small><br ><br >
    <button type="submit" class="btn btn-primary" name="createConfig"> Create </button></div>
    </form>
    </div>

    </div>
<?php
}
?>
  </body>
</html>
