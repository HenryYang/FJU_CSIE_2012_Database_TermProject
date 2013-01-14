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





$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd, "Database"=>"THSR");

$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "SELECT *
FROM guest
";





$stmt = sqlsrv_query( $conn, $tsql);


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH))
{

echo $row[0];
echo $row[1];
echo $row[2];
echo $row[3];
echo $row[4];

}





sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>





</form>
</div>
</body>
</html>