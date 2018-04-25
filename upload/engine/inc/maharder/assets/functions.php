<?php

//	===============================
//	Глобальные функции
//	===============================
//	Автор: Maxim Harder
//	Сайт: https://maxim-harder.de
//	Телеграм: http://t.me/MaHarder
//	===============================
//	Ничего не менять
//	===============================

if( !defined( 'DATALIFEENGINE' ) ) die( "Oh! You little bastard!" );

$cssfiles = [
	'/engine/skins/maharder/css/frame.css',
	'/engine/skins/maharder/css/app.css',
];
$jsfiles = [
	'/engine/skins/maharder/js/frame.js',
	'/engine/skins/maharder/js/app.js',
];

function impFiles($type, $files) {
	foreach ($files as $file) {
		if($type=='css')  $out[] = "<link rel=\"stylesheet\" href=\"".$file."\">";
		if($type=='js')  $out[] = "<script src=\"".$file."\"></script>";
	}
	echo implode("", $out);
}

function boxes($list) {
	$out = '<div class="ui top attached tabular menu" id="box-navi">';
	$count = 0;
	foreach ($list as $name => $keys) {
		if($count == 0) $active = " active";
		else $active = "";
		$out .= '<a href="#" class="item'.$active.'" data-tab="'.$name.'"><i class="'.$keys['icon'].'"></i>&nbsp;&nbsp;'.$keys['name'].'</a>';
		$count++;
	}
	$out .= '</div>';
	echo $out;
}

function segment($name, $inhalt, $first = FALSE) {
	if($first) $active = " active";
	else $active = "";
	$input = implode("", $inhalt);
	$out = '<div class="ui bottom attached tab segment'.$active.'" data-tab="'.$name.'"><div class="ui four column grid">'.$input.'</div></div>';
	echo $out;
}

function addInput($name, $value, $label, $chosen = false) {
	if($chosen) $placebo = "class=\"chosen\"";
	else $placebo = "";
	$out = "<div class=\"field\"><input type=\"text\" id=\"{$name}\" name=\"save[{$name}]\" placeholder=\"{$label}\" value=\"{$value}\" {$placebo}></div>";
	return $out;
}

function addCheckbox($name, $selected) {
	$selected = $selected ? "checked" : "";
	$out = "<input id=\"{$name}\" class=\"switch\" type=\"checkbox\" name=\"save[{$name}]\" value=\"1\" {$selected}>";
	
	return $out;
}

function saveButton($save = "Сохранить") {
	$out = "<button class=\"fluid ui positive button\"><i class=\"save icon\"></i>&nbsp;&nbsp;{$save}</button>";
	echo $out;
}

function addTextarea($name, $value, $label) {
	$out = "<div class=\"field\"><textarea id=\"{$name}\" name=\"save[{$name}]\" placeholder=\"{$label}\">{$value}</textarea></div>";
	return $out;
}

function addSelect($name, $value, $label, $selected) {
	$output = "<div class=\"field\"><div class=\"ui selection dropdown\"><input type=\"hidden\" name=\"save[{$name}]\" value=\"{$selected}\"><i class=\"dropdown icon\"></i><div class=\"default text\">{$label}</div><div class=\"menu\">";
	foreach ( $value as $values => $description ) {
		$output .= "<div data-value=\"{$values}\" class=\"item";
		if( $selected == $values ) {
			$output .= "  active selected";
		}
		$output .= "\">{$description}</div>\n";
	}
	$output .= "</div></div></div>";
	return $output;
}

function addChosenSelect($name, $value, $selected) {
    global $db;
    $tempList = array();
    $tempList2 = array();
    $tempList3 = array();
    $sels = explode(',', $selected);
    if($value == 'cats') {
        $cats = $db->query("SELECT id, name FROM " . PREFIX . "_category");
        while ($entry = $db->get_array($cats)){
            if (in_array($entry['id'], $sels)) {
				$tempList2[] = "<a class=\"ui label transition visible\" data-value=\"" . $entry['id'] . "\" style=\"display: inline-block !important;\">" . $entry['name'] . "<i class=\"delete icon\"></i></a>";
				$activ2 = " active filtered";
				$active = " selected";
			} else {
				$active = "";
				$activ2 = "";
			}
			$tempList[] = "<option value=\"" . $entry['id'] . "\"".$active.">" . $entry['name'] . "</option>";
			$tempList3[] = "<div class=\"item".$activ2."\" data-value=\"" . $entry['id'] . "\">" . $entry['name'] . "</div>";
        }
        unset($cats);
    }
    $output = "<div class=\"inline field\"><div class=\"label ui selection fluid dropdown multiple\" tabindex=\"0\"><select id=\"{$name}\" name=\"{$name}[]\" multiple=\"\" class=\"\">";
    $output .= implode('', $tempList);
	$output .= "</select><i class=\"dropdown icon\"></i>";
	$output .= implode('', $tempList2);
	$output .= "<div class=\"text\"></div><div class=\"menu transition hidden\" tabindex=\"-1\">";
	$output .= implode('', $tempList3);
	$output .= "</div></div></div>";

    unset($tempList);
    return $output;
}

function segRow($name, $descr, $action, $id = "") {
	$out = "<div class=\"two column row\"><div class=\"column\"><label for=\"{$id}\">{$name}</label><br><small>{$descr}</small></div><div class=\"column\">{$action}</div></div>";
	return $out;
}

