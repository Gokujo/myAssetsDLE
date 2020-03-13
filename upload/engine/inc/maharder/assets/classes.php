<?php
	////////////////////////////////////////////////////////////
	// =======================================================
	// Модуль: MaHarder Assets
	// Файл: functions.php
	// Путь: /engine/inc/maharder/assets/classes.php
	// =======================================================
	// Автор: Maxim Harder (c) 2019
	// Сайт: https://maxim-harder.de / https://devcraft.club
	// Телеграм: http://t.me/MaHarder
	// =======================================================
	// Ничего не менять
	// =======================================================
	////////////////////////////////////////////////////////////

	if( !defined( 'DATALIFEENGINE' ) ) die( "Oh! You little bastard!" );

/**
 * Class mhAdmin
 */
class mhAdmin {

	private $cssfiles = [
		'engine/skins/maharder/css/frame.css',
		'engine/skins/maharder/css/app.css',
	];
	private $jsfiles = [
		'engine/skins/maharder/js/frame.js',
		'engine/skins/maharder/js/simple-modal.js',
		'engine/skins/maharder/js/autosize.min.js',
		'engine/skins/maharder/js/app.js',
	];
	private $webSite = [
		'header' => [],
		'boxes' => [],
		'segment' => [],
		'other' => [],
		'footer' => [],
	];

	/**
	 * mhAdmin constructor.
	 *
	 * @param array $config
	 */
	public function __construct($config = [
		'embed' => [
			'css' => [],
			'js' => []
		]
	]) {
		if (!empty($config['embed']['css'])) $this->setCssfiles($config['embed']['css']);
		if (!empty($config['embed']['js'])) $this->setJsfiles($config['embed']['js']);
	}

	/**
	 * @return string
	 */
	public function getCssfiles() {
		return $this->impFiles('css', $this->cssfiles);
	}

	/**
	 * @return string
	 */
	public function getJsfiles() {
		return $this->impFiles('js', $this->jsfiles);
	}

	/**
	 * @param array|string $cssfiles
	 */
	public function setCssfiles( $cssfiles ) {
		if (is_array($cssfiles))
			$this->cssfiles = array_merge($this->cssfiles, $cssfiles);
		else
			$this->cssfiles[] = $cssfiles;
	}

	/**
	 * @param array $jsfiles
	 */
	public function setJsfiles( $jsfiles ) {
		if (is_array($jsfiles))
			$this->jsfiles = array_merge($this->jsfiles, $jsfiles);
		else
			$this->jsfiles[] = $jsfiles;
	}

	/**
	 * @param mixed  $webSite
	 * @param string $type
	 */
	public function setWebSite( $webSite, $type = 'other' )
	{
		$this->webSite[$type][] = $webSite;
	}

	public function segment($name, $inhalt, $first = FALSE, $loading_text = FALSE, $after = '')
	{
		$loading_text = $loading_text ? translate($loading_text) : translate('Пожалуйста, подождите...');
		$active  = $first ? ' active' : '';
		$input = implode("", $inhalt);
		$out = '<div class="ui bottom attached tab segment'.$active.'" data-tab="'.$name.'"><div class="ui inverted dimmer"><div class="ui tiny text loader">'.$loading_text.'</div></div><div class="ui four column grid">'.$input.'</div>'.$after.'</div>';
		$this->setWebSite( $out, 'segment' );
	}

	public function segmentTable($name, $inhalt, $first = FALSE, $loading_text = FALSE, $after = '')
	{
		$loading_text = $loading_text ? translate($loading_text) : translate('Пожалуйста, подождите...');
		$active  = $first ? ' active' : '';
		$input = $inhalt;
		$out = '<div class="ui bottom attached tab segment'.$active.'" data-tab="'.$name.'"><div class="ui inverted dimmer"><div class="ui tiny text loader">'.$loading_text.'</div></div><table class="ui striped table stackable">'.$input.'</table>'.$after.'</div>';
		$this->setWebSite( $out, 'segment' );
	}

