
<?php 
// echo "here";
require('connectdb.php');
// require("login.css");

if(isset($_POST['login_submit'])){
    global $db;

    $uname =  $_POST['txt_uname'];
    $pwd = $_POST['txt_pwd'];
    
    $query = "SELECT user_id, COUNT(*) AS user_cnt FROM users 
                WHERE username = :username AND password = :password
                GROUP BY user_id";
    $statment = $db->prepare($query);
    $statment->bindValue(":username", $uname);
    $statment->bindValue(":password", $pwd);
    $statment->execute();

    $results = $statment->fetch();
    $statment->closecursor();
    $count = $results['user_cnt'];
    if($count > 0){ // maybe should be == 1
        $_SESSION['uname'] = $uname;
        $_SESSION['uid'] = $results['user_id'];
        header('Location: index.php');
    }else{
        echo "Invalid username and password";
    }

    }
?>

<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="login_submit" id="login_submit" />
            </div>
        </div>
    </form>

<form action="create_user.php" method="post">
  <input type="submit" value="Create Account" name="action" class="btn btn-primary" title="Create User" />             
</form> 


</div>