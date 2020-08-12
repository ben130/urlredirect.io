<?php

namespace blog\Http\Controllers;

use blog\Http\Controllers\Controller;
use Illuminate\Http\Request;

//ini_set('max_execution_time', 300);
set_time_limit(0);
class Controller2 extends Controller
{
public function parseLink(Request $request){
    $myArray = $request->links;
    $tempArr = [];
    // Initialize a CURL session. 
    

    echo  "Redirected Links: <br/>";
    echo "<br/>";
    for ($i=0, $len=count($myArray)-1; $i<$len; $i++) {
    $url = $myArray[$i];
    $ch = curl_init(); 
    
    // Grab URL and pass it to the variable. 
    curl_setopt($ch, CURLOPT_URL, $url); 
    
    // Catch output (do NOT print!) 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    
    // Return follow location true 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
    $html = curl_exec($ch); 
    
    // Getinfo or redirected URL from effective URL 
    $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); 
    $errorCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    array_push($tempArr, $redirectedUrl);
    // Close handle 
    curl_close($ch);
    

        if($url != $redirectedUrl){
            echo "Original URL:   " . $url . "<br/>";
            echo "Redirected URL: " . $redirectedUrl . "<br/>";
            echo $errorCode . "<br/>";
            echo  "<br/>";
        }
    }
    echo "Non-Redirected Links: <br/>";
    echo "<br/>";
    
    for($x=0, $len=count($myArray)-1; $x<$len; $x++){
        if($myArray[$x] == $tempArr[$x]){
            echo "Original URL:   " . $myArray[$x] . "<br/>";
            echo "Redirected URL: " . $tempArr[$x] . "<br/>";
           echo  "<br/>";

        }


    }





    return "DONE <br/>";
}









}
