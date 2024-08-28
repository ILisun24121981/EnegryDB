
<?php
    if($request->get('cmd') != 'Logout'){
        $loginValue = $request->get('login');
        if($loginValue){
            $loginValidateErrorMassage = Validator::getMassage('login');
        }
        $passwordValue = $request->get('password');
        if($passwordValue){
            $passwordValidateErrorMassage = Validator::getMassage('password');
        }
        $massage = $request->getFeedbackString();
    }
?>



<div>    
    <p>Авторизация</p>  
    <form method = "POST" id = "LoginForm" >
        <?php 
        if(isset($massage) && !is_null($massage)){
            echo "<label> $massage </label>";
        }
        ?>
        <label> Логин </label> 
        <input  name = "login" type = "text" <?php         
            if(isset($loginValidateErrorMassage)){
                echo "> <label>{$loginValidateErrorMassage}</label>"; 
            }else{
                if($request->get('cmd') != 'Logout'){
                    echo "value ='{$loginValue}'>";
                }else{
                    echo ">";
                }
            } 
        ?>
        <br>               
        <label> Пароль </label>
        <input  name = "password" type = "password" <?php   
            if(isset($passwordValidateErrorMassage)){
                echo  "> <label>{$passwordValidateErrorMassage}</label>"; 
            }else{
                if($request->get('cmd') != 'Logout'){
                    echo "value = '{$passwordValue}'>";
                }else{
                    echo "value = ''>";
                }
            }  
        ?>
        <br> 
        <button  name = "cmd" type="submit" value = "Login">Войти</button>
    </form>   
</div>


        