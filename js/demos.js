jQuery(document).ready(function($) {
	/* Cache panel elements */
	var $demos = $('#mpcth_demos').find('.preview-item'),
		$options = $('#mpcth_options').find('.install-option'),
		$import_btn = $('#mpcth_import'),
		$import_process = $('#mpcth_import_process'),
		$import_success = $('#mpcth_import_success'),
		$import_backups = $('#mpcth_import_backups'),
		$import_progress = $('#mpcth_import_content_progress'),
		$import_progress_value = $('#mpcth_import_content_progress_value');

	var backup_flag = false;

	/* Set active demo theme */
	$demos.on('click', function(e) {
		$demos.removeClass('active').find('.install-option').removeClass('active');

		$(this).toggleClass('active')
			.find('.install-option').toggleClass('active');

		$import_btn.children('strong').text($(this).text());

		e.preventDefault();
	});

	/* Set import elements */
	$options.on('click', function(e) {
		var $option = $(this);

		$option.toggleClass('active');

		if($options.filter('.active').length)
			$import_btn.addClass('active');
		else
			$import_btn.removeClass('active');

		e.preventDefault();
	});

	/* Begin the import */
	$import_btn.on('click', function (e) {
		if ($(this).is('.active'))
			mpcth_begin_import();

		e.preventDefault();
	});

	function mpcth_begin_import() {
		/* Set elements flags */
		var theme = $demos.filter('.active').attr('data-theme'),
			install_content = $('#mpcth_opt_content').is('.active'),
			install_widgets = $('#mpcth_opt_widgets').is('.active'),
			install_panel = $('#mpcth_opt_panel').is('.active');

		$import_success.css('display', 'none');
		$import_btn.css('display', 'none');
		$import_process.css('display', 'inline-block');

		import_step_backup();

		/* Backup the whole settings before import */
		function import_step_backup() {
			$import_process.attr('class', 'step-backup');

			$.post(ajaxurl, {
				action: 'mpcth_import_step_backup'
			}, function(response) {
				import_step_content();
			});
		}

		/* Import the whole demo content with menu */
		function import_step_content() {
			if (install_content) {
				var current_part = 1,
					total_parts = 1,
					percents = 0;

				$import_process.attr('class', 'step-content');

				function import_content_before() {
					$.post(ajaxurl, {
						theme: theme,
						action: 'mpcth_import_step_content_before'
					}, function(response) {
						console.log(response);
						total_parts = parseInt(response);
						percents = '0%';

						$import_progress.css('width', percents);
						$import_progress_value.html(percents);

						import_content_part();
					});
				}
				function import_content_part() {
					$.post(ajaxurl, {
						theme: theme,
						part: current_part++,
						action: 'mpcth_import_step_content_part'
					}, function(response) {
						console.log(response);
						if (response != '1') {
							percents = ~~(((current_part - 1) / total_parts) * 100) + '%';

							$import_progress.css('width', percents);
							$import_progress_value.html(percents);

							import_content_part();
						} else {
							import_content();
						}
					});
				}
				function import_content() {
					$.post(ajaxurl, {
						theme: theme,
						part: '',
						action: 'mpcth_import_step_content_part'
					}, function(response) {
						console.log(response);
						percents = '100%';

						$import_progress.css('width', percents);
						$import_progress_value.html(percents);

						import_content_after();
					});
				}
				function import_content_after() {
					$.post(ajaxurl, {
						theme: theme,
						action: 'mpcth_import_step_content_after'
					}, function(response) {
						import_step_widgets();
					});
				}

				import_content_before();
			} else {
				import_step_widgets();
			}
		}

		/* Import all widgets */
		function import_step_widgets() {
			if (install_widgets) {
				$import_process.attr('class', 'step-widgets');

				$import_progress.css('width', '0%');
				$import_progress_value.html('0%');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_widgets'
				}, function(response) {
                    console.log(response);
					import_step_panel();
				});
			} else {
				import_step_panel();
			}
		}

		/* Import theme options */
		function import_step_panel() {
			if (install_panel) {
				$import_process.attr('class', 'step-panel');

				$import_progress.css('width', '0%');
				$import_progress_value.html('0%');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_panel'
				}, function(response) {
					clear_wizard();
				});
			} else {
				clear_wizard();
			}
		}

		/* Reset import wizard to default values */
		function clear_wizard() {
			$options.removeClass('active visible');

			$import_btn.removeClass('active');

			$import_success.css('display', 'inline-block');
			$import_process.css('display', 'none');

			$import_progress.css('width', '0%');
			$import_progress_value.html('0%');

			setTimeout(function () {
				$import_success.css('display', 'none');
				$import_btn.css('display', 'inline-block');
			}, 5000);

			$.post(ajaxurl, {
				theme: theme,
				action: 'mpcth_import_backups_list'
			}, function(response) {
				$import_backups.find('ol').html(response);
			});
		}
	}

	/* Restore/Delete backup */
	$import_backups.on('click', '.mpcth-backup-delete, .mpcth-backup-restore', function (e) {
		if (backup_flag)
			return false;

		var $this = $(this),
			$parent = $this.parent(),
			is_delete = $this.is('.mpcth-backup-delete');

		if (! window.confirm($this.attr('data-msg')))
			return false;

		$parent.addClass('active');
		backup_flag = true;

		$.post(ajaxurl, {
			id: $parent.attr('data-id'),
			action: is_delete ? 'mpcth_import_backup_delete' : 'mpcth_import_backup_restore'
		}, function(response) {
			if (is_delete) {
				$parent.slideUp(function () {
					$parent.remove();
					backup_flag = false;
				});
			} else {
				$parent.removeClass('active');
				backup_flag = false;
			}
		});

		e.preventDefault();
	});

	/* Exporter */
	$('#mpcth_export_demo_widgets').on('click', function(e) {
		var ajax_export_url = ajaxurl + '?action=mpcth_export_demo_widgets';
		location.href = ajax_export_url;

		e.preventDefault();
	});

	$('#mpcth_export_demo_settings').on('click', function(e) {
		var ajax_export_url = ajaxurl + '?action=mpcth_export_demo_settings';
		location.href = ajax_export_url;

		e.preventDefault();
	});
});
