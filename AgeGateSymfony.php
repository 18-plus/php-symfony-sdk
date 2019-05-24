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
        
        $title = getenv('agegate_title');
        if (!$title) {            
            try {            
                $title = $this->container->getParameter('agegate_title');
            } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
                $title = '';
            }
        }
        
        $testIp = getenv('agegate_test_ip');
        if (!$testIp) {            
            try {            
                $testIp = $this->container->getParameter('agegate_test_ip');
            } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
                $testIp = '';
            }
        }
        
        $startFrom = getenv('agegate_start_from');
        if (!$startFrom) {            
            try {            
                $startFrom = $this->container->getParameter('agegate_start_from');
            } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
                $startFrom = '';
            }
        }
        
        $gate = new AgeGate($baseUrl);
        $gate->setTitle($title);
        $gate->setTestIp($testIp);
        $gate->setStartFrom($startFrom);
        $gate->run();
    }
}