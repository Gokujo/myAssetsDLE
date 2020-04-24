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

/** **********************************************************************************
* Generate hundreds of thousands of unique mobile & desktop User Agents that are 100% authentic.
* Supports Hundreds of Android devices, 32 & 64 bit versions of Windows XP-10.5, Linux 540-686, and Mac 7-10.12
* as well as browsers Firefox, Chrome, and Internet Explorer.
* https://github.com/phpfail/UserAgentGenerator
*/
class userAgent {
	/**
	 * Windows Operating System list with dynamic versioning
	 * @var array $windows_os
	 */
	public $windows_os = [ '[Windows; |Windows; U; |]Windows NT 6.:number0-3:;[ Win64; x64| WOW64| x64|]',
		'[Windows; |Windows; U; |]Windows NT 10.:number0-5:;[ Win64; x64| WOW64| x64|]', ];
	/**
	 * Linux Operating Systems [limited]
	 * @var array $linux_os
	 */
	public $linux_os = [
		'[Linux; |][U; |]Linux x86_64',
		'[Linux; |][U; |]Linux i:number5-6::number4-8::number0-6: [x86_64|]'
	];
	/**
	 * Mac Operating System (OS X) with dynamic versioning
	 * @var array $mac_os
	 */
	public $mac_os = [
		'Macintosh; [U; |]Intel Mac OS X :number7-9:_:number0-9:_:number0-9:',
		'Macintosh; [U; |]Intel Mac OS X 10_:number0-12:_:number0-9:'
	];
	/**
	 * Versions of Android to be used
	 * @var array $androidVersions
	 */
	public $androidVersions = [
		'4.3.1',
		'4.4',
		'4.4.1',
		'4.4.4',
		'5.0',
		'5.0.1',
		'5.0.2',
		'5.1',
		'5.1.1',
		'6.0',
		'6.0.1',
		'7.0',
		'7.1',
		'7.1.1'
	];
	/**
	 * Holds the version of android for the User Agent being generated
	 * @property string $androidVersion
	 */
	public $androidVersion;
	/**
	 * Android devices and for specific android versions
	 * @var array $androidDevices
	 */
	public $androidDevices = [
		'4.3' => [
			'GT-I9:number2-5:00 Build/JDQ39',
			'Nokia 3:number1-3:[10|15] Build/IMM76D',
			'[SAMSUNG |]SM-G3:number1-5:0[R5|I|V|A|T|S] Build/JLS36C',
			'Ascend G3:number0-3:0 Build/JLS36I',
			'[SAMSUNG |]SM-G3:number3-6::number1-8::number0-9:[V|A|T|S|I|R5] Build/JLS36C',
			'HUAWEI G6-L:number10-11: Build/HuaweiG6-L:number10-11:',
			'[SAMSUNG |]SM-[G|N]:number7-9:1:number0-8:[S|A|V|T] Build/[JLS36C|JSS15J]',
			'[SAMSUNG |]SGH-N0:number6-9:5[T|V|A|S] Build/JSS15J',
			'Samsung Galaxy S[4|IV] Mega GT-I:number89-95:00 Build/JDQ39',
			'SAMSUNG SM-T:number24-28:5[s|a|t|v] Build/[JLS36C|JSS15J]',
			'HP :number63-73:5 Notebook PC Build/[JLS36C|JSS15J]',
			'HP Compaq 2:number1-3:10b Build/[JLS36C|JSS15J]',
			'HTC One 801[s|e] Build/[JLS36C|JSS15J]',
			'HTC One max Build/[JLS36C|JSS15J]',
			'HTC Xplorer A:number28-34:0[e|s] Build/GRJ90',
		],
		'4.4' => [
			'XT10:number5-8:0 Build/SU6-7.3',
			'XT10:number12-52: Build/[KXB20.9|KXC21.5]',
			'Nokia :number30-34:10 Build/IMM76D',
			'E:number:20-23::number0-3::number0-4: Build/24.0.[A|B].1.34',
			'[SAMSUNG |]SM-E500[F|L] Build/KTU84P',
			'LG Optimus G Build/KRT16M',
			'LG-E98:number7-9: Build/KOT49I',
			'Elephone P:number2-6:000 Build/KTU84P',
			'IQ450:number0-4: Quad Build/KOT49H',
			'LG-F:number2-5:00[K|S|L] Build/KOT49[I|H]',
			'LG-V:number3-7::number0-1:0 Build/KOT49I',
			'[SAMSUNG |]SM-J:number1-2::number0-1:0[G|F] Build/KTU84P',
			'[SAMSUNG |]SM-N80:number0-1:0 Build/[KVT49L|JZO54K]',
			'[SAMSUNG |]SM-N900:number5-8: Build/KOT49H',
			'[SAMSUNG-|]SGH-I337[|M] Build/[JSS15J|KOT49H]',
			'[SAMSUNG |]SM-G900[W8|9D|FD|H|V|FG|A|T] Build/KOT49H',
			'[SAMSUNG |]SM-T5:number30-35: Build/[KOT49H|KTU84P]',
			'[Google |]Nexus :number5-7: Build/KOT49H',
			'LG-H2:number0-2:0 Build/KOT49[I|H]',
			'HTC One[_M8|_M9|0P6B|801e|809d|0P8B2|mini 2|S][ dual sim|] Build/[KOT49H|KTU84L]',
			'[SAMSUNG |]GT-I9:number3-5:0:number0-6:[V|I|T|N] Build/KOT49H',
			'Lenovo P7:number7-8::number1-6: Build/[Lenovo|JRO03C]',
			'LG-D95:number1-8: Build/KOT49[I|H]',
			'LG-D:number1-8::number0-8:0 Build/KOT49[I|H]',
			'Nexus5 V:number6-7:.1 Build/KOT49H',
			'Nexus[_|] :number4-10: Build/[KOT49H|KTU84P]',
			'Nexus[_S_| S ][4G |]Build/GRJ22',
			'[HM NOTE|NOTE-III|NOTE2 1LTE[TD|W|T]',
			'ALCATEL ONE[| ]TOUCH 70:number2-4::number0-9:[X|D|E|A] Build/KOT49H',
			'MOTOROLA [MOTOG|MSM8960|RAZR] Build/KVT49L'
		],
		'5.0' => [
			'Nokia :number10-11:00 [wifi|4G|LTE] Build/GRK39F',
			'HTC 80:number1-2[s|w|e|t] Build/[LRX22G|JSS15J]',
			'Lenovo A7000-a Build/LRX21M;',
			'HTC Butterfly S [901|919][s|d|] Build/LRX22G',
			'HTC [M8|M9|M8 Pro Build/LRX22G',
			'LG-D3:number25-37: Build/LRX22G',
			'LG-D72:number0-9: Build/LRX22G',
			'[SAMSUNG |]SM-G4:number0-9:0 Build/LRX22[G|C]',
			'[|SAMSUNG ]SM-G9[00|25|20][FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[LRX21T|KTU84F|KOT49H]',
			'[SAMSUNG |]SM-A:number7-8:00[F|I|T|H|] Build/[LRX22G|LMY47X]',
			'[SAMSUNG-|]SM-N91[0|5][A|V|F|G|FY] Build/LRX22C',
			'[SAMSUNG |]SM-[T|P][350|550|555|355|805|800|710|810|815] Build/LRX22G',
			'LG-D7:number0-2::number0-9: Build/LRX22G',
			'[LG|SM]-[D|G]:number8-9::number0-5::number0-9:[|P|K|T|I|F|T1] Build/[LRX22G|KOT49I|KVT49L|LMY47X]'
		],
		'5.1' => [
			'Nexus :number5-9: Build/[LMY48B|LRX22C]',
			'[|SAMSUNG ]SM-G9[28|25|20][X|FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[LRX22G|LMY47X]',
			'[|SAMSUNG ]SM-G9[35|350][X|FD|8|F|F-ORANGE|FG|FQ|H|I|L|M|S|T] Build/[MMB29M|LMY47X]',
			'[MOTOROLA |][MOTO G|MOTO G XT1068|XT1021|MOTO E XT1021|MOTO XT1580|MOTO X FORCE XT1580|MOTO X PLAY XT1562|MOTO XT1562|MOTO XT1575|MOTO X PURE XT1575|MOTO XT1570 MOTO X STYLE] Build/[LXB22|LMY47Z|LPC23|LPK23|LPD23|LPH223]'
		],
		'6.0' => [
			'[SAMSUNG |]SM-[G|D][920|925|928|9350][V|F|I|L|M|S|8|I] Build/[MMB29K|MMB29V|MDB08I|MDB08L]',
			'Nexus :number5-7:[P|X|] Build/[MMB29K|MMB29V|MDB08I|MDB08L]',
			'HTC One[_| ][M9|M8|M8 Pro] Build/MRA58K',
			'HTC One[_M8|_M9|0P6B|801e|809d|0P8B2|mini 2|S][ dual sim|] Build/MRA58K'
		],
		'7.0' => [
			'Pixel [XL|C] Build/[NRD90M|NME91E]',
			'Nexus :number5-9:[X|P|] Build/[NPD90G|NME91E]',
			'[SAMSUNG |]GT-I:number91-98:00 Build/KTU84P',
			'Xperia [V |]Build/NDE63X',
			'LG-H:number90-93:0 Build/NRD90[C|M]'
		],
		'7.1' => [
			'Pixel [XL|C] Build/[NRD90M|NME91E]',
			'Nexus :number5-9:[X|P|] Build/[NPD90G|NME91E]',
			'[SAMSUNG |]GT-I:number91-98:00 Build/KTU84P',
			'Xperia [V |]Build/NDE63X',
			'LG-H:number90-93:0 Build/NRD90[C|M]'
		]
	];

