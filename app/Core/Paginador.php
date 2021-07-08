<?php
namespace App\Core;

use JasonGrimes\Paginator;
use Ausi\SlugGenerator\SlugGenerator;

class Paginador extends Paginator
{
    public function __construct(int $count, int $limit, int $page, string $query)
    {
        parent::__construct($count, $limit, $page, $query . '?page=(:num)');
    }
}