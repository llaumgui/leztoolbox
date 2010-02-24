<?php
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
class leztbInfo
{
    static function info()
    {
        return array(   'Name'            => "leZToolBox",
                        'Version'         => "1.1",
                        'Copyright'       => 'Copyright (c) 2008-' . date('Y') . ' Guillaume Kulakowski and contributors',
                        'info_url'        => "http://trac.llaumgui.com/wiki/eZ%20Publish/MyUtils",
                        'License'         => "GNU General Public License v2.0"
                 );
    }
}
?>