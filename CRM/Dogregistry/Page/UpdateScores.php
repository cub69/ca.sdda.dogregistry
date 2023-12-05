<?php
use CRM_Dogregistry_ExtensionUtil as E;

class CRM_Dogregistry_Page_UpdateScores extends CRM_Core_Page {

  public function run() {   
    $tempdir = "/tmp";
    global $wpdb;
    CRM_Utils_System::setTitle(E::ts('Reading Trial Scores'));
    $obj=[];
    $rows =  $wpdb->get_results( 'SELECT * FROM `civicrm_dog_scores` ' , ARRAY_A);
    foreach($rows as $row){  
      //error_log(print_r($row,true));
      if ($row['Event']) {
        error_log("The event number is ".$row['Event']);
        error_log(print_r($row,true));
        $sqlcmd= "SELECT * from civicrm_trial_admin where id = (Select ta_id from civicrm_trial_components where trial_number = ". $row['Event']." LIMIT 1) ;";
        error_log($sqlcmd);
        $trial_components = $wpdb->get_results($sqlcmd);
        error_log(print_r($trial_components,true));
      }
    }
    exit;
    $sqlcmd = "select max(id) as maxrecord from civicrm_dog_scores";
    $result = $wpdb->get_results($sqlcmd);
    $maxtemp = $result[0];
    $maxrecord = $maxtemp->maxrecord;
    //$maxrecord = 0;   //Uncomment this line to completely reload the dog scores database (truncate the table first!)
    $sqlcmd = "/var/www/html/wp-content/uploads/civicrm/upload/Sdda_v13.mdb\n";
    $sqlcmd = $sqlcmd."select scrId, scrEvent, scrRules, scrDogId, scrStream, scrSequence, scrHandlerId, scrScore, scrPass, scrTime, scrJudge, scrUsedForFirstTitle from tblScores where scrId >".$maxrecord.";\n";
    $sqlcmd = $sqlcmd."export /var/www/html/wp-content/uploads/civicrm/upload/update.csv;\n";
    file_put_contents($tempdir.'/sqlcmd.sql', $sqlcmd);
    // Uncomment next 3 lines in production
    //$command = "cp /home/ec2-user/Dropbox/SDDA/Database/Sdda_v13.mdb ".$tempdir."/Sdda_v13.mdb";
    //$output = shell_exec($command);
    //$command = "/usr/bin/mdb-sql -HFp -d , -i ".$tempdir."/sqlcmd.sql -o ".$tempdir."/update.csv ".$tempdir."/Sdda_v13.mdb";
    // comment out the next line in production
    //$command = "cd /opt/UCanAccess-5.0.1.bin;./console.sh <".$tempdir."/sqlcmd.sql\n";
    //file_put_contents($tempdir.'/run.sh', $command);
    //$command = "/usr/bin/mdb-sql -HFP -d , -i ".$tempdir."/sqlcmd.sql -o ".$tempdir."/update.csv ".$tempdir."/Sdda_v13.mdb";
    //echo $command;
    $command = "./UCanAccess-5.0.1.bin/export.sh 2>&1";
    $return_var = null;
    //$output = shell_exec($command);
    error_log(print_r($return_var,true));
    system($command, $return_var);
    echo "return_var is: ".print_r($return_var,true)."\n";
    
    
    //shell_exec("rm -f $tempdir/sqlcmd.sql");
    exit;
    $updates = fopen("$tempdir/update.csv", "r");
    $row = 1;
    if (($handle = fopen("$tempdir/update.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            if ($row == 1) loop;
            $row++;
            for ($c=0; $c < $num; $c++) {
            if($data[$c]=="") $data[$c]="null";
            }
            $sqlcmd = "INSERT INTO civicrm_dog_scores (Id, Event, Levels, DogId, Stream, Sequence, HandlerId, Score, Pass, Event_date, Judge, UsedForFirstTitle) VALUES ($data[0], $data[1], "."'"."$data[2]"."', "."$data[3], "."'"."$data[4]"."' ,"." $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11])";
            $result = $wpdb->get_results($sqlcmd);
            //error_log(print_r($result,true));
        }
        fclose($handle);
//             shell_exec("rm -f $tempdir/update.csv");
        //echo "DONE!";
        //echo "Loading Titles...";
    }

// Import titles data now!
    $sqlcmd = "'select dgSDDA_DogNumber, dgStartedTitleScore, dgStartedTitleHonour, dgStartedTitleDate, dgAdvancedTitleScore, dgAdvancedTitleHonour, dgAdvancedTitleDate, dgExcellentTitleScore, dgExcellentTitleHonour, dgExcellentTitleDate, dgChTitleDate, dgMachTitleDate, dgMach2TitleDate, dgMach3TitleDate, dgEliteTitleScore, dgEliteTitleDate, dgEliteCHTitleDate, dgEliteMachTitleDate, dgEliteCH2TitleDate, dgEliteMach2TitleDate, dgGamesAerialTitleDate, dgGamesDistanceTitleDate, dgGamesSpeedTitleDate, dgGamesTeamTitleDate, dgGamesTitleDate, dgGames2TitleDate, dgGames3TitleDate, dgGames4TitleDate FROM tblSDDA_dogs'";
    $output=shell_exec("echo $sqlcmd>$tempdir/sqlcmd.sql");
    
    $command = "/usr/bin/mdb-sql -HFP -d , -i ".$tempdir."/sqlcmd.sql -o ".$tempdir."/titles.csv ".$tempdir."/Sdda_v13.mdb";
    $output = shell_exec($command);
    shell_exec("rm -f $tempdir/sqlcmd.sql");
    $row = 1;
    if (($handle = fopen("$tempdir/titles.csv", "r")) !== FALSE) {
        $sqlcmd = "truncate table civicrm_dog_titles";
        $result = $wpdb->get_results($sqlcmd);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            for ($c=0; $c < $num; $c++) {
            if($data[$c]=="") $data[$c]="null";
            if(str_contains($data[$c], "/")) {
                // convert date/time stamps from mm/dd/yy to yyyy/mm/dd
                $month=substr($data[$c],0,2);
                $day=substr($data[$c],3,2);
                $year=substr($data[$c],6,2);
            //    error_log("before conversion:".$data[$c]);
                $data[$c] = null;
                if ($month > 0 and $month < 13) {
                  if ($day > 0 and $day < 32) {
                    if ($year >10){
                      $data[$c] = date($year.$month.$day);
                    }
                  }
                }
                //$data[$c] = date($year.$month.$day);
            //    error_log("After conversion:".$data[$c]);
              }
              //error_log($data[$c]);
            }
            if ($data[2] == "1") {$data[2]="SP";} else {$data[2]=" ";}
            if ($data[5] == "1") {$data[5]="SP";} else {$data[5]=" ";}
            if ($data[8] == "1") {$data[8]="SP";} else {$data[8]=" ";}

            //Evaluate the data and insert titles into database
            // $data[0] is dogid
            // $data[1] to [3] Started Title with [2] indicating special
            // $data[4] to [6] Advanced Title with [5] indicating special
            // $data[7] to [9] Excellent title with [8] indicating special
            // $data[10] Indicates Champion Title date
            // $data[11] Indicates Master Champion Title date
            // $data[12] Indicates Master Champion 2 Title date
            // $data[13] Indicates Master Champion 3 Title date
            // $data[14] Elite Title Score
            // $data[15] Elite Title Date
            // $data[16] Elite Champion Date
            // $data[17] Elite Master Champion
            // $data[18] Elite Champion 2 Date
            // $data[19] Elite Master Champion 2
            // $data[20] Aerial Games Title Date
            // $data[21] Distance Games Title Date
            // $data[22] Speed Games Title Date
            // $data[23] Team Games Title Date
            // $data[24] Games Title Date
            // $data[25] Games Title 2 Date
            // $data[26] Games Title 3 Date
            // $data[27] Games Title 4 Date
            //error_log("The value of data[1] is: ".$data[3]);
            If (validateDate($data[3])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Started', '$data[2]', $data[1], $data[3])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[6])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Advanced', '$data[5]', $data[4], $data[6])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[9])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Excellent', '$data[8]', $data[7], $data[9])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[10])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Champion', null, null, $data[10])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[11])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Master Champion', null, null, $data[11])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[12])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Master Champion 2', null, null, $data[12])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[13])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Master Champion 3', null, null, $data[13])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[15])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Elite', null, $data[14], $data[15])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[17])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Elite Master Champion', null, null, $data[17])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[18])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Elite Champion 2', null, null, $data[18])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[19])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Elite Master Champion 2', null, null, $data[19])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[20])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Aerial Games', null, null, $data[20])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[21])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Distance Games', null, null, $data[21])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[22])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Speed Games', null, null, $data[22])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[23])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'Team Games', null, null, $data[23])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[24])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'All Games', null, null, $data[24])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[25])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'All Games 2', null, null, $data[25])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[26])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'All Games 3', null, null, $data[26])";
              $result = $wpdb->get_results($sqlcmd);
            }
            If (validateDate($data[27])) {
              $sqlcmd = "INSERT INTO civicrm_dog_titles (dogId, description, honours, titleScore, titleDate) VALUES ($data[0], 'All Games 4', null, null, $data[27])";
              $result = $wpdb->get_results($sqlcmd);
            } 
            //$sqlcmd = "INSERT INTO civicrm_dog_titles (dogId,StartedTitleScore,StartedTitleHonour,StartedTitleDate,AdvancedTitleScore,AdvancedTitleHonour,AdvancedTitleDate,ExcellentTitleScore,ExcellentTitleHonour,".
            //          "ExcellentTitleDate,ChTitleDate,MachTitleDate,Mach2TitleDate,Mach3TitleDate,EliteTitleScore,EliteTitleDate,EliteCHTitleDate,EliteMachTitleDate,EliteCH2TitleDate,EliteMach2TitleDate,".
            //          "GamesAerialTitleDate,GamesDistanceTitleDate,GamesSpeedTitleDate,GamesTeamTitleDate,GamesTitleDate,Games2TitleDate,Games3TitleDate,Games4TitleDate) ".
            //          "VALUES ($data[0],$data[1],$data[2],$data[3],$data[4],$data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17],".
            //          "$data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24], $data[25], $data[26], $data[27])";
            //$result = $wpdb->get_results($sqlcmd);
            //error_log(print_r($result,true));
        }
        fclose($handle);
//             shell_exec("rm -f $tempdir/update.csv");
        //echo "DONE!";
    }
    parent::run();
  }

   
}


