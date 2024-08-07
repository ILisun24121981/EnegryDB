<p> Основное меню </p>   
<form method = "GET" id = "NavigateMenu" >
    <?php 
    if($user == null){
               
    }else{
    echo'<button  name = "cmd" type="submit" value = "Items">Номенклатура</button>
         <button  name = "cmd" type="submit" value = "Parts">Склад</button>';
    
        if($user->getroleId() = User::role('SUPERUSER')){
            echo '<button  name = "cmd" type="submit" value = "Users">Пользователи</button>
                  <button  name = "cmd" type="submit" value = "Locations">Локации</button>';
        }
    }
    ?>  
</form>



