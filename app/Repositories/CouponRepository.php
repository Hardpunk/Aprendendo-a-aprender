<?php

namespace App\Repositories;

use App\Coupon;
use App\Repositories\BaseRepository;

/**
 * Class CouponRepository
 * @package App\Repositories
 * @version May 5, 2021, 12:32 am -03
*/

class CouponRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Coupon::class;
    }
}
