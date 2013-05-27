<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      	
      	
      	
      	
      	
      var data = google.visualization.arrayToDataTable([
        ['city',   'Dives'],
        ['Balearic Islands',  42,],
       	['Playa del carmen',  37,],
       	['Cancun',  37,],
       	['Red Sea',  42,],
       	['philippines',  22,],
     	['Galapagos Islands',  3,],
        ['thailand', 23,],
        ['Canary Islands',  12,],
        ['Utila',  12,],
		['Punta Cana',  12,],       
       
        ['totales', 520,],
      ]);

      var options = {
        region: 'world',
        displayMode: 'markers',
        colorAxis: {colors: ['#8099CE', '#4E71BA']},
        legend: 'none', 
        backgroundColor: 'white', 
        
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 176px; height: 100px; border:1px solid #D7E2F2"></div>
  </body>
</html>