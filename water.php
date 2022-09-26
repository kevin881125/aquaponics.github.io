<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="temp.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
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
            <li class="list">
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
                        <ion-icon name="analytics-outline"></ion-icon>
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
            <li class="list ">
                <a href="humi.php">
                    <span class="icon">
                        <ion-icon name="water-outline"></ion-icon>
                    </span>
                    <span class="title">溫/濕度</span>
                </a>
            </li>
            <li class="list ">
                <a href="ec.php">
                    <span class="icon">
                        <ion-icon name="flash-outline"></ion-icon>
                    </span>
                    <span class="title">電導度</span>
                </a>
            </li>
            <li class="list active">
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
    <table>
        <thead >	
			<tr>
				<th >時間</th></font>
				<th >水位</th></font>
				<th >警示燈</th></font>
			</tr>
		</thead>
    <?php

    header('refresh: 300');

    $server = "203.68.61.244";
    $user = "root";
    $pass = "iot12345";
    $db = "009";

    $conn = mysqli_connect( $server, $user, $pass, $db);
    
    $sql = "SELECT Waterlevel, PH, EC, DO,humidity,temp,watertemp, uploadtime ,id FROM allvalue Order by uploadtime desc limit 100";			
    $result = mysqli_query($conn, $sql);
    $chart_data = '';
    $result = $conn->query($sql);
    $sum =0;

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
				
                <tr >															
						<td style="border:1px solid #000;font-weight:400;" align="center" bgcolor=	#DDDDDD><font size= "5"><?php echo $row["7"];?></td></font>
						<td style="border:1px solid #000;font-weight:400;" align="center" bgcolor=	#DDDDDD><font size= "5"><?php echo $row["0"];?></td></font>
						<?php
							if($row["0"] >= 100){
								echo '<td style="border:1px solid #000;font-weight:400;" align="center" bgcolor=	#FF0000><font size= "5">>1000</td></font>';
                                $sum=$sum+1;
								}
							else if($row["0"] < 20){
								echo '<td style="border:1px solid #000;font-weight:400;" align="center" bgcolor=	#FF0000><font size= "5"><300</td></font>';
                                $sum=$sum+1;
							}else{
								echo '<td style="border:1px solid #000;font-weight:400;" align="center" bgcolor=	#00FF00><font size= "5"></td></font>';
							}
						?>
				</tr> 
                <?php }?>
            <?php }?>
                
   
                
            </table>
    </div>
    <?php
        if($sum==0) 
        {
            echo '<div class="sum">目前沒有錯誤</div>';
        }
        else {
            echo '<div class="sums">今日錯誤'.$sum.'個</div>';
        }
    ?>
      <center>				
			    <div class= "container">
				    <h2 align= "center"> 水位折線圖 </h2>
				        <br /><br />
                    <div class="ofer">
				        <div id ="chart"></div>
                    </div>
			    </div>
			</center>
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
    <script>
	Morris.Line({
		element : 'chart',
		data: [<?php echo $chart_data; ?>],
		xkey:'uploadtime',
		ykeys:['Waterlevel'],
		labels:['Waterlevel'],
		hideHover:'auto',
	});
</script>
</html>