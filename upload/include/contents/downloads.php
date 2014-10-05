<?php 
#  Script Copyright by: Manuel Staechele
#  Support: www.ilch.de
  
#  Ueberarbeitung copyright by honklords.de
#  erstellt von Topolino
#  seite: www.honklords.de
 
#  Support auf www.honklords.de 


defined ('main') or die ( 'no direct access' );


function get_cats_title ( $catsar ) {
  $l = '';
	foreach($catsar as $k => $v) {
	  if ( $k != '' AND $v != '' ) {
		  $l = $v.' :: '.$l;
		}
	}
	return ($l);
}

function get_cats_urls ( $catsar ) {
  $l = '';
	foreach($catsar as $k => $v) {
	  if ( $k != '' AND $v != '' ) {
		  $l = '<a class="smalfont" href="?downloads-'.$k.'">'.$v.'</a><b> &raquo; </b>'.$l;
		}
	}
	return ($l);
}

function get_cats_array ( $cid , $ar ) {
	if ( empty($cid) ) {
	  return ($ar);
	} else { 
	  $erg = db_query("SELECT cat,id,name FROM prefix_downcats WHERE id = ".$cid);
		$row = db_fetch_assoc($erg);
		$ar[$row['id']] = $row['name'];
	  return ( get_cats_array($row['cat'],$ar) );
	}
	if ( $r ) {
	  return ($l);
	}
}

