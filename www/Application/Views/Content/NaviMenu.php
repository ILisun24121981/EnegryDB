<form  method = "POST" id = "NaviMenu" >    
        <?php 
        if($user)
        echo "<label>Пользователь:".$user->getLogin()."</label>";  
        ?>
        <button  name = "cmd" type="submit" value = "Logout">Выйти</button>
</form>
