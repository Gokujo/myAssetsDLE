<?php
//	===============================
//	Globale Einstellungen
//  Глобальные настройки
//	===============================
//	Autor: Maxim Harder
//	Web: https://maxim-harder.de
//	Telegram: http://t.me/MaHarder
//	===============================
//	Nichts verändern
//	Ничего не менять
//	===============================

if( !defined( 'DATALIFEENGINE' ) ) die( "Oh! You little bastard!" );

$cssfiles = [
    'engine/skins/maharder/css/frame.css',
    'engine/skins/maharder/css/app.css',
];

$jsfiles = [
    'engine/skins/maharder/js/frame.js',
    'engine/skins/maharder/js/simple-modal.js',
    'engine/skins/maharder/js/app.js',
];

$mh_mod_lang = $mh_mod_lang ? $mh_mod_lang : 'ru';
@include (DLEPlugins::Check(ROOT_DIR . '/language/MaHarder/'.$mh_mod_lang.'/assets.php'));

function impFiles($type, $files) {
    global $config;
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

function segmentTable($name, $inhalt, $first = FALSE) {
    if($first) $active = " active";
    else $active = "";
    $input = $inhalt;
    $out = '<div class="ui bottom attached tab segment'.$active.'" data-tab="'.$name.'"><table class="ui striped table">'.$input.'</table></div>';
    echo $out;
}

function addInput($name, $value, $label, $chosen = false, $type = "text") {
    if($chosen) $placebo = "class=\"chosen\"";
    else $placebo = "";
    $out = "<div class=\"field\"><input type=\"{$type}\" id=\"{$name}\" name=\"save[{$name}]\" placeholder=\"{$label}\" value=\"{$value}\" {$placebo}></div>";
    return $out;
}

function addCheckbox($name, $selected) {
    $selected = $selected ? "checked" : "";
    $out = "<input id=\"{$name}\" class=\"switch\" type=\"checkbox\" name=\"save[{$name}]\" value=\"1\" {$selected}>";

    return $out;
}

function saveButton($save = "") {
    global $mh_lang;
    $save = $save ? $save : $mh_lang['save'];
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
//    global $db, $mh_lang;
//    $tempList = array();
//    $sels = explode(',', $selected);
//    if($value == 'cats') {
//        $cats = $db->query("SELECT id, name FROM " . PREFIX . "_category");
//        while ($entry = $db->get_array($cats)){
//            if(in_array($entry['id'], $sels))
//                $tempList[] = "<option value=\"" . $entry['id'] . "\" selected>" . $entry['name'] . "</option>";
//            else
//                $tempList[] = "<option value=\"" . $entry['id'] . "\">" . $entry['name'] . "</option>";
//        }
//        unset($cats);
//    } elseif (is_array($value)) {
//        foreach ($value as $id => $data) {
//            if(in_array($id, $sels))
//                $tempList[] = "<option value=\"" . $id . "\" selected>" . $data . "</option>";
//            else
//                $tempList[] = "<option value=\"" . $id . "\">" . $data . "</option>";
//        }
//    }
//    $output = "<div class=\"inline field\"><select id=\"{$name}\" name=\"save[{$name}]\" class=\"ui search multiple selection\" multiple>";
//    $output .= implode('', $tempList);
//    $output .= "</select></div>";
//    $output .= "<script>
//
//$(function() {
//    $('#{$name}').dropdown({
//        fields: {
//            values: '{$selected}'
//        }
//    })
//});
//
//
//</script>";
//
//
//    unset($tempList);

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
    } elseif (is_array($value)) {
        foreach ($value as $id => $data) {
            if(in_array($id, $sels)){
                $tempList2[] = "<a class=\"ui label transition visible\" data-value=\"" . $id . "\" style=\"display: inline-block !important;\">" . $data . "<i class=\"delete icon\"></i></a>";
                $activ2 = " active filtered";
                $active = " selected";
            } else {
                $active = "";
                $activ2 = "";
            }
            $tempList[] = "<option value=\"" . $id . "\"".$active.">" . $data . "</option>";
            $tempList3[] = "<div class=\"item".$activ2."\" data-value=\"" . $id . "\">" . $data . "</div>";
        }
    }
    $output = "<div class=\"inline field\"><div class=\"label ui selection fluid dropdown multiple\" tabindex=\"0\"><select id=\"{$name}\" name=\"save[{$name}]\" multiple=\"\" class=\"\">";
    $output .= implode('', $tempList);
    $output .= "</select><input name='save[{$name}]' type='hidden' value='{$selected}'><i class=\"dropdown icon\"></i>";
    $output .= implode('', $tempList2);
    $output .= "<div class=\"text\"></div><div class=\"menu transition hidden\" tabindex=\"-1\">";
    $output .= implode('', $tempList3);
    $output .= "</div></div></div>";
    unset($tempList);
    return $output;

    return $output;
}

