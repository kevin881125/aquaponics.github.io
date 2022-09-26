<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="data.css">
    <title>數據</title>
</head>
<body>
    <div class="nav-top">
        <div class="logo">
            <a>魚菜共生</a>
        </div>
        <ul>
            <li><a href="index.html">首頁</a></li>
            <li><a href="data.php">數據</a></li>
            <li><a href="introduction.html">關於我們</a></li>
        </ul>
    </div>
    <div class="navigation">
        <ul>
            <li class="list active">
                <a href="data.php">
                    <span class="icon">
                        <ion-icon name="podium-outline"></ion-icon>
                    </span>
                    <span class="title">資料</span>
                </a>
            </li>
            <li class="list">
                <a href="temp.php">
                    <span class="icon">
                        <ion-icon name="thermometer-outline"></ion-icon>
                    </span>
                    <span class="title">水溫</span>
                </a>
            </li>
            <li class="list">
                <a href="ph.php">
                    <span class="icon">
                        <ion-icon name="eyedrop-outline"></ion-icon>
                    </span>
                    <span class="title">酸鹼值</span>
                </a>
            </li>
            <li class="list">
                <a href="humi.php">
                    <span class="icon">
                        <ion-icon name="water-outline"></ion-icon>
                    </span>
                    <span class="title">溫/濕度</span>
                </a>
            </li>
            <li class="list">
                <a href="ec.php">
                    <span class="icon">
                        <ion-icon name="flash-outline"></ion-icon>
                    </span>
                    <span class="title">電導度</span>
                </a>
            </li>
            <li class="list">
                <a href="water.php">
                    <span class="icon">
                        <ion-icon name="beaker-outline"></ion-icon>
                    </span>
                    <span class="title">水位</span>
                </a>
            </li>
            <li class="list">
                <a href="do.php">
                    <span class="icon">
                        <ion-icon name="leaf-outline"></ion-icon>
                    </span>
                    <span class="title">溶氧量</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main1">
    <?php

    header('refresh: 300');

    $server = "203.68.61.244";
    $user = "root";
    $pass = "iot12345";
    $db = "009";

    $conn = mysqli_connect( $server, $user, $pass, $db);
    
    $sql = "SELECT Waterlevel, PH, EC, DO,humidity,temp,watertemp, uploadtime ,id FROM allvalue Order by uploadtime desc limit 1";			
    $result = mysqli_query($conn, $sql);
    $chart_data = '';
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        for($i=1;$i<=mysqli_num_rows($result);$i++){ 
            $row=mysqli_fetch_row($result);
            
            $chart_data .="{ 
                uploadtime:'".$row["7"]."',
                Waterlevel:".$row["0"].",
                temp:".$row["5"].",
                humidity:".$row["4"].",						
                PH:".$row["1"].",
                EC:".$row["2"].",
                DO:".$row["3"].",
                watertemp:".$row["6"].", 
                id:".$row["8"]."}, ";	                              
    ?>
    <?php }?>
    <div class="bigbox"></div>
        <div class="box">
            <?php 
                 $sum = 0;
                 $good = 0;
                if($row["1"]<=7.5&&$row["1"]>6.5){
                    $b='<div class="box1"><a>酸鹼值</a><br><br><br><div class="box2">';
                    $b=$b.$row["1"];
                    $b=$b.'</div></div>';
                    echo  $b;
                    $good = $good+1;
                     }
                else{
                    $b='<div class="box1s"><a>酸鹼值</a><br><br><br><div class="box2s">';
                    $b=$b.$row["1"];
                    $b=$b.'</div></div>';
                    echo  $b;
                    $sum=$sum+1;
                    }
                 /*------------------------------------------------------------------*/

                if($row["6"]<40&&$row["6"]>4&&$row["4"]<90&&$row["4"]>60){
                    $d='<div class="tbox1"><a>溫/濕度</a><p>°C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;％</p><br><br><br><div class="tbox2">';
                    $d=$d.$row["6"].'/'.$row["4"];
                    $d=$d.'</div></div>';
                    echo  $d;
                    $good = $good+1;
                    
                     }
                else{
                    $d='<div class="tbox1s"><a>溫/濕度</a><p>°C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;％</p><br><br><br><div class="tbox2s">';
                    $d=$d.$row["6"].'/'.$row["4"];
                    $d=$d.'</div></div>';
                    echo  $d;
                    $sum=$sum+1;
                    }
                       /*------------------------------------------------------------------*/


                if($row["5"]<40&&$row["5"]>=16){
                    $c='<div class="box1"><a>水溫</a><p>&nbsp;&nbsp;˚C</p><br><br><br><div class="box2">';
                    $c=$c.$row["5"];
                    $c=$c.'</div></div>';
                    echo  $c;
                    $good = $good+1;
                     }
                else{
                    $c='<div class="box1s"><a>水溫</a><p>&nbsp;&nbsp;˚C</p><br><br><br><div class="box2s">';
                    $c=$c.$row["5"];
                    $c=$c.'</div></div>';
                    echo  $c;
                    $sum=$sum+1;
                    }
            
                           /*------------------------------------------------------------------*/

                if($row["0"]>=100 ){
                    $a='<div class="box1s"><a>水位</a><br><br><br><div class="wbox2s">水位滿出';
                    $a=$a.'</div></div>';
                    echo  $a;
                    $sum=$sum+1;
                     }
                else  if($row["0"]<100&&$row["0"]>=80 ){
                        $a='<div class="box1"><a>水位</a><br><br><br><div class="wbox2">高水位';
                        $a=$a.'</div></div>';
                        echo  $a;
                        $good = $good+1;
                         }
                else  if($row["0"]<80&&$row["0"]>=35 ){
                        $a='<div class="box1"><a>水位</a><br><br><br><div class="wbox2">正常水位';
                        $a=$a.'</div></div>';
                        $good = $good+1;
                        echo  $a;
                        }
                else  if($row["0"]<35&&$row["0"]>=20 ){
                        $a='<div class="box1"><a>水位</a><br><br><br><div class="wbox2">低水位';
                        $a=$a.'</div></div>';
                        $good = $good+1;
                        echo  $a;
                        }
                else{
                    $a='<div class="box1s"><a>水位</a><br><br><br><div class="wbox2s">馬達空轉';
                    $a=$a.'</div></div>';
                    echo  $a;
                    $sum=$sum+1;
                     
                    }
                        /*------------------------------------------------------------------*/

                if($row["2"]<4&&$row["2"]>0){
                    $d='<div class="box1"><a>EC導電度</a><p>mS/cm</p><br><br><br><div class="box2">';
                    $d=$d.$row["2"];
                    $d=$d.'</div></div>';
                    echo  $d;
                    $good = $good+1;
                     }
                else{
                    $d='<div class="box1s"><a>EC導電度</a><p>mS/cm</p><br><br><br><div class="box2s">';
                    $d=$d.$row["2"];
                    $d=$d.'</div></div>';
                    echo  $d;
                    $sum=$sum+1;
                    }
                        /*------------------------------------------------------------------*/

                if(($row["3"]/1000+2)>4){
                    $d='<div class="box1"><a>DO溶氧量</a><p>mg/L</p><br><br><br><div class="box2">';
                    $d=$d.($row["3"]/1000+2);
                    $d=$d.'</div></div>';
                    echo  $d;
                    $good = $good+1;
                     }
                else{
                    $d='<div class="box1s"><a>DO溶氧量</a><p>mg/L</p><br><br><br><div class="box2s">';
                    $d=$d.($row["3"]/1000+2);
                    $d=$d.'</div></div>';
                    echo  $d;
                    $sum=$sum+1;
                    }
            ?>
        </div>
        <?php echo '<div class="timebox"><div class="box3">&emsp;&emsp;最後更新時間<br>'.$row[7].'<div class="timeline"></div><div class="normal">正常</br>'.$good.'</div><div class="timeline3"></div><div class="bug">異常</br>'.$sum.'</div></div></div>';?>
        
    <?php }?>
    <div class="monitor">
        <img src="http://203.68.61.9:8080/?action=stream" width="760px" height="450px"/> 
    </div>
    </div>
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        const list = document.querySelectorAll('.list');
        function activeLink(){
            list.forEach((item) =>
            item.classList.remove('active'));
            this.classList.add('active');
        }
        list.forEach((item) =>
        item.addEventListener('click',activeLink));
    </script>
</html>