<?php
/**
 * File containing the leztbTemplatesOperators class
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The leztbTemplatesOperators class template operator
 *
 * @package LeZToolbox
 * @version //autogentag//
 */
class leztbTemplatesOperators
{

    private $Operators;


    /**
     * Constructor
     */
    function __construct()
    {
        $this->Operators = array(
            'get_siteaccess',
            'redirect'
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
            'get_siteaccess' => array( ),

            'redirect'  => array(
                'url' => array( 'type' => 'string', 'required' => true, 'default' => ''  ),
                'type' => array( 'type' => 'integer', 'required' => false, 'default' => '301' )  )
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
            case 'get_siteaccess':
                $operatorValue = $GLOBALS['eZCurrentAccess']['name'];
                break;

            case 'redirect':
                $operatorValue = leztbFunctions::redirect( $namedParameters['url'], $namedParameters['type'] );
                break;
        }
    }

}

?>