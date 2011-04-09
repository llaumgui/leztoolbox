/**
 * eZPortal jQuery portal
 *
 * @require jQuery 1.5.x (tested on 1.5.2)
 * @require jQueryUI 1.8.x (tested on 1.8.11)
 * @require jQuery Cookie 2.2.x <http://code.google.com/p/cookies/> (tested on 2.2.0)
 *
 * ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
 * SOFTWARE NAME: eZPortal
 * SOFTWARE RELEASE: 1.0
 * COPYRIGHT NOTICE: Copyright (C) 2011 Guillaume Kulakowski
 * SOFTWARE LICENSE: GNU General Public License v2.0
 * NOTICE: >
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of version 2.0 of the GNU General
 * Public License as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of version 2.0 of the GNU General
 * Public License along with this program; if not, write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
 */

;( function($)
{

    /**
     * $eZPortal main function
     */
    $.ezPortal = {

        version: '0.9.1',

        /* Default options */
        options: {
            zonesClass: '.portal .zone',
            blockClass: '.block',
            blockHeader: 'h2',
            cookieName: 'ezPortal_v09',
            debug: false,
            resetButtonID: '#portalReset',
            saveButtonID: '#portalSave',
            loadButtonID: '#portalLoad',
        },

        /* System */
        sortableZones: [],
        sortableBlock: [],
        defaultOrder: {},
        cookie: {},


        /**
         * Init eZPortal
         * @TODO extends options
         * <code>
         * $.ezPortal.init({
         * });
         * </code>
         */
        init: function () {

            $.ezPortal.debug('Init $.eZPortal v' + $.ezPortal.version );

            // Get and set sortable elements
            $.ezPortal.sortableZones = $($.ezPortal.options.zonesClass);
            $.ezPortal.resetButton = $($.ezPortal.options.resetButtonID);
            /*$.ezPortal.saveButton = $($.ezPortal.options.saveButtonID);
            $.ezPortal.loadButton = $($.ezPortal.options.loadButtonID);
            $.ezPortal.defaultOrder = $.ezPortal.getDefaultOrder();*/

            // Add mandatory classes
            $.ezPortal.sortableBlock = $($.ezPortal.options.zonesClass + ' ' + $.ezPortal.options.blockClass)
            	.addClass( "ui-widget ui-widget-content ui-helper-clearfix portlet" )
            	.find( "h2:first" )
                	.addClass( "ui-widget-header" )
                	.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
                	.end();

            /*
             * Read cookie informations to set $.ezPortal.cookie.
             * If readed cookie is false, init $.ezPortal.cookie with
             * $.ezPortal.defaultOrder. If is true set sortable order with him.
             */
            $.ezPortal.cookie = $.cookies.get( $.ezPortal.options.cookieName );
            if ( $.ezPortal.cookie  ) {
                $.ezPortal.debug('Cookie');
                // Set from cookie
                $.ezPortal.setSortableOrder($.ezPortal.cookie);
            }
            else {
                $.ezPortal.debug('No cookie');
                $.ezPortal.cookie = $.ezPortal.defaultOrder;
            }

            // Enable jQueryUI sortable with all options
            $.ezPortal.sortableZones.sortable({
                connectWith: $.ezPortal.options.zonesClass,
                handle: $.ezPortal.options.blockHeader,
                update: function(event, ui) {
                    $.ezPortal.storeZoneInCookie( $(this) );
                }
            });

            // Add event Minimize/Normalize on .ui-icon
            $( "h2 .ui-icon" ).click(function() {
                $(this).parents( ".portlet:first" ).ezpBlockToggle();
            });
            
            // Disable buttons
            /*$.ezPortal.saveButton.addClass('disabled');
            $.ezPortal.loadButton.addClass('disabled');*/

            // Disable selection
            $.ezPortal.sortableZones.disableSelection();
        },


        /**
         * Debug ezPortal
         * @param string msg
         * <code>
         * $.ezPortal.debug('My message');
         * </code>
         */
        debug: function(msg) {
            if ( $.ezPortal.options.debug ) {
                console.log(msg)
            }
        },


        /**
         * Get default sortable order
         */
        getDefaultOrder: function() {
            $.ezPortal.sortableZones.each(function() {
                zoneID = $(this).attr('id');
                $.ezPortal.defaultOrder[zoneID] = {};
                $(this).find($.ezPortal.options.blockClass).each(function() {
                    $.ezPortal.defaultOrder[zoneID][$(this).attr('id')] = {
                        state: $(this).ezpBlockGetState()
                    };
                });
            });
            return $.ezPortal.defaultOrder;
            $.ezPortal.debug('Default order:'); $.ezPortal.debug($.ezPortal.defaultOrder);
        },


        /**
         * Set sortable order informations
         * @param JSON jsonData
         */
        setSortableOrder: function( jsonData ) {
            // Get zones
            $.each(jsonData, function(zoneID, blocks) {
                zone = $('#'+zoneID);
                // Place block
                $.each( blocks, function(blockID, block) {
                    // Set block placement
                    $('#'+blockID).appendTo(zone);
                    // Set block statement
                    if( block.state == 'normal' ) {
                        $('#'+blockID).ezpBlockNormalize();
                    }
                    else if( block.state == 'minimized' ) {
                        $('#'+blockID).ezpBlockMinimize();
                    }
                });
            });
        },


        /**
         * Store order in cookie
         */
        storeZoneInCookie: function( zone ) {

            zoneID = zone.attr('id');
            $.ezPortal.cookie[zoneID] = {};

            // Get identifier of each element in column
            zone.find( $.ezPortal.options.blockClass ).each(function() {
            	$.ezPortal.cookie[zoneID][$(this).attr('id')] =  {
                    state: $(this).ezpBlockGetState()
                };
            });

            $.ezPortal.debug( 'Update cookie' );
            $.ezPortal.debug( $.ezPortal.cookie );

            // Save information in cookie
            $.cookies.set( $.ezPortal.options.cookieName, $.ezPortal.cookie );  

            // Mark as you can save it
            //$.ezPortal.saveButton.ezpEnableButton();
        },


        /**
         * Read information from database
         */
        readDataBases: function() {

        },


        /**
         * Store order in Database
         */
        storeDatabases: function() {

        },
    }; // EO $.ezPortal



    /**
     * jQuery plugin: Toggle minimize a block
     * <code>
     * $(myBlockElement).ezpBlockGetState();
     * </code>
     */
    $.fn.ezpBlockGetState = function() {
        if( this.find( ".content" ).is(':visible') ) {
            return 'normal';
        }
        else {
            return 'minimized';
        }
    };


    /**
     * jQuery plugin: Toggle minimize a block
     * <code>
     * $(myBlockElement).ezpBlockToggle();
     * </code>
     */
    $.fn.ezpBlockToggle = function() {
        this.find( "h2:first .ui-icon" ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
        this.find( ".content:first" ).toggle();            
        $.ezPortal.storeZoneInCookie( this.parents($.ezPortal.options.zonesClass) );
    };


    /**
     * jQuery plugin: Minimize a block
     * <code>
     * $(myBlockElement).ezpBlockMinimize();
     * </code>
     */
    $.fn.ezpBlockMinimize = function() {
    	this.find( "h2:first .ui-icon" ).removeClass( "ui-icon-minusthick" ).addClass( "ui-icon-plusthick" );
    	this.find( ".content:first" ).hide();
    };


    /**
     * jQuery plugin: Maximize a block
     * <code>
     * $(myBlockElement).ezpBlockNormalize();
     * </code>
     */
    $.fn.ezpBlockNormalize = function() {
    	this.find( "h2:first .ui-icon" ).removeClass( "ui-icon-plusthick" ).addClass( "ui-icon-minusthick" );
        this.find( ".content:first" ).show();
    };


    /**
     * jQuery plugin: Enable save/load button
     * <code>
     * $(myElement).ezpEnableButton();
     * </code>
     */
    $.fn.ezpEnableButton = function() {
        this.removeClass('disabled');
        // Add click event
    };


    /**
     * jQuery plugin: Disable save/load button
     * <code>
     * $(myElement).ezpEnableButton();
     * </code>
     */
    $.fn.ezpDisableButton = function() {
        this.addClass('disabled');
        // Remove click event
    };

})(jQuery);