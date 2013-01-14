<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<title>page3</title>
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
<body><form  id ="nextpage" action="10.php" method="POST">
 <div class="container" style="margin: 0px auto; width: 25%">
	<form class="form-signin">
<?php

$serverName = "127.0.0.1";
$uid = "sa";
$pwd = "@a123";

$Train_ID = $_POST['Train_ID'];
$reservation_num = $_POST['reservation_num'];
$train_date = $_POST['train_date'];
$station_ID = $_POST['station_ID'];
$station_ID_end = $_POST['station_ID_end'];




$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "select top 1 seat_ID
from seat
where seat_ID in((
	select seat_ID
	from seat)
	except(
		select seat_ID
		from reserved_list
		where train_date='{$train_date}'
			and train_number = '{$Train_ID}'))
	or
	seat_ID not in(
		select seat_ID
		from reserved_list
		where train_number='{$Train_ID}'
			and station_ID between {$station_ID} and ({$station_ID_end}-1)
			and train_date='{$train_date}')
order by NEWID()
";

$tsql2 = "select top 1 seat_ID
from seat
where seat_ID in((
	select seat_ID
	from seat)
	except(
		select seat_ID
		from reserved_list
		where train_date='{$train_date}'
			and train_number = '{$Train_ID}'))
	or
	seat_ID not in(
		select seat_ID
		from reserved_list
		where train_number='{$Train_ID}'
			and station_ID between ({$station_ID_end}+1) and {$station_ID}
			and train_date='{$train_date}')
order by NEWID()
";


if ($station_ID < $station_ID_end)
{
$stmt = sqlsrv_query( $conn, $tsql);
}
if  ($station_ID > $station_ID_end)
{
$stmt = sqlsrv_query( $conn, $tsql2);
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
$seat_id = $row[0];
echo " ";

}

if (empty($seat_id))
{
echo "訂票流程發生錯誤 A System Error Occurred";
exit();
}

$tsql = "select depart_time
from train_stop_at
where train_number='{$Train_ID}' and station_ID={$station_ID}
";

$stmt = sqlsrv_query( $conn, $tsql);
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>請確認您所選擇的車次</font></b></h4>";
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>日期：".$train_date."</font></b></h4>";

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	$depart_hr	= (int)($row[0]/60);
	$depart_min	= $row[0]%60;
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>出發時間：".$depart_hr.":".(($depart_min>9)?$depart_min:"0".$depart_min)."</font></b></h4>";	

}


$tsql = "select depart_time
from train_stop_at
where train_number='{$Train_ID}' and station_ID={$station_ID_end}
";

$stmt = sqlsrv_query( $conn, $tsql);

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	$depart_hr	= (int)($row[0]/60);
	$depart_min	= $row[0]%60;
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>到站時間：".$depart_hr.":".(($depart_min>9)?$depart_min:"0".$depart_min)."</font></b></h4>";	

}

$ticket_num = "";

for ($i = 0; $i <13; $i++)
{
	$ticket_num .= rand(0,9); 
}




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



$tsql3 = "select price
from price
where station_start='{$station_ID}'
	and station_end='{$station_ID_end}'
";
$stmt = sqlsrv_query( $conn, $tsql3);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

$ticket_price = $row[0];


}
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>票價：".$ticket_price."元</font></b></h4>";




echo "<input type='hidden' name='reservation_num' value='".$reservation_num."'/>";
echo "<input type='hidden' name='ticket_num' value='".$ticket_num."'/>";
echo "<input type='hidden' name='train_date' value='".$train_date."'/>";
echo "<input type='hidden' name='Train_ID' value='".$Train_ID."'/>";
echo "<input type='hidden' name='station_ID' value='".$station_ID."'/>";
echo "<input type='hidden' name='station_ID_end' value='".$station_ID_end."'/>";
echo "<input type='hidden' name='seat_id' value='".$seat_id."'/>";
echo "<input type='hidden' name='ticket_price' value='".$ticket_price."'/>";





sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>

<script >
$(document).ready(function(){
	$('#submit2').click(function(){
	if($('#pid').val()=='' || $('#cellphone').val()=='' || $('#last_name').val()=='' || $('first_name').val()=='' || $('#email').val()=='') {
		alert('請把資料填寫完整');
		
	}
	else
	{
	$('#nextpage').submit();
	}
	});
});


</script>


<label for="pid" ><font face="微軟正黑體"><b>身分證字號：</font></b></label>
<input type="text" id="pid" name="pid" maxlength="10"  /><br />
<label for="cellphone" ><font face="微軟正黑體"><b>手機號碼：</font></b></label>
<input type="text" id="cellphone" name="cellphone" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /><br />
<label for="first_name" ><font face="微軟正黑體"><b>姓：</font></b></label>
<input type="text" id="first_name" name="first_name" maxlength="5" ><br />
<label for="last_name" ><font face="微軟正黑體"><b>名：</font></b></label>
<input type="text" id="last_name" name="last_name" maxlength="5" /><br />
<label for="email" ><font face="微軟正黑體"><b>電子信箱：</font></b></label>
<input type="text" id="email" name="email" maxlength="40" /><br />

<input id="submit2" class="btn btn-primary" type="button" value="送出" />

</form>
</div>
</body>
</html>