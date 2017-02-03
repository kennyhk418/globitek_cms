<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    $first_name = "";
    $last_name = "";
    $email = "";
    $username = "";
    if(is_post_request()){
      $first_name = h($_POST['first_name']);
      $last_name = h($_POST['last_name']);
      $email = h($_POST['email']);
      $username = h($_POST['username']);

      $errors = [];
      if(is_blank($first_name))
        $errors[] = "First name cannot be blank";
      elseif(!has_length($first_name,['min' => 2, 'max' => 255]))
        $errors[] = "First name must be between 2 and 255 characters";
      elseif(!preg_match('/\A[A-Za-z\s\-,\.\']+\z/', $first_name))
        $errors[] = "First name must be a valid format";

      if(is_blank($last_name))
        $errors[] = "Last name cannot be blank";
      elseif(!has_length($last_name,['min' => 2, 'max' => 255]))
        $errors[] = "Last name must be between 2 and 255 characters";
      elseif(!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $last_name))
        $errors[] = "Last name must be a valid format";

      if(is_blank($email))
        $errors[] = "Email cannot be blank";
      elseif(!has_length($email,['min' => 2, 'max' => 255]))
        $erors[] = "Email must be between 2 and 255 characters";
      elseif(!has_valid_email_format($email))
        $errors[] = "Email must be a valid format";

      if(is_blank($username))
        $errors[] = "Username cannot be blank";
      elseif(!has_length($username,['min' => 8, 'max' => 255]))
        $errors[] = "Username must be between 8 and 255 characters";
      elseif(!preg_match('/\A[A-Za-z\d\_]+\Z/', $last_name))
        $errors[] = "Username must be a valid format";
      echo display_errors($errors);

      if(empty($errors)){
        //Create date for sql
        $create_at = date("Y-m-d H:i:s");

        $db = new mysqli("localhost","root","","globitek");
        //Check if db connects correctly
        if(db_connect()){
          $unique = "Select * from users where username = '$username' LIMIT 1";
          $existingUser = db_query($db,$unique);
          if(db_num_rows($existingUser) > 0){
            $errors[] = "The username is already in use";
            echo display_errors($errors);
          }//end if existinguser
          else{
            $sql = "INSERT INTO users (first_name,last_name,email,username,create_at)
                  VALUES ('$first_name', '$last_name', '$email','$username', '$create_at')";
            $result = db_query($db,$sql);
            if($result){
              db_close($db);
              redirect_to("./registration_success.php");
            }//end if check result
            else{
              echo db_error($db);
              db_close($db);
              exit;
            }//end else check result
          }//end else existinguser
        }// end if db_connect
      }//end if empty errors
    }// end if post request
  ?>

  <!-- TODO: HTML form goes here -->
  <!DOCTYPE html>
  <html>
  <head>
    <title></title>
  </head>
  <body>
    <form action = "register.php" method = "POST">
      first_name <input type="text" name = "first_name" value ="<?php echo $first_name?>"><br>
      last_name <input type="text" name = "last_name" value = "<?php echo $last_name?>"><br>
      email <input type="text" name = "email" value = "<?php echo $email?>"><br>
      username <input type="text" name = "username" value = "<?php echo $username?>"><br>
      <button type ="submit" value="Submit">Submit</button>
    </form>
  </body>
  </html>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