function author($type) {
	global $author, $changes;

	switch ($type) {
		case 'name':
			return $author['name']." [<a href=\"{$author['site']}\" target=\"_blank\">сайт</a>]";
			break;
		
		case 'social':
			$out[] = "<ul>";
			foreach($author['social'] as $name => $link) {
				$out[] = "<li><b>{$name}</b>: {$link}</li>";
			}
			$out[] = "</ul>";
			return implode("", $out);
			break;

		case 'changes':
			$out[] = "<ul>";
			foreach($changes as $nummer => $new) {
				$temp = "<li><b>{$nummer}</b>: <ul>";
				foreach ($new as $change) {
					$temp .= "<li>{$change}</li>";
				}
				$temp .= "</ul></li>";
				$out[] = $temp;
			}
			$out[] = "</ul>";
			return implode("", $out);
			break;
	}
}

function messageOut($header, $message, $buttons){
	$button[] = "<div class=\"ui buttons\">";

	foreach ($buttons as $link => $value) {
		$button[] = "<a href=\"{$link}\" class=\"ui button\">{$value}</a>";
	}
	$button[] = "</div>";
	$click = implode("", $button);

	$out = <<<HTML
	<div class="ui info message">
    	<div class="header">
      		{$header}
    	</div>
    	<p>{$message}</p>
		{$click}
	</div>
HTML;
	echo $out;
}

function getXfields($id, $type = "post") {
	global $db;

	if($type == "post")
		$post = $db->super_query("SELECT xfields FROM " . PREFIX . "_post WHERE id = '{$id}'");
	 elseif($type == "user")
		$post = $db->super_query("SELECT xfields FROM " . PREFIX . "_users WHERE user_id = '{$id}'");
	
	if($post) {
		$xfout = array();
		$fields = explode('||', $post['xfields']);
		foreach ($fields as $key => $value) {
			$xfout[$key] = $value;
		}
	} else $xfout = false;

	return $xfout;
}

class pagination {
	protected $id;
	protected $startChar;
	protected $prevChar;
    protected $nextChar;
    protected $endChar;
	public function __construct ($id = 'pagination', $startChar = '<i class="angle double left icon"></i>', $prevChar  = '<i class="left chevron icon"></i>', $nextChar  = '<i class="right chevron icon"></i>', $endChar   = '<i class="angle double right icon"></i>') {
		$this->id = $id;
		$this->startChar = $startChar;
      	$this->prevChar  = $prevChar;
		$this->nextChar  = $nextChar;
		$this->endChar   = $endChar;
    }   

	public function getLinks($all, $limit, $start, $linkLimit = 10, $varName = 'page') {
		if ( $limit >= $all || $limit == 0 ) {
			return NULL;
		}     
         
		$pagess = 0;
		$needChunk = 0;
		$queryVars = array();
		$pagessArr = array();
		$htmlOut = '';
		$link = NULL;
       
		parse_str($_SERVER['QUERY_STRING'], $queryVars );
		if( isset($queryVars[$varName]) ) {
			unset( $queryVars[$varName] );
		}
		$link  = $_SERVER['PHP_SELF'].'?'.http_build_query( $queryVars );
	  
		$pagess = ceil( $all / $limit );
		for( $i = 0; $i < $pagess; $i++) {
			$pagessArr[$i+1] = $i * $limit;
		}
		$allPages = array_chunk($pagessArr, $linkLimit, true);
		$needChunk = $this->searchPage( $allPages, $start );
       
		if ( $start > 1 ) {
			$htmlOut .= '<a href="'.$link.'" class="item">'.$this->startChar.'</a>'.
						'<a href="'.$link.'&'.$varName.'='.ceil($start / $limit).'" class="item">'.$this->prevChar.'</a>';   
		} else {
			$htmlOut .= '<a class="item disabled">'.$this->startChar.'</a>'.
						'<a class="item disabled">'.$this->prevChar.'</a>'; 
		}

		foreach( $allPages[$needChunk] AS $pageNum => $ofset )  {
			if( $ofset == $start  ) {
				$htmlOut .= '<a class="item active">'. $pageNum .'</a>';            
				continue;
			}        
			$htmlOut .= '<a href="'.$link.'&'.$varName.'='. $pageNum .'" class="item">'. $pageNum . '</a>';
		}

		if ( ($all - $limit) >  $start) {
			$htmlOut .= '<a href="' . $link . '&' . $varName . '=' . (ceil(( $start + $limit)/$limit)+1) . '" class="item">' . $this->nextChar . '</a>'.
						'<a href="' . $link . '&' . $varName . '=' . $pagess . '" class="item">' . $this->endChar . '</a>';            
		} else {
			$htmlOut .= '<a class="item disabled">' . $this->nextChar . '</a>'.
						'<a class="item disabled">' . $this->endChar . '</a>';         
		}         
		return '<div class="ui right floated pagination menu" id="'.$this->id.'">' . $htmlOut . '</div>';
	}
	
    protected function searchPage( array $pagessList, $needPage ) {
        foreach( $pagessList AS $chunk => $pagess  ){
            if( in_array($needPage, $pagess) ){
                return $chunk;
            }
        }
        return 0;
    }    
}

?>