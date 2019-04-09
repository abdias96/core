<?php
/**
 * Created by PhpStorm.
 * User: abdiasmunoz
 * Date: 23/02/17
 * Time: 15:10
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="wrapper" class="wrapper">
        <div class="row">
            <div class="col-lg-2">
                <input class="form-control"  name="txtValorE" type="text" value="">
            </div>
        </div>
    </div>
</body>
</html>
<script>
    arr1 = new Array();
    arr1[0] = 0;
    arr1[1] = 0.69;
    arr1[2] = 1.29;
    arr1[3] = 0.99;
    arr1[4] = 1.99;

    $(function(){
        sumt = 0;
        cont = 1;

        while(sumt != 10.03 ){

            var item = arr1[Math.floor(Math.random()*arr1.length)];
            var item1 = arr1[Math.floor(Math.random()*arr1.length)];
            var item2 = arr1[Math.floor(Math.random()*arr1.length)];
            var item3 = arr1[Math.floor(Math.random()*arr1.length)];
            var item4 = arr1[Math.floor(Math.random()*arr1.length)];
            var item5 = arr1[Math.floor(Math.random()*arr1.length)];
            var item6 = arr1[Math.floor(Math.random()*arr1.length)];
            var item7 = arr1[Math.floor(Math.random()*arr1.length)];
            var item8 = arr1[Math.floor(Math.random()*arr1.length)];
            var item9 = arr1[Math.floor(Math.random()*arr1.length)];
            var item10 = arr1[Math.floor(Math.random()*arr1.length)];
            var item11 = arr1[Math.floor(Math.random()*arr1.length)];
            var item12 = arr1[Math.floor(Math.random()*arr1.length)];
            var item13 = arr1[Math.floor(Math.random()*arr1.length)];
            var item14 = arr1[Math.floor(Math.random()*arr1.length)];
            var item15 = arr1[Math.floor(Math.random()*arr1.length)];
            var item16 = arr1[Math.floor(Math.random()*arr1.length)];
            var item17 = arr1[Math.floor(Math.random()*arr1.length)];
            var item18 = arr1[Math.floor(Math.random()*arr1.length)];
            var item19 = arr1[Math.floor(Math.random()*arr1.length)];
            var item20 = arr1[Math.floor(Math.random()*arr1.length)];
            var item21 = arr1[Math.floor(Math.random()*arr1.length)];
            var item22 = arr1[Math.floor(Math.random()*arr1.length)];
            var item23 = arr1[Math.floor(Math.random()*arr1.length)];
            var item24 = arr1[Math.floor(Math.random()*arr1.length)];
            var item25 = arr1[Math.floor(Math.random()*arr1.length)];
            var item26 = arr1[Math.floor(Math.random()*arr1.length)];


            sumt = item+item1+item2+item3+item4+item5+item6+item7+item8+item9+item10+item11+item12+item13+item14+item15+item16+item17+item18+item19+item20+item21+item22+item23+item24+item25+item26;

            if( sumt > 10 && sumt < 10.10){
                console.log(item);
                console.log(item1);
                console.log(item2);
                console.log(item3);
                console.log(item4);
                console.log(item5);
                console.log(item6);
                console.log(item7);
                console.log(item8);
                console.log(item9);
                console.log(item10);
                console.log(item11);
                console.log(item12);
                console.log(item13);
                console.log(item14);
                console.log(item15);
                console.log(item16);
                console.log(item17);
                console.log(item18);
                console.log(item19);
                console.log(item20);
                console.log(item21);
                console.log(item22);
                console.log(item23);
                console.log(item24);
                console.log(item25);
                console.log(item26);
                console.log(sumt);
                console.log("contador");
                console.log(cont);
            }

            cont++;
        }

    });
</script>
