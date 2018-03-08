// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
;(function ($, window, document, undefined) {
	'use strict';

	var Shortcodes  = vc.shortcodes;

	if (window.VcColumnView) {

		//
		// Amy module
		// -------------------------------------------------------------------------
		window.AmyModuleView  = window.VcColumnView.extend({
			events: {
				'click > .controls .column_add': 'addDirectlyElement',
				'click > .wpb_element_wrapper > .vc_empty-container': 'addDirectlyElement',
				'click > .controls .column_delete': 'deleteShortcode',
				'click > .controls .column_edit': 'editElement',
				'click > .controls .column_clone': 'clone',
			},

			addDirectlyElement: function(e) {
				e.preventDefault();

				var module  = Shortcodes.create({shortcode: 'amy_module_item', parent_id: this.model.id});

				return module;
			},

			setDropable: function () {

			},

			dropButton: function(event, ui) {

			},
		});
	}

	//
	// ATTS
	// -------------------------------------------------------------------------
	_.extend(vc.atts, {
		vc_amy_exploded_textarea: {
			parse: function (param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '~');
			}
		},
		vc_amy_style_textarea: {
			parse: function(param) {
				var $field  = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');

				return $field.val().replace(/\n/g, '');
			}
		},
		vc_amy_chosen: {
			parse: function(param) {
				var value = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']').val();

				return ( value ) ? value.join(',') : '';
			}
		},
	});

	// ======================================================
	// VISUAL COMPOSER IMAGE SELECT
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_IMAGE_SELECT = function() {
		return this.each(function() {

		var _el       = $(this),
			_elems    = _el.find('li');

			_elems.each( function (){
				var _this = $(this),
				  _data   = _this.data('value');

				_this.click(function() {
					if (_this.is('.selected')) {
						_this.removeClass('selected');
						_el.next().val('').trigger('keyup');
					} else {
						_this.addClass('selected').siblings().removeClass('selected');
						_el.next().val( _data ).trigger('keyup');
					}
				});
			});
		});
	};
	// ======================================================

	// ======================================================
	// VISUAL COMPOSER SWITCH
	// ------------------------------------------------------
	$.fn.JSCOMPOSER_SWITCH = function() {
		return this.each(function() {

			var _this   = $(this),
			_input  = _this.find('input');

			_this.click(function() {
				_this.toggleClass('switch-active');
				_input.val(( _input.val() == 1 ) ? '' : 1).trigger('keyup');
			});
		});
	};

	// ======================================================
	// RELOAD FRAMEWORK PLUGINS
	// ------------------------------------------------------
	$.AMYFRAMEWORK_VC_RELOAD_PLUGINS = function () {
		$('.chosen').AMYFRAMEWORK_CHOSEN();
		$('.amy-field-image-select').AMYFRAMEWORK_IMAGE_SELECTOR();
		$('.vc_image_select').JSCOMPOSER_IMAGE_SELECT();
		$('.vc_switch').JSCOMPOSER_SWITCH();
		$('.amy-field-image').AMYFRAMEWORK_IMAGE_UPLOADER();
		$('.amy-field-gallery').AMYFRAMEWORK_IMAGE_GALLERY();
		$('.amy-field-sorter').AMYFRAMEWORK_SORTER();
		$('.amy-field-upload').AMYFRAMEWORK_UPLOADER();
		$('.amy-field-typography').AMYFRAMEWORK_TYPOGRAPHY();
		$('.amy-field-color-picker').AMYFRAMEWORK_COLORPICKER();
		$('.amy-help').AMYFRAMEWORK_TOOLTIP();
	};

})(jQuery, window, document);