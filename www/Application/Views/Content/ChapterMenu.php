<p> Разделы </p>   
<form method = "GET" id = "ChapterMenu" >
    <?php 
    echo'<button  name = "cmd" type="submit" value = "Items">Номенклатура</button>
         <button  name = "cmd" type="submit" value = "Parts">Склад</button>';

    if($user->getRoleId() == User::role('SUPERUSER')){
        echo '<button  name = "cmd" type="submit" value = "Users">Пользователи</button>
              <button  name = "cmd" type="submit" value = "Locations">Локации</button>';
    }
    ?>  
</form>



