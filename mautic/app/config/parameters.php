<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

//load default parameters from bundle files
$bundles = $container->getParameter('mautic.bundles');

$mauticParams = array();
foreach ($bundles as $bundle) {
    if (file_exists($bundle['directory'].'/Resources/config/parameters.php')) {
        $bundleParams = include $bundle['directory'].'/Resources/config/parameters.php';
        foreach ($bundleParams as $k => $v) {
            $mauticParams[$k] = $v;
        }
    }
}

$mauticParams['supported_languages'] = array(
    'en_US' => 'English - United States'
);

//load parameters array from local configuration
include "local.php";

foreach ($parameters as $k => $v) {
    $container->setParameter("mautic.{$k}", $v);
    $mauticParams[$k] = $v;
}

//used for passing params into services
$container->setParameter('mautic.parameters', $mauticParams);