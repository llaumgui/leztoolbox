<?php
//
// Definition of leztbDateTemplatesOperators class
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


/*! \file leztbdatetemplatesoperators.php
*/

/*!
  \class leztbDateTemplatesOperators leztbdatetemplatesoperators.php
 */
class leztbDateTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        /* Opérateurs */
        $this->Operators = array(
            'gmdate',
            'r_datetime',
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
            'gmdate' => array(
                'format' => array( 'type' => 'string', 'required' => true, 'default' => ''  ),
                'timestamp' => array( 'type' => 'integer', 'required' => true, 'default' => time()  ) ),

            'r_datetime'  => array(
                'class' => array( 'type' => 'string', 'required' => true, 'default' => ''  ),
                'data'  => array( 'type' => 'string', 'required' => false, 'default' => '' ) ),
        );
    }



    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                      &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'gmdate':
                $operatorValue = gmdate( $namedParameters['format'], $namedParameters['timestamp'] );
                break;

            case 'r_datetime':
                leztbFunctions::relatedDatetime( $operatorValue, $namedParameters['class'], $namedParameters['data'] );
                break;
        }
    }

} // EOC

?>