	/**
	 * List of "OS" strings used for android
	 * @var array $android_os
	 */
	public $android_os = [ 'Linux; Android :androidVersion:; :androidDevice:',
		//TODO: Add a $windowsDevices variable that does the same as androidDevice
		//'Windows Phone 10.0; Android :androidVersion:; :windowsDevice:',
		'Linux; U; Android :androidVersion:; :androidDevice:',
		'Android; Android :androidVersion:; :androidDevice:', ];
	/**
	 * List of "OS" strings used for iOS
	 * @var array $mobile_ios
	 */
	public $mobile_ios = [
		'iphone' => 'iPhone; CPU iPhone OS :number7-11:_:number0-9:_:number0-9:; like Mac OS X;',
		'ipad' => 'iPad; CPU iPad OS :number7-11:_:number0-9:_:number0-9: like Mac OS X;',
		'ipod' => 'iPod; CPU iPod OS :number7-11:_:number0-9:_:number0-9:; like Mac OS X;',
	];

	public $lang = 'en-US';

	public function __construct($lang = 'en-US') {$this->lang = $lang;}

	/**
	 * Get a random operating system
	 *
	 * @param null|string $os
	 *
	 * @return string *
	 * @throws Exception
	 */
	public function getOS($os = NULL) {
		$_os = [];
		if($os === NULL || in_array($os, [ 'chrome', 'firefox', 'explorer' ])) {
			$_os = $os === 'explorer' ? $this->windows_os : array_merge($this->windows_os, $this->linux_os, $this->mac_os);
		} else {
			$_os += $this->{$os . '_os'};
		}
		// randomly select on operating system
		$selected_os = rtrim($_os[random_int(0, count($_os) - 1)], ';');
		// check for spin syntax
		if(strpos($selected_os, '[') !== FALSE) {
			$selected_os = self::processSpinSyntax($selected_os);
		}

		// check for random number syntax
		if(strpos($selected_os, ':number') !== FALSE) {
			$selected_os = self::processRandomNumbers($selected_os);
		}

		if(random_int(1, 100) > 50) {
			$selected_os .= '; '. $this->lang;
		}
		return $selected_os;
	}

