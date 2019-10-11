<?php 
	include('dbconnect.php');
	




 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $pwd = trim($_POST["password"]);

    }
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement

        $sql = "SELECT user_id,email,password FROM user_info WHERE email = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;
            echo $pwd;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    
                    // Bind result variables
                    echo $pwd;
                    mysqli_stmt_bind_result($stmt, $user_id, $email, $password);
                    if(mysqli_stmt_fetch($stmt)){

                        if(password_verify($pwd, $password)){
                            echo 90;
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["logged-in"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;  

                            // Redirect user to welcome page
                            header("location: profile.php");
                        } else{
                            echo 'pppppppppppppppppp';
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    // $email_err = "No account found with that username.";
                echo 'no===============t';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);

        }
        
        // Close statement
    }
    
    // Close connection
    mysqli_close($conn);
    echo "Oops! Something went wrong. Please try again later.";

}

echo "Oops! Something went wrong. Please try again later.";

 ?>