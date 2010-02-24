<?php
//
// Definition of myUtilsExtendedFilter class
//
// Created on: <07-oct-2008 12:14:34 bf>
//
// SOFTWARE NAME: MyUtils
// SOFTWARE RELEASE: 1.0.1
// BUILD VERSION:
// COPYRIGHT NOTICE: Copyright (c) 2008 Guillaume Kulakowski and contributors
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
//


/*! \file myutilsextendedfilter.php
*/

/*!
  \class myUtilsExtendedFilter myutilsextendedfilter.php
  \brief
*/
class myUtilsExtendedFilter
{

    /*!

     \param $params array
     \return array
     */
    function onlyVisibilityHidden( $params )
    {
        $result = array(
            'tables' => ', ezcontentobject_tree AS tree',
            'joins'  => ' tree.contentobject_id = ezcontentobject.id AND tree.is_hidden = 1 AND ',
            'columns' => '' );

        return $result;
    }



    /*!
     Build a query with REGEXP

     \param $params array
     \return array
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
                if ( is_array($p) && isset($p['contentclass']) && isset($p['regexp']) )
                {
                    $contentclass = $p['contentclass'];
                    $regexp = $p['regexp'];

                    if ( !is_numeric($contentclass) )
                    {
                        $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier($contentclass);
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