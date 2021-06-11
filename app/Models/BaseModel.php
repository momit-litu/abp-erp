<?php

namespace App\Models;

use App\Helpers\Classes\AuthHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * Class BaseModel
 * @package App\Models
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property-read int id
 */
abstract class BaseModel extends Model
{
    public const ROW_STATUS_ACTIVE = '1';
    public const ROW_STATUS_INACTIVE = '0';
    public const ROW_STATUS_DELETED = '99';

    /**
     * @return array
     * @deprecated Use getCurrentInstance
     */
    public static function getRowStatusOptions(): array
    {
        return [
            self::ROW_STATUS_ACTIVE => __('Active'),
            self::ROW_STATUS_INACTIVE => __('Inactive'),
            self::ROW_STATUS_DELETED => __('Deleted'),
        ];
    }

    public static function getCurrentRowStatus(Model $model): string
    {
        $rowStatusArray = self::getStatusOptions();
        if (!empty($rowStatusArray[$model->row_status])) {
            return $rowStatusArray[$model->row_status];
        }
        return '';
    }

    public static function getStatusOptions(): array
    {
        return self::getRowStatusOptions();
    }


    public function save(array $options = [])
    {
        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($this->getAttribute('id')) {
                if (Schema::hasColumn($this->getTable(), 'updated_by')) {
                    $this->updated_by = $authUser->id;
                }
            } else {
                if (Schema::hasColumn($this->getTable(), 'created_by')) {
                    $this->created_by = $authUser->id;
                }
            }
        }

        return parent::save($options);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (Auth::check()) {
            $authUser = AuthHelper::getAuthUser();
            $connectionName = $this->getConnectionName();
            if (Schema::connection($connectionName)->hasColumn($this->getTable(), 'updated_by')) {
                $this->updated_by = $authUser->id;
            }
        }

        return parent::update($attributes, $options);
    }


}