	/**
	 *
	 */
	public function getWebSite()
	{
		$webseite = $this->getCssfiles();
		$webseite .= implode("\n", $this->webSite['header']);
		$webseite .= implode("\n", $this->webSite['boxes']);
		$webseite .= '<form class="ui form" method="POST" enctype="multipart/form-data" action="">';
		$webseite .= implode("\n", $this->webSite['segment']);
		$webseite .= implode("\n", $this->webSite['other']);
		$webseite .= implode("\n", $this->webSite['footer']);
		$webseite .= '</form>';
		$webseite .= $this->getJsfiles();

		echo $webseite;
	}

	/**
	 * @param $type
	 * @param array $files
	 *
	 * @return string
	 */
	public function impFiles($type, $files = array())
	{
		foreach ($files as $file) {
			if($type === 'css') $out[] = '<link rel="stylesheet" href="'.$file.'">';
			if($type === 'js') $out[] = '<script src="'.$file.'"></script>';
		}
		return implode("\n", $out);
	}

	/**
	 * @param        $body
	 * @param string $header
	 * @param string $footer
	 *
	 * @return string
	 */
	public function createTable($body, $header = [], $footer = '')
	{
		$output = [];

		$thead = [];
		$tbody = [];
		$tfoot = [];

		if(!empty($header)) {
			$thead[] = '<thead class="full-width"><tr>';
			foreach ($header as $name) {
				$tr = '<th>'. $name .'</th>';
				$thead[] = $tr;
			}
			$thead[] = '</tr></thead>';
		}

		if(!empty($footer)) {
			$tfoot[] = '<tfoot class="full-width"><tr>';
			$tfoot[] = $footer;
			$tfoot[] = '</tr></tfoot>';
		}

		$tbody[] = '<tbody>';
		foreach ($body as $row => $item) {
			$tbody[] = '<tr>';
			$this_cols = count($item);
			if(isset($header)) {
				$th_count = count($header);
			}
			else {
				$th_count = 0;
			}
			foreach ($item as $value) {
				if(isset($header)) {
					if ($this_cols !== $th_count) {
						$dif  = $th_count - $this_cols + 1;
						$cols = " colspan='".$dif."'";
						if (end($item) === $value) {
							$tbody[] = "<td{$cols}><div style=\"text-align: center;\">".$value.'</div></td>';
						}
						else {
							$tbody[] = '<td>'.$value.'</td>';
						}
					} else {
						$tbody[] = '<td>'.$value.'</td>';
					}
				}
			}
			$tbody[] = '</tr>';
		}
		$tbody[] = '</tbody>';

		$output[] = implode('', $thead);
		$output[] = implode('', $tbody);
		$output[] = implode('', $tfoot);

		return implode('', $output);
	}

	/**
	 * @param array $list
	 */
	public function boxes($list = array()) {
		$out = '<div class="ui top attached tabular menu" id="box-navi">';
		$count = 0;
		foreach ($list as $name => $keys) {
			$active = ($count == 0) ? " active" : "";
			$keys['link'] = $keys['link'] ? $keys['link'] : "#";
			if($keys['link'] != '#')
				$out .= '<a href="'.$keys['link'].'" class="item'.$active.'"><i class="'.$keys['icon'].'"></i>&nbsp;&nbsp;'.$keys['name'].'</a>';
			else
				$out .= '<a href="'.$keys['link'].'" class="item'.$active.'" data-tab="'.$name.'"><i class="'.$keys['icon'].'"></i>&nbsp;&nbsp;'.$keys['name'].'</a>';
			$count++;
		}
		$out .= '</div>';
		$this->setWebSite( $out, 'boxes' );
	}

