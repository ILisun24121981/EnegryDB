
 <?php 
    $parentId = $locations->getParentId();
    if($userRole != User::role('TECHNICIAN')){       
     echo ' <form method = "GET" id = "Create" >
                <input  name = "parent_id" value = "'.$parentId. '" hidden>               
                <button name = "cmd" value = "LocationCreateForm" type="submit">Создать</button>';
    if($locations->getParentId() && $locations->getParentId()!=1){
        echo ' <form method = "GET" id = "Back" >
                <input  name = "id" value = "'.$parentId. '" hidden>               
                <button name = "cmd" value = "LocationStructureBack" type="submit">Назад</button> <br>';
    }else{        
             
        echo '<br>';
    }
    echo   '</form>
            <form method = "GET" id = "Open" hidden>
                <input  name = "name" value ="0" hidden>
                <input  name = "id" value = "0" hidden>               
                <button  name = "cmd" value = "LocationStructure" type="submit" " >Открыть</button> <br>       
            </form>
             <form method = "GET" id = "Edit" hidden>
                <input  name = "id" value = "0" hidden>               
                <button  name = "cmd" value = "LocationEdit" type="submit" " >Редакировать</button> <br>       
            </form>
             <form method = "GET" id = "Delete" hidden>
                <input  name = "id" value = "0" hidden>               
                <button name = "cmd" value = "LocationCreate" type="submit" " >Удалить</button> <br>                            
            </form>';
    }
    
 ?> 

