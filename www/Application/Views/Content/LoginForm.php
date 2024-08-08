
<?php
    $loginValue = $request->getProperty('login');
    if($loginValue){
        $loginValidateErrorMassage = Validator::$Massage['login'];
    }
    $passwordValue = $request->getProperty('password');
    if($passwordValue){
        $passwordValidateErrorMassage = Validator::$Massage['password'];
    }
    $massage = $request->getFeedbackString();
?>



<div>    
    <p>Авторизация</p>  
    <form method = "GET" id = "LoginForm" >
        <?php 
        if(!is_null($massage)){
            echo "<label> $massage </label>";
        }
        ?>
        <input  name = "cmd"  type = "hidden" value = "Login"> <br>
        <label> Логин </label> 
        <input  name = "login" type = "text" <?php         
            if(isset($loginValidateErrorMassage)){
                echo "> <label>{$loginValidateErrorMassage}</label>"; 
            }else{
                echo "value ='{$loginValue}'>";
            } 
        ?>
        <br>               
        <label> Пароль </label>
        <input  name = "password" type = "password" <?php   
            if(isset($passwordValidateErrorMassage)){
                echo  "> <label>{$passwordValidateErrorMassage}</label>"; 
            }else{
                echo "value = '{$passwordValue}'>";
            }  
        ?>
        <br> 
        <input  type="submit" value = "Войти">
    </form>   
</div>


        