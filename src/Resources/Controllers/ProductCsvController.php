<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunilyadav\Generator\ProductGenerator;

class ProductCsvController extends Controller
{
    protected $productGenerator;

    /**
     * Create generator instance
     */
    public function __construct(ProductGenerator $productGenerator)
    {
        $this->productGenerator = $productGenerator;
    }

    /**
     * Generate CSV file
     * 
     * @param Request $request
     * @param string $platform
     * 
     * @return mixed
     */
    public function index(Request $request, $platform)
    {
        $numberOfProducts =  $request->products ? $request->products : 10;

        return $this->productGenerator->generateCsv($platform, $numberOfProducts);
    }
}
