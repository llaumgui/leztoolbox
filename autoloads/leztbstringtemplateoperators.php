<?php
/**
 * File containing the leztbStringTemplatesOperators class
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The leztbStringTemplatesOperators class template operator for string operations
 *
 * @package LeZToolbox
 * @version //autogentag//
 */
class leztbStringTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        $this->Operators = array(
            'json_decode',
            'str_ireplace',
            'str_replace'
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
            case 'json_decode':
                $operatorValue = json_decode( $namedParameters['json'],
                                              $namedParameters['assoc'] );
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