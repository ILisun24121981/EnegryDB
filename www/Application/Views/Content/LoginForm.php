
<?php        
    $loginValue = $req->getProperty('login');
    $loginValidateErrorMassage = Validator::$Massage['login'];
    $passwordValue = $req->getProperty('Password');
    $passwordValidateErrorMassage = Validator::$Massage['password'];
    $massage = $req->getFeedbackString();    
?>



<div>    
    <p>Авторизация Саня</p>  
    <form method = "GET" id = "LoginForm" >
        <?php echo "<label> $massage </label>";  ?>
        <input  name = "cmd"  type = "hidden" value = "Login"> <br>
        <label> Логин </label> 
        <input  name = "Login" type = "text" <?php         
            if(!is_null($loginValidateErrorMassage)){
                echo "> <label>{$loginValidateErrorMassage}</label>"; 
            }else{
                echo "value ='{$loginValue}'>";
            } 
        ?>
        <br>               
        <label> Пароль </label>
        <input  name = "Password" type = "password" <?php   
            if(!is_null($passwordValidateErrorMassage)){
                echo  "> <label>{$passwordValidateErrorMassage}</label>"; 
            }else{
                echo "value = '{$passwordValue}'>";
            }  
        ?>
        <br> 
        <input  type="submit" value = "Войти">
    </form>   
</div>


        