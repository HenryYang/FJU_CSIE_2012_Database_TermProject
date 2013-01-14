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
<body><form action="10.php" method="POST">
<div class="container" style="margin: 0px auto; width: 25%">
	<form class="form-signin">
<?php

$serverName = "127.0.0.1";
$uid = "sa";
$pwd = "@a123";

$pid = $_POST['pid'];



$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "begin try
	begin transaction
		delete
		from reserved_list
		where ticket_number in(
			select ticket_number
			from ticket_of
			where reservation_number='{$pid}');
	
		insert into reservation_canceled values ('{$pid}');
		commit transaction
	end try
begin catch
	select
		ERROR_MESSAGE() AS ErrorMessage;
    if @@trancount>0
        rollback transaction
end catch
";

$tsql2 = "select *
from reservation
where reservation_number='{$pid}'
	and reservation_number not in(
		select reservation_number
		from reservation_canceled);";

$stmt = sqlsrv_query( $conn, $tsql2);

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

$check_result = $row[0];

}

if (empty($check_result)){
echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>查詢結果：無效的訂位代碼。</b></font></h4>";
echo "</br><a class='btn  btn-primary' href='index.html'><font face='微軟正黑體'><b>按此回首頁</b></font></a>";
exit();
}

$stmt = sqlsrv_query( $conn, $tsql);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

$check_result = $row[0];

/*echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>訂票查詢結果：</font></b></h4>";
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

echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>座位：".$row[5]."</font></b></h4>";*/
}

echo "<h4 class='form-signin-heading'><font face='微軟正黑體'><b>查詢結果：指令操作完成。</b></font></h4>";
echo "</br><a class='btn  btn-primary' href='index.html'><font face='微軟正黑體'><b>按此回首頁</b></font></a>";

sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>

</form>
</div>
</body>
</html>