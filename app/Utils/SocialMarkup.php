<?php
namespace App\Utils;

class SocialMarkup {

	public static $facebook_share_base = "https://www.facebook.com/sharer/sharer.php";
	public static $twitter_share_base = "https://twitter.com/intent/tweet";
	public static $googleplus_share_base = "https://plus.google.com/share";
	public static $pinterest_share_base = "http://pinterest.com/pin/create/button/";

	public static $facebook_share_defaults = [ 'u' => false, 'title' => false, 'description' => false ];
	public static $twitter_share_defaults = [ 'text' => false, 'hashtags' => false, 'url' => false ];
	public static $googleplus_share_defaults = [ 'url' => false ];
	public static $pinterest_share_defaults = [ 'url' => false, 'media' => false, 'description' => false ];

	public static function facebookShareURL($url = '', $params = array()){
		if(empty($url)){
			$url = \Request::url();
		}
		$params['u'] = $url;
		$params = array_merge(self::$facebook_share_defaults, $params);
		return self::shareURL(self::$facebook_share_base, $params);
	}
	public static function twitterShareURL($url = '', $params = array()){
		if(empty($url)){
			$url = \Request::url();
		}
		$params['url'] = $url;
		$params = array_merge(self::$twitter_share_defaults, $params);
		if($params['text'] && strlen($params['text']) > 140){
			$params['text'] = substr($params['text'], 0, 140);
		}
		return self::shareURL(self::$twitter_share_base, $params);
	}
	
	public static function googleplusShareUrl($url = '', $params = array()){
		if(empty($url)){
			$url = \Request::url();
		}
		$params['url'] = $url;
		$params = array_merge(self::$googleplus_share_defaults, $params);
		return self::shareURL(self::$googleplus_share_base, $params);
	}
	public static function pinterestShareUrl($url = '', $params = array()){
		if(empty($url)){
			$url = \Request::url();
		}
		$params['url'] = $url;
		$params = array_merge(self::$pinterest_share_defaults, $params);
		return self::shareURL(self::$pinterest_share_base, $params);
	}


	public static function shareURL($url, $params){
		foreach($params as $key => $val){
			if($val === false){
				unset($params[$key]);
			}
		}

		return $url . '?' . http_build_query($params);
	}

	public static $prefixes = [
		'og' => 'http://ogp.me/ns#',
		'fb' => 'http://ogp.me/ns/fb#',
		'product' => 'http://ogp.me/ns/product#',
	];
	public static $registered_prefixes = [];

	public static $registered_tags = [];
	public static $tags_site_defaults = [
		'image' => [false, 'og'],
		'title' => [false, 'og'],
		'url' => [false, 'og'],
		'site_name' => [false, 'og'],
		'image' => [false, 'og'],
		'type' => [false, 'og'],
		'description' => [false, 'og'],
		'locale' => [false, 'og'],
		'app_id' => [false, 'fb'],
	];
	public static $tags_product_defaults = [
		'type' => ['product', 'og'],

		'availability' => [false, 'product'], //instoc, oos, pending
		'category' => [false, 'product'],
		'color' => [false, 'product'],
		'condition' => [false, 'product'], //new, refurbished, used
		'price' => [false, 'product'],
		'size' => [false, 'product'],
		'weight' => [false, 'product'],
		'target_gender' => [false, 'product'], //female, male, unisex


		'original_price:amount' => [false, 'product'],
		'original_price:currency' => [false, 'product'],
		'pretax_price:amount' => [false, 'product'],
		'pretax_price:currency' => [false, 'product'],
		'price:amount' => [false, 'product'],
		'price:currency' => [false, 'product'],
		'shipping_cost:amount' => [false, 'product'],
		'shipping_cost:currency' => [false, 'product'],
		'weight:value' => [false, 'product'],
		'weight:units' => [false, 'product'],
		'shipping_weight:value' => [false, 'product'],
		'shipping_weight:units' => [false, 'product'],
		'sale_price:amount' => [false, 'product'],
		'sale_price:currency' => [false, 'product'],
		'sale_price_dates:start' => [false, 'product'],
		'sale_price_dates:end' => [false, 'product'],
	];

	public static $tags_article_defaults = [
		'type' => ['article', 'og'],

		'published_time' => [false, 'article'],	//DateTime
		'section' => [false, 'article'], //	String category name
		'tag' => [false, 'article'], //	Array<String>	An array of keywords
	];

	public static function setSiteTags($params){
		if(!$params){
			return false;
		}
		$params = self::merge_tags(self::$tags_site_defaults, self::$registered_tags, $params);
		self::register_prefix('og');
		self::register_prefix('fb');
		return self::register_tags($params);
	}
	public static function setProductTags($params){
		if(!$params){
			return false;
		}
		unset(self::$registered_tags['type']);

		$params = self::merge_tags(self::$tags_site_defaults, self::$tags_product_defaults, self::$registered_tags, $params);
		self::register_prefix('product');
		return self::register_tags($params);
	}
	public static function setArticleTags($params){
		if(!$params){
			return false;
		}
		unset(self::$registered_tags['type']);

		$params = self::merge_tags(self::$tags_site_defaults, self::$tags_article_defaults, self::$registered_tags, $params);
		self::register_prefix('article');
		return self::register_tags($params);
	}
	public static function register_prefix($prefix){
		$arr = self::$registered_prefixes;
		$arr[] = $prefix;
		self::$registered_prefixes = array_unique($arr);
	}
	public static function makeRegisteredPrefixes(){
		if(!self::$registered_prefixes){
			return false;
		}
		$arr = array();
		foreach(self::$registered_prefixes as $prefix_type){
			if(!isset(self::$prefixes[$prefix_type])){
				continue;
			}
			$prefix_url = self::$prefixes[$prefix_type];
			$arr[$prefix_type] = $prefix_url;
		}
		return self::makePrefixes($arr);
	}
	public static function makePrefixes($prefixes){
		$str = "";
		foreach($prefixes as $prefix_type => $prefix_url){
			$str .= ($str ? " " : "") . $prefix_type . ": " . $prefix_url;
		}
		return $str;
	}
	public static function merge_tags(...$groups){
		$params = array();

		if($groups){
			foreach($groups as $group){
				foreach($group as $property => $arr){
					if(is_string($arr)){
						$arr = [$arr, null];
					}

					if(isset($params[$property])){
						$arr = [ 
							$arr[0] ? $arr[0] : $params[$property][0],
							$arr[1] ? $arr[1] : $params[$property][1],
						];
					}

					$params[$property] = $arr;
				}
			}
		}
		return $params;
	}
	public static function register_tags($tags = array()){
		if(!$tags){
			return false;
		}
		foreach($tags as $key => $arr){
			list($content, $type) = $arr;
			if($content){
				self::$registered_tags[$key] = $arr;
			}else if($content === false){
				unset(self::$registered_tags[$key]);
			}
		}
		return true;
	}
	public static function makeRegisteredTags(){
		return self::makeTags(self::$registered_tags);
	}
	public static function makeTags($tags){
		$html = "";

		if($tags){
			foreach($tags as $property => $arr){
				list($content, $type) = $arr;

				$html .= self::make_tag($property, $content, $type);
			}
		}

		return $html;
	}
	public static function make_tag($property, $content, $type = 'og'){

		return "<meta property=\"". $type .":". $property ."\" content=\"". htmlspecialchars($content, ENT_QUOTES)."\"/>\n";
	}

} 