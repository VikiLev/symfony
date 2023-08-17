<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\ApiSales;

#[ApiResource(operations: [
    new Get(
        name: 'api_sales',
        uriTemplate: '/api/sales/{productId}',
        controller: ApiSales::class
    )
])]

class Sales
{
    // ...
}
