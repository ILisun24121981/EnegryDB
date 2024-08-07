$(document).ready(function () {
   
    
   
    $("body").on("change", "select[name=Company]", function () {      
        $(this).parents('form').submit();
    });
    $("body").on("change", ".departure_region", function () {
    
    
    
    
    
    
    
    
    
    
    
    

    $(".route").change(function () {
        var route_id = $(this).val();
        var dataString = 'route_id=' + route_id;
        $.ajax(
                {
                    type: "POST",
                    url: "show_route_table.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $(".table_box").html(html);
                    }
                }
        );

    });
    $("body").on("change", ".departure_region", function () {
        var $curr_div = $(this).closest("div");
        var $curr_div_set = $(this).closest("td").children("div").children("div");
        var ind = $curr_div_set.index($curr_div);
        $curr_div_set.each(function (indx, element) {
            if (indx > ind) {
                $(element).empty();
            }
            ;
        });

        var region_id = $(this).val();
        var dataString = 'region_id=' + region_id;
        $.ajax(
                {
                    type: "POST",
                    url: "get_districts_by_region.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $("#departure_district").html(html);
                    }
                }
        );
    });
    $("body").on("change", ".departure_district", function () {

        var $curr_div = $(this).closest("div");
        var $curr_div_set = $(this).closest("td").children("div").children("div");
        var ind = $curr_div_set.index($curr_div);
        $curr_div_set.each(function (indx, element) {
            if (indx > ind) {
                $(element).empty();
            }
            ;
        });

        var district_id = $(this).val();
        var dataString = 'district_id=' + district_id;
        //alert(dataString);
        $.ajax(
                {
                    type: "POST",
                    url: "get_cities_by_district.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $("#departure_city").html(html);
                    }
                }
        );
    });
    $("body").on("change", ".departure_city", function () {
        var $curr_div = $(this).closest("div");
        var $curr_div_set = $(this).closest("td").children("div").children("div");
        var ind = $curr_div_set.index($curr_div);
        $curr_div_set.each(function (indx, element) {
            if (indx > ind) {
                $(element).empty();
            }
            ;
        });


        var city_id = $(this).val();
        var dataString = 'city_id=' + city_id;
        //alert(dataString);
        $.ajax(
                {
                    type: "POST",
                    url: "get_points_by_city.php",
                    data: dataString,
                    cache: false,
                    success: function (html) {
                        $("#departure_point").html(html);
                    }
                }
        );
    });
});