<?php


namespace App\Interfaces\Autocomplete;

use App\Application\Models\Users;
use App\Components\Database\Model;

/**
 * Interface PolicyInterface
 * @package App\Interfaces
 */
interface PolicyAutocomplete
{

    /**
     * @param Model $model
     * @return mixed
     */
    public function view(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function create(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function delete(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function update(Model $model);
}
