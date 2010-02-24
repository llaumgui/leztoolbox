<?php
//
// Definition of myUtilsFunctions class
//
// Created on: <01-Sep-2008 19:00:00 bf>
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


/*! \file myutilsfunctions.php
*/

/*!
  \class myUtilsFunctions myutilsfunctions.php
  \brief Ensemble de fonctions utilisée pour l'extension myUtils
 */
class myUtilsFunctions
{

    /*!
     Converti un "path" en "path_array".
     Permet de retrouver un équivalent de $node.path_array là où il n'y a que
     les informations path, par exemple dans le pagelayout ($module_result.path).

     \param $path array
     \return array
     */
    static function path2PathArray( $path )
    {
        $path_array = array();
        if ( !is_array( $path ) )
        {
            return array();
        }

        foreach ( $path as $p )
        {
            $path_array[]=$p['node_id'];
        }
        return $path_array;
    }



    /*!
     Fonction header() de php mise en forme pour faire des redirections.

     \param $url string URL de redirection
     \param $type integer Type de redirection
     */
    static function redirect( $url, $type=0 )
    {
        switch( $type )
        {
            case 301:
                header("HTTP/1.1 301 Moved Permanently");
                break;
            case 307:
                header("HTTP/1.1 307 Temporary Redirect");
                break;
        }
        header ('location: '.$url);
        eZExecution::cleanExit();
    }



    /*!
     Fonction datetime relative (Aujourd'hui, hier, etc..)

     \param $operatorValue integer
     \param $class string
     \param $data string
     */
    static function relatedDatetime( &$operatorValue, $class, $data )
    {
        $locale = eZLocale::instance();
        $dateFormat = '%d-%m-%Y';
        $date = $locale->formatDateTimeType( $dateFormat, $operatorValue);
        $today = $locale->formatDateTimeType( $dateFormat);
        $yesterday = $locale->formatDateTimeType( $dateFormat, time()-86400);

        if ( $class === null )
        {
            return;
        }

        if ( $class == 'custom' )
        {
            $classFormat = $data;
        }
        else
        {
            $dtINI = eZINI::instance( 'datetime.ini' );
            $formats = $dtINI->variable( 'ClassSettings', 'Formats' );
            if ( array_key_exists( $class, $formats ) )
            {
                $classFormat = $formats[$class];
            }
            else
            {
                $tpl->error( $operatorName, "DateTime class '$class' is not defined", $placement );
                return;
            }
        }

        if ( $date == $today )
        {
            $classFormat = preg_replace( '#\$\$(.+?)\$\$#',  ezi18n( 'myutils/date', 'Today' ), $classFormat );
        }
        else if ( $date == $yesterday )
        {
            $classFormat = preg_replace( '#\$\$(.+?)\$\$#',  ezi18n( 'myutils/date', 'Yesterday' ), $classFormat );
        }

        $operatorValue = $locale->formatDateTimeType(  str_replace('$$', '', $classFormat ), $operatorValue  );
    }

} // EOC

?>