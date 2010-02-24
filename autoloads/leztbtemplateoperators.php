<?php
//
// Definition of leztbTemplatesOperators class
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


/*! \file leztbtemplatesoperators.php
*/

/*!
  \class leztbTemplatesOperators leztbtemplatesoperators.php
 */
class leztbTemplatesOperators
{

    private $Operators;


    /*!
     Constructor
     */
    function __construct()
    {
        /* Opérateurs */
        $this->Operators = array(
            'get_siteaccess',
            'is_debug_enabled',
            'path_to_path_array',
            'redirect'
        );
    }



    function &operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
         return array(
            'get_siteaccess' => array( ),

            'is_debug_enabled' => array( ),

            'path_to_path_array' => array(
                'path' => array( 'type' => 'array', 'required' => true, 'default' => ''  ),  ),

            'redirect'  => array(
                'url' => array( 'type' => 'string', 'required' => true, 'default' => ''  ),
                'type' => array( 'type' => 'integer', 'required' => false, 'default' => '301' )  )
         );
    }



    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                      &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'get_siteaccess':
                $operatorValue = $GLOBALS['eZCurrentAccess']['name'];
                break;

            case 'is_debug_enabled':
                $operatorValue = eZDebug::isDebugEnabled();
                break;

            case 'path_to_path_array':
                $operatorValue = leztbFunctions::path2PathArray( $namedParameters['path'] );
                break;

            case 'redirect':
                $operatorValue = leztbFunctions::redirect( $namedParameters['url'], $namedParameters['type'] );
                break;
        }
    }

} // EOC

?>