	/**
	 * @param $path
	 * @param $codename
	 *
	 * @return mixed
	 */
	public function getConfig($path, $codename, $confName = '') {
		if(!empty($confName)) {
			$oldConfig = ENGINE_DIR.'/data/'.$codename.'.php';
			if (file_exists($oldConfig)) {
				$oldFile = file_get_contents((DLEPlugins::Check($oldConfig)));
				$oldFile = str_replace("{$confName} = ", 'return ', $oldFile);
				file_put_contents($oldConfig, $oldFile);
				$oldSettings = include(DLEPlugins::Check($oldConfig));
				file_put_contents($path.DIRECTORY_SEPARATOR.$codename.'.json', $oldSettings);
//				@unlink($oldConfig);
			}
		}
		$settings = json_decode(file_get_contents($path.DIRECTORY_SEPARATOR.$codename.'.json'), true);
		foreach ($settings as $name => $value) {
			$settings[$name] = htmlspecialchars_decode ( $value );
		}
		return $settings;
	}

}

class pagination {
	protected $id;
	protected $startChar;
	protected $prevChar;
	protected $nextChar;
	protected $endChar;
	protected $float;
	protected $style;
	protected $urlQuery;

	/**
	 * pagination constructor.
	 *
	 * @param string $id
	 * @param string $startChar
	 * @param string $prevChar
	 * @param string $nextChar
	 * @param string $endChar
	 */
	public function __construct ($style = 'fomantic', $float = 'right', $id = 'pagination', $startChar = '<i class="angle double left 
	icon"></i>',
$prevChar  = '<i class="left chevron icon"></i>', $nextChar  = '<i class="right chevron icon"></i>', $endChar   = '<i class="angle double right icon"></i>') {
		$this->id = $id;
		$this->startChar = $startChar;
		$this->prevChar  = $prevChar;
		$this->nextChar  = $nextChar;
		$this->endChar   = $endChar;
		$this->float     = $float;
		$this->style     = $style;
		$this->setUrlQuery($_SERVER['QUERY_STRING']);
	}

	/**
	 * @param string $endChar
	 */
	public function setEndChar ($endChar) {
		$this->endChar = $endChar;
	}

	/**
	 * @param string $nextChar
	 */
	public function setNextChar ($nextChar) {
		$this->nextChar = $nextChar;
	}

	/**
	 * @param string $style
	 */
	public function setStyle ($style) {
		$this->style = $style;
	}

	/**
	 * @param string $prevChar
	 */
	public function setPrevChar ($prevChar) {
		$this->prevChar = $prevChar;
	}

	/**
	 * @param string $startChar
	 */
	public function setStartChar ($startChar) {
		$this->startChar = $startChar;
	}

	/**
	 * @param mixed $urlQuery
	 */
	public function setUrlQuery ($urlQuery) {
		$this->urlQuery = $urlQuery;
	}

	/**
	 * @param        $all
	 * @param        $limit
	 * @param        $start
	 * @param int    $linkLimit
	 * @param string $varName
	 * @param string $cstmPage
	 *
	 * @return null|string
	 */
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

