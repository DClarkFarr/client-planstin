<?php
/**
 * File: CoverageTierPriceRepository.php
 * Project: planstin
 * Author: @laytoneverson <layton.everson@gmail.com>
 */

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class CoverageTierPriceRepository extends EntityRepository
{
    use SalesForceObjectRepositoryTrait;
}
