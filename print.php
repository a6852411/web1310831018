<?php
$a=$_POST['inputImage'];
?>
<!DOCTYPE html>
<!-- saved from url=(0044)https://1310831020easyweb.azurewebsites.net/ -->
<html class="translated-ltr" style="
    background-image: url( &#39; http://img.yao51.com/jiankangtuku/gwqqkmwky.jpeg&#39; );
"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>辨識結果</title>
    <script src="./&#27320;&#27308;&#25110;&#37240;&#27225;_files/jquery.min.js.&#19979;&#36617;"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>      
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/js/flot/excanvas.min.js"></script><![endif]-->   


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<link type="text/css" rel="stylesheet" charset="UTF-8" href="./&#27320;&#27308;&#25110;&#37240;&#27225;_files/translateelement.css"></head>
<body onload="processImage()">
<script type="text/javascript">
    function processImage() {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************

        let subscriptionKey = '7d84e33d694745b7b2f1dbdfaeb0e976';
        let endpoint = 'https://s1310831018.cognitiveservices.azure.com/customvision/v3.0/Prediction/4285d1e5-abfd-45eb-b41e-74ef1f355c81/classify/iterations/Iteration1/url';
        if (!subscriptionKey) { throw new Error('Set your environment variables for your subscription key and endpoint.'); }
        
        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;

        // Make the REST API call.
        $.ajax({
            url: endpoint + "?",

            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Prediction-Key", subscriptionKey);
            },

            type: "POST",

            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })

        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
    var barData = {
			        labels: [data.predictions[0].tagName, data.predictions[1].tagName, data.predictions[2].tagName, data.predictions[3].tagName, data.predictions[4].tagName],
			         datasets: [
				        {
				            label: "預測結果百分比",
				            backgroundColor: "rgba(58,203,254,1)",
				            strokeColor: "rgba(220,220,220,0.8)",
				            highlightFill: "rgba(220,220,220,0.75)",
				            highlightStroke: "rgba(220,220,220,1)",
				            data: [data.predictions[0].probability*100, data.predictions[1].probability*100,data.predictions[2].probability*100, data.predictions[3].probability*100, data.predictions[4].probability*100]
				        }

				    ]
			    };

			    // render chart
			    var ctx = document.getElementById("barChart");
				var myRadarChart = new Chart(ctx, {
					type: 'bar',
					data: barData,
					options:{
						responsive: false,
						
					}
				});
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });

    };
</script>
<input type="hidden" name="inputImage" id="inputImage" value="<?php echo $a;?>" />
<br><br>
<center><div align=center id="wrapper" style="width:1020px; display:table;">
    <div align=center id="jsonOutput" style="width:600px; display:table-cell;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
        <h1 style="
    color: #FF0000;" align=center>辨識結果:</h1>
        </font></font><br><br>
        <canvas align=center id="barChart" width="580" height="388"></canvas>
    </div>
    <div align=center id="imageDiv" style="width:420px; display:table-cell;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
        <h1 style="
    color: #FF0000;" align=center>要辨識之圖片:</h1>
        </font></font><br><br>
        <img align=center id="sourceImage" width="580" height="363">
    </div>
</div>
<input style="width:120px;height:40px;font-size:20px;" type="button" value="回上頁" onclick="location.href='index.html'"></center>
</body>
</html>