<?php
/**
 * File containing the leztbFunctions class
 *
 * @version //autogentag//
 * @package LeZToolbox
 * @copyright Copyright (C) 2008-2012 Guillaume Kulakowski and contributors
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

/**
 * The leztbFunctions provide functions used by LeZToolbox
 *
 * @package LeZToolbox
 * @version //autogentag//
 */
class leztbFunctions
{

    /**
     * Redirect with php header
     *
     * @param string $url Url to redirect
     * @param integer $type Type of redirection
     */
    static function redirect( $url, $type=0 )
    {
        switch( $type )
        {
            case 301:
                header( 'HTTP/1.1 301 Moved Permanently' );
                break;
            case 307:
                header( 'HTTP/1.1 307 Temporary Redirect' );
                break;
        }
        header( 'location: ' . $url );
        eZExecution::cleanExit();
    }



    /**
     * Relative (yesterday, today) datetime
     *
     * @param integer $operatorValue
     * @param string $class
     * @param string $data
     */
    static function relatedDatetime( &$operatorValue, $class, $data )
    {
        $locale = eZLocale::instance();
        $dateFormat = '%d-%m-%Y';
        $date = $locale->formatDateTimeType( $dateFormat, $operatorValue );
        $today = $locale->formatDateTimeType( $dateFormat );
        $yesterday = $locale->formatDateTimeType( $dateFormat, time()-86400 );

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
            $classFormat = preg_replace( '#\$\$(.+?)\$\$#',  ezpI18n::tr( 'myutils/date', 'Today' ), $classFormat );
        }
        else if ( $date == $yesterday )
        {
            $classFormat = preg_replace( '#\$\$(.+?)\$\$#',  ezpI18n::tr( 'myutils/date', 'Yesterday' ), $classFormat );
        }

        $operatorValue = $locale->formatDateTimeType(  str_replace( '$$', '', $classFormat ), $operatorValue );
    }

}

?>