	/**
	 * Get Mobile OS
	 *
	 * @param null|string $os Can specifiy android, iphone, ipad, ipod, or null/blank for random
	 *
	 * @return string *
	 * @throws Exception
	 */
	public function getMobileOS($os = NULL) {
		$os = strtolower($os);
		$_os = [];
		switch( $os ) {
			case'android':
				$_os += $this->android_os;
				break;
			case 'iphone':
			case 'ipad':
			case 'ipod':
				$_os[] = $this->mobile_ios[$os];
				break;
			default:
				$_os = array_merge($this->android_os, $this->mobile_ios);
		}
		// select random mobile os
		$selected_os = rtrim($_os[random_int(0, count($_os) - 1)], ';');
		if(strpos($selected_os, ':androidVersion:') !== FALSE) {
			$selected_os = $this->processAndroidVersion($selected_os);
		}
		if(strpos($selected_os, ':androidDevice:') !== FALSE) {
			$selected_os = $this->addAndroidDevice($selected_os);
		}
		if(strpos($selected_os, ':number') !== FALSE) {
			$selected_os = self::processRandomNumbers($selected_os);
		}
		return $selected_os;
	}

	/**
	 *  static::processRandomNumbers
	 * @param $selected_os
	 * @return null|string|string[] *
	 */
	public static function processRandomNumbers($selected_os) {
		return preg_replace_callback('/:number(\d+)-(\d+):/i', function($matches) { return random_int($matches[1], $matches[2]); }, $selected_os);
	}

