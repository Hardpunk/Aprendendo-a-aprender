<?php

namespace App\Repositories;

use App\Affiliate;
use App\Repositories\BaseRepository;

/**
 * Class AffiliateRepository
 * @package App\Repositories
 * @version February 21, 2021, 11:00 pm -03
*/

class AffiliateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
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
        return Affiliate::class;
    }
}
