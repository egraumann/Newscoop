<?php
//define(_IMG_PREFIX_, '/images/cms-image-');
//define(_DIR_, '/priv/imagearchive/');
define(CAMPSITE_IMAGEARCHIVE_DIR, '/priv/imagearchive/');
//define(_IMAGEMAGICK_, TRUE);
//define(_TUMB_CMD_, 'convert -sample 64x64');
//define(_TUMB_PREFIX_, '/images/tumbnails/cms-tumb-');
//define(_TMP_DIR_, '/tmp/');


function orE($p_input)
{
	if (empty($p_input)) {
		return 'unknown';
	} else {
		return $p_input;
	}
} // fn orE

function trColor()
{
	global $color;

	if ($color) {
		$color = 0;
		return 'BGCOLOR="#D0D0B0"';
	} else {
		$color = 1;
		return 'BGCOLOR="#D0D0D0"';
	}
}

class ImageLink {
	var $m_isSearch;
	var $m_orderBy;
	var $m_orderDirection;
	var $m_view;
	var $m_imageOffset;
	var $m_imagesPerPage;
	var $m_searchDescription;
	var $m_searchPhotographer;
	var $m_searchDate;
	var $m_searchInUse;
	
	function ImageLink($p_request) {
		$this->m_isSearch = isset($p_request['is_search'])?$p_request['is_search']:0;
		$this->m_orderBy = isset($p_request['order_by'])?$p_request['order_by']:'id';
		$this->m_rderDirection =
			isset($p_request['order_direction'])?$p_request['order_direction']:'ASC';
		$this->m_view = isset($p_request['view'])?$p_request['view']:'thumbnail';
		$this->m_imageOffset = isset($p_request['image_offset'])?$p_request['image_offset']:0;
		$this->m_imagesPerPage = 20;
		
		$this->m_searchDescription = 
			isset($p_request['search_description'])?$p_request['search_description']:null;
		$this->m_searchPhotographer = 
			isset($p_request['search_photographer'])?$p_request['search_photographer']:null;
		$this->m_searchDate = isset($p_request['search_date'])?$p_request['search_date']:null;
		$this->m_searchInUse = isset($p_request['search_inuse'])?$p_request['search_inuse']:null;
	    
		$searchKeywords = array('description' => $SearchDescription,
								'photographer' => $SearchPhotographer,
								'date' => $SearchDate,
								'inuse' => $SearchInUse);
		if (!is_null($p_searchKeywords)) {
	    	$keywordSearch = false;
	    	foreach ($p_searchKeywords as $fieldName => $keyword) {
	    		if (!is_null($keyword)) {
	    			$Link['search'] .= '&'.$fieldName.'='.urlencode($keyword);
	    			$keywordSearch = true;
	    		}
	    	}
	    	if ($keywordSearch) {
		    	$Link['search'] .= '&is_search=1';		
	    	}
	    }
	}	
	
	function getOrderByLink($p_columnName) {
		return CAMPSITE_IMAGEARCHIVE_DIR.'?order_by='.$p_columnName.$this->getSearchUrlPart()
			.'&'.$p_columnName.'=0';
	}
	
	function getOrderBy() {
		return $this->m_orderBy;
	}
	
	function getOrderDirection() {
		return $this->m_orderDirection;	
	}
	
	function getSearchUrlPart() {
		
	}
	
	function getOrderUrlPart() {
		
	}
}


