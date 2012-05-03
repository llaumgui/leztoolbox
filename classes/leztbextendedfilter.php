<?php
/**
 * File containing the leztbExtendedFilter class
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The leztbExtendedFilter provide extended attribut filter
 *
 * @package LeZToolbox
 * @version //autogentag//
 */
class leztbExtendedFilter
{

    /**
     * Build a query with REGEXP
     *
     * @param array $params
     * @return array
     */
    public function regexpSqlParts($params)
    {
        $db = eZDB::instance();

        $result = array( 'tables' => '', 'joins'  => '', 'columns' => '' );
        $arrayJoins = array();
        $arrayTables = array();
        $arrayCondition = array();
        $filterJoinType = 'AND';

        if ( is_array( $params ) )
        {
            if ( is_string( $params[0] ) )
            {
                if ( strtolower( $params[0] ) == 'or' )
                {
                    $filterJoinType = 'OR';
                }
                else if ( strtolower( $params[0] ) == 'and' )
                {
                    $filterJoinType = 'AND';
                }
                unset( $params[0] );
            }

            foreach ( $params as $p )
            {
                if ( is_array( $p ) && isset( $p['contentclass'] ) && isset( $p['regexp'] ) )
                {
                    $contentclass = $p['contentclass'];
                    $regexp = $p['regexp'];

                    if ( !is_numeric( $contentclass ) )
                    {
                        $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $contentclass );
                    }
                    else
                    {
                        $attributeID = $contentclass;
                    }

                    /* Requêtes SQL */
                    $arrayTables[] = "ezcontentobject_attribute reg";
                    $arrayJoins[] = "( reg.contentobject_id = ezcontentobject.id
                                       AND reg.contentclassattribute_id = $attributeID
                                       AND reg.version = ezcontentobject_name.content_version )";
                    $arrayCondition[] = '( reg.sort_key_string REGEXP "' . $db->escapeString( $regexp ) . '" )';
                }
            }
        }

        $result['tables'] = ", " . implode( ', ', $arrayTables );
        $result['joins'] = implode( ' AND ', $arrayJoins ) . " AND (" . implode( ' ' . $filterJoinType . ' ', $arrayCondition ) . ") AND ";

        return $result;
    }
}

?>