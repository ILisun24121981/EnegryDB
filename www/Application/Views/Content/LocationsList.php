  
<?php 

    $locations= $user->getLocationsCollection();
    
    if ($locations){
        echo    '<table>
                    <caption>
                        <<Список локаций';
                    $parentName = $locations->getParentLocationName();
                    if($parentName){
                       echo  'в составе'.$parentName.'>>'; 
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
                            <td>'.$n.'</td>
                            <td>'.$loc->getName().'</td>
                            <td>'.$loc->getType().'</td> 
                            <td>'.$loc->getComment().'</td> 
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

