<html>
<script src="http://stefanpleava.com/hackthenorth/scripts/globalvariables.js"></script>
<script src="http://stefanpleava.com/hackthenorth/includes/jquery/jquery-2.1.0.min.js"></script>
<script src="http://stefanpleava.com/hackthenorth/includes/Chart.js-master/Chart.js"></script>
<script src="http://stefanpleava.com/hackthenorth/scripts/parsingscripts.js"></script>
<script src="http://stefanpleava.com/hackthenorth/includes/errorcheck.js"></script>

 <head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="generator" content="7.3.5.244"/>
  <title>WATiSPEND | My Account</title>
  <!-- CSS -->

  <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="/hackthenorth/layout/css/site_global.css?4023935739"/>
  <link rel="stylesheet" type="text/css" href="/hackthenorth/layout/css/main.css?3962422351" id="pagesheet"/>
  <style type="text/css">
  #helplink {
    color: red;
  }
  div {
    font-family: 'Montserrat', sans-serif;
  }
  body {
    color: #434343;
  }
  </style>
  <!-- Other scripts -->
  <script type="text/javascript">
   document.documentElement.className += ' js';
   
</script>
<?php
$username = $_POST[acnt_1]; //the quest ID of the user
$password = $_POST[acnt_2]; //the pin number of the user
$url = "https://account.watcard.uwaterloo.ca/watgopher661.asp"; //the ASP that 
$curDate = date("m/d/Y");
$d=strtotime("-13 days");
$oldDate = date("m/d/Y", $d);
$balanceData = array(
"acnt_1" => $username, "acnt_2" => $password, "FINDATAREP" => "ON", "MESSAGEREP" => "ON", "STATUS" => "STATUS", 
"watgopher_title" => "WatCard Account Status", "watgopher_regex" => "/<hr>([\s\S]*)<hr>/;", "watgopher_style" => "onecard_regular",
);
$transactData = array(
"acnt_1" => $username, "acnt_2" => $password, "DBDATE" => $oldDate, "DEDATE" => $curDate, "PASS" => "PASS", "STATUS" => "HIST", "watgopher_title" => "WatCard History Report", "watgopher_regex" => "<hr>([\s\S]*wrong[\s\S]*)<p></p>|(<form[\s\S]*?(</center>|</form>))|(<pre><p>[\s\S]*</pre>)", "watgopher_style" => "onecard_narrow",
);
$header = array();
$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
$header[] = "Cache-Control: max-age=0";
$header[] = "Connection: keep-alive";
$header[] = "Keep-Alive: 300";
$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
$header[] = "Accept-Language: en-us,en;q=0.5";
$header[] = "Pragma: ";
$header[] = "REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'];
$header[] = "HTTP_X_FORWARDED_FOR: ".$_SERVER['REMOTE_ADDR'];
$tmpfname = "cookies.txt";
//$balanceFile = "balance.txt"; 
//$transactFile = "transact.txt";
function curlPage($url, $tmpfname, $data, $header)
{ //curls page and passes it back as a string to the main function
	$ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	$returnPage = curl_exec ($ch);
	//file_put_contents($file, $returnPage);
	return $returnPage;
}
$balance = curlPage($url, $tmpfname, $balanceData, $header);
$transact = curlPage($url, $tmpfname, $transactData, $header);
$index = strrpos($balance, "Financial Status Report"); //if index = -1, it does not work. Else, the user has been logged in.
if($index == false)
{
	$works = 0;
}
else {
	$works = 1;
}
?>
<script type="text/javascript">
var strBalance = <?php echo json_encode($balance); ?>;
var strTransact = <?php echo json_encode($transact); ?>;

var arrTransact = parseTransact(strTransact);
parseBalance(strBalance);

aDates = arrTransact[0];
aCosts = arrTransact[1];

$(document).ready(function() {
  $('#avgDay').text("$" + avgPerDay.toFixed(2).toString());
  $('#avgWeek').text("$" + avgPerWeek.toFixed(2).toString());
  $('#divBal').text("$"  + dolBal.toFixed(2).toString());
  $('#divMeal').text("$" + dolMeal.toFixed(2).toString());
  $('#divFlex').text("$" + dolFlex.toFixed(2).toString());
  $('#dolSuggest').text("$" + dolSuggest.toFixed(2).toString());
});

