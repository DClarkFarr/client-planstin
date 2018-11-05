<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public static function getTableStatic(){
        return ((new static)->getTable());
    }
    public function getTable(){
        return $this->table;
    }

    public function set($attributes = []){
        foreach($attributes as $key => $val){
            $this->$key = $val;
        }

        return $this;
    }
    public function setAndSave($attributes){
        $this->set($attributes);
        $this->save();

        return $this;
    }

    public static function create($attributes = []){
        $model = new static;

        $model->setForCreate($attributes);
        
        list($status, $message) = $model->validateCreate();

        if(!$status){
            return [$status, $message];
        }

        $model->save();

        return [$model, ''];
    }
    public function setForCreate($attributes = []){
        return $this->set($attributes);
    }
    public function validateCreate(){
        return [true, ''];
    }
}
