<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adodb {
	function __construct() {

		$db_handle = null;
		if ( ! class_exists('ADONewConnection') )
		{
     		require_once(APPPATH.'libraries/adodb5/adodb.inc'.EXT);
		}

		$obj =& get_instance();
		$this->_init_adodb_library($obj);
		$obj->ci_is_loaded[] = 'adodb';
	}

    function _init_adodb_library(&$ci) {
        $db_var = false;
        $debug = false;
        
        // try to load config/adodb.php
        // extra parameter comes from patch at http://www.codeigniter.com/wiki/ConfigLoadPatch/
        // without this patch, if config/adodb.php doesn't exist, CI will display a fatal error.
        if ($ci->config->load('adodb',true)) {
            $cfg = $ci->config->item('adodb');
            if (isset($cfg['dsn'])) {
                $dsn = $cfg['dsn'];
            }
            
            // set db_var if it's set in the config file, or false otherwise
            $db_var = isset($cfg['db_var']) && $cfg['db_var'];
            
            $debug = isset($cfg['debug']) && $cfg['debug'];
        } 
        
        if (!isset($dsn)) {
            // fallback to using the CI database file
            include(APPPATH.'config/database'.EXT);
            $group = 'default';
            $dsn = $db[$group]['dbdriver'].'://'.$db[$group]['username']
                   .':'.$db[$group]['password'].'@'.$db[$group]['hostname']
                   .'/'.$db[$group]['database'];
        }
        
        // $ci is by reference, refers back to global instance
        $ci->adodb =& ADONewConnection($dsn);
		$this->db_handle = $ci->adodb;
        
        if ($db_var) {
            // also set the normal CI db variable
            $ci->db =& $ci->adodb;
        }
        
        if ($debug) {
            $ci->adodb->debug = true;
        }
    }

 // taken from adodb5/pivottable.php
 function PivotTableSQL($tables,$rowfields,$colfield, $where=false,
 	$aggfield = false,$sumlabel='Sum ',$aggfn ='SUM', $showcount = true)
 {
	$db = $this->db_handle ;
//$db->debug = true;
	if ($aggfield) $hidecnt = true;
	else $hidecnt = false;
	
	$iif = strpos($db->databaseType,'access') !== false; 
		// note - vfp 6 still doesn' work even with IIF enabled || $db->databaseType == 'vfp';
	
	//$hidecnt = false;
	
 	if ($where) $where = "\nWHERE $where";
//echo ("select distinct $colfield from $tables $where order by 1\n\n\n\n");
	if (!is_array($colfield)) $colarr = $db->GetCol("select distinct $colfield from $tables $where order by 1");

	if (!$aggfield) $hidecnt = false;
	
	$sel = "$rowfields, ";
	if (is_array($colfield)) {
		foreach ($colfield as $k => $v) {
			$k = trim($k);
			if (!$hidecnt) {
				$sel .= $iif ? 
					"\n\t$aggfn(IIF($v,1,0)) AS \"$k\", "
					:
					"\n\t$aggfn(CASE WHEN $v THEN 1 ELSE 0 END) AS \"$k\", ";
			}
			if ($aggfield) {
				$sel .= $iif ?
					"\n\t$aggfn(IIF($v,$aggfield,0)) AS \"$sumlabel$k\", "
					:
					"\n\t$aggfn(CASE WHEN $v THEN $aggfield ELSE 0 END) AS \"$sumlabel$k\", ";
			}
		} 
	} else {
		foreach ($colarr as $v) {
			if (!is_numeric($v)) $vq = $db->qstr($v);
			else $vq = $v;
			$v = trim($v);
			if (strlen($v) == 0	) $v = 'null';
			if (!$hidecnt) {
				$sel .= $iif ?
					"\n\t$aggfn(IIF($colfield=$vq,1,0)) AS \"$v\", "
					:
					"\n\t$aggfn(CASE WHEN $colfield=$vq THEN 1 ELSE 0 END) AS \"$v\", ";
			}
			if ($aggfield) {
				if ($hidecnt) $label = $v;
				else $label = "{$v}_$aggfield";
				$sel .= $iif ?
					"\n\t$aggfn(IIF($colfield=$vq,$aggfield,0)) AS \"$label\", "
					:
					"\n\t$aggfn(CASE WHEN $colfield=$vq THEN $aggfield ELSE 0 END) AS \"$label\", ";
			}
		}
	}
	if ($aggfield && $aggfield != '1'){
		$agg = "$aggfn($aggfield)";
		$sel .= "\n\t$agg as \"$sumlabel$aggfield\", ";		
	}
	
	if ($showcount)
		$sel .= "\n\tSUM(1) as Total";
	else
		$sel = substr($sel,0,strlen($sel)-2);
	
	
	// Strip aliases
	$rowfields = preg_replace('/ AS (\w+)/i', '', $rowfields);
	
	$sql = "SELECT $sel \nFROM $tables $where \nGROUP BY $rowfields";
	echo $sql ; exit;
	
	return $sql;
 }

// RecordSet to HTML Table
//------------------------------------------------------------
// Convert a recordset to a html table. Multiple tables are generated
// if the number of rows is > $gSQLBlockRows. This is because
// web browsers normally require the whole table to be downloaded
// before it can be rendered, so we break the output into several
// smaller faster rendering tables.
//
// $rs: the recordset
// $ztabhtml: the table tag attributes (optional)
// $zheaderarray: contains the replacement strings for the headers (optional)
//
//  USAGE:
//	include('adodb.inc.php');
//	$db = ADONewConnection('mysql');
//	$db->Connect('mysql','userid','password','database');
//	$rs = $db->Execute('select col1,col2,col3 from table');
//	rs2html($rs, 'BORDER=2', array('Title1', 'Title2', 'Title3'));
//	$rs->Close();
//
// RETURNS: number of rows displayed


function pivot2json(&$rs, $returnArray = false)
{
//	$rs = $this->db_handle ;
// specific code for tohtml
//GLOBAL $gSQLMaxRows,$gSQLBlockRows,$ADODB_ROUND;

	$ADODB_ROUND=4; // rounding
	$gSQLMaxRows = 1000; // max no of rows to download
	$gSQLBlockRows=20; // max no of rows per table block
	$s ='';$rows=0;$docnt = false;
	//GLOBAL $gSQLMaxRows,$gSQLBlockRows,$ADODB_ROUND;

	if (!$rs) {
		printf(ADODB_BAD_RS,'pivot2json');
		return false;
	}
	
	$typearr = array();
	$ncols = $rs->FieldCount();
	
	$row = 0;
	$out = array();	
	$out[$row] = array();	
	
	for ($i=0; $i < $ncols; $i++) {	
		$field = $rs->FetchField($i);
		if ($field) {
			$fname = htmlspecialchars($field->name);	
			$typearr[$i] = $rs->MetaType($field->type,$field->max_length); 			
		} else {
			$fname = 'Field '.($i+1);
			$typearr[$i] = 'C';
		}
		
		if (strlen($fname)==0) $fname = '&nbsp;';
		
		$out[$row][$i] = $fname;
	}
	
	$row++;
		
	// smart algorithm - handles ADODB_FETCH_MODE's correctly by probing...
	$numoffset = isset($rs->fields[0]) ||isset($rs->fields[1]) || isset($rs->fields[2]);
	while (!$rs->EOF) {

		$out[$row] = array();
		
		for ($i=0; $i < $ncols; $i++) {
			if ($i===0) $v=($numoffset) ? $rs->fields[0] : reset($rs->fields);
			else $v = ($numoffset) ? $rs->fields[$i] : next($rs->fields);
			
			$out[$row][$i] = '';
			
			$type = $typearr[$i];						
			switch($type) {
			case 'D':
				if (strpos($v,':') !== false);
				else {
					if (!empty($v)) {				
						$out[$row][$i] = $rs->UserDate($v,"D d, M Y");				
					}
					break;
				}							
			case 'T':
				if (!empty($v)) {
					$out[$row][$i]  = $rs->UserTimeStamp($v,"D d, M Y, H:i:s");
				}							
			break;
			
			case 'N':
				if (abs(abs($v) - round($v,0)) < 0.00000001)
					$v = round($v);
				else
					$v = round($v,$ADODB_ROUND);
			case 'I':
				$vv = stripslashes((trim($v)));
				if (strlen($vv) != 0) {				
			   		$out[$row][$i]  = $vv;
				}
			break;
			/*
			case 'B':
				if (substr($v,8,2)=="BM" ) $v = substr($v,8);
				$mtime = substr(str_replace(' ','_',microtime()),2);
				$tmpname = "tmp/".uniqid($mtime).getmypid();
				$fd = @fopen($tmpname,'a');
				@ftruncate($fd,0);
				@fwrite($fd,$v);
				@fclose($fd);
				if (!function_exists ("mime_content_type")) {
				  function mime_content_type ($file) {
				    return exec("file -bi ".escapeshellarg($file));
				  }
				}
				$t = mime_content_type($tmpname);
				$s .= (substr($t,0,5)=="image") ? " <td><img src='$tmpname' alt='$t'></td>\\n" : " <td><a
				href='$tmpname'>$t</a></td>\\n";
				break;
			*/

			default:
				$v = trim($v);
				if (strlen($v) != 0) {				
					$out[$row][$i]  = str_replace("\n",'<br>',stripslashes($v));
				}
			}
		}
			  
		$rows += 1;
		
		$row++;
		
		if ($rows >= $gSQLMaxRows) {
			$rows = "<p>Truncated at $gSQLMaxRows</p>";
			break;
		} // switch

		$rs->MoveNext();	
	} // while		
	
	return $returnArray ? $out : 
						  json_encode($out);
 }
}
?>
