<?php
  $url = "https://reportes.reportaciudad.org/api/geo_reports/?api_key=1234";
  $remoteGroups =  variable_get("remoteGroups");
  $url = "https://reportes.reportaciudad.org/api/geo_reports/?api_key=1234";
  if($remoteGroups){
    $url = $url . "&gid=" .$remoteGroups;
  }
  $json = file_get_contents($url);
  if ( $json ) {
    $objResponse = json_decode($json);
    $data = $objResponse->features;
    usort($data, function($a, $b) { //Sort the array using a user defined function
      return $a->properties->date > $b->properties->date ? -1 : 1; //Compare the dates
    });
    $max_items = 10;
    $count = 0;
    foreach($data as $report){
      $count += 1;
      if($count<=$max_items){
?>
        <div class="report">
          <a href="https://reportes.reportaciudad.org/report/<?php echo $report->properties->id; ?>?platform=1&callback=https%3A%2F%2Freportaciudad.org%2Fcategories%2Ftransporte-y-movilidad">
          <div class="txt">
            <h4><?php echo $report->properties->title; ?></h4>
            <p><?php echo $report->properties->category; ?></p>
            <span><?php echo $report->properties->date; ?></span>
          </div>
         </a>
      </div>


<?php
      }
    }
  }
?>
