<?php
/**
 * File containing the leztbDateTemplatesOperators class
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The leztbDateTemplatesOperators class template operator for date operations
 *
 * @package LeZToolbox
 * @version //autogentag//
 */
class leztbDateTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        $this->Operators = array(
            'related_datetime',
        );
    }



    /**
     * Return list of operators
     *
     * @return multitype:string
     */
    function &operatorList()
    {
        return $this->Operators;
    }



    /**
     * Return named parameters by operator
     *
     * @return boolean
     */
    function namedParameterPerOperator()
    {
        return true;
    }



    /**
     * Return named parameters list
     *
     * @return multitype:multitype:
     */
    function namedParameterList()
    {
         return array(
            'related_datetime'  => array(
                'class' => array( 'type' => 'string', 'required' => true, 'default' => ''  ),
                'data'  => array( 'type' => 'string', 'required' => false, 'default' => '' ) ),
        );
    }



    /**
     * Excecute template operator action
     *
     * @param eZTemplate_type $tpl
     * @param string $operatorName
     * @param array $operatorParameters
     * @param operatorList $rootNamespace
     * @param operatorList $currentNamespace
     * @param string $operatorValue
     * @param array $namedParameters
     */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
        &$currentNamespace, &$operatorValue, &$namedParameters
    ) {
        switch ( $operatorName )
        {
            case 'related_datetime':
                leztbFunctions::relatedDatetime( $operatorValue, $namedParameters['class'], $namedParameters['data'] );
                break;
        }
    }

}

?>