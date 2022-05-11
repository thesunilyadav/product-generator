<?php

namespace Sunilyadav\Generator;

use App;

class ProductGenerator
{
    protected $platformGenerator;

    /**
     *  Init dynamic platform and generate file
     * 
     * @param string $platform
     * @param int $nOfProducts
     * 
     * @return mixed
     */
    public function generateCsv($platform, $nOfProducts = 10)
    {
        $status = $this->init($platform);
        if($status){
            $totalProducts = $nOfProducts > 50000 ? 50000 : ( $nOfProducts <= 0 ? 1 : $nOfProducts );
            
            return $this->platformGenerator->getFile($totalProducts);
        }
        return response("Platform is not valid.",422);
    }

    /**
     * Create platform instance
     * 
     * @param string $platform
     * 
     * @return bool
     */
    public function init($platform)
    {
        $isValid = $this->resolvePlatform($platform);  
        
        if($isValid){
            $class = __NAMESPACE__ . "\\Platforms\\" . ucfirst($platform) . "Generator";
            $this->platformGenerator = App::make($class);

            return true;
        }
        return false;
    }

    /**
     * Check the platform
     * 
     * @param string $platform
     * 
     * @return bool
     */
    public function resolvePlatform($platform)
    {
        return in_array(strtolower($platform),['shopify', 'bigcommerce']);
    }
}