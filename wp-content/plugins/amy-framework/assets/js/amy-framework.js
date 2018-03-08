/**
 *
 * -----------------------------------------------------------
 *
 * AmyTheme Framework
 * A Lightweight and easy-to-use WordPress Options Framework
 *
 * Copyright 2016 AmyTheme <info@amythemelive.com>
 *
 * -----------------------------------------------------------
 *
 */
;(function ($, window, document, undefined) {
	'use strict';

	$.AMYFRAMEWORK	= $.AMYFRAMEWORK || {};

	// caching selector
	var $amy_body	= $('body');

	// caching variables
	var amy_is_rtl	= $amy_body.hasClass('rtl');

	// ======================================================
	// AMYFRAMEWORK MEGA MENU
	// ------------------------------------------------------
	$.AMYFRAMEWORK.MEGAMENU	= function(el) {
		var base	= this;

		// Access to jQuery and DOM versions of element
		base.$el	= $(el);
		base.el		= el;

		// Add a reverse reference to the DOM object
		base.$el.data("AMYFRAMEWORK.MEGAMENU", base);

		base.init = function () {
			var _timeout	= 0,
				_menu		= base.$el;

			_menu.on('click', '.is-mega', function () {
				base.flush($(this));
				base.depends(_menu);
			});

			_menu.on('mouseup', '.menu-item-bar', function () {
				clearTimeout(_timeout);

				_timeout	= setTimeout(function () {
					base.depends();
				}, 50);
			});

			_menu.on('change', '.is-width', function () {
				var _this		= $(this),
					_container	= _this.closest('.amy-mega-menu');

				if (_this.val() == 'custom' || _this.val() == 'natural') {
					_container.find('.mega-depend-position').removeClass('hidden');
				} else {
					_container.find('.mega-depend-position').addClass('hidden');
				}

				if (_this.val() == 'custom') {
					_container.find('.mega-depend-width').removeClass('hidden');
				} else {
					_container.find('.mega-depend-width').addClass('hidden');
				}
			});

			$('.is-width').trigger('change');

			base.depends();
		};

		base.depends = function () {
			var _menu	= base.$el;

			_menu.find('.is-mega').each(function () {
				base.flush($(this));
			});

			// clear all mega columns
			$('li', _menu).removeClass('active-mega-column').removeClass('active-sub-mega-column');

			// add columns for mega menu
			var nextDepth	= $('.active-mega-menu', _menu).nextUntil('.menu-item-depth-0', 'li');

			nextDepth.closest('li.menu-item-depth-1').addClass('active-mega-column');
			nextDepth.closest('li:not(.menu-item-depth-1)').addClass('active-sub-mega-column');
		};

		base.flush = function (_el) {
			if (_el.is(':checked')) {
				_el.closest('li').addClass('active-mega-menu');
				_el.closest('li').find('.field-mega-width').removeClass('hidden');
			} else {
				_el.closest('li').find('.field-mega-width').addClass('hidden');
				_el.closest('li').removeClass('active-mega-menu');
			}
		};

		// Run initializer
		base.init();
	};

	$.fn.AMYFRAMEWORK_MEGAMENU = function () {
		return this.each(function () {
			new $.AMYFRAMEWORK.MEGAMENU(this);
		});
	};

	// ======================================================
	// AMYFRAMEWORK TAB NAVIGATION
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_TAB_NAVIGATION	= function () {
		return this.each(function () {
			var $this	= $(this),
				$nav	= $this.find('.amy-nav'),
				$reset	= $this.find('.amy-reset'),
				$expand	= $this.find('.amy-expand-all');

			$nav.find('ul:first a').on('click', function (e) {
				e.preventDefault();

				var $el		= $(this),
					$next	= $el.next(),
					$target	= $el.data('section');

				if ($next.is('ul')) {
					$next.slideToggle('fast');
					$el.closest('li').toggleClass('amy-tab-active');
				} else {
					$('#amy-tab-' + $target).show().siblings().hide();
					$nav.find('a').removeClass('amy-section-active');
					$el.addClass('amy-section-active');
					$reset.val($target);
				}
			});

			$expand.on('click', function (e) {
				e.preventDefault();
				$this.find('.amy-body').toggleClass('amy-show-all');
				$(this).find('.fa').toggleClass('fa-eye-slash').toggleClass('fa-eye');
			});

		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK STICKY HEADER
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_STICKY_HEADER = function() {
		if (this.length) {
			var $header			= $(this),
				header_offset	= $header.offset().top;

			$(window).on('scroll.amy-sticky-header', function() {
				if ($(this).scrollTop() > header_offset - 32) {
					var header_width	= $header.outerWidth(),
						header_height	= $header.outerHeight();

					$header.addClass('amy-sticky-header');
					$header.css({
						width:	header_width + 'px',
						height:	header_height + 'px'
					});

					$('.amy-option-framework').css('padding-top', header_height);
				} else {
					$header.removeClass('amy-sticky-header');
					$header.css({
						width:	'',
						height:	''
					});

					$('.amy-option-framework').css('padding-top', '');
				}
			});

			$(window).on('resize.amy-sticky-header', function() {
				if ($(this).scrollTop() > header_offset - 32) {
					var header_width	= $header.siblings('.amy-body').outerWidth();

					$header.css('width', header_width);
				}
			});
		}
	};


	// ======================================================
	// AMYFRAMEWORK DEPENDENCY
	// ------------------------------------------------------
	$.AMYFRAMEWORK.DEPENDENCY	= function (el, param) {

		// Access to jQuery and DOM versions of element
		var base	= this;
		base.$el	= $(el);
		base.el		= el;

		base.init	= function () {

			base.ruleset	= $.deps.createRuleset();

			// required for shortcode attrs
			var cfg	= {
				show: function (el) {
					el.removeClass('hidden');
				},
				hide: function (el) {
					el.addClass('hidden');
				},
				log: false,
				checkTargets: false
			};

			if (param !== undefined) {
				base.depSub();
			} else {
				base.depRoot();
			}

			$.deps.enable(base.$el, base.ruleset, cfg);
		};

		base.depRoot = function () {
			base.$el.each(function () {
				$(this).find('[data-controller]').each(function () {
					var $this		= $(this),
						_controller	= $this.data('controller').split('|'),
						_condition	= $this.data('condition').split('|'),
						_value		= $this.data('value').toString().split('|'),
						_rules		= base.ruleset;

					$.each(_controller, function (index, element) {
						var value		= _value[index] || '',
							condition	= _condition[index] || _condition[0];

						_rules			= _rules.createRule('[data-depend-id="' + element + '"]', condition, value);
						_rules.include($this);
					});
				});
			});
		};

		base.depSub	= function () {
			base.$el.each(function () {
				$(this).find('[data-sub-controller]').each(function () {
					var $this	= $(this),
						_controller	= $this.data('sub-controller').split('|'),
						_condition	= $this.data('sub-condition').split('|'),
						_value		= $this.data('sub-value').toString().split('|'),
						_rules		= base.ruleset;

					$.each(_controller, function (index, element) {
						var value		= _value[index] || '',
							condition	= _condition[index] || _condition[0];

						_rules			= _rules.createRule('[data-sub-depend-id="' + element + '"]', condition, value);
						_rules.include($this);
					});
				});
			});
		};

		base.init();
	};

	$.fn.AMYFRAMEWORK_DEPENDENCY = function (param) {
		return this.each(function () {
			new $.AMYFRAMEWORK.DEPENDENCY(this, param);
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK CHOSEN
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_CHOSEN = function () {
		return this.each(function() {
			var $this	= $(this);

			if (!$this.closest('#widget-list').length) {
				$this.chosen({
					allow_single_deselect:		true,
					disable_search_threshold:	15,
					width:						parseFloat($(this).actual('width') + 25) + 'px'
				});
			}
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK IMAGE SELECTOR
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_IMAGE_SELECTOR = function () {
		return this.each(function () {
			$(this).find('label').on('click', function () {
				$(this).siblings().find('input').prop('checked', false);
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK SORTER
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_SORTER = function () {
		return this.each(function () {
			var $this		= $(this),
				$enabled	= $this.find('.amy-enabled'),
				$disabled	= $this.find('.amy-disabled');

			$enabled.sortable({
				connectWith:	$disabled,
				placeholder:	'ui-sortable-placeholder',
				update:			function (event, ui) {
					var $el 		= ui.item.find('input');

					if (ui.item.parent().hasClass('amy-enabled')) {
						$el.attr('name', $el.attr('name').replace('disabled', 'enabled'));
					} else {
						$el.attr('name', $el.attr('name').replace('enabled', 'disabled'));
					}
				}
			});

			// avoid conflict
			$disabled.sortable({
				connectWith:	$enabled,
				placeholder:	'ui-sortable-placeholder'
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK MEDIA UPLOADER / UPLOAD
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_UPLOADER = function () {
		return this.each(function () {
			var $this	= $(this),
				$add	= $this.find('.amy-add'),
				$input	= $this.find('input'),
				wp_media_frame;

			$add.on('click', function (e) {
				e.preventDefault();

				// Check if the `wp.media.gallery` API exists.
				if (typeof wp === 'undefined' || !wp.media || !wp.media.gallery) {
					return;
				}

				// If the media frame already exists, reopen it.
				if (wp_media_frame) {
					wp_media_frame.open();
					return;
				}

				// Create the media frame.
				wp_media_frame	= wp.media({
					// Set the title of the modal.
					title: $add.data('frame-title'),

					// Tell the modal to show only images.
					library: {
						type: $add.data('upload-type')
					},

					// Customize the submit button.
					button: {
						// Set the text of the button.
						text: $add.data('insert-title'),
					}
				});

				// When an image is selected, run a callback.
				wp_media_frame.on('select', function () {
					// Grab the selected attachment.
					var attachment = wp_media_frame.state().get('selection').first();
					$input.val(attachment.attributes.url).trigger('change');
				});

				// Finally, open the modal.
				wp_media_frame.open();
			});

		});

	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK IMAGE UPLOADER
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_IMAGE_UPLOADER = function () {
		return this.each(function () {
			var $this		= $(this),
				$add		= $this.find('.amy-add'),
				$preview	= $this.find('.amy-image-preview'),
				$remove		= $this.find('.amy-remove'),
				$input		= $this.find('input'),
				$img		= $this.find('img'),
				wp_media_frame;

			$add.on('click', function (e) {
				e.preventDefault();

				// Check if the `wp.media.gallery` API exists.
				if (typeof wp === 'undefined' || !wp.media || !wp.media.gallery) {
					return;
				}

				// If the media frame already exists, reopen it.
				if (wp_media_frame) {
					wp_media_frame.open();
					return;
				}

				// Create the media frame.
				wp_media_frame = wp.media({
					library: {
						type: 'image'
					}
				});

				// When an image is selected, run a callback.
				wp_media_frame.on('select', function () {
					var attachment	= wp_media_frame.state().get('selection').first().attributes;
					var thumbnail	= (typeof attachment.sizes.thumbnail !== 'undefined') ? attachment.sizes.thumbnail.url : attachment.url;

					$preview.removeClass('hidden');
					$img.attr('src', thumbnail);
					$input.val(attachment.id).trigger('change');
				});

				// Finally, open the modal.
				wp_media_frame.open();
			});

			// Remove image
			$remove.on('click', function (e) {
				e.preventDefault();
				$input.val('').trigger('change');
				$preview.addClass('hidden');
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK IMAGE GALLERY
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_IMAGE_GALLERY = function () {
		return this.each(function () {
			var $this	= $(this),
				$edit	= $this.find('.amy-edit'),
				$remove	= $this.find('.amy-remove'),
				$list	= $this.find('ul'),
				$input	= $this.find('input'),
				$img	= $this.find('img'),
				wp_media_frame,
				wp_media_click;

			$this.on('click', '.amy-add, .amy-edit', function (e) {
				var $el		= $(this),
					what	= ($el.hasClass('amy-edit')) ? 'edit' : 'add',
					state	= (what === 'edit') ? 'gallery-edit' : 'gallery-library';

				e.preventDefault();

				// Check if the `wp.media.gallery` API exists.
				if (typeof wp === 'undefined' || !wp.media || !wp.media.gallery) {
					return;
				}

				// If the media frame already exists, reopen it.
				if (wp_media_frame) {
					wp_media_frame.open();
					wp_media_frame.setState(state);
					return;
				}

				// Create the media frame.
				wp_media_frame = wp.media({
					library: {
						type: 'image'
					},
					frame: 'post',
					state: 'gallery',
					multiple: true
				});

				// Open the media frame.
				wp_media_frame.on('open', function () {
					var ids	= $input.val();

					if (ids) {
						var get_array	= ids.split(',');
						var library		= wp_media_frame.state('gallery-edit').get('library');

						wp_media_frame.setState(state);

						get_array.forEach(function (id) {
							var attachment	= wp.media.attachment(id);
							library.add(attachment ? [attachment] : []);
						});
					}
				});

				// When an image is selected, run a callback.
				wp_media_frame.on('update', function () {
					var inner	= '';
					var ids		= [];
					var images	= wp_media_frame.state().get('library');

					images.each(function (attachment) {
						var attributes	= attachment.attributes;
						var thumbnail	= (typeof attributes.sizes.thumbnail !== 'undefined') ? attributes.sizes.thumbnail.url : attributes.url;

						inner += '<li><img src="' + thumbnail + '"></li>';
						ids.push(attributes.id);
					});

					$input.val(ids).trigger('change');
					$list.html('').append(inner);
					$remove.removeClass('hidden');
					$edit.removeClass('hidden');

				});

				// Finally, open the modal.
				wp_media_frame.open();
				wp_media_click = what;
			});

			// Remove image
			$remove.on('click', function (e) {
				e.preventDefault();
				$list.html('');
				$input.val('').trigger('change');
				$remove.addClass('hidden');
				$edit.addClass('hidden');
			});
		});

	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK TYPOGRAPHY
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_TYPOGRAPHY = function () {
		return this.each(function () {
			var typography		= $(this),
				family_select	= typography.find('.amy-typo-family'),
				variants_select	= typography.find('.amy-typo-variant'),
				typography_type	= typography.find('.amy-typo-font');

			family_select.on('change', function () {
				var _this		= $(this),
					_type		= _this.find(':selected').data('type') || 'custom',
					_variants	= _this.find(':selected').data('variants');

				if (variants_select.length) {
					variants_select.find('option').remove();

					$.each(_variants.split('|'), function (key, text) {
						variants_select.append('<option value="' + text + '">' + text + '</option>');
					});

					variants_select.find('option[value="regular"]').attr('selected', 'selected').trigger('chosen:updated');
				}

				typography_type.val(_type);
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK GROUP
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_GROUP = function () {
		return this.each(function () {
			var _this			= $(this),
				field_groups	= _this.find('.amy-groups'),
				accordion_group	= _this.find('.amy-accordion'),
				clone_group		= _this.find('.amy-group:first').clone();

			if (accordion_group.length) {
				accordion_group.accordion({
					header:			'.amy-group-title',
					collapsible:	true,
					active:			false,
					animate:		250,
					heightStyle:	'content',
					icons:			{
						'header': 'dashicons dashicons-arrow-right',
						'activeHeader': 'dashicons dashicons-arrow-down'
					},
					beforeActivate:	function (event, ui) {
						$(ui.newPanel).AMYFRAMEWORK_DEPENDENCY('sub');
					}
				});
			}

			field_groups.sortable({
				axis:			'y',
				handle:			'.amy-group-title',
				helper:			'original',
				cursor: 		'move',
				placeholder:	'widget-placeholder',
				start:	function (event, ui) {
					var inside	= ui.item.children('.amy-group-content');
					if (inside.css('display') === 'block') {
						inside.hide();
						field_groups.sortable('refreshPositions');
					}
				},
				stop: function (event, ui) {
					ui.item.children('.amy-group-title').triggerHandler('focusout');
					accordion_group.accordion({active: false});
				}
			});

			var i = 0;
			$('.amy-add-group', _this).unbind('click').on('click', function (e) {
				e.preventDefault();

				clone_group.find('input, select, textarea').each(function () {
					this.name	= this.name.replace(/\[(\d+)\](?!.*\[(\d+)\])/, function (string, id) {
						return '[' + (parseInt(id, 10) + 1) + ']';
					});
				});

				var cloned	= clone_group.clone().removeClass('hidden');
				field_groups.append(cloned);

				if (accordion_group.length) {
					field_groups.accordion('refresh');
					field_groups.accordion({active: cloned.index()});
				}

				field_groups.find('input, select, textarea').each(function () {
					this.name	= this.name.replace('[_nonce]', '');
				});

				// run all field plugins
				cloned.AMYFRAMEWORK_DEPENDENCY('sub');
				cloned.AMYFRAMEWORK_RELOAD_PLUGINS();

				i++;
			});

			field_groups.on('click', '.amy-remove-group', function (e) {
				e.preventDefault();
				$(this).closest('.amy-group').remove();
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK RESET CONFIRM
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_CONFIRM = function () {
		return this.each(function () {
			$(this).on('click', function (e) {
				if (!confirm('Are you sure?')) {
					e.preventDefault();
				}
			});
		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK SAVE OPTIONS
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_SAVE = function () {
		return this.each(function () {
			var $this	= $(this),
				$text	= $this.data('save'),
				$value	= $this.val(),
				$ajax	= $('#amy-save-ajax');

			$(document).on('keydown', function (event) {
				if (event.ctrlKey || event.metaKey) {
					if (String.fromCharCode(event.which).toLowerCase() === 's') {
						event.preventDefault();
						$this.trigger('click');
					}
				}
			});

			$this.on('click', function (e) {
				if ($ajax.length) {
					if (typeof tinyMCE === 'object') {
						tinyMCE.triggerSave();
					}

					$this.prop('disabled', true).attr('value', $text);

					var serializedOptions	= $('#amyframework_form').serialize();

					$.post('options.php', serializedOptions).error(function () {
						alert('Error, Please try again.');
					}).success(function () {
						$this.prop('disabled', false).attr('value', $value);
						$ajax.hide().fadeIn().delay(250).fadeOut();
					});

					e.preventDefault();
				} else {
					$this.addClass('disabled').attr('value', $text);
				}

			});

		});
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK SAVE TAXONOMY CLEAR FORM ELEMENTS
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_TAXONOMY = function() {
		return this.each(function () {
			var $this	= $(this),
				$parent	= $this.parent();

			// Only works in add-tag form
			if ($parent.attr('id') === 'addtag') {
				var $submit		= $parent.find('#submit'),
					$name		= $parent.find('#tag-name'),
					$wrap		= $parent.find('.amy-framework'),
					$clone		= $wrap.find('.amy-element').clone(),
					$list		= $('#the-list'),
					flooding	= false;

				$submit.on('click', function () {
					if (!flooding) {
						$list.on('DOMNodeInserted', function () {
							if (flooding) {
								$wrap.empty();
								$wrap.html($clone);

								$clone	= $clone.clone();

								$wrap.AMYFRAMEWORK_RELOAD_PLUGINS();
								$wrap.AMYFRAMEWORK_DEPENDENCY();

								flooding = false;
							}
						});
					}

					flooding = true;
				});
			}
		});
	};

	// ======================================================
	// AMYFRAMEWORK UI DIALOG OVERLAY HELPER
	// ------------------------------------------------------
	if (typeof $.widget !== 'undefined' && typeof $.ui !== 'undefined' && typeof $.ui.dialog !== 'undefined') {
		$.widget('ui.dialog', $.ui.dialog, {
				_createOverlay: function () {
					this._super();
					if (!this.options.modal) {
						return;
					}

					this._on(this.overlay, {click: 'close'});
				}
			}
		);
	}

	// ======================================================
	// AMYFRAMEWORK ICONS MANAGER
	// ------------------------------------------------------
	$.AMYFRAMEWORK.ICONS_MANAGER = function () {
		var base	= this,
			onload	= true,
			$parent;

		base.init = function () {
			$amy_body.on('click', '.amy-icon-add', function (e) {
				e.preventDefault();

				var $this	= $(this),
					$dialog	= $('#amy-icon-dialog'),
					$load	= $dialog.find('.amy-dialog-load'),
					$select	= $dialog.find('.amy-dialog-select'),
					$insert	= $dialog.find('.amy-dialog-insert'),
					$search	= $dialog.find('.amy-icon-search');

				// set parent
				$parent	= $this.closest('.amy-icon-select');

				// open dialog
				$dialog.dialog({
					width:			850,
					height:			700,
					modal:			true,
					resizable:		false,
					closeOnEscape:	true,
					position:		{my: 'center', at: 'center', of: window},
					open:	function () {
						// fix scrolling
						$amy_body.addClass('amy-icon-scrolling');

						// fix button for VC
						$('.ui-dialog-titlebar-close').addClass('ui-button');

						// set viewpoint
						$(window).on('resize', function () {
							var height		= $(window).height(),
								load_height	= Math.floor(height - 237),
								set_height	= Math.floor(height - 125);

							$dialog.dialog('option', 'height', set_height).parent().css('max-height', set_height);
							$dialog.css('overflow', 'auto');
							$load.css('height', load_height);
						}).resize();
					},
					close: function () {
						$amy_body.removeClass('amy-icon-scrolling');
					}
				});

				// load icons
				if (onload) {
					$.ajax({
						type:	'POST',
						url:	ajaxurl,
						data:	{
							action: 'amy-get-icons'
						},
						success: function (content) {
							$load.html(content);

							onload	= false;

							$load.on('click', 'a', function (e) {
								e.preventDefault();

								var icon	= $(this).data('amy-icon');

								$parent.find('i').removeAttr('class').addClass(icon);
								$parent.find('input').val(icon).trigger('change');
								$parent.find('.amy-icon-preview').removeClass('hidden');
								$parent.find('.amy-icon-remove').removeClass('hidden');
								$dialog.dialog('close');
							});

							$search.keyup(function () {
								var value	= $(this).val(),
									$icons	= $load.find('a');

								$icons.each(function () {
									var $ico	= $(this);

									if ($ico.data('amy-icon').search(new RegExp(value, 'i')) < 0) {
										$ico.hide();
									} else {
										$ico.show();
									}
								});

							});

							$load.find('.amy-icon-tooltip').amytooltip({html: true, placement: 'top', container: 'body'});
						}
					});
				}
			});

			$amy_body.on('click', '.amy-icon-remove', function (e) {
				e.preventDefault();

				var $this	= $(this),
					$parent	= $this.closest('.amy-icon-select');

				$parent.find('.amy-icon-preview').addClass('hidden');
				$parent.find('input').val('').trigger('change');
				$this.addClass('hidden');
			});

		};

		// run initializer
		base.init();
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK SHORTCODE MANAGER
	// ------------------------------------------------------
	$.AMYFRAMEWORK.SHORTCODE_MANAGER	= function () {

		var base	= this,
			deploy_atts;

		base.init	= function () {
			var $dialog				= $('#amy-shortcode-dialog'),
				$insert				= $dialog.find('.amy-dialog-insert'),
				$shortcodeload		= $dialog.find('.amy-dialog-load'),
				$selector			= $dialog.find('.amy-dialog-select'),
				shortcode_target	= false,
				shortcode_name,
				shortcode_view,
				shortcode_clone,
				$shortcode_button,
				editor_id;

			$amy_body.on('click', '.amy-shortcode', function (e) {
				e.preventDefault();

				// init chosen
				$selector.AMYFRAMEWORK_CHOSEN();

				$shortcode_button	= $(this);
				shortcode_target	= $shortcode_button.hasClass('amy-shortcode-textarea');
				editor_id			= $shortcode_button.data('editor-id');

				$dialog.dialog({
					width:			850,
					height:			700,
					modal:			true,
					resizable:		false,
					closeOnEscape:	true,
					position:		{my: 'center', at: 'center', of: window},
					open:	function () {
						// fix scrolling
						$amy_body.addClass('amy-shortcode-scrolling');

						// fix button for VC
						$('.ui-dialog-titlebar-close').addClass('ui-button');

						// set viewpoint
						$(window).on('resize', function () {
							var height		= $(window).height(),
								load_height	= Math.floor(height - 281),
								set_height	= Math.floor(height - 125);

							$dialog.dialog('option', 'height', set_height).parent().css('max-height', set_height);
							$dialog.css('overflow', 'auto');
							$shortcodeload.css('height', load_height);
						}).resize();
					},
					close: function () {
						shortcode_target	= false;
						$amy_body.removeClass('amy-shortcode-scrolling');
					}
				});
			});

			$selector.on('change', function () {
				var $elem_this	= $(this);
				shortcode_name	= $elem_this.val();
				shortcode_view	= $elem_this.find(':selected').data('view');

				// check val
				if (shortcode_name.length) {
					$.ajax({
						type:	'POST',
						url:	ajaxurl,
						data:	{
							action:		'amy-get-shortcode',
							shortcode:	shortcode_name
						},
						success:	function (content) {
							$shortcodeload.html(content);
							$insert.parent().removeClass('hidden');

							shortcode_clone	= $('.amy-shortcode-clone', $dialog).clone();

							$shortcodeload.AMYFRAMEWORK_DEPENDENCY();
							$shortcodeload.AMYFRAMEWORK_DEPENDENCY('sub');
							$shortcodeload.AMYFRAMEWORK_RELOAD_PLUGINS();
						}
					});
				} else {
					$insert.parent().addClass('hidden');
					$shortcodeload.html('');
				}
			});

			$insert.on('click', function (e) {
				e.preventDefault();

				var send_to_shortcode	= '',
					ruleAttr			= 'data-atts',
					cloneAttr			= 'data-clone-atts',
					cloneID				= 'data-clone-id';

				switch (shortcode_view) {
					case 'contents':
						$('[' + ruleAttr + ']', '.amy-dialog-load').each(function () {
							var _this	= $(this),
								_atts	= _this.data('atts');

							send_to_shortcode	+= '[' + _atts + ']';
							send_to_shortcode	+= _this.val();
							send_to_shortcode	+= '[/' + _atts + ']';
						});

						break;
					case 'clone':
						send_to_shortcode	+= '[' + shortcode_name; // begin: main-shortcode

						// main-shortcode attributes
						$('[' + ruleAttr + ']', '.amy-dialog-load .amy-element:not(.hidden)').each(function () {
							var _this_main	= $(this), _this_main_atts = _this_main.data('atts');

							send_to_shortcode	+= base.validate_atts(_this_main_atts, _this_main);  // validate empty atts
						});

						send_to_shortcode	+= ']'; // end: main-shortcode attributes

						// multiple-shortcode each
						$('[' + cloneID + ']', '.amy-dialog-load').each(function () {
							var _this_clone	= $(this),
								_clone_id	= _this_clone.data('clone-id');

							send_to_shortcode	+= '[' + _clone_id; // begin: multiple-shortcode

							// multiple-shortcode attributes
							$('[' + cloneAttr + ']', _this_clone.find('.amy-element').not('.hidden')).each(function () {
								var _this_multiple	= $(this), _atts_multiple = _this_multiple.data('clone-atts');

								// is not attr content, add shortcode attribute else write content and close shortcode tag
								if (_atts_multiple !== 'content') {
									send_to_shortcode	+= base.validate_atts(_atts_multiple, _this_multiple); // validate empty atts
								} else if (_atts_multiple === 'content') {
									send_to_shortcode	+= ']';
									send_to_shortcode	+= _this_multiple.val();
									send_to_shortcode	+= '[/' + _clone_id + '';
								}
							});

							send_to_shortcode	+= ']'; // end: multiple-shortcode
						});

						send_to_shortcode	+= '[/' + shortcode_name + ']'; // end: main-shortcode

						break;
					case 'clone_duplicate':
						// multiple-shortcode each
						$('[' + cloneID + ']', '.amy-dialog-load').each(function () {
							var _this_clone	= $(this),
								_clone_id	= _this_clone.data('clone-id');

							send_to_shortcode	+= '[' + _clone_id; // begin: multiple-shortcode

							// multiple-shortcode attributes
							$('[' + cloneAttr + ']', _this_clone.find('.amy-element').not('.hidden')).each(function () {
								var _this_multiple	= $(this),
									_atts_multiple	= _this_multiple.data('clone-atts');


								// is not attr content, add shortcode attribute else write content and close shortcode tag
								if (_atts_multiple !== 'content') {
									send_to_shortcode	+= base.validate_atts(_atts_multiple, _this_multiple); // validate empty atts
								} else if (_atts_multiple === 'content') {
									send_to_shortcode	+= ']';
									send_to_shortcode	+= _this_multiple.val();
									send_to_shortcode	+= '[/' + _clone_id + '';
								}
							});

							send_to_shortcode	+= ']'; // end: multiple-shortcode
						});

						break;
					default:
						send_to_shortcode	+= '[' + shortcode_name;

						$('[' + ruleAttr + ']', '.amy-dialog-load .amy-element:not(.hidden)').each(function () {
							var _this	= $(this),
							_atts		= _this.data('atts');

							// is not attr content, add shortcode attribute else write content and close shortcode tag
							if (_atts !== 'content') {
								send_to_shortcode	+= base.validate_atts(_atts, _this); // validate empty atts
							} else if (_atts === 'content') {
								send_to_shortcode	+= ']';
								send_to_shortcode	+= _this.val();
								send_to_shortcode	+= '[/' + shortcode_name + '';
							}
						});

						send_to_shortcode	+= ']';

						break;
				}

				if (shortcode_target) {
					var $textarea	= $shortcode_button.next();

					$textarea.val(base.insertAtChars($textarea, send_to_shortcode)).trigger('change');
				} else {
					base.send_to_editor(send_to_shortcode, editor_id);
				}

				deploy_atts = null;

				$dialog.dialog('close');
			});

			// cloner button
			var cloned	= 0;

			$dialog.on('click', '#shortcode-clone-button', function (e) {
				e.preventDefault();

				// clone from cache
				var cloned_el	= shortcode_clone.clone().hide();

				cloned_el.find('input:radio').attr('name', '_nonce_' + cloned);

				$('.amy-shortcode-clone:last').after(cloned_el);

				// add - remove effects
				cloned_el.slideDown(100);

				cloned_el.find('.amy-remove-clone').show().on('click', function (e) {
					cloned_el.slideUp(100, function () {
						cloned_el.remove();
					});

					e.preventDefault();
				});

				// reloadPlugins
				cloned_el.AMYFRAMEWORK_DEPENDENCY('sub');
				cloned_el.AMYFRAMEWORK_RELOAD_PLUGINS();
				cloned++;
			});
		};

		base.validate_atts	= function (_atts, _this) {
			var el_value;

			if (_this.data('check') !== undefined && deploy_atts === _atts) {
				return '';
			}

			deploy_atts	= _atts;

			if (_this.closest('.pseudo-field').hasClass('hidden') === true) {
				return '';
			}

			if (_this.hasClass('pseudo') === true) {
				return '';
			}

			if (_this.is(':checkbox') || _this.is(':radio')) {
				el_value	= _this.is(':checked') ? _this.val() : '';
			} else {
				el_value	= _this.val();
			}

			if (_this.data('check') !== undefined) {
				el_value	= _this.closest('.amy-element').find('input:checked').map(function () {
					return $(this).val();
				}).get();
			}

			if (_this.hasClass('chosen') && el_value === null) {
				return ' ' + _atts + '=""';
			}

			if (el_value !== null && el_value !== undefined && el_value !== '' && el_value.length !== 0) {
				return ' ' + _atts + '="' + el_value + '"';
			}

			return '';
		};

		base.insertAtChars	= function (_this, currentValue) {
			var obj	= (typeof _this[0].name !== 'undefined') ? _this[0] : _this;

			if (obj.value.length && typeof obj.selectionStart !== 'undefined') {
				obj.focus();
				return obj.value.substring(0, obj.selectionStart) + currentValue + obj.value.substring(obj.selectionEnd, obj.value.length);
			} else {
				obj.focus();
				return currentValue;
			}

		};

		base.send_to_editor	= function (html, editor_id) {
			var tinymce_editor;

			if (typeof tinymce !== 'undefined') {
				tinymce_editor	= tinymce.get(editor_id);
			}

			if (tinymce_editor && !tinymce_editor.isHidden()) {
				tinymce_editor.execCommand('mceInsertContent', false, html);
			} else {
				var $editor = $('#' + editor_id);
				$editor.val(base.insertAtChars($editor, html)).trigger('change');
			}
		};

		// run initializer
		base.init();
	};
	// ======================================================

	// ======================================================
	// AMYFRAMEWORK COLORPICKER
	// ------------------------------------------------------
	if (typeof Color === 'function') {
		// adding alpha support for Automattic Color.js toString function.
		Color.fn.toString	= function () {
			// check for alpha
			if (this._alpha < 1) {
				return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
			}

			var hex	= parseInt(this._color, 10).toString(16);

			if (this.error) {
				return '';
			}

			// maybe left pad it
			if (hex.length < 6) {
				for (var i = 6 - hex.length - 1; i >= 0; i--) {
					hex = '0' + hex;
				}
			}

			return '#' + hex;
		};
	}

	$.AMYFRAMEWORK.PARSE_COLOR_VALUE = function (val) {
		var value	= val.replace(/\s+/g, ''),
			alpha	= (value.indexOf('rgba') !== -1) ? parseFloat(value.replace(/^.*,(.+)\)/, '$1') * 100) : 100,
			rgba	= (alpha < 100) ? true : false;

		return {value: value, alpha: alpha, rgba: rgba};
	};

	$.fn.AMYFRAMEWORK_COLORPICKER = function () {
		return this.each(function () {
			var $this	= $(this);

			// check for rgba enabled/disable
			if ($this.data('rgba') !== false) {
				// parse value
				var picker	= $.AMYFRAMEWORK.PARSE_COLOR_VALUE($this.val());

				// wpColorPicker core
				$this.wpColorPicker({
					// wpColorPicker: clear
					clear: function () {
						$this.trigger('keyup');
					},

					// wpColorPicker: change
					change: function (event, ui) {
						var ui_color_value	= ui.color.toString();

						// update checkerboard background color
						$this.closest('.wp-picker-container').find('.amy-alpha-slider-offset').css('background-color', ui_color_value);
						$this.val(ui_color_value).trigger('change');
					},

					// wpColorPicker: create
					create: function () {
						// set variables for alpha slider
						var a8cIris		= $this.data('a8cIris'),
							$container	= $this.closest('.wp-picker-container'),

						// appending alpha wrapper
							$alpha_wrap = $('<div class="amy-alpha-wrap">' +
								'<div class="amy-alpha-slider"></div>' +
								'<div class="amy-alpha-slider-offset"></div>' +
								'<div class="amy-alpha-text"></div>' +
								'</div>').appendTo($container.find('.wp-picker-holder')),

							$alpha_slider	= $alpha_wrap.find('.amy-alpha-slider'),
							$alpha_text		= $alpha_wrap.find('.amy-alpha-text'),
							$alpha_offset	= $alpha_wrap.find('.amy-alpha-slider-offset');

						// alpha slider
						$alpha_slider.slider({
							// slider: slide
							slide: function (event, ui) {
								var slide_value	= parseFloat(ui.value / 100);

								// update iris data alpha && wpColorPicker color option && alpha text
								a8cIris._color._alpha = slide_value;
								$this.wpColorPicker('color', a8cIris._color.toString());
								$alpha_text.text((slide_value < 1 ? slide_value : ''));
							},

							// slider: create
							create: function () {
								var slide_value			= parseFloat(picker.alpha / 100),
									alpha_text_value	= slide_value < 1 ? slide_value : '';

								// update alpha text && checkerboard background color
								$alpha_text.text(alpha_text_value);
								$alpha_offset.css('background-color', picker.value);

								// wpColorPicker clear for update iris data alpha && alpha text && slider color option
								$container.on('click', '.wp-picker-clear', function () {
									a8cIris._color._alpha	= 1;
									$alpha_text.text('').trigger('change');
									$alpha_slider.slider('option', 'value', 100).trigger('slide');
								});

								// wpColorPicker default button for update iris data alpha && alpha text && slider color option
								$container.on('click', '.wp-picker-default', function () {
									var default_picker	= $.AMYFRAMEWORK.PARSE_COLOR_VALUE($this.data('default-color')),
										default_value	= parseFloat(default_picker.alpha / 100),
										default_text	= default_value < 1 ? default_value : '';

									a8cIris._color._alpha	= default_value;
									$alpha_text.text(default_text);
									$alpha_slider.slider('option', 'value', default_picker.alpha).trigger('slide');
								});

								// show alpha wrapper on click color picker button
								$container.on('click', '.wp-color-result', function () {
									$alpha_wrap.toggle();
								});

								// hide alpha wrapper on click body
								$amy_body.on('click.wpcolorpicker', function () {
									$alpha_wrap.hide();
								});
							},

							// slider: options
							value: picker.alpha,
							step: 1,
							min: 1,
							max: 100
						});
					}
				});
			} else {
				// wpColorPicker default picker
				$this.wpColorPicker({
					clear: function () {
						$this.trigger('keyup');
					},
					change: function (event, ui) {
						$this.val(ui.color.toString()).trigger('change');
					}
				});
			}
		});
	};

	// ======================================================
	// PROFILE MANAGER
	// ------------------------------------------------------
	$.AMYFRAMEWORK.PROFILE_MANAGER	= function() {
		var base	= this;

		base.init	= function() {
			$amy_body.on('click', '.amy-save-profile', function(e) {
				e.preventDefault();
				e.stopPropagation();

				var $this	= $(this),
					$parent	= $this.parents('.amy-field-backup'),
					$dialog	= $('#amy-profile-dialog'),
					$load	= $dialog.find('.amy-dialog-load'),
					$save	= $dialog.find('.amy-dialog-insert');

				// open dialog
				$dialog.dialog({
					width:			450,
					height:			'auto',
					modal:			true,
					resizable:		false,
					closeOnEscape:	true,
					position:		{my: 'center', at: 'center', of: window},

					open:			function() {
						// fix scrolling
						$amy_body.addClass('amy-icon-scrolling');

						// fix button for VC
						$('.ui-dialog-titlebar-close').addClass('ui-button');

						//
						$save.on('click', function(e) {
							e.preventDefault();
							e.stopPropagation();

							var title	= $load.find('input').val().trim();

							if (!title) {

							} else {
								$save.attr('disabled', 'disabled');

								$.ajax({
									type:	'POST',
									url:	ajaxurl,
									data:	{
										action:	'amy-save-profile',
										title:	title
									},
									success: function(content) {
										$parent.find('.amy-dropdown-menu').html(content);
										$save.removeAttr('disabled');
										$dialog.dialog('close');
										$.AMYFRAMEWORK.PROFILE_RELOAD();
									}
								});
							}
						});
					},

					close: function () {
						$amy_body.removeClass('amy-icon-scrolling');
					}
				});
			});

			$amy_body.on('click', '.amy-dropdown > button', function(e) {
				e.preventDefault();
				e.stopPropagation();

				var $this	= $(this),
					$parent	= $this.parents('.amy-element');

				if ($this.hasClass('active')) {
					$this.removeClass('active');
					$parent.find('.amy-dropdown-menu').slideUp('fast');
				} else {
					$this.addClass('active');
					$parent.find('.amy-dropdown-menu').slideDown('fast');
				}
			});

			$amy_body.on('click amy-dropdown-close', function() {
				var $button	= $('.amy-dropdown > button');

				$button.removeClass('active');
				$button.parents('.amy-element').find('.amy-dropdown-menu').slideUp('fast');
			});
		};

		base.init();
	};


	$.AMYFRAMEWORK.PROFILE_RELOAD	= function() {
		$('.amy-profile-select').unbind('click').click(function(e) {
			e.preventDefault();
			e.stopPropagation();

			$amy_body.trigger('amy-dropdown-close');

			var $this	= $(this),
				$parent	= $this.parents('.amy-element');

			$parent.find('textarea:first-child').text($this.data('profile'));
		});

		$('.amy-profile-remove').unbind('click').click(function(e) {
			e.preventDefault();
			e.stopPropagation();

			var $this	= $(this),
				$parent	= $this.parents('.amy-element');

			$.ajax({
				type:	'POST',
				url:	$this.attr('href'),
				success: function(content) {
					$parent.find('.amy-dropdown-menu').html(content);
					$.AMYFRAMEWORK.PROFILE_RELOAD();
					$amy_body.trigger('amy-dropdown-close');
				}
			})
		});
	};

	// ======================================================
	// DEMO IMPORTER
	// ------------------------------------------------------
	$.AMYFRAMEWORK.DEMO_IMPORTER	= function() {
		var base	= this;

		var progress_bar	= {
			progress_bar_wrapper_element:	'',
			progress_bar_element:			'',
			current_value:					0,
			goto_value:						0,
			timer:							'',
			last_goto_value: 				0,

			show: function show() {
				progress_bar.progress_bar_wrapper_element.addClass('amy-demo-progress-bar-visible');
			},

			hide: function hide() {
				progress_bar.progress_bar_wrapper_element.removeClass('amy-demo-progress-bar-visible');
			},

			reset: function reset() {
				clearInterval(progress_bar.timer);

				progress_bar.current_value		= 0;
				progress_bar.goto_value			= 0;
				progress_bar.timer				= '';
				progress_bar.last_goto_value	= 0;

				progress_bar.change(0);
			},


			change: function change(new_progress) {
				progress_bar.progress_bar_element.css('width', new_progress + '%');

				progress_bar.last_goto_value	= new_progress;

				if (new_progress === 100) {
					clearInterval(progress_bar.timer);
				}
			},

			timer_change: function timer_change(new_progress) {
				clearInterval(progress_bar.timer);

				progress_bar._ui_change(progress_bar.last_goto_value);

				progress_bar.current_value	= progress_bar.last_goto_value;

				clearInterval(progress_bar.timer);

				progress_bar.timer	= setInterval(function () {
					if (Math.floor((Math.random() * 5) + 1) === 1) {
						var tmp_value	= Math.floor((Math.random() * 5) + 1) + progress_bar.current_value;

						if (tmp_value <= new_progress) {
							progress_bar._ui_change(progress_bar.current_value);

							progress_bar.current_value	= tmp_value;
						} else {
							progress_bar._ui_change(new_progress);
							clearInterval(progress_bar.timer);
						}
					}
				}, 1000);
				progress_bar.last_goto_value = new_progress;
			},

			_ui_change: function change(new_progress) {
				progress_bar.progress_bar_element.css('width', new_progress + '%');
			}
		};

		base.init	= function() {
			$('.amy-button-install-demo').click(function(e) {
				e.preventDefault();

				var $demo	= $('.amy-demo');

				if ($demo.hasClass('amy-demo-installed') || $demo.hasClass('amy-demo-installing') || $demo.hasClass('amy-demo-disabled') || $(this).hasClass('button-disabled')) {
					return;
				}

				var c	= confirm(adiL10n.install_demo_confirm);

				if (c) {
					base.install($(this).data('demo-id'));
				}
			});

			$('.amy-button-uninstall-demo').click(function(e) {
				e.preventDefault();

				var c = confirm(adiL10n.uninstall_demo_confirm);

				if (c) {
					base.uninstall($(this).data('demo-id'));
				}
			});
		};

		base.install	= function(id, data) {
			var $wrapper	= $('.amy-demo-' + id);

			$wrapper.addClass('amy-demo-installing');
			$wrapper.find('.amy-button-install-demo').addClass('button-disabled');
			$('.amy-demo').not($wrapper).addClass('amy-demo-disabled');

			progress_bar.progress_bar_wrapper_element	= $wrapper.find('.amy-demo-progress-bar-wrapper');
			progress_bar.progress_bar_element			= $wrapper.find('.amy-demo-progress-bar');
			progress_bar.show();
			progress_bar.change(0);

			base.install_step(id, {amy_demo_importer_action: 'install'});
		};

		base.install_finish	= function(id, error) {
			var $wrapper	= $('.amy-demo-' + id);

			$wrapper.removeClass('amy-demo-installing');

			if (!error) {
				// finish
				progress_bar.change(100);

				setTimeout(function() {
					progress_bar.hide();
					progress_bar.reset();

					$wrapper.removeClass('amy-demo-installing').addClass('amy-demo-installed');
					$wrapper.find('.amy-button-install-demo').removeClass('button-disabled');
				}, 500);
			} else {
				progress_bar.hide();
				progress_bar.reset();
				$wrapper.find('.amy-button-install-demo').removeClass('button-disabled');
			}
		};

		base.install_step	= function(id, data) {
			var $wrapper	= $('.amy-demo-' + id);

			data	= data || {};

			if (!data.action) {
				data.action		= 'amy_demo_importer_action';
			}

			if (!data.demo_id) {
				data.demo_id	= id;
			}

			$.ajax({
				type:		'POST',
				url:		ajaxurl,
				cache:		false,
				dataType:	'text',
				data:		data,
				success:	function(content) {
					if (!content || content == '0') {
						base.install_finish(id, true);
						alert(adiL10n.install_demo_error);
					} else if (content == '1') {
						base.install_finish(id);
					} else {
						var response	= JSON.parse(content);

						progress_bar.change(response.progress);

						var request		= {
							amy_demo_importer_action:	response.next_action
						};

						if (response.next_action == 'post' && response.pni) {
							request.pni	= response.pni;
						}

						base.install_step(id, request);
					}
				},
				error:		function() {
					base.install_finish(id, true);
					alert(adiL10n.install_demo_error);
				}
			});
		};

		base.uninstall	= function(id) {
			var $wrapper	= $('.amy-demo-' + id);

			$wrapper.addClass('amy-demo-uninstalling').removeClass('amy-demo-installed');

			progress_bar.progress_bar_wrapper_element	= $wrapper.find('.amy-demo-progress-bar-wrapper');
			progress_bar.progress_bar_element			= $wrapper.find('.amy-demo-progress-bar');
			progress_bar.show();
			progress_bar.change(2);
			progress_bar.timer_change(98);

			$.ajax({
				type:		'POST',
				url:		ajaxurl,
				cache:		false,
				dataType:	'text',
				data:		{
					action:						'amy_demo_importer_action',
					amy_demo_importer_action:	'uninstall',
					demo_id:					id
				},
				success:	function(content) {
					progress_bar.change(100);

					setTimeout(function() {
						progress_bar.hide();
						progress_bar.reset();

						$wrapper.removeClass('amy-demo-uninstalling');
						$('.amy-demo').removeClass('amy-demo-disabled');
					})
				},
				error:	function() {
					$wrapper.removeClass('amy-demo-uninstalling');
					alert(adiL10n.uninstall_demo_error);
				}
			});
		};

		base.init();
	};

	// ======================================================

	// ======================================================
	// CUSTOM SIDEBARS
	// ------------------------------------------------------
	$.AMYFRAMEWORK.CUSTOM_SIDEBARS	= function() {
		var base	= this;

		base.custom_sidebars = (function() {
			function Custom_Sidebars() {
				this.widget_wrap	= $('.widget-liquid-right');
				this.widget_area	= $('#widgets-right');
				this.widget_add		= $('#tmpl-amy-add-widget');

				this.create_form();
				this.add_elements();
				this.events();
			}

			Custom_Sidebars.prototype.create_form = function () {
				this.widget_wrap.append(this.widget_add.html());

				this.widget_name	= this.widget_wrap.find('input[name="amy-add-widget"]');
				this.nonce			= this.widget_wrap.find('input[name="amy-delete-nonce"]').val();
			};

			Custom_Sidebars.prototype.add_elements = function () {
				this.widget_area.find('.sidebar-amy-custom-widget').append('<span class="amy-area-delete"><span class="dashicons dashicons-no"></span></span>');

				this.widget_area.find('.sidebar-amy-custom-widget').each(function () {
					var where_to_add	= $(this).find('.widgets-sortables');
					var id				= where_to_add.attr('id').replace('sidebar-', '');

					/*
					if (where_to_add.find('.sidebar-description').length > 0) {
						where_to_add.find('.sidebar-description').prepend("<p class=\"description\">" + acsL10n.shortcode + ": <code>[amy_sidebar id=\"" + id + "\"]</code></p>");
					} else {
						where_to_add.find('.sidebar-name').after("<div class=\"sidebar-description\"><p class=\"description\">" + acsL10n.shortcode + ": <code>[amy_sidebar id=\"" + id + "\"]</code></p></div>");
					}
					*/
				});
			};

			Custom_Sidebars.prototype.events = function () {
				this.widget_wrap.on('click', '.amy-area-delete', $.proxy(this.delete_sidebar, this));
			};

			Custom_Sidebars.prototype.delete_sidebar = function (e) {
				var widget		= $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)');
				var title		= widget.find('.sidebar-name h2');
				var spinner		= widget.find('.spinner');
				var widget_name	= widget.children().first().attr('id');
				var obj			= this;

				if (confirm(acsL10n.delete_sidebar_area)) {
					$.ajax({
						type:	'POST',
						url:	window.ajaxurl,
						data: {
							action: 'amy_ajax_delete_custom_sidebar',
							name: widget_name,
							_wpnonce: obj.nonce
						},

						beforeSend: function () {
							spinner.addClass('activate');
						},

						success: function (response) {
							if (response === "sidebar-deleted") {
								widget.slideUp(200, function () {
									$('.widget-control-remove', widget).trigger('click');
									widget.remove();
									wpWidgets.saveOrder();
								});
							}
						}
					});
				}
			};

			return Custom_Sidebars;
		})();

		new base.custom_sidebars();
	};

	// ======================================================

	// ======================================================
	// ON WIDGET-ADDED RELOAD FRAMEWORK PLUGINS
	// ------------------------------------------------------
	$.AMYFRAMEWORK.WIDGET_RELOAD_PLUGINS = function () {
		$(document).on('widget-added widget-updated', function (event, $widget) {
			$widget.AMYFRAMEWORK_RELOAD_PLUGINS();
			$widget.AMYFRAMEWORK_DEPENDENCY();
		});
	};

	// ======================================================
	// TOOLTIP HELPER
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_TOOLTIP = function () {
		return this.each(function () {
			var placement = (amy_is_rtl) ? 'right' : 'left';
			$(this).amytooltip({html: true, placement: placement, container: 'body'});
		});
	};

	// ======================================================
	// RELOAD FRAMEWORK PLUGINS
	// ------------------------------------------------------
	$.fn.AMYFRAMEWORK_RELOAD_PLUGINS = function () {
		return this.each(function () {
			$('.chosen:not(.amy-group.hidden:first-child .chosen)', this).AMYFRAMEWORK_CHOSEN();
			$('.amy-field-image-select', this).AMYFRAMEWORK_IMAGE_SELECTOR();
			$('.amy-field-image', this).AMYFRAMEWORK_IMAGE_UPLOADER();
			$('.amy-field-gallery', this).AMYFRAMEWORK_IMAGE_GALLERY();
			$('.amy-field-sorter', this).AMYFRAMEWORK_SORTER();
			$('.amy-field-upload', this).AMYFRAMEWORK_UPLOADER();
			$('.amy-field-typography', this).AMYFRAMEWORK_TYPOGRAPHY();
			$('.amy-field-color-picker', this).AMYFRAMEWORK_COLORPICKER();
			$('.amy-help', this).AMYFRAMEWORK_TOOLTIP();
			$('.amy-field-group', this).AMYFRAMEWORK_GROUP();
		});
	};

	// ======================================================
	// JQUERY DOCUMENT READY
	// ------------------------------------------------------
	$(document).ready(function () {
		$('#menu-to-edit').AMYFRAMEWORK_MEGAMENU();
		$('.amy-header').AMYFRAMEWORK_STICKY_HEADER();
		$('.amy-framework').AMYFRAMEWORK_TAB_NAVIGATION();
		$('.amy-reset-confirm, .amy-import-backup').AMYFRAMEWORK_CONFIRM();
		$('.amy-content, .wp-customizer, .widget-content, .amy-taxonomy').AMYFRAMEWORK_DEPENDENCY();
		$('.amy-field-group').AMYFRAMEWORK_GROUP();
		$('.amy-save').AMYFRAMEWORK_SAVE();
		$('.amy-taxonomy').AMYFRAMEWORK_TAXONOMY();
		$('.amy-framework, #widgets-right').AMYFRAMEWORK_RELOAD_PLUGINS();
		$.AMYFRAMEWORK.ICONS_MANAGER();
		$.AMYFRAMEWORK.SHORTCODE_MANAGER();
		$.AMYFRAMEWORK.PROFILE_MANAGER();
		$.AMYFRAMEWORK.PROFILE_RELOAD();
		$.AMYFRAMEWORK.DEMO_IMPORTER();
		$.AMYFRAMEWORK.CUSTOM_SIDEBARS();
		$.AMYFRAMEWORK.WIDGET_RELOAD_PLUGINS();
	});
})(jQuery, window, document);
