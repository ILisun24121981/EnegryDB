<?php   
    if ($locations){
        echo    '<table>
                    <caption >
                        << Редактирование локации >>';
                    $parentName = $locations->getParentName();
                    if($parentName){
                       echo  ' '.$parentName.'>>'; 
                    }else{
                       echo '>>';
                    }
        echo        '</caption>
                    <thead>
                        <tr>
                          <th scope="col">Номер</th>
                          <th scope="col">Название</th>
                          <th scope="col">Тип</th>
                          <th scope="col">Комментарий</th>
                        </tr>
                    </thead>
                    <tbody>';
        $n = 1;
        while(!is_null($loc = $locations->next())){
            echo        '<tr id ='.$loc->getId().'> 
                            <td id = "number">'.$n.'</td>
                            <td id = "name" value = "'.$loc->getName().'">'.$loc->getName().'</td>
                            <td id = "type">'.$loc->getType().'</td> 
                            <td id = "comment">'.$loc->getComment().'</td> 
                        </tr>';
        $n++;
        }
        echo        '</tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">
                               здесь пагинатор
                            </th>
                        </tr>
                    </tfoot>
                </table>';
    }else{
        echo '<lable> Список локаций пуст </label>';
    } 
?>