</script>
</head>
<body>

  <div class="clearfix" id="page"><!-- column -->
   <div class="position_content" id="page_position_content">
    <img class="colelem" id="u206-6" src="/hackthenorth/layout/images/u246-6.png" alt="WAT iSpend"/><!-- rasterized frame -->
    <div class="colelem" id="u356"><!-- custom html -->
        <h1 style="font-family: Montserrat; margin-bottom:15px; padding:0;"><center></center></h1>
        <style type="text/css">
        .tg  {border: none;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border:none;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border:none;overflow:hidden;word-break:normal;}
        </style>
        <?php
        if($works > 0)
		{
			echo "
        <table class=\"tg\" style=\"undefined;table-layout: fixed; width: 100%\" allign = \"center\">
          <tr>
            <th width = \"33%\" class=\"tg-031e\"style=\"font-family: Montserrat\"><center>TOTAL BALANCE<div id=\"divBal\"></div></center></th>
            <th class=\"tg-031e\"><div id=\"divBal\"></div></th>
            <th width = \"33%\" class=\"tg-031e\"style=\"font-family: Montserrat\"><center>MEAL PLAN BALANCE<div id=\"divMeal\"></div></center></th>
            <th class=\"tg-031e\"><div id=\"divMeal\"></div></th>
            <th width = \"33%\" class=\"tg-031e\"style=\"font-family: Montserrat\"><center>FLEX BALANCE<div id=\"divFlex\"></div></center></th>
            <th class=\"tg-031e\"><div id=\"divFlex\"></div></th>
          </tr>
        </table>
        
    </div>
    <div class=\"colelem\" id=\"u195\"><!-- custom html -->

				<canvas id=\"history\" width=\"900px\" height=\"450px\"></canvas>
				<script>
				var data = [
				  {
					value: 20,
					color:\"#637b85\"
				  },
				  {
					value : 30,
					color : \"#2c9c69\"
				  },
				  {
					value : 40,
					color : \"#dbba34\"
				  },
				  {
					value : 10,
					color : \"#c62f29\"
				  }

				];
				var dataLine = {
				  labels: aDates,
				  datasets: [
					{
					  label: \"My First dataset\",
					  fillColor: \"rgba(255,215,0,1)\",
					  strokeColor: \"rgba(255,215,0,1)\",
					  pointStrokeColor: \"#fff\",
					  highlightFill: \"#ffff66\",
					  highlightStroke: \"rgba(220,220,220,1)\",
					  data: aCosts
					},
				  ]
				};

				var canvas = document.getElementById(\"history\");
				var ctx = canvas.getContext(\"2d\");
				new Chart(ctx).Bar(dataLine);
				</script>
</div>
    <div class=\"colelem\" id=\"u354\"><!-- custom html -->
      <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <style type=\"text/css\">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;overflow:hidden;word-break:normal;}
        </style>
        <table allign = \"center\" class=\"tg\" cellspacing=\"0\" cellpadding=\"0\"style=\"undefined;table-layout: fixed; width: 100%\">
          <tr>
            <th class=\"tg-031e\" width = \"33%\" style=\"font-family: Montserrat\"><center>AVERAGE COST PER DAY<div id=\"avgDay\"></div></center></th>
            <th class=\"tg-031e\" width = \"33%\" style=\"font-family: Montserrat\"><center>AVERAGE COST PER WEEK<div id=\"avgWeek\"></div></center></th>
            <th class=\"tg-031e\" width = \"33%\" style=\"font-family: Montserrat\"><center>SUGGESTED COST PER DAY<div id=\"dolSuggest\"></div></center></th>
          </tr>
        </table>";
		}
		else 
		{
			echo "
			    <div class=\"colelem\" id=\"u195\"><!-- custom html -->
			<h2>Sorry, you were not logged in properly. <p><a href=\"/hackthenorth/index.html\">Please try again.</a></h2></p>
			</div>";
		}
				?>
      
        
    </div>
  <!-- JS includes -->
  <script type="text/javascript">
   if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script type="text/javascript">
   window.jQuery || document.write('\x3Cscript src="/hackthenorth/layout/scripts/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');
</script>
  <script src="/hackthenorth/layout/scripts/museutils.js?3880880085" type="text/javascript"></script>
  <script src="/hackthenorth/layout/scripts/jquery.watch.js?4199601726" type="text/javascript"></script>
  <!-- Other scripts -->
  <script type="text/javascript">
   $(document).ready(function() { try {
Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
Muse.Utils.prepHyperlinks(true);/* body */
Muse.Utils.fullPage('#page');/* 100% height page */
Muse.Utils.showWidgetsWhenReady();/* body */
Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
} catch(e) { Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
<!-- FOOTER STARTS HERE -->
   <style type="text/css">
    
   a.clickHere:link {
    color: #828282;
    text-decoration: none;
   }

   a.clickHere:visited {
    color: #828282;
    text-decoration: none;
   }

   a.clickHere:active {
    color: #828282;
    text-decoration: none;
   }

   a.clickHere:hover {
    color: #1a1a1a;
    text-decoration: none;
   }

    #footer {
      z-index = 10;
      position: fixed;
      bottom: 0;
      height: 30px;
      left: 15%;
      width: 70%;
      text-align: center;
      padding: 15px 15px 0px 15px;
      margin: 0;
      background-color: #fbe86a;
    }
    </style>
   <script type="text/javascript">
   $(document).ready(function() {
      $('.link').hover(function() {
        $(this).css('cursor', 'pointer');
        $(this).css('color', '#828282');
      }, function() {
        $(this).css('color', '#1a1a1a');
      });
      $('#about').click(function() {
        alert("WATiSPEND presents your uWaterloo meal plan history in an intuitive and user-friendly interface. Your login details and meal plan information are not recorded, distributed, or disclosed. \n\nIn fact, the only thing we can do with your login information is deposit more money onto your account. We can't actually spend your money - we'd need your physical Watcard to do that.\n\nThis app was not designed for mobiles. This app does not currently work for uWaterloo residence dons.\n\nBuilt Setepmber 2014 by Dian Jin, Melissa Tedesco and Stefan Pleava.");
      });
      $('#contact').click(function() {
         alert("Your feedback is greatly appreciated. Feel free to contact us with any questions, bug reports, or any other concerns at gryffindorstudent (at) gmail.com.");
      });
      $('#help').click(function() {
         alert("Total balance = how much money you have on your Watcard.\nMeal plan balance = how much meal plan money you have on your Watcard. Meal plan money is only accepted at UW Food Services locations.\n\nFlex balance = how many flex dollars you have.\n\nAverage cost per day = roughly how much money you're spending after the discount per day.\n\nAverage cost per week = same deal as above\n\nSuggested cost per day = How much you should be spending per day after discount to end up with a 0 meal plan balance by the last day of exams.\n\nKeep in mind we only look at your spending from the last 2 weeks.");
      });
   });
   </script>
   

    <div id="footer">
    <div style="float: left;" id="about" class="link">About</div>
    <div style="float: right;" id="contact" class="link">Contact</div>
    <div style="margin-left: auto; margin-right: auto;" id="help" class="link">Help</div>
   </div>
   
   <!-- FOOTER ENDS HERE -->
</body>
</html>
