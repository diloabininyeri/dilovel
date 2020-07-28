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
     * @return array
     */
    public static function make(Model $model, array $data):array
    {
        if (isset($data['hits']['hits'])) {
            $data=$data['hits']['hits'];
            $return = [];
            foreach ($data as $key =>$value) {
                $clonedModel = clone $model;
                foreach ($value as $item=>$itemValue) {
                    $clonedModel->$item=$itemValue;
                }
                foreach ($value['_source'] as $sourceKey=>$sourceValue) {
                    $clonedModel->$sourceKey=$sourceValue;
                }
                unset($clonedModel->_source);
                $return[]=$clonedModel;
            }
            return $return;
        }
        return  [];
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
