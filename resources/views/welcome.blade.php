<!DOCTYPE html>
<html>
    <head>
        <title>Link Checker</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
       <style>
       div {
            background-color: gainsboro;
            width: 1000px;
            height: 600px;
            border: 5px solid royalblue;
            padding: 50px;
            margin: 20px;
            overflow:scroll;
          }
       h1{color: DimGrey;}
       p{color: DimGrey;}
       input{color: DimGrey;}
       output{color: DimGrey;}
       
        body{  background-color: LightSkyBlue;}
      </style>
    </head>



    <body>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h1> Link Redirection Catcher </h1>
    <p>Select local CSV File:</p>
    <input id="csv" type="file">
    <button id = "button1">Submit data</button>
    <output id="out">
    file contents will appear below: <br>
    <br>
    </output>
    <div>
    <results>
    
    
    </results>
    </div>
    <button id = "button2" value = "Download">Save Data</button>
    <button id = "button3">Reset page</button>







    <script>
      var links = [];
      var fileInput = document.getElementById("csv");

      readFile = function() {
        var reader = new FileReader();

        reader.onload = function() {
          let lines = reader.result.split(/[\n,]+/);
          let output = document.querySelector('#out');

          const loop = async (lines,output) => {
            var x;
            for(x=2; x < lines.length; x+=2) {
              links.push(lines[x]);
              // output.innerHTML += line + '<br>';
              
            }
            //document.write(links[2].toString());
          }
          loop(lines,output);
        };
        // start reading the file. When it is done, calls the onload event defined above.
        reader.readAsBinaryString(fileInput.files[0]);
      };
    fileInput.addEventListener('change', readFile);

var temp;
$(document).ready(function(){
    $("#button1").click(function(){
      var data = {
        links : links,
        _token:"<?php echo csrf_token(); ?>"
      };
      $.ajax({  
      type: "POST",
      url: '/',
      data: data,
      error: function(data){
          alert("fail, no data uploaded");
      },
      success: function(data) {
        $("results").html(data);
        temp = data;
      }
    });
  });

  $("#button2").click(function(){
    if(temp == null){
      alert("No data loaded");
    }
    else{
    var textToSave = temp.split("<br/>").join("\n");
    var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = "output.txt";
    var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    }
  });
  function destroyClickedElement(event)
    {
        document.body.removeChild(event.target);
    }

    $("#button3").click(function(){
      location.reload();
    });



});


</script> 



    </body>
</html>
