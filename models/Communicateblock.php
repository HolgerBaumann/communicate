<?php namespace HolgerBaumann\Communicate\Models;

use Model;

use FlyNex\Utils\Models\BaseModel as BaseModel;

/**
 * Model
 */
class Communicateblock extends BaseModel
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

	/**
	 * Softly implement the TranslatableModel behavior.
	 */
	public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

	/**
	 * @var array Attributes that support translation, if available.
	 */
	public $translatable = ['form_title','info_title','address_data','phone_data','email_data'];

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
	    'form_title' => 'required',
	    'block_id' => 'required|unique:holgerbaumann_communicate_communicateblock,block_id'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'holgerbaumann_communicate_communicateblock';
}