function cImgLink($p_searchKeywords = null, $p_orderBy = null, $p_orderDirection = null, $p_imageOffset = -1, $p_imagesPerPage = 20, $p_view)
{
	//global $S, $de, $ph, $da, $use, $O, $ImgOffs, $lpp, $D, $v;

	// regarding parameters from search form or link //////////////////////
//	todef('S');
//	todef('de');
//	todef('ph');
//	todef('da');
//	todef('use');
//    todef('v');

    if (!is_null($p_searchKeywords)) {
    	$keywordSearch = false;
    	foreach ($p_searchKeywords as $fieldName => $keyword) {
    		if (!is_null($keyword)) {
    			$Link['search'] .= '&'.$fieldName.'='.urlencode($keyword);
    			$keywordSearch = true;
    		}
    	}
    	if ($keywordSearch) {
	    	$Link['search'] .= '&is_search=1';		
    	}
    }
//	if ($S && (isset($de) || isset($ph)  || isset($da)|| isset($use))) {
//
//		if (isset($de)) {
//			$Link['S']   .= "&S=1&de=".urlencode($de);
//		}
//		if (isset($ph)) {
//			$Link['S']   .= "&S=1&ph=".urlencode($ph);
//		}
//		if (isset($da)) {
//			$Link['S']   .= "&S=1&da=".urlencode($da);
//		}
//		if (isset($use)) {   
//			$Link['S']   .= "&S=1&use=".urlencode($use);
//		}
//
//	}
	////////////////////////////////////////////////////////////////////

	// build the order statement ///////////////////////////////////////
	//todef('O');
	//todef('D');

//	if ($D == 'ASC') {
//		$HrefDir  = "ASC";
//	} else {
//		$HrefDir  = "DESC";
//	}

	if (!is_null($p_orderBy)) {
		$Link['order_by'] .= '&order_by='.$p_orderBy.'&order_direction='.$p_orderDirection;
	}
//	switch ($p_orderBy) {
//	case 'de':
//		$Link['O'] .= '&O=de&D='.$HrefDir;
//		break;
//
//	case 'ph':
//		$Link['O'] .= '&O=ph&D='.$HrefDir;
//		break;
//
//	case 'da':
//		$Link['O'] .= '&O=da&D='.$HrefDir;
//		break;
//
//	case 'use':
//		$Link['O'] .= '&O=use&D='.$HrefDir;
//		break;
//
//	case 'id':
//	default:
//		$Link['O'] .= '&O=id&D='.$HrefDir;
//		break;
//	}
	// calculationg offset
//	todefnum('ImgOffs');
//	todefnum('lpp', 20);
//
	if ($p_imageOffset < 0) {
		$p_imageOffset = 0;
	}

//	// Prev/Next switch
	$Link['previous'] = 'image_offset='.($p_imageOffset - $p_imagesPerPage).$Link['search'].$Link['order_by'].'&view='.$p_view;
	$Link['next'] = 'image_offset='.($p_imageOffset + $p_imagesPerPage).$Link['search'].$Link['order_by'].'&view='.$p_view;

	$Link['search'] .= '&image_offset='.$p_imageOffset.'&view='.$p_view;
//	$Link['SO'] = $Link['S'].$Link['O'];

	return $Link;
}
//function cImgLink()
//{
//	global $S, $de, $ph, $da, $use, $O, $ImgOffs, $lpp, $D, $v;
//
//	// regarding parameters from search form or link //////////////////////
//	todef('S');
//	todef('de');
//	todef('ph');
//	todef('da');
//	todef('use');
//    todef('v');
//
//	if ($S && (isset($de) || isset($ph)  || isset($da)|| isset($use))) {
//
//		if (isset($de)) {
//			$Link['S']   .= "&S=1&de=".urlencode($de);
//		}
//		if (isset($ph)) {
//			$Link['S']   .= "&S=1&ph=".urlencode($ph);
//		}
//		if (isset($da)) {
//			$Link['S']   .= "&S=1&da=".urlencode($da);
//		}
//		if (isset($use)) {   
//			$Link['S']   .= "&S=1&use=".urlencode($use);
//		}
//
//	}
//	////////////////////////////////////////////////////////////////////
//
//	// build the order statement ///////////////////////////////////////
//	todef('O');
//	todef('D');
//
//	if ($D == 'ASC') {
//		$HrefDir  = "ASC";
//	} else {
//		$HrefDir  = "DESC";
//	}
//
//	switch ($O) {
//	case 'de':
//		$Link['O'] .= '&O=de&D='.$HrefDir;
//		break;
//
//	case 'ph':
//		$Link['O'] .= '&O=ph&D='.$HrefDir;
//		break;
//
//	case 'da':
//		$Link['O'] .= '&O=da&D='.$HrefDir;
//		break;
//
//	case 'use':
//		$Link['O'] .= '&O=use&D='.$HrefDir;
//		break;
//
//	case 'id':
//	default:
//		$Link['O'] .= '&O=id&D='.$HrefDir;
//		break;
//	}
//	// calculationg offset
//	todefnum('ImgOffs');
//	todefnum('lpp', 20);
//
//	if ($ImgOffs < 0) {
//		$ImgOffs= 0;
//	}
//
//	// Prev/Next switch
//	$Link['P'] = 'ImgOffs='.($ImgOffs - $lpp).$Link['S'].$Link['O'].'&v='.$v;
//	$Link['N'] = 'ImgOffs='.($ImgOffs + $lpp).$Link['S'].$Link['O'].'&v='.$v;
//
//	$Link['S'] .= '&ImgOffs='.$ImgOffs.'&v='.$v;
//	$Link['SO'] = $Link['S'].$Link['O'];
//
//	return $Link;
//}

