<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="jquery.js"></script>
<title>check ticket</title>
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
<body><form action="19.php" method="POST">
<div class="container" style="margin: 0px auto; width: 25%">
	<form class="form-signin">
<?php

$serverName = "127.0.0.1";
$uid = "sa";
$pwd = "@a123";

$pid = $_POST['pid'];
$cellphone = $_POST['cellphone'];


$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "select reservation_number, ticket_date, train_number, start_station, end_station, seat_ID
from ticket_of full outer join ticket on ticket_of.ticket_number=ticket.ticket_number
where reservation_number in(
	select reservation_number
	from reservation
	where guest_ID in(
		select guest_ID
		from guest
		where guest_ID='{$pid}' and phone_mobile='{$cellphone}'))
	and
	reservation_number not in(
	select *
	from reservation_canceled)
";



$stmt = sqlsrv_query( $conn, $tsql);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{

$reservation_number = $row[0];

$start_station = $row[3];
$end_station =$row[4];
$seat_id = $row[5];


echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>訂票查詢結果：</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>訂票代碼：".$row[0]."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>日期：".$row[1]->format('Y-m-d')."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>車次：".$row[2]."</font></b></h4>";
switch ($row[3]){
case "1":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台北</font></b></h4>";
break;

case "2":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：板橋</font></b></h4>";
break;

case "3":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：桃園</font></b></h4>";
break;

case "4":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：新竹</font></b></h4>";
break;

case "5":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台中</font></b></h4>";
break;

case "6":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：嘉義</font></b></h4>";
break;

case "7":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台南</font></b></h4>";
break;

case "8":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：左營</font></b></h4>";
break;

default:
  echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>沒車</font></b></h4>";
}

switch ($row[4]){
case "1":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台北</font></b></h4>";
break;

case "2":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：板橋</font></b></h4>";
break;

case "3":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：桃園</font></b></h4>";
break;

case "4":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：新竹</font></b></h4>";
break;

case "5":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台中</font></b></h4>";
break;

case "6":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：嘉義</font></b></h4>";
break;

case "7":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：台南</font></b></h4>";
break;

case "8":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發站：左營</font></b></h4>";
break;

default:
  echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>沒車</font></b></h4>";
}

$tsql3 = "select car_number, seat_number
from seat
where seat_ID='{$seat_id}'
";
$stmt3 = sqlsrv_query( $conn, $tsql3);


while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_BOTH))
{

$car_seat = $row[0];
$num_seat = $row[1];

}



echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>車廂：".$car_seat."座位：".$num_seat."</font></b></h4>";


$tsql3 = "select price
from price
where station_start='{$start_station}'
	and station_end='{$end_station}'
";
$stmt2 = sqlsrv_query( $conn, $tsql3);


while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_BOTH))
{

$ticket_price = $row[0];


}
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>票價：".$ticket_price."元</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>==================</font></b></h4>";

}




if (empty($reservation_number))
{
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>查無訂票資訊。</font></b></h4>";
echo "</br><a class='btn  btn-primary' href='index.html'><font face='微軟正黑體'><b>回首頁</b></font></a>";
exit();
}

echo "<input type='hidden' name='pid' value='".$reservation_number."'/>";

echo "</br><a class='btn  btn-primary' href='index.html'><font face='微軟正黑體'><b>按此回首頁</b></font></a>";

sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>


</form>
</div>
</body>
</html>