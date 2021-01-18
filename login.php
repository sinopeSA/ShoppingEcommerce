<?php
    session_start();
    require_once 'configuration.php';

    if(isset($_POST['submit']))
    {
        $name = $_POST['user_name'];
        $password = $_POST['password'];

        $user_name_query = $pdo->prepare("SELECT * FROM register_table WHERE user_name = :user_name");
        $user_name_query ->execute(array(':user_name' => $name));
        $u_n_q = $user_name_query -> fetch(PDO::FETCH_ASSOC);

        if($u_n_q['user_name'] == $name)
        {
            if($u_n_q['user_password'] == $password)
            {
            
                $_SESSION['u_name'] = $name;
                header("Location: homepage.php");
            }
            else
            {
                echo "Password Incorrect";
            }
        }
        else
        {
            echo "User name Incorrect";
        }
    }

?>


<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>
<body>
        <form action = "login.php" method="post">
            <div class="login-form">
                    <h1>Get Started...</h1>
                    <h1>Enter Credentials </h1>
                    <div class="fields">
                        <div class="username"><svg class="svg-icon" viewBox="0 0 20 20"><path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                            </svg><input type="text"  name="user_name" class="user-input" required="required" placeholder="User Name"/></div>
                        <div class="password"><svg class="svg-icon" viewBox="0 0 20 20"><path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
                            </svg><input type="password" name="password" class="pass-input" required="required"placeholder="Password"id="myInput"/></div>
                            <span class="eye" onclick="myFunction()">
                                <i id="hide1" class="fa fa-eye"></i>
                                <i id="hide2" class="fa fa-eye-slash"></i>
                            </span>
                    </div>
                    <button type="submit"  name="submit" class="login-box" >Login</button>
                    <h4>Don't have an account yet?<a href="index.php">Sign Up</a><h4>
            </div>

    </form>
            <script>
                function myFunction(){
                    var x = document.getElementById("myInput");
                    var y = document.getElementById("hide1");
                    var z = document.getElementById("hide2");

                    if(x.type === 'password')
                    {
                        x.type = "text";
                        y.style.display = "block";
                        z.style.display = "none";
                    }
                    else{
                        x.type = "password";
                        y.style.display = "none";
                        z.style.display = "block";
                    }
                }
            </script>
    </body>

</html>

