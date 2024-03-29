<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;


/**
 * Class Modele_emballages
 * @package App\Models
 * @version March 9, 2023, 8:21 pm +07
 *
 * @property string $model_type
 * @property integer $model_id
 * @property integer $emballage_id
 * @property integer $quantite
 * @property string $unite
 * @property integer $freinte
 * @property boolean $maitre
 * @property string $variantes
 * @property string $description
 */
class Modele_emballages extends Model
{
    use SoftDeletes;


    public $table = 'modele_emballages';


    protected $dates = ['deleted_at'];

    public $timestamps = false;



    public $fillable = [
        'model_type',
        'model_id',
        'emballage_id',
        'quantite',
        'unite',
        'freinte',
        'maitre',
        'variantes',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'model_type' => 'string',
        'model_id' => 'integer',
        'emballage_id' => 'integer',
        'quantite' => 'integer',
        'unite' => 'string',
        'freinte' => 'integer',
        'maitre' => 'boolean',
        'variantes' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function emballage(){
        return $this->belongsTo(Emballages::class, 'emballage_id');
    }


}
