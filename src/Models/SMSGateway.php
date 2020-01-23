<?php

namespace Bakhritdinov\SMSManager\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SMSGateway
 * @package Bakhritdinov\SMSManager\Models
 */
class SMSGateway extends Model
{
    /**
     * SMSGateway constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $tableName = config('sms_manager.table_name') ?: 'sms_gateways';

        $this->setTable($tableName);
    }

    /**
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'priority' => 'integer'
    ];

    /**
     * @var array
     */
    protected $fillable = ['active', 'name', 'description', 'class_id', 'priority'];

    /**
     * @param $data
     * @return bool
     */
    public function getActiveAttribute($data): bool
    {
        return boolval($data);
    }

    /**
     * @param $data
     * @return int
     */
    public function getPriorityAttribute($data): int
    {
        return (int)$data;
    }
}