		parse_str($this->urlQuery, $queryVars );
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
			if ($this->style == 'fomantic') {
				$htmlOut .= '<a href="'.$link.'" class="item">'.$this->startChar.'</a>'.'<a href="'.$link.'&'.$varName.'='.ceil($start / $limit).'" class="item">'.$this->prevChar.'</a>';
			} elseif ($this->style == 'bootstrap3') {
				$htmlOut .= '<li><a href="'.$link.'"><span aria-hidden="true">'.$this->startChar.'</span></a></li>'.'<li><a href="'.$link.'&'.$varName.'='.ceil($start / $limit).'"><span aria-hidden="true">' . $this->prevChar .'</span></a></li>';
			} elseif ($this->style == 'bootstrap4') {
				$htmlOut .= '<li class="page-item"><a class="page-link" href="'.$link.'">'.$this->startChar.'</a></li>'.'<li class="page-item"><a class="page-link" href="'.$link.'&'.$varName.'='.ceil($start / $limit).'">' . $this->prevChar .'</a></li>';
			}
		} else {
			if ($this->style == 'fomantic') {
				$htmlOut .= '<a class="item disabled">'.$this->startChar.'</a>'.'<a class="item disabled">'.$this->prevChar.'</a>';
			} elseif ($this->style == 'bootstrap3') {
				$htmlOut .= '<li class="disabled"><a href="'.$link.'"><span aria-hidden="true">'.$this->startChar.'</span></a></li>'.'<li class="disabled"><a href="'.$link.'&'.$varName.'='.ceil($start / $limit).'"><span aria-hidden="true">' . $this->prevChar .'</span></a></li>';
			} elseif ($this->style == 'bootstrap4') {
				$htmlOut .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">'.$this->startChar.'</a></li>'.'<li class="page-item"><a tabindex="-1" aria-disabled="true" class="page-link" href="'.$link.'&'.$varName.'='.ceil($start / $limit).'">' . $this->prevChar .'</a></li>';
			}
		}
		foreach( $allPages[$needChunk] AS $pageNum => $ofset )  {
			if( $ofset == $start  ) {

				if ($this->style == 'fomantic') {
					$htmlOut .= '<a class="item active">'. $pageNum .'</a>';
				} elseif ($this->style == 'bootstrap3') {
					$htmlOut .= '<li class="active"><a href="#">'. $pageNum .' <span class="sr-only">(current)</span></a></li>';
				} elseif ($this->style == 'bootstrap4') {
					$htmlOut .= ' <li class="page-item active" aria-current="page"> <a class="page-link" href="#">'. $pageNum .' <span class="sr-only">(current)</span></a></li>';
				}
				continue;
			}
			if ($this->style == 'fomantic') {
				$htmlOut .= '<a href="'.$link.'&'.$varName.'='. $pageNum .'" class="item">'. $pageNum . '</a>';
			} elseif ($this->style == 'bootstrap3') {
				$htmlOut .= '<li><a href="'.$link.'&'.$varName.'='. $pageNum .'">'. $pageNum . '</a></li>';
			} elseif ($this->style == 'bootstrap4') {
				$htmlOut .= '<li class="page-item"><a class="page-link" href="'.$link.'&'.$varName.'='. $pageNum .'">'. $pageNum . '</a></li>';
			}
		}
		if ( ($all - $limit) >  $start) {

			if ($this->style == 'fomantic') {
				$htmlOut .= '<a href="' . $link . '&' . $varName . '=' . (ceil(( $start + $limit)/$limit)+1) . '" class="item">' . $this->nextChar . '</a>'.'<a href="' . $link . '&' . $varName . '=' . $pagess . '" class="item">' . $this->endChar . '</a>';
			} elseif ($this->style == 'bootstrap3') {
				$htmlOut .= '<li><a href="' . $link . '&' . $varName . '=' . (ceil(( $start + $limit)/$limit)+1) . '"><span aria-hidden="true">'.$this->nextChar.'</span></a></li>'.'<li><a href="' . $link . '&' . $varName . '=' . $pagess . '"><span aria-hidden="true">' . $this->endChar .'</span></a></li>';
			} elseif ($this->style == 'bootstrap4') {
				$htmlOut .= '<li class="page-item"><a class="page-link" href="' . $link . '&' . $varName . '=' . (ceil(( $start + $limit)/$limit)+1) . '">'.$this->nextChar.'</a></li>'.'<li class="page-item"><a class="page-link" href="' . $link . '&' . $varName . '=' . $pagess . '">' . $this->endChar .'</a></li>';
			}
		} else {
			if ($this->style == 'fomantic') {
				$htmlOut .= '<a class="item disabled">'.$this->nextChar.'</a>'.'<a class="item disabled">'.$this->endChar.'</a>';
			} elseif ($this->style == 'bootstrap3') {
				$htmlOut .= '<li class="disabled"><a href="'.$link.'"><span aria-hidden="true">'.$this->nextChar.'</span></a></li>'.'<li class="disabled"><a href="'.$link.'&'.$varName.'='.ceil($start / $limit).'"><span aria-hidden="true">' . $this->endChar .'</span></a></li>';
			} elseif ($this->style == 'bootstrap4') {
				$htmlOut .= '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">'.$this->nextChar.'</a></li>'.'<li class="page-item"><a tabindex="-1" aria-disabled="true" class="page-link" href="'.$link.'&'.$varName.'='.ceil($start / $limit).'">' . $this->endChar .'</a></li>';
			}
		}

		if ($this->style == 'fomantic') {
			$htmlOut = '<div class="ui ' . $this->float . ' floated pagination menu" id="'.$this->id.'">' . $htmlOut .'</div>';
		} elseif ($this->style == 'bootstrap3') {
			$htmlOut = '<nav aria-label="Page navigation"><ul class="' . $this->float . ' floated pagination" id="'	.$this->id.'">' . $htmlOut .'</ul></nav>';
		} elseif ($this->style == 'bootstrap4') {
			$htmlOut = '<nav aria-label="Page navigation"><ul class="' . $this->float . ' floated pagination" id="'	.$this->id.'">' . $htmlOut .'</ul></nav>';
		}
		return $htmlOut;
	}

	/**
	 * @param array $pagessList
	 * @param       $needPage
	 *
	 * @return int|string
	 */
	protected function searchPage( array $pagessList, $needPage ) {
		foreach( $pagessList AS $chunk => $pagess  ){
			if( in_array($needPage, $pagess) ){
				return $chunk;
			}
		}
		return 0;
	}
}