function segRow($name, $descr, $action, $id = "") {
    $out = "<div class=\"two column row\"><div class=\"column\"><label for=\"{$id}\">{$name}</label><br><small>{$descr}</small></div><div class=\"column\">";
    if(is_array($action)) {
        foreach ($action as $act) $out .= $act;
    } else $out .= $action;
    $out .= "</div></div>";
    return $out;
}

function formMessage ($id, $header, $text, $show = false) {
    if($show == false) $display = " style='display:none'";
    else $display = "";
    $out = <<<HTML
<div id='{$id}' class="ui warning message"{$display}>
    <div class="header">{$header}</div>
    {$text}
</div>
HTML;
    return $out;
}

function addList ($points = "") {
    $out = "<ul class=\"list\">";
    foreach ($points as $point) $out .= "<li>{$point}</li>";
    $out .= "</ul>";

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

function messageOut($header, $message, $buttons, $type = "info"){
    $button[] = "<div class=\"ui buttons\">";
    foreach ($buttons as $link => $value) {
        $button[] = "<a href=\"{$link}\" class=\"ui button\">{$value}</a>";
    }
    $button[] = "</div>";
    $click = implode("", $button);
    $out = <<<HTML
	<div class="ui {$type} message">
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

function loadXfields($type = "post") {
    if($type == "post")
        $xf_file = file(ENGINE_DIR . '/data/xfields.txt');
    elseif (($type == "user"))
        $xf_file = file(ENGINE_DIR . '/data/xprofile.txt');

    $xf_info = array();
    foreach ($xf_file as $line) {
        $info = explode("|", $line);
        $xf_info[$info[0]] = $info[1];
    }

    return $xf_info;
}

function addDocItem ($icon, $header, $subheader, $content) {
    $out = "<h2 class=\"ui header\"><i class=\"{$icon}\"></i><div class=\"content\">{$header}";
    if(isset($subheader)) $out .= "<div class=\"sub header\">{$subheader}</div>";
    $out .= "</div></h2>";
    $out .= $content;

    return $out;
}

function stepByStep ($items, $type = "ol") {
    if($type == "ol") $list = "ol";
    elseif($type == "li") $list = "li";
    $out = "<{$list}>";
    foreach ($items as $item) {
        $out .= "<li>{$item}</li>";
    }
    $out .= "</{$list}>";

    return $out;
}

function docMenu($items) {
    global $mh_lang;
    $i = 0;
    foreach ($items as $name => $keys) {
        if($i == 0) $active = " active";
        else $active = "";
        $out[] = '<a href="#" class="item'.$active.'" data-tab="'.$name.'"><i class="'.$keys['icon'].'"></i> '.$keys['name'].'</a>';
        $i++;
    }
    $out[] = "<a class=\"item\" data-tab=\"help\"><i class=\"user circle icon\"></i> {$mh_lang['functions_01']}</a>";

    return implode("", $out);
}

function docBoxes ($name, $items, $first = FALSE) {
    if($first) $active = " active";
    else $active = "";
    $input = implode("", $items);
    $out = '<div class="ui segment tab'.$active.'" data-tab="'.$name.'">'.$input.'</div>';
    return $out;
}

function docPage ($columnOne, $columnTwo, $helplink = "", $sitelink = "") {
    global $mh_lang;

    $st_link = str_replace('\helplink', $helplink, $mh_lang['functions_07']);
    $st_link = str_replace('\sitelink', $sitelink, $mh_lang['functions_07']);
    $out = <<<HTML
<div class="ui fluid container">
    <div class="ui equal width stackable divided grid">
			<div class="three wide column sticky">
				<div class="ui vertical fluid tabular menu docMenu">
					{$columnOne}
				</div>
			</div>
			<div class="column content docContent">
				{$columnTwo}
				<div class="ui segment tab" data-tab="help">
                    <h2 class="ui header">
                        <i class="user circle icon"></i>
                        <div class="content">
                           {$mh_lang['functions_01']}
                            <div class="sub header">{$mh_lang['functions_02']} <a href="{$helplink}" target="_blank">{$mh_lang['functions_03']}<i class="fas fa-external-link-alt"></i></a></div>
                        </div>
                    </h2>
                    <p>{$mh_lang['functions_04']}</p>
					<p>{$mh_lang['functions_05']}</p>
                    <p>{$mh_lang['functions_06']}</p>
                    <ul>
                        <li>{$st_link}</li>
						<li>{$mh_lang['functions_08']}</li>
                        <li>{$mh_lang['functions_09']}</li>
                        <li>{$mh_lang['functions_10']}</li>
                        <li>{$mh_lang['functions_11']}</li>
                        <li>{$mh_lang['functions_12']}</li>
                    </ul>
                    <p>{$mh_lang['functions_13']}</p>
                    <ul>
                        <li>{$mh_lang['functions_14']}</li>
                        <li>{$mh_lang['functions_15']}</li>
                        <li>{$mh_lang['functions_16']}</li>
                        <li>{$mh_lang['functions_17']}</li>
                        <li>{$mh_lang['functions_18']}</li>
                        <li>{$mh_lang['functions_19']}</li>
                    </ul>
                    <p>{$mh_lang['functions_20']}</p>
                    <ul>
                        <li><{$mh_lang['functions_21']} Maxim Harder</li>
                        <li>{$mh_lang['functions_22']} <a href="https://t.me/MaHarder" target="_blank" rel="noopener">MaHarder</a></li>
                    </ul>
                    <p>{$mh_lang['functions_23']}</p>
                    <ul>
                    	<li><strong>Webmoney (RU)</strong>:&nbsp;R127552376453</li>
                        <li><strong>Webmoney (USD)</strong>:&nbsp;Z139685140004</li>
                        <li><strong>Webmoney (EU)</strong>:&nbsp;E275336355586</li>
                        <li><strong>PayPal</strong>:&nbsp;<a href="https://paypal.me/MaximH" target="_blank" rel="noopener">paypal.me/MaximH</a></li>
                </ul>
            </div>
		</div>
	</div>
</div>
HTML;

    echo $out;
}

function getUsers() {
    global $db;

    $db->query("SELECT * FROM " . PREFIX . "_users WHERE restricted = '0'");
    $user_ar = array();

    while($build = $db->get_array()) {
        $user_ar[$build['user_id']] = $build['name'];
    }

    $db->free();
    return $user_ar;
}

function getCategories ($news_id, $link = false) {
    global $db, $config, $PHP_SELF;

    $cat_name = array();
    $cats = $db->super_query("SELECT category FROM " . PREFIX . "_post WHERE id = '{$news_id}'");
    $cat = explode(',', $cats['category']);
    foreach ($cat as $category) {
        $temp_cat = $db->super_query("SELECT * FROM " . PREFIX . "_category WHERE id = '{$category}'");
        if($link) {
            if( $config['allow_alt_url'] ) {
                $pid = $temp_cat['parentid'];
                $url = "&lt;a href=\"" . $config['http_home_url'];
                $parent_list = array();
                if(isset($pid) && $pid != 0) {
                    while($pid != 0){
                        $par_id = $db->super_query("SELECT * FROM " . PREFIX . "_category WHERE id = '{$pid}'");
                        $parent_list[] = $par_id['alt_name'];
                        $pid = $par_id['parentid'];
                    }
                }
                rsort($parent_list);
                $parent_list[] = $temp_cat['alt_name'];
                $url .= implode('/', $parent_list) . "/\" &gt;{$temp_cat['name']}&lt;/a&gt;";
                $cat_name[] = $url;
            } else {
                $cat_name[] = "&lt;a href=\"{$PHP_SELF}?do=cat&amp;category={$temp_cat['alt_name']}\"&gt;{$temp_cat['name']}&lt;/a&gt;";
            }
        } else $cat_name[] = $temp_cat['name'];
    }

    return implode($config['category_separator'] ." ", $cat_name);

}

function createTable($body, $header = "", $footer = "") {
    $output = [];

    $thead = [];
    $tbody = [];
    $tfoot = [];

    $tbody[] = "<tbody>";
    foreach ($body as $row => $item) {
        $tbody[] = "<tr>";
        foreach ($item as $value) {
            $tbody[] = "<td>" . $value . "</td>";
        }
        $tbody[] = "</tr>";
    }
    $tbody[] = "</tbody>";

    if(!empty($header)) {
        $thead[] = "<thead><tr>";
        foreach ($header as $name) {
            $tr = "<th>" . $name . "</th>";
            $thead[] = $tr;
        }
        $thead[] = "</tr></thead>";
    }

    if(!empty($footer)) {
        $tfoot[] = "<tfoot><tr>";
        $tfoot[] = $footer;
        $tfoot[] = "</tr></tfoot>";
    }

    $output[] = implode("", $thead);
    $output[] = implode("", $tbody);
    $output[] = implode("", $tfoot);

    return implode("", $output);
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
    public function getLinks($all, $limit, $start, $linkLimit = 10, $varName = 'page', $cstmPage = "") {
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
        if(isset($cstmPage)) {
            foreach ($cstmPage as $name => $page) {
                $queryVars[$name] = $page;
            }
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