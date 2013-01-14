<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="jquery.js"></script>
<title>page4</title>
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
<body><form action="11.php" method="POST">
<div class="container" style="margin: 0px auto; width: 25%">
	<form class="form-signin">
<?php


$Train_ID = $_POST['Train_ID'];
$reservation_num = $_POST['reservation_num'];
$train_date = $_POST['train_date'];
$station_ID = $_POST['station_ID'];
$station_ID_end = $_POST['station_ID_end'];
$reservation_num = $_POST['reservation_num'];
$ticket_num = $_POST['ticket_num'];
$seat_id = $_POST['seat_id'];
$train_date = $_POST['train_date'];

$pid = $_POST['pid'];
$cellphone = $_POST['cellphone'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$ticket_price = $_POST['ticket_price'];

$serverName = "127.0.0.1";
$uid = "sa";
$pwd = "@a123";

$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");

$conn = sqlsrv_connect( $serverName, $connectionInfo);





$tsql = "begin try insert into guest values ('$pid','$first_name','$last_name','$cellphone','$email')
end try

begin catch update guest
	set name_first='$first_name',
	 name_last='$last_name',
	 phone_mobile='$cellphone',
	 email_address='$email'
	where guest_ID='$pid'
	end catch;

BEGIN TRY
    BEGIN TRANSACTION
insert into ticket values ('$ticket_num','$train_date','$Train_ID','$seat_id','$station_ID','$station_ID_end');
";

for($x=$station_ID ; $x<$station_ID_end ;$x++ ){
$tsql .= "insert into reserved_list values ('$train_date','$Train_ID','$seat_id','$x','$ticket_num');";
}

$tsql .= "
insert into reservation values ('$reservation_num','$pid');
insert into ticket_of values ('$reservation_num','$ticket_num');
    COMMIT TRANSACTION
	select *
	from train
	
end try
begin catch
	select
		ERROR_MESSAGE() AS ErrorMessage;
    if @@trancount>0
        rollback transaction
end catch

";


$tsql1 = "begin try insert into guest values ('$pid','$first_name','$last_name','$cellphone','$email')
end try

begin catch update guest
	set name_first='$first_name',
	 name_last='$last_name',
	 phone_mobile='$cellphone',
	 email_address='$email'
	where guest_ID='$pid'
	end catch;

BEGIN TRY
    BEGIN TRANSACTION
insert into ticket values ('$ticket_num','$train_date','$Train_ID','$seat_id','$station_ID','$station_ID_end');
";

for($x=$station_ID ; $x>$station_ID_end ;$x-- ){
$tsql1 .= "insert into reserved_list values ('$train_date','$Train_ID','$seat_id','$x','$ticket_num');";
}

$tsql1 .= "
insert into reservation values ('$reservation_num','$pid');
insert into ticket_of values ('$reservation_num','$ticket_num');
    COMMIT TRANSACTION
	select *
	from train
	
end try
begin catch
	select
		ERROR_MESSAGE() AS ErrorMessage;
    if @@trancount>0
        rollback transaction
end catch

";




if ($station_ID < $station_ID_end)
{
$stmt =  sqlsrv_query( $conn, $tsql );
}
if  ($station_ID > $station_ID_end)
{
$stmt =  sqlsrv_query( $conn, $tsql1 );
}







$tsql2 = "select *
from ticket
where ticket_number='$ticket_num'
";
$stmt = sqlsrv_query( $conn, $tsql2);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

$fin_tick = $row[0];

}


$tsql3 = "select car_number, seat_number
from seat
where seat_ID='{$seat_id}'
";
$stmt = sqlsrv_query( $conn, $tsql3);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

$car_seat = $row[0];
$num_seat = $row[1];

}








if (empty($fin_tick))
{
echo "ERROR PLEASE RETRY !!! ";
exit();
}
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>恭喜訂票成功，以下為您的購票資訊</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>車票代號：".$fin_tick."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>日期：".$train_date."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>車次：".$Train_ID."</font></b></h4>";


switch ($station_ID){
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


switch ($station_ID_end){
case "1":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：台北</font></b></h4>";
break;

case "2":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：板橋</font></b></h4>";
break;

case "3":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：桃園</font></b></h4>";
break;

case "4":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：新竹</font></b></h4>";
break;

case "5":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：台中</font></b></h4>";
break;

case "6":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：嘉義</font></b></h4>";
break;

case "7":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：台南</font></b></h4>";
break;

case "8":
 echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>目地站：左營</font></b></h4>";
break;

default:
  echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>沒車</font></b></h4>";
}



echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>車廂：".$car_seat."座位：".$num_seat."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>票價：".$ticket_price."元</font></b></h4>";

echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>身分證字號：".$pid."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>手機：".$cellphone."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>名字：".$first_name." ".$last_name."</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>電子信箱：".$email."</font></b></h4>";

echo "</br><a class='btn  btn-primary' href='index.html'><font face='微軟正黑體'><b>按此回首頁</b></font></a>";





?>
</form>
</div>
</body>
</html>