	/**
	 *  static::processSpinSyntax
	 * @param $selected_os
	 * @return null|string|string[] *
	 */
	public static function processSpinSyntax($selected_os) {
		return preg_replace_callback('/\[([\w\-\s|;]*?)\]/i', function($matches) {
			$shuffle = explode('|', $matches[1]);
			return $shuffle[array_rand($shuffle)];
		}, $selected_os);
	}

	/**
	 * processAndroidVersion
	 * @param $selected_os
	 * @return null|string|string[] *
	 */
	public function processAndroidVersion($selected_os) {
		$this->androidVersion = $version = $this->androidVersions[array_rand($this->androidVersions)];
		return preg_replace_callback('/:androidVersion:/i', function($matches) use ($version) { return $version; }, $selected_os);
	}

	/**
	 * addAndroidDevice
	 * @param $selected_os
	 * @return null|string|string[] *
	 */
	public function addAndroidDevice($selected_os) {
		$devices = $this->androidDevices[substr($this->androidVersion, 0, 3)];
		$device  = $devices[array_rand($devices)];

		$device = self::processSpinSyntax($device);
		return preg_replace_callback('/:androidDevice:/i', function($matches) use ($device) { return $device; }, $selected_os);
	}

	/**
	 *  static::chromeVersion
	 *
	 * @param $version
	 *
	 * @return string *
	 * @throws Exception
	 */
	public static function chromeVersion($version) {
		return random_int($version['min'], $version['max']) . '.0.' . random_int(1000, 4000) . '.' . random_int(100, 400);
	}

	/**
	 *  static::firefoxVersion
	 *
	 * @param $version
	 *
	 * @return string *
	 * @throws Exception
	 */
	public static function firefoxVersion($version) {
		return random_int($version['min'], $version['max']) . '.' . random_int(0, 9);
	}

	/**
	 *  static::windows
	 *
	 * @param $version
	 *
	 * @return string *
	 * @throws Exception
	 */
	public static function windows($version) {
		return random_int($version['min'], $version['max']) . '.' . random_int(0, 9);
	}

	/**
	 * generate
	 *
	 * @param null $userAgent
	 *
	 * @return string *
	 * @throws Exception
	 */
	public function generate($userAgent = NULL) {
		if($userAgent === NULL) {
			$r = random_int(0, 100);
			if($r >= 44) {
				$userAgent = array_rand([ 'firefox' => 1, 'chrome' => 1, 'explorer' => 1 ]);
			} else {
				$userAgent = array_rand([ 'iphone' => 1, 'android' => 1, 'mobile' => 1 ]);
			}
		} elseif($userAgent == 'windows' || $userAgent == 'mac' || $userAgent == 'linux') {
			$agents = [ 'firefox' => 1, 'chrome' => 1 ];
			if($userAgent == 'windows') {
				$agents['explorer'] = 1;
			}
			$userAgent = array_rand($agents);
		}
		$_SESSION['agent'] = $userAgent;
		if($userAgent == 'chrome') {
			return 'Mozilla/5.0 (' . $this->getOS($userAgent) . ') AppleWebKit/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(1, 50) . ' (KHTML, like Gecko) Chrome/' . self::chromeVersion([ 'min' => 47,
						'max' => 55 ]) . ' Safari/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603));
		} elseif($userAgent == 'firefox') {

			return 'Mozilla/5.0 (' . $this->getOS($userAgent) . ') Gecko/' . (random_int(1, 100) > 30 ? '20100101' : '20130401') . ' Firefox/' . self::firefoxVersion([ 'min' => 45,
						'max' => 74 ]);
		} elseif($userAgent == 'explorer') {

			return 'Mozilla / 5.0 (compatible; MSIE ' . ($int = random_int(7, 11)) . '.0; ' . $this->getOS('windows') . ' Trident / ' . ($int == 7 || $int == 8 ? '4' : ($int == 9 ? '5' : ($int == 10 ? '6' : '7'))) . '.0)';
		} elseif($userAgent == 'mobile' || $userAgent == 'android' || $userAgent == 'iphone' || $userAgent == 'ipad' || $userAgent == 'ipod') {

				return 'Mozilla/5.0 (' . $this->getMobileOS($userAgent) . ') AppleWebKit/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(1, 50) . ' (KHTML, like Gecko)  Chrome/' . self::chromeVersion([ 'min' => 47,
						'max' => 55 ]) . ' Mobile Safari/' . (random_int(1, 100) > 50 ? random_int(533, 537) : random_int(600, 603)) . '.' . random_int(0, 9);
		} else {
			new Exception('Unable to determine user agent to generate');
		}
	}
}