class langPlugin {
	private $locale, $locales, $module, $path, $fallBack, $cookieName;
	private $curLangPath, $curLang;

	public function __construct ($locale = ['ru_RU'=>['short' => 'ru', 'name' =>'Russian']], $locales = ['ru_RU'=>['short' => 'ru', 'name' =>'Russian'], 'de_DE'=>['short' => 'de', 'name' =>'German'], 'en_GB'=>['short' => 'en', 'name' =>'English']], $module = '', $path = ROOT_DIR . '/locale', $fallBack = ['en_GB'=>['short' => 'en', 'name' =>'English']], $cookieName = 'dle_lang') {
		$this->setModule($module);
		$this->setPath($path);
		$this->setLocale($locale);
		$this->setCookieName($cookieName);
		$this->setLocales($locales);
		$this->setFallBack($fallBack);
	}

	/**
	 * @param mixed $locales
	 */
	public function setLocales( $locales ) {
		$allLocales = [];
		foreach($locales as $lang => $list) {
			$allLocales[] = $lang;
			$path = $this->getPath() . DIRECTORY_SEPARATOR . $lang;
			$this->createDir($path);
			$this->createLangFile($path);

		}
		$this->locales = $allLocales;
		$this->curLang = $locales;
	}

	/**
	 * @return mixed
	 */
	public function getCookieName() {
		return $this->cookieName;
	}

	/**
	 * @return mixed
	 */
	public function getLocales() {
		return $this->locales;
	}

	/**
	 * @param mixed $cookieName
	 * @param float|int $lifetime
	 */
	public function setCookieName( $cookieName, $lifetime = (60 * 60 * 24) ) {

		$this->cookieName = $cookieName;
		$cookieValue = $this->getLocale();
		$_SESSION[$cookieName] = $cookieValue;

		set_cookie( $cookieName, $cookieValue, $lifetime );
	}

	/**
	 * @param mixed $module
	 */
	public function setModule( $module ) {

		$this->module = $module;
	}

	/**
	 * @return mixed
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @return mixed
	 */
	public function getLocale() {
		return $this->locale;
	}

