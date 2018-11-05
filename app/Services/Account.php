<?php 
namespace App\Services;

class Account {
    var $sobject = 'Account';
    var $source;
    static $globalBase;
    var $base;

    var $baseColumns = ['keyPrefix', 'label', 'labelPlural'];

    public function __construct(){
        $this->source = $this->getSource();
        if(static::$globalBase){
            $this->base = static::$globalBase;
        }
    }

    public function getSource(){
        return \App\App::salesforce();
    }
    public function fetchBase(){
        if($this->base){
            return $this->base;
        }
        $url = $this->selfUrl();
        $response = $this->source->call('get', 'token', $url);

        $data = $response['objectDescribe'];
        
        $base = [];
        foreach($this->baseColumns as $column){
            $base[$column] = $data[$column];
        }
        
        $selfUrl = $this->selfUrl();

        $base['urls'] = $data['urls'];
        $base['data'] = $data;

        return static::$globalBase = $this->base = $base;
    }

    public function describe(){
        $this->fetchBase();

        return $this->call('get', $this->base['urls']['describe']);
    }

    public function list(){
        $this->fetchBase();

        //object group
        $group = $this->call('get', $this->base['urls']['listviews']);

        $resultsUrl = $group['listviews'][0]['resultsUrl'];

        $results = $this->call('get', $resultsUrl);

        return array_map(function($record){ 
            $row = [];
            foreach($record['columns'] as $column){
                $row[$column['fieldNameOrPath']] = $column['value'];
            }
            return $row;
        }, $results['records']);

    }
    public function idPath($id){
        return str_replace('{ID}', $id, $this->base['urls']['rowTemplate']);
    }
    public function getById($id){
        $this->fetchBase();

        $url = $this->idPath($id);
        return $this->call('get', $url);
    }

    public function update($id, $post){
        $this->fetchBase();

        $url = $this->idPath($id);  
        return $this->call('patch', $url, $post, ['json' => 1]);
    }

    public function call($method, $url, $post = [], $params = []){
        $url = $this->source->instance_url . '/' . ltrim($url, '/');

        return $this->source->call($method, 'token', $url, $post, $params);
    }


    public function selfUrl(){
        return $this->source->apiUrl('sobjects/' . $this->sobject . '/');
    }
}