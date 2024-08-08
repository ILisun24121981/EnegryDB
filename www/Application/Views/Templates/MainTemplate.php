<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Главная страница</title>
        <link href="css/maket.css" rel="stylesheet" type="text/css">
        <?php
        if(!empty($css)){
            foreach ($css as $num => $cssFile){
                echo '<link href=css/"'.$cssFile.'" rel="stylesheet" type="text/css">';
            }
        }
        ?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <?php
        if(!empty($js)){
            foreach ($js as $num => $jsFile){
                echo '<script type="text/javascript" src="js/'.$jsFile.'"></script>';
            }
        }
        ?>
    </head>
    
    <?php
    require_once 'core/ObjectWatcher.php';
    $userParams = SessionRegistry::getUserParams();
    if(Empty($userParams)){ 
        $user = ObjectWatcher::exists('Admin', $userParams['id']);
    }
    ?>  
    <body>
         <div id="header">
            <?php
            include 'Views/Content/Header.php';
            ?>
        </div>
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