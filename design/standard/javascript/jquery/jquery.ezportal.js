/**
 * eZPortal jQuery portal
 *
 * @require jQuery 1.6.x (tested on 1.5.2)
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

        version: '0.9.5',

        /* Default options */
        options: {
    		// Class and elements options
            zonesClass: '.portal .zone', /* CSS class for each columns */
            blockClass: '.block', /* CSS class for each block */
            blockHeader: 'h2', /* Block header element and draggable zone */

            // Class and elements for action buttons
            resetButtonID: '#portalReset',
            saveButtonID: '#portalSave',
            loadButtonID: '#portalLoad',

            // Portlet controls
            canMinimized: true, /* Block have minus option */
            canDeleted: true, /* Block have delete option */

            // Cookie options
            cookieName: 'ezPortal_v095', /* Cookie name */
            saveInCookie: true, /* Save in cookies for each sort action */

            // Save in database options
            saveModule: 'user/preferences/set_and_exit', /* Save information in this module */
            keyName: 'ezPortal', /* Keyname used by ezpreference module */

            // Misc options
            debug: false /* Enable internal debug */
        },

        /* System */
        sortableZones: [],
        sortableBlock: [],
        defaultOrder: {},
        cookie: {},


        /**
         * Init eZPortal
         *
         * @param JSON options Option passed to the ezPortal
         * @param JSON initialOrder Allow to set an initial order
         *
         * <code>
         * $.ezPortal.init(
         *     {},
         * 	   {}
         * );
         * </code>
         */
        init: function ( options, initialOrder ) {

        	// Pass option
        	$.extend(
    			$.ezPortal.options,
    			options
			);

        	$.ezPortal.debug('Init $.eZPortal v' + $.ezPortal.version );
        	$.ezPortal.debug( $.ezPortal.options );

            // Get and set sortable elements
            $.ezPortal.sortableZones = $($.ezPortal.options.zonesClass);
            $.ezPortal.saveButton = $($.ezPortal.options.saveButtonID);
            $.ezPortal.loadButton = $($.ezPortal.options.loadButtonID);
            $.ezPortal.resetButton = $($.ezPortal.options.resetButtonID);

        	// Get the default sortable order before any modification used by reset
            $.ezPortal.defaultOrder = $.ezPortal.getSortableOrder();

            // Add mandatory classes
            $.ezPortal.sortableBlock = $($.ezPortal.options.zonesClass + ' ' + $.ezPortal.options.blockClass)
            	.addClass( "ui-widget ui-widget-content ui-helper-clearfix portlet" )
                 .end();

            $.ezPortal.sortableBlockHeader = $.ezPortal.sortableBlock.find( "h2:first" )
            	.addClass( "ui-widget-header" )
        		.end();

        	if ( $.ezPortal.options.canDelete == true ) {
        		$.ezPortal.sortableBlockHeader.prepend( "<span class='ui-icon ui-icon-delthick'></span>")
        	}
        	if ( $.ezPortal.options.canMinimized ) {
        		$.ezPortal.sortableBlockHeader.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
        	}

            /*
             * Read cookie informations to set $.ezPortal.cookie.
             * If readed cookie is false, init $.ezPortal.cookie with
             * $.ezPortal.defaultOrder. If is true set sortable order with him.
             */
            if ( $.ezPortal.options.saveInCookie == true ) {
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
            }
            else {
                $.ezPortal.debug('No cookie store');

                if ( initialOrder != null && initialOrder != '' )
                	$.ezPortal.setSortableOrder(initialOrder);
            }

            // Enable jQueryUI sortable with all options
            $.ezPortal.sortableZones.sortable({
                connectWith: $.ezPortal.options.zonesClass,
                handle: $.ezPortal.options.blockHeader,
                update: function(event, ui) {
	            	$.ezPortal.saveButton.ezpEnableButton('storeDatabases');
	        		if ( $.ezPortal.options.saveInCookie == false ) {
	        			$.ezPortal.storeZoneInCookie( $(this) );
	            	}
                }
            });

            // Add event Minimize/Normalize on .ui-icon
            $( "h2 .ui-icon" ).click(function() {
                $(this).parents( ".portlet:first" ).ezpBlockToggle();
            });

            // Add event delete on .ui-icon
            $( "h2 .delthick" ).click(function() {
            	$(this).parent().parent().hide();
            	$.ezPortal.saveButton.ezpEnableButton('storeDatabases');
        		for ( var param in $.ez.defaultPortalOrder.first_colonne ){

        			if($(this).parent().parent().attr("id")==param)
        			{
        				$("input[name="+param+"]").attr("checked", "");
        			}
        		}
        		for ( var param in $.ez.defaultPortalOrder.second_colonne ){

        			if($(this).parent().parent().attr("id")==param)
        			{
        				$("input[name="+param+"]").attr("checked", "");
        			}
        		}
        		for ( var param in $.ez.defaultPortalOrder.last_colonne ){

        			if($(this).parent().parent().attr("id")==param)
        			{
        				$("input[name="+param+"]").attr("checked", "");
        			}
        		}
            });

            // Disable and enable buttons
            $.ezPortal.saveButton.addClass('disabled');
            $.ezPortal.resetButton.ezpEnableButton('resetOrder');
            $.ezPortal.loadButton.ezpEnableButton('loadOrder');

            // Disable selection
            $.ezPortal.sortableZones.disableSelection();
        },


        /**
         * Debug ezPortal.
         *
         * @param string msg
         *
         * <code>
         * $.ezPortal.debug('My message');
         * </code>
         */
        debug: function(msg) {
            if ( $.ezPortal.options.debug ) {
            	if (typeof console == "undefined" || typeof console.log == "undefined") {
        			alert(msg);
            	}
            	else {
            		console.log(msg);
            	}
            }
        },


        /**
         * Get sortable order
         */
        getSortableOrder: function() {
        	order = {};
            $.ezPortal.sortableZones.each(function() {
                zoneID = $(this).attr('id');
                order[zoneID] = {};
                $(this).find($.ezPortal.options.blockClass).each(function() {
                	order[zoneID][$(this).attr('id')] = {
                        state: $(this).ezpBlockGetState()
                    };
                });
            });
        	$.ezPortal.debug('Order:'); $.ezPortal.debug(order);
        	return order;
        },


        /**
         * Set sortable order informations from jsonData.
         *
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
                    if( block.state == 'minimized' ) {
                        $('#'+blockID).ezpBlockMinimize();
                    }
                    else if( block.state == 'delete' ) {
                        $('#'+blockID).ezpBlockDelete();
                    }
                    else {
                        $('#'+blockID).ezpBlockNormalize();
                    }
                });
            });
        },


        /**
         * Store order in cookie.
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
        },


        /**
         * Call the used module to store order in Database.
         * With eZ Publish, you can use ezpreference and initialOrder.
         *
         * @TODO
         */
        readDataBases: function() {
        },


        /**
         * Call the used module to store order in Database.
         */
        storeDatabases: function() {
            var url = jQuery.ez.url.replace( 'ezjscore/', $.ezPortal.options.saveModule + '/' )
            	+ $.ezPortal.options.keyName + '/' + JSON.stringify( $.ezPortal.getSortableOrder() );

            $.ezPortal.debug( 'Update database: ' + url );
            jQuery.post( url, {}, function(){} );
            $.ezPortal.saveButton.ezpDisableButton();
        },


        /**
         * Reset the order.
         */
        resetOrder: function() {
        	$.ezPortal.setSortableOrder( $.ezPortal.defaultOrder );
        }

    }; // EO $.ezPortal



    /**
     * jQuery plugin: Get block state.
     *
     * <code>
     * $(myBlockElement).ezpBlockGetState();
     * </code>
     */
    $.fn.ezpBlockGetState = function() {
        if( !this.is(':visible') ) {
            return 'delete';
        }
        else if( !this.find( ".content" ).is(':visible') ) {
            return 'minimized';
        }
        else {
            return 'normal';
        }
    };


    /**
     * jQuery plugin: Toggle minimize a block.
     *
     * <code>
     * $(myBlockElement).ezpBlockToggle();
     * </code>
     */
    $.fn.ezpBlockToggle = function() {
        this.find( "h2:first .ui-icon" )
        	.toggleClass( "ui-icon-minusthick" )
        	.toggleClass( "ui-icon-plusthick" )
        	.find( ".content:first" )
        		.toggle()
    		.end();

    	if ( $.ezPortal.options.saveInCookie == false ) {
			$.ezPortal.storeZoneInCookie( this.parents($.ezPortal.options.zonesClass) );
    	}
    };


    /**
     * jQuery plugin: Minimize a block.
     *
     * <code>
     * $(myBlockElement).ezpBlockMinimize();
     * </code>
     */
    $.fn.ezpBlockMinimize = function() {
    	this.find( "h2:first .ui-icon" )
    		.removeClass( "ui-icon-minusthick" )
    		.addClass( "ui-icon-plusthick" )
    		.find( ".content:first" )
    			.hide()
    		.end();
    };


    /**
     * jQuery plugin: Delete a block.
     *
     * <code>
     * $(myBlockElement).ezpBlockDelete();
     * </code>
     */
    $.fn.ezpBlockDelete = function() {
    	this.hide();
    };


    /**
     * jQuery plugin: Maximize a block.
     *
     * <code>
     * $(myBlockElement).ezpBlockNormalize();
     * </code>
     */
    $.fn.ezpBlockNormalize = function() {
    	this.show()
    		.find( "h2:first .ui-icon" )
    			.removeClass( "ui-icon-plusthick" )
    			.addClass( "ui-icon-minusthick" )
			.end();
        this.find( ".content:first" ).show();
    };


    /**
     * jQuery plugin: Enable button and add on click event.
     *
     * @param String action to do on click
     *
     * <code>
     * $(myElement).ezpEnableButton();
     * </code>
     */
    $.fn.ezpEnableButton = function( action ) {
        this.removeClass('disabled')
        	.each(function() {
		    	$(this).unbind('click').click(function() {
		    		eval( '$.ezPortal.' + action + '()' );
		    	});
        	})
        	.end();
    };


    /**
     * jQuery plugin: Disable button and remove on clikc event
     *
     * <code>
     * $(myElement).ezpDisableButton();
     * </code>
     */
    $.fn.ezpDisableButton = function() {
        this.addClass('disabled')
    	.each(function() {
	    	$(this).unbind('click');
    	});
    };

})(jQuery);