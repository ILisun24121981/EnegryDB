<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Главная страница</title>
        <link href="css/maket.css" rel="stylesheet" type="text/css">    
    </head>
        
    <body>       
        <div id="container"> 
            <?php
                foreach ($content as $destination => $content){
                    echo "<div id=".$destination.">";
                    foreach ($content as $content) {                   
                        include 'Views/Content/' . $content;
                    }
                    echo "</div>";
                }
            ?>            
        </div>
        <div id="clear"></div>
        <div id="footer">
            <?php
            include 'Views/Content/footer.php';
            ?>
        </div>  
    </body>
    

</html>