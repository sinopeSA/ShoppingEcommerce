<?php
    require_once 'configuration.php';
    $success_registration_info=0;
    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $p_number = $_POST['p_number'];
        $Password = $_POST['password'];

        $p_number_query = $pdo->prepare("SELECT COUNT(p_number) AS pnumberunique FROM register_table WHERE p_number = :p_number");
        $p_number_query ->execute(array(':p_number' =>$p_number));
        $p_n_u = $p_number_query -> fetch(PDO::FETCH_ASSOC);
        if($p_n_u['pnumberunique'] <1)
        {
            $query =$pdo->prepare("INSERT INTO register_table (user_name,p_number, user_password) VALUES ( :username,:p_number, :user_password)");
            $query ->execute(array(':username' => $name ,
                                    ':p_number' => $p_number,
                                    ':user_password' => $Password ));
            $success_registration_info=1;
        }
        else{
            echo "Registration Fail";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Page</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <form method="post" >
        <div class="sign-up-form">
            <h1>Welcome to ProShop</h1> 
            <h1>Sign Up Now</h1>
            <?php
                if($success_registration_info == 1){
                    echo "<h3 style='color:green; padding-left:15px;'>Registration successful.</h3>";                
                }
               
            ?>
                <div class="fields">
                    <div class="username"><svg class="svg-icon" viewBox="0 0 20 20"><path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                        </svg><input type="text"  name="name" class="user-input" required="required" placeholder="User Name"/></div>
                    <div class="phonenumber"><svg class="svg-icon" viewBox="0 0 20 20"><path d="M13.372,1.781H6.628c-0.696,0-1.265,0.569-1.265,1.265v13.91c0,0.695,0.569,1.265,1.265,1.265h6.744c0.695,0,1.265-0.569,1.265-1.265V3.045C14.637,2.35,14.067,1.781,13.372,1.781 M13.794,16.955c0,0.228-0.194,0.421-0.422,0.421H6.628c-0.228,0-0.421-0.193-0.421-0.421v-0.843h7.587V16.955z M13.794,15.269H6.207V4.731h7.587V15.269z M13.794,3.888H6.207V3.045c0-0.228,0.194-0.421,0.421-0.421h6.744c0.228,0,0.422,0.194,0.422,0.421V3.888z"></path>
						</svg><input type="text" name="p_number" class="phone-input" required="required"placeholder="Phone Number"/></div> 
                    <div class="password"><svg class="svg-icon" viewBox="0 0 20 20"><path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
						</svg><input type="password" name="password" class="pass-input" required="required"placeholder="Password" id="myInput"/></div>
                        <span class="eye" onclick="myFunction()">
                            <i id="hide1" class="fa fa-eye"></i>
                            <i id="hide2" class="fa fa-eye-slash"></i>
                        </span>
                </div>
                <button class="signup-box" name="submit">Register</button><br>
                <h4>Already have an account?<a href="login.php">login</a><h4>
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
