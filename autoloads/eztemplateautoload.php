<?php
//
// Created on: <01-Sep-2008 19:00:00 GKUL>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: leZToolbox
// SOFTWARE RELEASE: 1.1
// BUILD VERSION:
// COPYRIGHT NOTICE: Copyright (c) 2008-2010 Guillaume Kulakowski and contributors
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

// Operator autoloading
$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbtemplateoperators.php',
    'class' => 'myutilsTemplatesOperators',
    'operator_names' => array(
        'get_siteaccess',
        'is_debug_enabled',
        'path_to_path_array',
        'redirect'
    )
);

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbdatetemplateoperators.php',
    'class' => 'myutilsDateTemplatesOperators',
    'operator_names' => array(
        'gmdate',
        'r_datetime'
    )
);

$eZTemplateOperatorArray[] = array(
    'script' => 'extension/leztoolbox/autoloads/leztbstringtemplateoperators.php',
    'class' => 'myutilsStringTemplatesOperators',
    'operator_names' => array(
        'json_decode',
        'str_ireplace',
        'str_replace'
    )
);

?>