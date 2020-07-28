<?php


namespace App\Components\Elasticsearch;

/**
 * Class ModelMapper
 * @package App\Components\Elasticsearch
 */
class ModelMapper
{
    /**
     * @param Model $model
     * @param array $data
     * @return array|Model[]
     */
    public static function make(Model $model, array $data):array
    {
        $return=[];
        foreach ($data['hits']['hits'] as $hit) {
            $return[]= self::instance($hit, clone $model);
        }
        return $return;
    }

    /**
     * @param array $data
     * @param Model $model
     * @return Model
     */
    public static function instance(array $data, Model $model):Model
    {
        $source=$data['_source'];
        $source['id']=$data['_id'];
        foreach ($source as $key=>$value) {
            $model->$key=$value;
        }
        $model->setAttributes($source);
        return  $model;
    }
}
