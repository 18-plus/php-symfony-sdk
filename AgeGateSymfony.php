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
        
        $params = [
            'agegate_title' => '',
            'agegate_logo' => '',
            'agegate_site_name' => '',
            'agegate_custom_text' => '',
            'agegate_custom_text_location' => '',
            'agegate_background_color' => '',
            'agegate_text_color' => '',
            'agegate_remove_reference' => '',
            'agegate_remove_visiting' => '',
            'agegate_test_mode' => '',
            'agegate_test_anyip' => '',
            'agegate_test_ip' => '',
            'agegate_start_from' => '',
            'agegate_desktop_session_lifetime' => '',
            'agegate_mobile_session_lifetime' => '',
        ];
        
        foreach ($params as $key => &$value) {
            $value = getenv($key);
            if (!$value) {
                try {            
                    $value = $this->container->getParameter($key);
                } catch (\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException $e) {
                    $value = '';
                }
            }
        }
        
        $gate = new AgeGate($baseUrl);
        $gate->setTitle($params['agegate_title']);
        $gate->setLogo($params['agegate_logo']);
        
        $gate->setSiteName($params['agegate_site_name']);
        $gate->setCustomText($params['agegate_custom_text']);
        $gate->setCustomLocation($params['agegate_custom_text_location']);
        
        $gate->setBackgroundColor($params['agegate_background_color']);
        $gate->setTextColor($params['agegate_text_color']);
        
        $gate->setRemoveReference($params['agegate_remove_reference']);
        $gate->setRemoveVisiting($params['agegate_remove_visiting']);
        
        $gate->setTestMode($params['agegate_test_mode']);
        $gate->setTestAnyIp($params['agegate_test_anyip']);
        $gate->setTestIp($params['agegate_test_ip']);
        
        $gate->setStartFrom($params['agegate_start_from']);
        
        $gate->setDesktopSessionLifetime($params['agegate_desktop_session_lifetime']);
        $gate->setMobileSessionLifetime($params['agegate_mobile_session_lifetime']);
        
        $gate->run();
    }
}