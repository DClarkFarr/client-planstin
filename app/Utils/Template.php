<?php

namespace App\Utils;

Class Template {
	var $class;
	var $controller;
	var $layout;
	var $template;
	var $location = 'templates';
	var $not_found_view = '404';
	var $not_found_css = 'page-not-found.css';
	var $priority = 10;
	var $asset_path = "";
	var $js_path = "/js/";
	var $css_path = "/css/";
	var $image_path = '/images/';
	var $modules = [];
	var $pieces = [];

	var $assets = [];

	public function __construct($controller, $callback = null){
		$this->class = static::class;
		//$this->controller = $controller;

		if(!$this->template){
			$arr = explode('\\', $this->class);
			$end = end($arr);
			$this->template = strtolower( $end );
		}

		$this->resetAssets();
		
		if(is_callable($callback)){
			$callback($this);
		}
		$this->setupModules();
		$this->setDefaultPieces();
	}
	public function initialize() { /*keep empty to not polute extension */ }
	public function setupModules() { /* keep empty - used for typing out list of modules */ }

	function setDefaultPieces(){
		$this->setPiece('header', 'header');
		$this->setPiece('footer', 'footer');
	}

	public function resetAssets(){
    	$this->assets = (object) [
    		'css' => [],
    		'js' => [],
    		'jsInline' => [],
    	];
	}
	
	public function setModules($modules = []){
		foreach($modules as $key => $module){
			$defaultMinify = isset($module['minify']) ? !!$module['minify'] : false;

			foreach($module['resources'] as $key1 => $val){
				if(!($val instanceOf Enqueue)){
					$val = call_user_func_array([$this, 'enqueue'], $this->arrToArgs($val, ['minify' => $defaultMinify]));
				}
				$module['resources'][$key1] = $val;
			}
			$this->modules[$key] = $module['resources'];
		}
	}

	public function arrToArgs($arr, $options = []){
		if(is_string($arr)){
			$arr = [$arr];
		}
		$c = count($arr);
		$type = $path = $priority = $header = $minify = null;
		if($c == 5){
			list($type, $path, $priority, $header, $minify) = $arr;
		}else if($c == 4){
			list($type, $path, $priority, $header) = $arr;
		}else if($c == 3){
			list($path, $priority, $header) = $arr;
		}else if($c == 2){
			list($path, $priority) = $arr;
		}else if($c == 1){
			list($path) = $arr;
		}

		foreach($options as $key => $value){
			if( ${$key} == null){
				${$key} = $value;
			}
		}
		return [$type, $path, $priority, $header, $minify];
	}

	public function loadModules($modules = []){
		if(!is_array($modules)){
			$modules = [$modules];
		}

		foreach($modules as $key){
			$module = isset($this->modules[$key]) ? $this->modules[$key] : false;
			if(!$module){
				continue;
			}

			foreach($module as $enqueue){
				if($enqueue->type == 'css'){
					$this->loadCSS($enqueue);
				}else if($enqueue->type == 'js'){
					$this->loadJS($enqueue);
				}
			}
		}
	}



	

	//template interaction functions
	function getPiece($piece_name){
		return !empty($this->pieces[$piece_name]) ? $this->pieces[$piece_name] : $piece_name;
	}
	function setPiece($piece_name, $template_name){
		$this->pieces[$piece_name] = $template_name;
	}
	function piece($piece_name){
		return implode('.', array_filter([$this->location, $this->template, $this->getPiece($piece_name)]));
	}
	public function layout(){
		return implode('.', array_filter([$this->location, $this->template, $this->layout]));
	}
	public function notFoundView(){
		return implode('.', [$this->location, $this->template, $this->not_found_view]);
	}
	public function notFoundCSS(){
		return $this->cssPath($this->not_found_css);
	}

	//resource url/baseurl functions
	public function cssPath($filename = null){
		return $this->joinPaths($this->asset_path, $this->css_path, $filename);
	}
	public function jsPath($filename = null){
		return $this->joinPaths($this->asset_path, $this->js_path, $filename);
	}
	public function imagePath($filename = null){
		return $this->joinPaths($this->asset_path, $this->image_path, $filename);
	}
	public function assetPath($filename = null){
		return $this->joinPaths($this->asset_path, $filename);
	}
	public function joinPaths(...$xs){
		$path = "";
		$pieces = $xs;
		$basefile = array_pop($pieces);
		$extpath = $this->joinPathsLoop($pieces);
		if( strpos($basefile, $extpath) === 0){
			$xs[ (count($xs) - 1) ] = str_replace($extpath, '', $basefile);
		}
		$path = $this->joinPathsLoop($xs);
		return $path;
	}
	public function joinPathsLoop($paths){
		$path = "";
		foreach(array_filter($paths) as $x){
			$path .= (substr($path, -1) !== '/' ? '/' : '') . ltrim($x, '/');
		}
		return $path;
	}
	

	//load resources
	public function enqueue($type, $path, $priority = null, $header = false, $minify = null){
		if(!is_numeric($priority)){
			$priority = $this->priority;
		}
		if($minify === null){
			$minify = false;
		}

		return (new Enqueue($type, $path, $priority, $header, $minify, $this));
	}
	
    public function loadCSS(...$xs){
		if( ($xs[0] instanceOf Enqueue) ){
			$enqueue = $xs[0];
		}else{
			if($xs[0] != 'css'){
				array_unshift($xs, 'css');
			}
			$enqueue = call_user_func_array([$this, 'enqueue'], $this->arrToArgs($xs));
		}
        $this->assets->css[] = $enqueue;
    }
    public function loadJS(...$xs){
        if( ($xs[0] instanceOf Enqueue) ){
			$enqueue = $xs[0];
		}else{
			if($xs[0] != 'js'){
				array_unshift($xs, 'js');
			}
			$enqueue = call_user_func_array([$this, 'enqueue'], $this->arrToArgs($xs));
		}
        $this->assets->js[] = $enqueue;
    }
    public function loadJSInline($str){
        $this->assets->jsInline[] = $str;
	}
	

	public function filterAssets($type, $options = []){
		$options = array_merge([
			'header' => null,
			'relative' => null,
			'external' => null,
			'minify' => null,
			'prioritize' => true,
			'toUrl' => false,
		], $options);

		$rows = array_filter($this->assets->$type, function($resource) use ($options) {
			$status = true;

			if(isset($options['header']) && (!!$options['header'] != !!$resource->header)){
				$status = false;
			}
			if(isset($options['minify']) && (!!$options['minify'] != !!$resource->minify)){
				$status = false;
			}

			if(isset($options['relative']) && (!!$options['relative'] != !!$resource->isRelative)){
				$status = false;
			}
			if(isset($options['external']) && (!!$options['external'] != !!$resource->isExternal)){
				$status = false;
			}

			return $status;
		});

		if($options['prioritize']){
			$groupedRows = [];
			foreach($rows as $row){
				if( empty($groupedRows[$row->priority]) ){
					$groupedRows[$row->priority] = [];
				}
				$groupedRows[$row->priority][] = $row;
			}
			ksort($groupedRows);

			$rows = [];
			foreach($groupedRows as $group){
				foreach($group as $row){
					$rows[] = $row;
				}
			}
		}
		if($options['toUrl']){
			return array_map(function($row){
				return $row->path;
			}, $rows);
		}
		return $rows;
	}


    public function outputAssets($type, $location, $scripts = [], $minify = false){
      $map = [];

      foreach($scripts as $script){
		$script = public_path($script);
		$modified = 0;

		if(is_file($script)){
			$modified = filemtime($script);
		}
        $map[$script] = $modified;
      }

      if(!$minify){
        return $this->makeAssetsHtml($type, $map);
      }

      $cached_map = cache($type . '.minified.' . $location . '.source');
      $minified_map = cache($type . '.minified.'. $location . '.target');

      if(!$cached_map || $cached_map != $map){
        $minified_map = $this->minifyAssets($type, $location, $map);
      }

      return $this->makeAssetsHtml($type, $minified_map ?: $map );
    }
    public function minifyAssets($type, $location, $map){

      if($type == 'js'){
        $minifier = new \MatthiasMullie\Minify\JS();
      }else if($type == 'css'){
        $minifier = new \MatthiasMullie\Minify\CSS();
      }

      $minified_map = [];

      foreach($map as $script => $time){
        if($time > 0){
          $minifier->add($script);
        }else{
          $minified_map[$script] = $time;
        }
      }



      $base = public_path('minify/');
      if(!is_dir( $base )){
        mkdir( $base );
      }

      $destination = $base . $location .'.'. $type;

      $minified_map[$destination] = time();

      $minifier->minify($destination);

      $cached_map = cache([$type . '.minified.' . $location . '.source' => $map], 60*24 );

      cache([$type . '.minified.'. $location . '.target' => $minified_map ], 60*25 );

      return $minified_map;
    }


    public function makeAssetsHtml($type, $map = []){
      $base = public_path();

      $html = '';
      foreach( $map as $file => $time ){
        $file = str_replace($base, '', $file);
        if($type == 'js'){
          $html .= "<script ". ($time ? "data-modified='". date('Y-m-d H:i:s', $time)."'" : '') ." type='text/javascript' src='{$file}'></script>";
        }else if($type == 'css'){
          $html .= "<link ". ($time ? "data-modified='". date('Y-m-d H:i:s', $time)."'" : '') ." type='text/css' rel='stylesheet' href='{$file}'></script>";
        }

      }
      return $html;
    }

    public function makeFooterJS(){
		$minify_active = config('app.minify_assets');
		if($minify_active){
			$html = $this->outputAssets('js', 'footer', $this->filterAssets('js', [
				'header' => false,
				'minify' => true,
				'toUrl' => true,
			]), true);
			
			$html .= $this->outputAssets('js', 'footer', $this->filterAssets('js', [
				'header' => false,
				'minify' => false,
				'toUrl' => true,
			]), false);
		}else{
			$html = $this->outputAssets('js', 'footer', $this->filterAssets('js', [
				'header' => false,
				'toUrl' => true,
			]), false);
		}

		return $html;
    }

    public function makeHeaderJS(){   
		$minify_active = config('app.minify_assets');
		if($minify_active){
			$html = $this->outputAssets('js', 'header', $this->filterAssets('js', [
				'minify' => true,
				'header' => true,
				'toUrl' => true,
			]), true);
			
			$html .= $this->outputAssets('js', 'header', $this->filterAssets('js', [
				'header' => true,
				'minify' => false,
				'toUrl' => true,
			]), false);	  
		}else{
			$html = $this->outputAssets('js', 'header', $this->filterAssets('js', [
				'header' => true,
				'toUrl' => true,
			]), false);
		}
		  
		return $html;
    }
    public function makeHeaderCSS(){
		$minify_active = config('app.minify_assets');
		if($minify_active){
			$html = $this->outputAssets('css', 'header', $this->filterAssets('css', [
				'minify' => true,
				'toUrl' => true,
			]), true);
			
			$html .= $this->outputAssets('css', 'header', $this->filterAssets('css', [
				'minify' => false,
				'toUrl' => true,
			]), false);	  
		}else{
			$html = $this->outputAssets('css', 'header', $this->filterAssets('css', [
				'toUrl' => true,
			]), false);
		}
		  
		return $html;
    }
}

