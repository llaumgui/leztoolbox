<?php
//
// Definition of leztbStringTemplatesOperators class
//
// Created on: <22-Mar-2009 19:00:00 GKUL>
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


/*! \file leztbstringtemplatesoperators.php
*/

/*!
  \class leztbStringTemplatesOperators leztbstringtemplatesoperators.php
 */
class leztbStringTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        /* Opérateurs */
        $this->Operators = array(
            'json_decode',
            'str_ireplace',
            'str_replace'
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
            'json_decode' => array(
                'json' => array( 'type' => 'string', 'required' => true, 'default' => '' ),
                'assoc' => array( 'type' => 'bool', 'required' => false, 'default' => true ) ),

            'str_ireplace' => array(
                'search' => array( 'type' => 'string', 'required' => true, 'default' => '' ),
                'replace' => array( 'type' => 'string', 'required' => true, 'default' => '' ),
                'subject' => array( 'type' => 'string', 'required' => true, 'default' => '' ) ),

            'str_replace' => array(
                'search' => array( 'type' => 'string', 'required' => true, 'default' => '' ),
                'replace' => array( 'type' => 'string', 'required' => true, 'default' => '' ),
                'subject' => array( 'type' => 'string', 'required' => true, 'default' => '' ) ),
        );
    }



    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                      &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'json_decode':
                $operatorValue = json_decode( $namedParameters['json'], $namedParameters['assoc'] );
                break;

            case 'str_ireplace':
                $operatorValue = str_ireplace( $namedParameters['search'],
                                               $namedParameters['replace'],
                                               $namedParameters['subject'] );
                break;

            case 'str_replace':
                $operatorValue = str_replace( $namedParameters['search'],
                                              $namedParameters['replace'],
                                              $namedParameters['subject'] );
                break;
        }
    }

}

?>