class translator {

	protected $api, $url, $from;
	protected $urls = [
		'yandex' =>	'https://translate.yandex.net/api/v1.5/tr.json/translate'
	];
	private $service, $to;

	/**
	 * translator constructor.
	 *
	 * @param $service
	 * @param $key
	 * @param $sourceLang
	 * @param $translateTo
	 */
	public function __construct($service, $key, $sourceLang, $translateTo = '') {
		$this->setService($service);
		$this->setApi($key);
		$this->setFrom($sourceLang);
		$this->setTo($translateTo);
	}

	/**
	 * @param mixed $api
	 */
	public function setApi( $api ) {
		$this->api = $api;
	}

	/**
	 * @param mixed $service
	 */
	public function setService( $service ) {
		$this->service = $service;
		$this->url = $this->urls[$service];
	}

	/**
	 * @param mixed $from
	 */
	public function setFrom( $from ) {
		$this->from = $from;
	}

	/**
	 * @param mixed $to
	 */
	public function setTo( $to ) {
		$this->to = $to;
	}

	/**
	 * @param $text
	 *
	 * @return string
	 */
	private function createURL($text) {
		$url = '';
		$options = [];
		if (!$this->api) {
			$this->sendConsoleLog(translate('API ключ не указан!'));
		}
		if (!$this->from) {
			$this->sendConsoleLog(translate('Исходный язык не указан!'));
		}
		if (!$this->to) {
			$this->sendConsoleLog(translate('Язык, на который должен быть сделан перевод, не указан!'));
		}
		if ($this->service == 'yandex') {
			$url = $this->url;
			$options = [
				'key' => $this->api,
				'lang' => "{$this->from}-{$this->to}",
				'format' => 'html',
				'text' => $text
			];
		}

		return $url . '?' . http_build_query($options);
	}

	/**
	 * @param $message
	 */
	private function sendConsoleLog($message) {
		if(is_array($message) || is_object($message)){
			echo("<script>console.log('PHP Debug: ".json_encode($message)."');</script>");
		} else {
			echo("<script>console.log('PHP Debug: ".$message."');</script>");
		}
		die();
	}

	/**
	 * @param $text
	 *
	 * @return bool|mixed|string
	 * @throws Exception
	 */
	public function translate( $text ){
		if (!$text) {
			$this->sendConsoleLog(translate('Текст для перевода не указан!'));
		}

		$url = $this->createURL($text);
		$agent = new userAgent();

		if (!$url) {
			$this->sendConsoleLog(translate('Ссылка на API не была сгенерирована!'));
		}

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent->generate());

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$this->sendConsoleLog(curl_error($ch));
		}
		curl_close($ch);

		$errors = [
			401,
			402,
			404,
			413,
			422,
			501
		];
		$result = json_decode($result, true);
		if ($result['code'] != 200 && in_array($result['code'], $errors)) {
			$this->sendConsoleLog($result['message']);
		}

		return $result;

	}

}