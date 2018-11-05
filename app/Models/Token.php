<?php 
namespace App\Models;

class Token extends BaseModel { 
    public $primaryKey = 'id_token';
    protected $table = 'token';

    protected $casts = [
        'data' => 'array',
    ];

    public function setForCreate($attributes = []){
        $attributes = array_merge(
            [
                'env' => \Config::get('app.env'),
                'type' => 'site',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            array_filter($this->getFillable()),
            array_filter($attributes)
        );

        $data = !empty($attributes['data']) ? (array) $attributes['data'] : [];

        if(empty($attributes['token'])){
            $attributes['token'] = !empty($data['access_token']) ? $data['access_token'] : '';
        }
        if(empty($attributes['refresh'])){
            $attributes['refresh'] = !empty($data['refresh_token']) ? $data['refresh_token'] : '';
        }

        return parent::setForCreate($attributes);
    }
}