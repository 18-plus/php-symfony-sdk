<?php

namespace EighteenPlus\AgeGateSymfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use EighteenPlus\AgeGate\AgeGate;
use Symfony\Component\HttpFoundation\Request;

class AgeGateSymfony extends Bundle
{
    public function boot()
    {
        $baseUrl = $this->container->get('router')->getContext()->getBaseUrl();
        if (!$baseUrl) {            
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        
        $gate = new AgeGate($baseUrl);
        $gate->setTitle(getenv('AGEGATE_TITLE'));
        $gate->run();
    }
}