<?php 
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//custom
use Illuminate\Http\Request;
use App\App;
use \App\Exceptions\ControllerException;

class MvcController extends LaravelController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $template;
    public $request;

    public function __construct(Request $request){
        $path = $request->path();

        $matches = [
            '@^employee/?@',
        ];
        $matched = false;
        foreach($matches as $match){
            if( preg_match($match, $path) ){
                $matched = true;
                break;
            }
        }
        if($matched){
            /**
             * Deactivate middleware so people can build pages
             */
            //$this->middleware('token');
        }
    }

    public function receive(Request $request, $controller = null, $method = null, $uri = ''){
        $this->request = $request;
        
        $toCamelCase = function($str){
            $arr = explode('-', $str);
            $arr = array_map(function($v){ return ucfirst($v); }, $arr);
            return implode('', $arr);
        };

        $this->route = (object) [
            'controller' => ucfirst($controller ?: 'main'),
            'method' => $toCamelCase($method) ?: 'home',
            'segments' => array_filter(explode('/', $uri)),
            'uri' => $uri,
        ];

        

        return $this->makeResponse();
    }
    
    public function makeResponse(){
        
        $controllerClass = __NAMESPACE__ . '\\' . $this->route->controller;

        if( !class_exists( $controllerClass ) ){
            return $this->error('Controller {'. $this->route->controller .'} not found.');
        }
        if(  !method_exists($controllerClass, $this->route->method) ){
            return $this->error('{'. $this->route->controller .'} Controller has no method {'. $this->route->method .'}');
        }

        try {
            $controller = new $controllerClass($this);
            return call_user_func_array([$controller, $this->route->method], $this->route->segments);
        }catch(ControllerException $e){
            if($e->getCode() == 300){
                return \App\App::redirectToLogin()->with(['error' => $e->getMessage()]);
            }else{
                return $this->error($e->getMessage());
            }
        }
        
    }

    public function error($message){
        return abort(404, $message);
    }


}