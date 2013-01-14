<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="jquery.js"></script>
		
	
<title>查詢車次</title>

 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
		
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.png">
  


  
</head>
<body><form action="9.php" method="POST">
 <div class="container" style="margin: 0px auto; width: 25%">
	<form class="form-signin">
<h2 class="form-signin-heading">請選搭乘車次：</h2>
<?php
// 以 SQL Server 2005 Driver for PHP 連接 SQL Server AdventureWorks 資料庫（Windows 驗證）
// 指定伺服器名稱
$serverName = "127.0.0.1";



$uid = "sa";

$pwd = "@a123";




// 指定連接字串的資料庫名稱
$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");
 
// 連接資料庫
$conn = sqlsrv_connect( $serverName, $connectionInfo);
 
// 檢查資料庫的連接是否成功，若 $conn 為 false，表示連接失敗
if( $conn === false )
{
    echo "無法連接伺服器 ".$serverName." 裡的資料庫，錯誤訊息如下：</br></br>";
    die( print_r( sqlsrv_errors(), true));
}
 
$train_date = $_POST['train_date'];
$station_ID = $_POST['station_ID'];
$depart_time = $_POST['depart_time'];
$station_ID_end = $_POST['station_ID_end'];



// 定義查詢的 SQL statement
$tsql = "select distinct top 10 A.train_number, A.depart_time, B.depart_time as arrive_time
from train_stop_at as A left outer join train_stop_at as B on A.train_number=B.train_number
where A.train_number in(
		select A.train_number
		from train_stop_at as S
		where
			exists((
				select distinct seat_ID
				from seat)
				except(
					select distinct T.seat_ID
					from reserved_list as T
					where train_date='{$train_date}' 
						and S.train_number = T.train_number)))
		and A.station_ID='{$station_ID}'
		and B.station_ID='{$station_ID_end}'
		and A.depart_time>='{$depart_time}'
		and A.train_number in(
			select train_number
			from train
			where start_station<end_station)
		or A.train_number in(
			select train_number
			from train_stop_at as S
			where
			exists((
				select distinct seat_ID
				from seat)
				except(
					select seat_ID
					from reserved_list as T
					where S.train_number=T.train_number
					and station_ID between {$station_ID} and ({$station_ID_end}-1)
					and train_date='{$train_date}')))
		and A.station_ID='{$station_ID}'
		and B.station_ID='{$station_ID_end}'
		and A.depart_time>='{$depart_time}'
		and A.train_number in(
			select train_number
			from train
			where start_station<end_station)
	order by A.depart_time asc;
";

$tsql2 = "select distinct top 10 A.train_number, A.depart_time, B.depart_time as arrive_time
from train_stop_at as A left outer join train_stop_at as B on A.train_number=B.train_number
where A.train_number in(
		select A.train_number
		from train_stop_at as S
		where
			exists((
				select distinct seat_ID
				from seat)
				except(
					select distinct T.seat_ID
					from reserved_list as T
					where train_date='{$train_date}' 
						and S.train_number = T.train_number)))
		and A.station_ID='{$station_ID}'
		and B.station_ID='{$station_ID_end}'
		and A.depart_time>='{$depart_time}'
		and A.train_number in(
			select train_number
			from train
			where start_station>end_station)
		or A.train_number in(
			select train_number
			from train_stop_at as S
			where
			exists((
				select distinct seat_ID
				from seat)
				except(
					select seat_ID
					from reserved_list as T
					where S.train_number=T.train_number
					and station_ID between ({$station_ID_end}+1) and {$station_ID}
					and train_date='{$train_date}')))
		and A.station_ID='{$station_ID}'
		and B.station_ID='{$station_ID_end}'
		and A.depart_time>='{$depart_time}'
		and A.train_number in(
			select train_number
			from train
			where start_station>end_station)
	order by A.depart_time asc;
";

 
// 執行查詢

if ($station_ID < $station_ID_end)
{
$stmt = sqlsrv_query( $conn, $tsql);
}
else if ($station_ID > $station_ID_end)
{
$stmt = sqlsrv_query( $conn, $tsql2);
}
else
{
echo "起迄站無法相同，請重新查詢";
echo "</br><a class='btn  btn-primary' href='8.html'><font face='微軟正黑體'><b>回上頁</b></font></a>";
exit();
}


// 檢查查詢是否成功
/**
if ( $stmt )
{
    echo "已執行 SQL 查詢：".$tsql."</br></br>";
    echo "結果如下：<br><br>";
} 
else 
{
    echo "查詢 ".$tsql." 失敗，錯誤訊息如下：</br></br>";
    die( print_r( sqlsrv_errors(), true));
}
 **/
// 以迴圈顯示查詢結果（資料列）
$i = 0;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	$depart_hr	= (int)($row[1]/60);
	$depart_min	= $row[1]%60; 
	$arrive_hr	= (int)($row[2]/60);
	$arrive_min	= $row[2]%60;
	$train_time_hr  = (int)(($row[2]-$row[1])/60);
	$train_time_min = ($row[2]-$row[1])%60;
	
	if($train_date == "")
	{
	echo "未選擇日期，請重新查詢";
	echo "</br><a class='btn  btn-primary' href='8.html'><font face='微軟正黑體'><b>回上頁</b></font></a>";
	exit();
	}
	
	if($station_ID == $station_ID_end)
	{
	echo "起迄站無法相同，請重新查詢";
	echo "</br><a class='btn  btn-primary' href='8.html'><font face='微軟正黑體'><b>回上頁</b></font></a>";
	exit();
	}
    echo "<input type='radio' name='Train_ID' value='".$row[0]."'".(($i==0)?"CHECKED":"")."></input>";
	$i++;
    echo "   ".$row[0]." 車次</br>   出發時間：".(($depart_hr>9)?$depart_hr:"0".$depart_hr).":".(($depart_min>9)?$depart_min:"0".$depart_min)."   到達時間：".(($arrive_hr>9)?$arrive_hr:"0".$arrive_hr).":".(($arrive_min>9)?$arrive_min:"0".$arrive_min)."   行駛時間：".$train_time_hr.":".(($train_time_min>9)?$train_time_min:"0".$train_time_min)."</br>";
    echo "</br>";
	
	
	
}
if($i==0){
	echo "無班次";
}
$reservation_num = "";

for ($i = 0; $i <15; $i++)
{
	$reservation_num .= rand(0,9); 
}

echo "<input type='hidden' name='reservation_num' value='".$reservation_num."'/>";
echo "<input type='hidden' name='train_date' value='".$train_date."'/>";
echo "<input type='hidden' name='station_ID' value='".$station_ID."'/>";
echo "<input type='hidden' name='station_ID_end' value='".$station_ID_end."'/>";



 
// 釋放查詢及連接資源
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
?>

<input class="btn btn-primary" type="submit">
</form>
</div>


</body>
</html>