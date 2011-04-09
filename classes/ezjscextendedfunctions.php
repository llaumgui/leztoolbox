<?php
//
// Created on: <08-Apr-2011 19:00:00 GKUL>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: leZToolbox
// SOFTWARE RELEASE: 1.2
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

class ezjscExtendedFunctions extends ezjscServerFunctions
{

    public static function getCacheTime( $functionName )
    {
        if ( $functionName === 'jqueryui' )
        {
            return -1;
        }
        return parent::getCacheTime();
    }

    /**
     * Figures out where to load jQueryUI files from and prepends them to $packerFiles
     *
     * @param array $args
     * @param array $packerFiles ByRef list of files to pack (by ezjscPacker)
     */
    public static function jqueryui( $args, &$packerFiles )
    {
        $ezjscoreIni = eZINI::instance( 'ezjscore.ini' );
        if ( $ezjscoreIni->variable( 'eZJSCore', 'LoadFromCDN' ) === 'enabled' )
        {
            $scriptFiles = $ezjscoreIni->variable( 'eZJSCore', 'ExternalScripts' );
            $packerFiles = array_merge( array( $scriptFiles['jqueryui'] ), $packerFiles );
        }
        else
        {
            $scriptFiles = $ezjscoreIni->variable( 'eZJSCore', 'LocalScripts' );
            $packerFiles = array_merge( array( $scriptFiles['jqueryui'] ), $packerFiles );
        }
        return '';
    }


}

?>