function get_download_size($file) {
  $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");  
  $size = @filesize($file); if ($size == 0) { return('n/a'); } else {
  return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
}

function count_files ($cid) {
  $zges = 0;
	$e = db_query("SELECT id FROM prefix_downcats WHERE cat = ".$cid);
	if ( db_num_rows($e) > 0 ) {
	  while ($r = db_fetch_assoc($e) ) {
	    $zges = $zges + count_files ( $r['id'] );
	  }
	}
	$zges = $zges + db_count_query("SELECT COUNT(*) FROM prefix_downloads WHERE cat = ".$cid);
	return ( $zges );
}

function icUpload () {
	    
      $name = escape($_POST['name'],'string');
	    $version = escape($_POST['version'],'string');
	    $autor = escape($_POST['autor'],'string');
	    $surl = escape($_POST['surl'],'string');
	    $ssurl = escape($_POST['ssurl'],'string');
      $url = ( empty($_POST['url']) ? '' : escape($_POST['url'],'string') );
	    $desc = escape($_POST['desc'],'string');
	    $descl = escape($_POST['descl'],'textarea');
      
      if (empty($name)) {
        return ('keinen Namen angegeben.');
      }

      if (empty($desc) or empty($descl)) {
        return ('kein langer oder/und kein kurzer Text angegeben.');
      }
      
      if (empty($url) AND empty($_FILES['file']['name'])) {
        return ('Keine Datei oder Link angegeben.');
      }
  
	    if (!empty ($_FILES['file']['name']) ) {
      
		    $rtype = trim(ic_mime_type ($_FILES['file']['tmp_name']));
        $fname = escape($_FILES['file']['name'],'string');
        $fende = preg_replace("/.+\.([a-zA-Z]+)$/", "\\1", $fname);
        $fende = strtolower($fende);
        
		    if ( $_FILES['file']['size'] > 2097000 ) { # 2 mb (2 097 152)
          return ('Die Datei darf NICHT gr&ouml;sser als 2 MBytes sein.');
        }
        
        if (
		      ($fende != 'rar' AND $fende != 'zip' AND $fende != 'tar')
                   
          OR (
          $rtype != 'application/x-rar' AND
          $rtype != 'application/x-zip' AND
          $rtype != 'application/x-tar')

		    ) {
          return ('Die Datei darf nur die Endungen: .zip, .tar oder .rar haben.');
        }
        
        $fname = str_replace ('.'.$fende, '', $fname);
        $fname = preg_replace("/[^a-zA-Z0-9]/", "", $fname);
        $fname = $fname.'.'.$fende;
        
        if (file_exists( 'include/downs/downloads/user_upload/'.$fname ) ) {
          return ('Die Datei existiert bereits und kann nicht &uuml;berschrieben werden.');
        }
        
        if ( move_uploaded_file($_FILES['file']['tmp_name'], 'include/downs/downloads/user_upload/'.$fname) ) {
          $url = 'include/downs/downloads/user_upload/'.$fname;
          @chmod($url, 0777);
			  }
      }
        
      if (empty($url)) {
        return ('Keine Datei oder Link angegeben');
      }
        
      db_query("INSERT INTO prefix_downloads (`time`,`cat`,`creater`,`version`,`url`,surl,`ssurl`,`name`,`desc`,`descl`,pos) VALUES (NOW(),-1,'".$autor."','".$version."','".$url."','".$surl."','".$ssurl."','".$name."','".$desc."','".$descl."','0')");
        
      return (true);
}

switch ( $menu->get(1) ) {
  default :
		$cid = ( $menu->get(1) ? escape($menu->get(1), 'integer') : 0 );
		$erg = db_query("SELECT cat,name FROM prefix_downcats WHERE id = ".$cid." ORDER BY pos");
		if ( db_num_rows($erg) > 0 ) {
		  $row = db_fetch_assoc($erg);
			$array = get_cats_array($row['cat'],'');
			if ( !empty($array) ) {
			  $titelzw = get_cats_title($array);
			  $namezw = get_cats_urls($array);
			} else {
			  $titelzw = '';
				$namezw = '';
			}
		  $cattitle = ':: '.$titelzw.$row['name'];
			$catname = '<b> &raquo; </b>'.$namezw.$row['name'];	
		} else {
		  $cattitle = '';
			$catname = '';
		}
		$title = $allgAr['title'].' :: Downloads '.$cattitle;
    $hmenu = '<a class="smalfont" href="?downloads">Downloads</a>'.$catname;
    $design = new design ( $title , $hmenu );
	  $design->header();
		$tpl = new tpl ('downloads' );
    require_once('include/contents/downloadsinfo.php');
    $tpl->set('cid', $cid);
	
	$i = 0;
    $z = 3;

    $erg = db_query("SELECT id,name,`desc`,img FROM prefix_downcats WHERE cat = ".$cid." AND recht >= ".$_SESSION['authright']." ORDER BY pos");
    if ( db_num_rows($erg) > 0 ) {
		  $tpl->out(1); $class = 'Cnorm';
			while ($row = db_fetch_assoc($erg) ) {
			  $row['files'] = count_files($row['id']);
			  $class = ( $class == 'Cmite' ? 'Cnorm' : 'Cmite' );
                        #optional code von Nero
                        $row['footer1'] = '';
                        $row['footer2'] = '';
                        if($i%$z == 0) {  $row['footer1'] = '<tr>'; }
                        if($i%$z == $z-1)  {  $row['footer2'] = '</tr>';  } $i++;
                        #optional code ende
				$row['class'] = $class;
			  $tpl->set_ar_out($row,2);
      }
		  $tpl->out(3);
		}
		
    # sortierung festlegen
    $sortierung = 'pos ASC';
    $DOM = 'ASC';
    $POM = 'ASC';
    $DAM = 'ASC';
    
    switch ($menu->get(2)) {
      case 'positionDESC' : $sortierung = 'pos DESC'; break;
      case 'positionASC' : $sortierung = 'pos ASC';  $POM = 'DESC'; break;
      case 'downsDESC' : $sortierung = 'downs DESC'; break;
      case 'downsASC' : $sortierung = 'downs ASC'; $DOM = 'DESC'; break;
      case 'dateDESC' : $sortierung = 'time DESC'; break;
      case 'dateASC' : $sortierung = 'time ASC'; $DAM = 'DESC'; break;
    }

    $tpl->set ('POM', $POM);
    $tpl->set ('DOM', $DOM);
    $tpl->set ('DAM', $DAM);
	$i = 0;
    $z = 2;
		$erg = db_query("select id,name,version,surl,ssurl,`desc`,downs,DATE_FORMAT(time,'%d.%m.%Y') as datum from prefix_downloads WHERE cat = ".$cid." ORDER BY time DESC");
		if ( db_num_rows($erg) > 0 ) {
		  $tpl->out(4); $class = 'Cnorm';
			while($row = db_fetch_assoc($erg) ) {
        # smal screenshot url
        $row['temp_surl'] = $row['surl'];                   
        $row['surl'] = ( $row['surl'] != '' ? 
            '<img src="'.$row['surl'].'" alt="'.$row['name'].' '.$row['version'].'" title="'.$row['name'].' '.$row['version'].'" style="max-width:60px; " />' 
            : 
            '<img src="/include/images/downcats/na.png" style="max-width:60px;"/>' 
        );
        $class = ( $class == 'Cmite' ? 'Cnorm' : 'Cmite' );
		            #optional code von Nero
                        $row['footer3'] = '';
                        $row['footer4'] = '';
                        if($i%$z == 0) {  $row['footer3'] = '<tr>'; }
                        if($i%$z == $z-1)  {  $row['footer4'] = '</tr>';  } $i++;
                    #optional code ende

				$row['class'] = $class;
			  $tpl->set_ar_out($row,5);
			}
			$tpl->out(6);
		}
    
    if ( $cid == 0 AND $allgAr['archiv_down_userupload'] == 1 AND loggedin() AND is_writeable ( 'include/downs/downloads/user_upload' ) ) {
      $tpl->out(7);
    }
    
		$design->footer();
	  break;
	case 'show' :
	  
    $fid = escape($menu->get(2), 'integer');
    $erg = db_query("SELECT prefix_downloads.cat,ssurl,surl,url,demo,hits,vote_klicks,vote_wertung,prefix_downloads.name,version,creater,downs,descl,drecht,prefix_downloads.id,DATE_FORMAT(time,'%d.%m.%Y') as datum FROM prefix_downloads LEFT JOIN prefix_downcats ON prefix_downcats.id = prefix_downloads.cat WHERE prefix_downloads.id = ".$fid." AND (".$_SESSION['authright']." <= prefix_downcats.recht OR (prefix_downloads.cat = 0 AND prefix_downcats.recht IS NULL))");    
    if (@db_num_rows($erg) <> 1) {
      $title = $allgAr['title'].' :: Downloads ';
      $hmenu = '<a class="smalfont" href="?downloads">Downloads</a>';
      $design = new design ( $title , $hmenu );
      $design->header();
      echo 'Der Download wurde nicht gefunden';
      $design->footer(1);
    }   
    
		$row = db_fetch_assoc($erg);
    
    # umfrage einen hoch zaehlen ...
    if ( $menu->getA(3) == 'z' AND is_numeric($menu->getE(3)) AND !isset ($_SESSION['downDoVote'][$row['id']]) AND loggedin() ) {
      $_SESSION['downDoVote'][$row['id']] = 'o';
      $row['vote_wertung'] = round ( ( ( $row['vote_wertung'] * $row['vote_klicks'] ) + $menu->getE(3) ) / ( $row['vote_klicks'] + 1 ) , 3 ); 
      $row['vote_klicks']++;
      db_query("UPDATE prefix_downloads SET vote_wertung = ".$row['vote_wertung'].", vote_klicks = ".$row['vote_klicks']." WHERE id = ".$row['id']);
    }
    if ( !isset ($_SESSION['downDoKlick'][$row['id']]) ) {
      $_SESSION['downDoKlick'][$row['id']] = 'o';
      db_query("UPDATE prefix_downloads SET hits = hits +1 WHERE id = ".$fid);
    }
    
		$cid = $row['cat'];
		$erg1 = db_query("SELECT id,cat,name FROM prefix_downcats WHERE id = ".$cid);
		if ( db_num_rows($erg1) > 0 ) {
		  $row1 = db_fetch_assoc($erg1);
			$array = get_cats_array($row1['cat'],'');
			if ( !empty($array) ) {
			  $titelzw = get_cats_title($array);
			  $namezw = get_cats_urls($array);
			} else {
			  $titelzw = '';
				$namezw = '';
			}
		  $cattitle = ':: '.$titelzw.$row1['name'].' :: '.$row['name'].' '.$row['version'];
			$catname = '<b> &raquo; </b>'.$namezw.'<a class="smalfont" href="?downloads-'.$row1['id'].'">'.$row1['name'].'</a><b> &raquo; </b>'.$row['name'].' '.$row['version'];	
		} else {
		  $cattitle = '';
			$catname = '';
		}
		$tpl = new tpl ('downloads_show' );
		$drecht = $row['drecht'];
    if ( $_SESSION['authright'] <= $drecht ) {
		$row['downlink'] = '<a class="btn btn-success btn-large" href="index.php?downloads-down-'.$row['id'].'"><i class="icon-download"></i> Download</a>';
		} else {
		$row['downlink'] = '<a class="btn btn-danger btn-large" href="index.php?downloads-error"><i class="icon-download"></i> Download</a>'; 
		}
    $row['ssurl'] = ( $row['ssurl'] != '' ? '<img src="'.$row['ssurl'].'"style="max-width:350px; max-height:350px; float:left; border: none; padding-right:5px;" />' : '' );
    
    $row['surl']  = ( empty($row['surl']) ? '<button class="btn btn-danger btn-large"><i class="icon-desktop"></i> No Screen</button>' :
                                            '<a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display=\'block\';document.getElementById(\'fade\').style.display=\'block\'"><button class="btn btn-info btn-large" ><i class="icon-desktop"></i> Screen ansehen</button></a>
                                                <div id="light" class="hdbgwhite_content">
                                                    <a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'" class="hdbgtextright"><i class="icon-remove-sign"></i>  Close</a></br>
                                                        <img src="'.$row['surl'].'" alt="Screenshot"  style="max-width:1050px; max-height:800px;border: none;"/></br>
                                                <a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'" class="hdbgtextleft"><i class="icon-remove-sign"></i>  Close</a>            
                                                </div>
                                            <div id="fade" class="hdbgblack_overlay"></div>' );

    $row['demo']  = ( empty($row['demo']) ? '<button class="btn btn-danger btn-large"><i class="icon-share"></i> No Demo</button>' : '<a class="btn btn-warning btn-large" href="'.$row['demo'].'" target="_blank"><i class="icon-share"></i> Demo ansehen</a>' );

    $row['size']  = get_download_size($row['url']);
		$row['descl'] = bbcode($row['descl']);
		$row['version_kl'] = (empty($row['version'])?'':'('.$row['version'].')');
    $title = $allgAr['title'].' :: Downloads '.$cattitle;
    $hmenu = '<a class="smalfont" href="?downloads">Downloads</a>'.$catname;
    $design = new design ( $title , $hmenu );
	  $design->header();
		$tpl->set_ar_out($row,0);
    $design->footer();
	  break;
	case 'down' :
    $fid = $menu->get(2);
    $erg = db_query("SELECT drecht FROM prefix_downloads LEFT JOIN prefix_downcats ON prefix_downcats.id = prefix_downloads.cat WHERE prefix_downloads.id = ".$fid." AND (".$_SESSION['authright']." <= prefix_downloads.drecht OR (prefix_downloads.cat = 0 AND prefix_downcats.recht IS NULL))");    
    if (@db_num_rows($erg) <> 1) {
      $title = $allgAr['title'].' :: Downloads ';
      $hmenu = '<a class="smalfont" href="?downloads">Downloads</a>';
      $design = new design ( $title , $hmenu );
      $design->header();
      echo $lang['nopermission'];
      $design->footer(1);
    }   
 
    $recht = @db_result(db_query("SELECT `recht` FROM `prefix_downcats` LEFT JOIN `prefix_downloads` ON `prefix_downcats`.`id` = `prefix_downloads`.`cat` WHERE `prefix_downloads`.`id` = $fid"),0);
	  $recht = (is_int($recht)?$recht:0);
    if (has_right($recht)) {
      $row = db_fetch_assoc(db_query("SELECT url FROM prefix_downloads WHERE id = ".$fid));
      $url = iurlencode($row['url']);
    } else {
      $url = 'http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"]).'/index.php?downloads';
    }
    db_query("UPDATE prefix_downloads SET downs = downs +1 WHERE id = ".$fid);
		header('location: '.$url);
	  break;
  case 'upload' :
    if ( $allgAr['archiv_down_userupload'] == 1 AND loggedin() AND is_writeable ( 'include/downs/downloads/user_upload' ) ) {
      $title = $allgAr['title'].' :: Downloads :: User - Upload';
      $hmenu = '<a class="smalfont" href="?downloads">Downloads</a><b> &raquo; </b>User - Upload';
      $design = new design ( $title , $hmenu );
	    $design->header();
      
      $re = icUpload(); 
	    if ($re === true) {
        echo 'Erfolgreich eingetragen! ... ein Moderator oder Admin dieser Seite wird den Download in n&auml;chster Zeit freischalten.';
      } else {
        echo '<b>Error:</b><br />'.$re;
      }
      
      $design->footer();
    }
    break;
    case 'error' :
      $title = $allgAr['title'].' :: Downloads Error';
      $hmenu = '<a class="smalfont" href="?downloads">Downloads Error</a>';
      $design = new design ( $title , $hmenu );
      $design->header();
      echo '<table width="100%" class="border" border="0" cellspacing="2" cellpadding="3" align="center">
      <tr><td class="Chead" align="center"><b>Sie haben leider nicht die n&ouml;tigen Rechte um diesen Download nutzen zu k&ouml;nnen.</b></td>
      </tr><tr class="Cdark"><td align="center"><a href="javascript:history.back();"><u>Zurück</u></a> oder <a href="/index.php"><u>Auf die Startseite</u></a></td></tr></table>';
      $design->footer();
   break;
}
?>