class Enqueue {
	var $type;
	var $path;
	var $orig_path;
	var $priority;
	var $header;
	var $isRelative;
	var $isExternal;
	var $template;
	var $minify;
	public function __construct($type, $path, $priority, $header, $minify, $template){
		$this->type = $type;
		$this->path = $this->orig_path = $path;
		$this->priority = $priority;
		$this->header = $header;
		$this->template = $template;
		$this->minify = $minify;

		return $this->run()->path();
	}
	public function run(){
		$this->isExternal = $this->isExternal();
		$this->isRelative = $this->isRelative();
		$this->type = $this->type ? $this->type : $this->typeByExtension();
		$this->minify = $this->isExternal ? false : $this->minify;
		return $this;
	}
	public function orig(){
		$this->path = $this->orig_path;
		return $this->run();
	}
	public function path(){
		$path = $this->path;
		$type = $this->type;

		if( $this->isRelative ){
			if($type == 'js'){
				$path = $this->template->jsPath($path);
			}else if($type == 'css'){
				$path = $this->template->cssPath($path);
			}
		}
		$this->path = $path;

		return $this->run();
	}
	public function isExternal(){
		$path = $this->path;
		return preg_match('@^https?\:\/\/@', $path);
	}
	public function isRelative(){
		$path = $this->path;
		return ($path[0] == '/' && $path[1] != '/' ? false : true);
	}
	public function typeByExtension(){
		$arr = explode('.', basename($this->path));
		return end($arr);
	}

	public function toArray(){
		return [$this->type, $this->path, $this->priority, $this->header];
	}

}
