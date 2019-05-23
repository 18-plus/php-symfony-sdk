<?php

namespace EighteenPlus\AgeGateSymfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use EighteenPlus\AgeGate\AgeGate;
use Symfony\Component\HttpFoundation\Request;

class AgeGateSymfony extends Bundle
{
    public function boot()
    {
        if (php_sapi_name() === 'cli') {
            return;
        }
        
        $baseUrl = $this->container->get('router')->getContext()->getBaseUrl();
        if (!$baseUrl) {            
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        
        $title = getenv('AGEGATE_TITLE');
        if (!$title) {            
            try {            
                $title = $this->container->getParameter('AGEGATE_TITLE');
            } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
                $title = '';
            }
        }
        
        $gate = new AgeGate($baseUrl);
        $gate->setTitle($title);
        $gate->run();
    }
}