	/**
	 * @return mixed
	 */
	public function getPath () {
		return $this->path;
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	private function createDir($dir) {
		// WPF Function
		if (!function_exists('wp_is_stream')) {
			function wp_is_stream ($path) {
				$scheme_separator = strpos($path, '://');

				if (false === $scheme_separator) {
					return false;
				}

				$stream = substr($path, 0, $scheme_separator);

				return in_array($stream, stream_get_wrappers(), true);
			}
		}

		$wrapper = NULL;

		if ( wp_is_stream( $dir ) ) {
			list ( $wrapper, $dir ) = explode( '://', $dir, 2 );
		}

		$dir = str_replace( '//', DIRECTORY_SEPARATOR, $dir );

		if ( $wrapper !== NULL ) {
			$dir = $wrapper . '://' . $dir;
		}

		$dir = rtrim( $dir, DIRECTORY_SEPARATOR );
		if ( empty( $dir ) ) $dir = DIRECTORY_SEPARATOR;

		if ( file_exists( $dir ) ) return @is_dir( $dir );

		$dir_parent = dirname( $dir );
		while ( '.' !== $dir_parent && !is_dir( $dir_parent ) ) {
			$dir_parent = dirname( $dir_parent );
		}

		if ( $stat = @stat( $dir_parent ) ) {
			$dir_perms = $stat['mode'] & 0007777;
		} else {
			$dir_perms = 0777;
		}

		if ( mkdir( $dir, $dir_perms, true ) || is_dir( $dir ) ) {

			if ( $dir_perms != ($dir_perms & ~umask()) ) {
				$folder_parts = explode( DIRECTORY_SEPARATOR, substr( $dir, strlen( $dir_parent ) + 1 ) );
				for ( $i = 1, $iMax = count( $folder_parts ); $i <= $iMax; $i++ ) {
					@chmod( $dir_parent . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, array_slice( $folder_parts, 0, $i ) ), $dir_perms );
				}
			}

			return true;
		}

		return false;

	}

	/**
	 * @param mixed $path
	 */
	public function setPath ($path) {
		$this->createDir($path);

		$this->path = $path;
	}

	/**
	 * @param $locale
	 */
	public function setLocale($locale) {
		$module = $this->getModule();
		foreach($locale as $lang => $list) {
			$locVariations = $this->prepareLang($lang);
			$path = $this->getPath() . DIRECTORY_SEPARATOR . $lang;
			$this->curLangPath = $path;
			$this->createDir($path);
			$this->createLangFile($path);
			$count = 0;
			foreach($locVariations as $variation) {
				if ( defined( 'LC_MESSAGES' ) ) {
					setlocale( LC_MESSAGES, $variation ); // Linux
					if ($count == 0) bindtextdomain( $module, $path );
				}
				else {
					putenv( "LC_ALL={$variation}" ); // windows
					if ($count == 0) bindtextdomain( $module, $path );
				}

				if ($count == 0) textdomain( $module );
				$count++;
			}
			$this->locale = $lang;
		}

	}

	/**
	 * @param $code
	 *
	 * @return array
	 */
	private function prepareLang($code){
		$hyphen = str_replace('_', '-', $code);
		$underscore = str_replace('-', '_', $hyphen);

		return [
			$hyphen . '.utf8',
			$underscore . '.utf8',
			$hyphen . '.UTF-8',
			$underscore . '.UTF-8',
			$hyphen,
			$underscore
		];
	}

	/**
	 * @param $path
	 */
	private function createLangFile($path) {
		$file = $path . DIRECTORY_SEPARATOR . $this->getModule() . '.json';
		if (!empty($this->curLang)) {
			if (!file_exists($file)) {
				$code     = explode(DIRECTORY_SEPARATOR, $path);
				$code     = end($code);
				$langFile = [
					'code'    => $code,
					'iso2'    => $this->curLang[$code]['short'],
					'name'    => $this->curLang[$code]['name'],
					'phrases' => []
				];
				file_put_contents($file, json_encode($langFile, JSON_UNESCAPED_UNICODE));
			}
		}
	}

	/**
	 * @param string $path
	 *
	 * @return mixed
	 */
	private function getLanguage($path = '') {
		if (empty($path)) $path = $this->curLangPath;
		$file = $path . DIRECTORY_SEPARATOR . $this->getModule() . '.json';
		if (!file_exists($file)) $this->createLangFile($path);
		return json_decode(file_get_contents($file), true);
	}

