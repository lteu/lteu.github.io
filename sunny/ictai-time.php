<?

/**
*
*
* A html based visualiser for sunny performance on feature selected dataset
*
*
*/


$scenarios = array();
$time_all = array();


$cases = [1,2,3,4,5,6,7,8,16,32,64];
$types = ["time_sym"];


$content_sym =  getHtmlFromType("time_sym");
$content_rt =  getHtmlFromType("time_gainratio");



function getHtmlFromType($type){
    $cases = $GLOBALS['cases'];
    //load data
    if ($handle = opendir("data/$type/")) {

       while (false !== ($entry = readdir($handle))) {

            $myfile = fopen("data/$type/".$entry, "r");
            while(!feof($myfile)) {
                $line = trim(fgets($myfile));
                $pieces = split(" ", $line);
                $time = $pieces[0];
                $scenario = $pieces[1];
                $attrsn = $pieces[3];

                if (trim($scenario) !== "") {
                    $scenarios[$scenario][$attrsn] =  $time;
                } 
            }
        fclose($myfile);
        }
    }

    //calculate all
    foreach ($cases as $case) {
        $all = 0.0;
        foreach ($scenarios as $name => $scenario) {
            $all = $all + floatval($scenario[$case]);
        }
        $time_all[$case] = $all; 
    }


    //produce contente
    return html($scenarios,$time_all);

}



function html($scenarios,$time_all){
    $cases = $GLOBALS['cases'];
    $scenario = $scenarios["COP-MZN-2013"];

//html

//par10

//table heading
    $htmlContentpt = "<tr><td><label>Scenario</label></td>";
    foreach ($cases as $idx => $val) {
        $htmlContentpt .= "<td><label>$val</label></td>";
    }
    $htmlContentpt .= "</tr>";

// //table content
    foreach ($scenarios as $name => $scenario) {


        $htmlContentpt .= "<tr>";
        $htmlContentpt .= "<td><label>$name</label></td>";


        foreach ($cases as $case) {
            $val = $scenario[$case];
            $htmlContentpt .= ($val >= 10800)? "<td class='red'>".round($scenario[$case],3)."</td>" : "<td class=''>".round($scenario[$case],3)."</td>";
            
        }
        $htmlContentpt .= "</tr>";
    }

    $htmlContentpt .= "<tr><td><label>Total</label></td>";
    foreach ($cases as $idx => $val) {

        $totraw = round($time_all[$val],3); 
        $htmlContentpt .= "<td><label>$totraw</label></td>";
    }
    $htmlContentpt .= "</tr>";

    $htmlContentpt .= "<tr><td><label>Total in hour</label></td>";
    foreach ($cases as $idx => $val) {

        $totraw = $time_all[$val]; 
        $tot = $totraw;
        $tot = $tot / 3600;
        $tot = round($tot, 3);
        $htmlContentpt .= "<td><label>$tot</label></td>";
    }
    $htmlContentpt .= "</tr>";

    return $htmlContentpt;

}




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8"/>
    <link type='text/css' href='css/bootstrap.css' rel='stylesheet' />
    <script type="text/javascript" src="lib/jquery-1.7.2.min.js"></script>
    <script type='text/javascript' src='lib/bootstrap.min.js'></script>

    <style>
    .content{
        margin: auto;
        width: 70%;
    }
    .green{
     color: green;
 }
 .red{
     color: red;
 }

 </style>
</head>

<body>
    <div class='content'>

        <div class="table-responsive">
            <h2> symmmetric uncertainty</h2>
            <table class="table">
             <?php echo $content_sym;?>
         </table>
     </div>

      <div class="table-responsive">
            <h2> gain ratio</h2>
            <table class="table">
             <?php echo $content_rt;?>
         </table>
     </div>


 </body>



 <script>
 </script>


 </html>

