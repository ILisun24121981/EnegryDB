<?php
    if($request->get('cmd') != 'LocationCreateForm'){
        $loginValue = $request->get('name');
        if($loginValue){
            $nameValidateErrorMassage = Validator::getMassage('login');
        }
        $commentValue = $request->get('comment');
        if($passwordValue){
            $commentValidateErrorMassage = Validator::getMassage('password');
        }
        $massage = $request->getFeedbackString();
        $commentValue = $request->get('comment');
    }
?>

<p>Добавление локации</p>  
<form method = "POST" id = "locationCreateForm" >
    <?php echo "<label> $massage </label>"; ?>
    
    <label> Локация Родитель </label> 
      
    <label> Название </label> 
    <input  name = "name" type = "text" <?php
    if(isset($nameValidateErrorMassage)){
        echo "> <label>{$nameValidateErrorMassage}</label>"; 
    }else{
        if($request->get('cmd') != 'Logout'){
            echo "value ='{$nameValue}'>";
        }else{
            echo ">";
        }
    } 
    ?>
    <br>               
    <label> Коментарий </label>
    <input  name = "comment" type = "text" <?php
    if(isset($commentValidateErrorMassage)){
        echo "> <label>{$commentValidateErrorMassage}</label>"; 
    }else{
        if($request->get('cmd') != 'Logout'){
            echo "value ='{$commentValue}'>";
        }else{
            echo ">";
        }
    } 
    ?>
    <br> 
    <button  name = "cmd" type="submit" value = "LocationCreate">Создать</button>
</form>   