	/**
	 * @param $language
	 *
	 * @return bool
	 */
	private function setLanguage($language) {
		if (!is_array($language)) return false;
		foreach ($this->getLocales() as $id => $lang) {
			$path = $this->getPath() . DIRECTORY_SEPARATOR . $lang;
			$langArr = $this->getLanguage($path);
			$phrases = $langArr['phrases'];
			foreach ($language as $n => $l) {
				$lookFor = array_search($l, array_column($phrases, 'original'));
				if ($lookFor === false) {
					$phrases[] = [
						'original' => $l,
						'translation' => ''
					];
				}
			}
			$langArr['phrases'] = $phrases;

			file_put_contents($path . DIRECTORY_SEPARATOR . $this->getModule() . '.json', json_encode($langArr, JSON_UNESCAPED_UNICODE));

		}

		return true;
	}

	/**
	 * @param array $fallBack
	 */
	public function setFallBack( array $fallBack ) {
		$this->fallBack = $fallBack;
	}

	/**
	 * @return mixed
	 */
	public function getFallBack () {
		$lang = '';
		foreach ($this->fallBack as $lng => $val) $lang = $lng;
		return $lang;
	}

	/**
	 * @param false|string $root
	 * @param array        $neededFiles
	 *
	 * @return array
	 */
	private function scanDirLang($root = ROOT_DIR, &$neededFiles = array()) {
		$root = realpath($root);
		$files = scandir(realpath($root));
		$skip = [
			'.',
			'..',
			'.git',
			'.gitignore',
			'.idea',
			'api',
			'cache',
		];
		foreach($files as $id => $file) {
			if(in_array($file, $skip, true)) continue;
			$newPath = realpath($root . DIRECTORY_SEPARATOR . $file);
			$isDir = is_dir($newPath);
			if($isDir){
				self::scanDirLang($newPath, $neededFiles);
			} elseif (preg_match('/^.*\.(php|html|tpl|js)/', $file)) {
				$neededFiles[] = $newPath;
			}
		}
		return $neededFiles;
	}

	/**
	 *
	 */
	public function generatePhrases() {
		$files = $this->scanDirLang();
		$phrases = [];
		foreach ($files as $id => $file) {
			$content = file_get_contents($file);
			if (preg_match('/^.*\.(js)/', $file)) {
				$pattern = '/translateJS\(\'((\.*[^\{\}\,])*)\'/';
				preg_match_all($pattern, $content, $found);
				foreach ($found[1] as $num => $phrase) {
					if (empty($phrase)) continue;
					$phrase = htmlentities(trim($phrase));
					if (!in_array($phrase, $phrases)) $phrases[] = $phrase;
				}
			} else {
				$patternPhrase = [
					'translate',
					'_'
				];
				$patternPhrase = implode('|', $patternPhrase);
				$pattern       = '/('.$patternPhrase.')\(([\'"])([^)]*)([\'"])\)/';
				preg_match_all($pattern, $content, $found);
				foreach ($found[3] as $num => $phrase) {
					if (empty($phrase)) continue;
					$phrase = htmlentities(trim($phrase));
					if (!in_array($phrase, $phrases)) $phrases[] = $phrase;
				}
				preg_match_all('/\{trans ([a-z]*)=\"([^}]*)\"\}/', $content, $found);
				foreach ($found[2] as $num => $phrase) {
					if (empty($phrase)) continue;
					$phrase = htmlentities(trim($phrase));
					if (!in_array($phrase, $phrases)) $phrases[] = $phrase;
				}
			}
		}

		$this->setLanguage( $phrases );
	}

	/**
	 * @param $phrase
	 *
	 * @return mixed
	 */
	public function translate($phrase) {
		$langArr = $this->getLanguage();
		$phrases = $langArr['phrases'];
		if(empty($phrases) || count($phrases) == 0) {
			$backPath = $this->getPath() . DIRECTORY_SEPARATOR . $this->getFallBack();
			$backArr = $this->getLanguage($backPath);
			$phrases = $backArr['phrases'];
		}
		$phrase = htmlentities($phrase);
		$phKey = array_search($phrase, array_column($phrases, 'original'));
		if ($phKey !== false) {
			if (!empty($phrases[$phKey]['translation'])) return $phrases[$phKey]['translation'];
		}
		return html_entity_decode($phrase);
	}
}