//function handleRemoteImg ($cDescription, $cPhotographer, $cPlace, $cDate, $cURL, $Id=0)
//{
//    include_once('Yahc.class.php');
//    $data = new Yahc($cURL, 'CAMPWARE');
//    $data->request_protocol = 'HTTP/1.0';
//    $data->request_method = 'GET';
//    if ($data->connect()) {
//        // URL OK
//        #echo "connect<br>";
//        $data->send_request();
//        $data->get_response();
//            $hrows = explode ("\r\n", $data->response_HEADER);
//        foreach ($hrows as $row) {
//            if (preg_match('/Content-Type:/', $row)) {
//                $ctype = trim(substr($row, strlen('Content-Type:')));
//            }
//        }
//        #echo "ctype $ctype";
//
//        if (preg_match('/image/', $ctype)) {
//            // content-type = image
//            if ($Id) {
//                $query = "UPDATE Images
//                          SET Description='$cDescription', Photographer='$cPhotographer', Place='$cPlace', Date='$cDate', ContentType='$ctype', Location='remote', URL='$cURL'
//                          WHERE Id=$Id
//                          LIMIT 1";
//                query($query);    
//                $currId = $Id;
//            } else {
//                $query = "INSERT INTO Images
//                          (Description, Photographer, Place, Date, ContentType, Location, URL)
//                           VALUES
//                          ('$cDescription', '$cPhotographer', '$cPlace', '$cDate', '$ctype', 'remote', '$cURL')";
//                query($query);
//                $currId = mysql_insert_id();
//            }
//
//            if (_IMAGEMAGICK_) {
//                $tmpname =_TMP_DIR_.'img'.md5(rand());
//                if ($tmphandle = fopen($tmpname, 'w')) {
//                    fwrite($tmphandle, $data->response_HTML);
//                    fclose($tmphandle);
//                    $cmd = _TUMB_CMD_.' '.$tmpname.' '.$_SERVER[DOCUMENT_ROOT]._TUMB_PREFIX_.$currId;
//                    system($cmd);
//                    unlink($tmpname);
//                } else {
//                    return getGS('Cannot create <B>$1</B>', $tmpname);
//                }
//            }
//        } else {
//            // wrong URL
//            return getGS('URL <B>$1</B> have wrong content type <B>$2</B>', $cURL, $ctype);
//        }
//    } else {
//        // no connection
//        return getGS('Unable to read image from <B>$1</B>', $cURL);
//    }
//}
//
//function handleLocalImage($cImageTemp, $cDescription, $cPhotographer, $cPlace, $cDate, $cURL, $Id=0)
//{
// 	if ($Id) {
//        $query = "UPDATE Images
//                  SET Description='$cDescription', Photographer='$cPhotographer', Place='$cPlace', Date='$cDate', ContentType='$ctype', Location='local', URL=''
//                  WHERE Id=$Id
//                  LIMIT 1";
//        query($query); 
//        $currId = $Id;
//    } else {
//        $query = "INSERT INTO Images
//                  (Description, Photographer, Place, Date, ContentType, Location)
//                  VALUES
//                  ('$cDescription', '$cPhotographer', '$cPlace', '$cDate', '$cImageType', 'local')";
//        query($query);
//        $currId = mysql_insert_id();
//    }
//
//    $target = $_SERVER[DOCUMENT_ROOT]._IMG_PREFIX_.$currId;
//    $tumb   = $_SERVER[DOCUMENT_ROOT]._TUMB_PREFIX_.$currId;
//
//    if (!$Id) {
//        if (!move_uploaded_file ($cImageTemp, $target)) {
//             return getGS('Unable to move Image to <B>$1</B>', $target);
//        }
//
//        if (_IMAGEMAGICK_) {
//            $cmd = _TUMB_CMD_.' '.$target.' '.$tumb;
//            #echo $cmd;
//            system($cmd);
//        }
//    }
//}
?>
