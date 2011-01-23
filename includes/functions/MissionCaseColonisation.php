<?php

/**
 * MissionCaseColonisation.php
 *
 * @version 1
 * @copyright 2008
 */

// ----------------------------------------------------------------------------------------------------------------
// Mission Case 9: -> Coloniser
//
function MissionCaseColonisation ( $FleetRow ) {
  // --- This is universal part which should be moved to fleet manager
  global $time_now;

  // Checking if we should now to proceed this fleet - does it arrive? No - exiting.
  if ($FleetRow['fleet_start_time'] > $time_now) return;

  // Checking fleet message: if not 0 then we already managed this fleet
  if($FleetRow['fleet_mess'] != 0) {
    // Checking fleet end_time: if less then time_now then restoring fleet to planet
    if($FleetRow['fleet_end_time'] <= $time_now) {
      RestoreFleetToPlanet($FleetRow);
    }
    return;
  }
  // --- End of Universal part

  global $lang, $resource, $user, $debug, $config;

  $iMaxColo = doquery("SELECT `colonisation_tech` + 1 FROM `{{table}}` WHERE `id`='". $FleetRow['fleet_owner']."'",'users', true);

  $iPlanetCount = doquery ("SELECT count(*) FROM `{{table}}` WHERE `id_owner` = '{$FleetRow['fleet_owner']}' AND `planet_type` = '1';", 'planets', true);
  if ($FleetRow['fleet_mess'] == 0) {
    // Déjà, sommes nous a l'aller ??
    $TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);

    $iGalaxyPlace = doquery ("SELECT count(*) as planet_count FROM `{{planets}}` WHERE `galaxy` = '{$FleetRow['fleet_end_galaxy']}' AND `system` = '{$FleetRow['fleet_end_system']}' AND `planet` = '{$FleetRow['fleet_end_planet']}' AND `planet_type` = 1;", "", true);
    if (!$iGalaxyPlace['planet_count']) {
      // Can we colonize more planets?
      if ($iPlanetCount[0] >= $iMaxColo[0] || $iPlanetCount[0] >= ($config->player_max_colonies + 1) ) {
        // No, we can't
        $TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'];
        SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
        doquery("UPDATE `{{table}}` SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
      } else {
        // Yes, we can colonize
        $NewOwnerPlanet = uni_create_planet($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], "{$lang['sys_colo_defaultname']} �{$iPlanetCount[0]}");
        if ( $NewOwnerPlanet ) {
$debug->warning('Sending several type of ships with colonizer leads to resource duplication. Resource duplicate X time where X - number of ship type<br>Fleet: ' . dump($FleetRow['fleet_array']), 'Colonization With Fleet', 304);

          $TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
          SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);

          $CurrentFleet = explode(';', $FleetRow['fleet_array']);
          $NewFleet     = '';
          foreach ($CurrentFleet as $Group) {
            if ($Group) {
              $Class = explode (',', $Group);
              if ($Class[0] == 208) {
                if ($Class[1] > 0) {
                  $NewFleet  .= $Class[0].','.($Class[1] - 1).';';
                  $FleetRow['fleet_amount']--;
                }
              } else {
                if ($Class[1] <> 0) {
                $NewFleet  .= $Class[0].','.$Class[1].';';
                }
              }
            }
          }
          $FleetRow['fleet_array'] = $NewFleet;
//          if($FleetRow['fleet_amount'] > 0)
//            $debug->warning('Sending several type of ships with colonizer leads to resource duplication. Resource duplicate X time where X - number of ship type<br>Fleet: ' . dump($FleetRow['fleet_array']), 'Colonization With Fleet', 304);
          RestoreFleetToPlanet ($FleetRow, false);
        } else {
          $TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
          SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
          doquery("UPDATE `{{table}}` SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."'", 'fleets');
        }
      }
    } else {
      // Pas de bol coiffé sur le poteau !
      $TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
      SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
      // Mettre a jour la flotte pour qu'effectivement elle revienne !
      doquery("UPDATE `{{table}}` SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."'", 'fleets');
    }
  } elseif ($FleetRow['fleet_end_time'] <= time()) {
    // Retour de flotte
    RestoreFleetToPlanet ( $FleetRow, true );
  }
}
?>