<?php
/**
 * Template autoload for eZFluxBB
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

// Operator autoloading
$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbtemplateoperators.php',
    'class' => 'leztbTemplatesOperators',
    'operator_names' => array(
        'get_siteaccess',
        'redirect'
    )
);

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbdatetemplateoperators.php',
    'class' => 'leztbDateTemplatesOperators',
    'operator_names' => array(
        'related_datetime'
    )
);

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbstringtemplateoperators.php',
    'class' => 'leztbStringTemplatesOperators',
    'operator_names' => array(
        'json_decode',
        'str_ireplace',
        'str_replace'
    )
);

?>