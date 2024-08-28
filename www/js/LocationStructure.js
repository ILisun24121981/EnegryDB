$(document).ready(function (){
    $("tbody").children("tr").hover(
        function(){
        $(this).css('background-color', '#e8edff')
        },
        function(){
        $(this).css('background-color', '')        
        }
    );
    $("tbody").on('click',"tr",function(){
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected').css('background-color', '');
            $("tbody").children("tr").hover(
                function(){
                $(this).css('background-color', '#e8edff')
                },
                function(){
                $(this).css('background-color', '')        
                }
            );            
            $('#Create').attr('hidden',false);
            $('#Open').attr('hidden',true);
            $('#Edit').attr('hidden',true);
            $('#Delete').attr('hidden',true);
            
        }else{
            $(this).parent("tbody").children(".selected").removeClass('selected').css('background-color', '');
            $(this).addClass('selected');
            $(this).css('background-color', '#e8edff');            
            $(this).parent("tbody").children("tr").off( "mouseenter mouseleave" ); 
            $('#Create').attr('hidden',true);
            var name = $(this).children('#name').attr('value');
            $('#Open').children('[name = "name"]').attr('value',name);
            $('#Open').attr('hidden',false).children('[name = "id"]').attr('value',$(this).attr('id'));
            $('#Edit').attr('hidden',false).children('[name = "id"]').attr('value',$(this).attr('id'));
            $('#Delete').attr('hidden',false).children('[name = "id"]').attr('value',$(this).attr('id'));           
        }                   
    });   
});
