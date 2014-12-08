					init.push(function () {
						$('.ui-wizard-example').pixelWizard({
							onChange: function () {
								console.log('Current step: ' + this.currentStep());
							},
							onFinish: function () {
								// Disable changing step. To enable changing step just call this.unfreeze()
								this.freeze();
								console.log('Wizard is freezed');
								console.log('Finished!');
							}
						});
						
						$('.wizard-next-step-btn').click(function () {
							$(this).parents('.ui-wizard-example').pixelWizard('nextStep');
						});
						
						//$('.wizard-next-step-btn').parents('.ui-wizard-example').pixelWizard('setCurrentStep', 4);
						$('#db-config').submit(function () {
							$('#db-config #pg-loading').hide().fadeIn();
							$("#db-config #pg-res").hide();
							$.ajax({
							  url: $(this).attr('action'),
							  type: 'POST',
							  data: new FormData(this),
							  processData: false,
							  contentType: false,
							  success: function(data) {
									console.log(data);
									var data = $.parseJSON(data);
									// check first success nor
									if(data.status == "ok"){
										$('#db-config #pg-loading').hide();
										$("#db-config button").hide();
										$("#db-config .wizard-next-step-btn").show();
										
										$("#db-config input").slideUp();
										$("#db-config #db_host .control-label" ).append(' <span class="text-success">' + data.db_host + '</span>');
										$("#db-config #db_user .control-label" ).append(' <span class="text-success">' + data.db_user + '</span>');
										$("#db-config #db_pass .control-label" ).append(' <span class="text-success">' + data.db_pass + '</span>');
										$("#db-config #db_name .control-label" ).append(' <span class="text-success">' + data.db_name + '</span>');
										
										$("#db-config #pg-res").html("&nbsp;&nbsp;" + data.isi).fadeIn();
										$("#pg-bar").css("width","33%");
										
										$('.wizard-next-step-btn').parents('.ui-wizard-example').pixelWizard('nextStep');
									}
									else if(data.status == "error"){
										$('#db-config #pg-loading').hide();
										$("#db-config #pg-res").html("&nbsp;&nbsp;" + data.isi + " (" + data.error + ")").fadeIn();
									}
							   }
							});
							return false;
						});
						
						$('#website-info').submit(function () {
							$('#website-info #pg-loading').hide().fadeIn();
							$("#website-info #pg-res").hide();
							$.ajax({
							  url: $(this).attr('action'),
							  type: 'POST',
							  data: new FormData(this),
							  processData: false,
							  contentType: false,
							  success: function(data) {
									console.log(data);
									var data = $.parseJSON(data);
									// check first success nor
									if(data.status == "ok"){
										$('#website-info #pg-loading').hide();
										$("#website-info button").hide();
										$("#website-info .wizard-next-step-btn").show();
										
										$("#website-info input, #website-info #s2id_select2, #website-info .radio").slideUp();
										$("#website-info #site_url .control-label" ).append(' <span class="text-success">' + data.site_url + '</span>');
										$("#website-info #site_name .control-label" ).append(' <span class="text-success">' + data.site_name + '</span>');
										$("#website-info #site_email .control-label" ).append(' <span class="text-success">' + data.site_email + '</span>');
										$("#website-info #timezone .control-label" ).append(' <span class="text-success">' + data.timezone + '</span>');
										$("#website-info #admin_theme .control-label" ).append(' <span class="text-success">' + data.admin_theme + '</span>');
										
										$("#website-info #pg-res").html("&nbsp;&nbsp;" + data.isi).fadeIn();
										$("#pg-bar").css("width","66%");
										
										$('.wizard-next-step-btn').parents('.ui-wizard-example').pixelWizard('nextStep');
									}
									else if(data.status == "error"){
										$('#website-info #pg-loading').hide();
										$("#website-info #pg-res").html("&nbsp;&nbsp;" + data.isi + " (" + data.error + ")").fadeIn();
									}
							   }
							});
							return false;
						});
						
						$('#account-setting').submit(function () {
							$('#account-setting #pg-loading').hide().fadeIn();
							$("#account-setting #pg-res").hide();
							$.ajax({
							  url: $(this).attr('action'),
							  type: 'POST',
							  data: new FormData(this),
							  processData: false,
							  contentType: false,
							  success: function(data) {
									console.log(data);
									var data = $.parseJSON(data);
									// check first success nor
									if(data.status == "ok"){
										$('#account-setting #pg-loading').hide();
										$("#account-setting button").hide();
										$("#account-setting .wizard-next-step-btn").show();
										
										$("#account-setting input, #account-setting .help-block").slideUp();
										$("#account-setting #el_fn .control-label" ).append(' <span class="text-success">' + data.el_fn + '</span>');
										$("#account-setting #el_un .control-label" ).append(' <span class="text-success">' + data.el_un + '</span>');
										$("#account-setting #el_em .control-label" ).append(' <span class="text-success">' + data.el_em + '</span>');
										$("#account-setting #el_pw .control-label" ).append(' <span class="text-success">' + data.el_pw + '</span>');
										$("#account-setting #el_pwc .control-label" ).append(' <span class="text-success">' + data.el_pwc + '</span>');
										
										$("#account-setting #pg-res").html("&nbsp;&nbsp;" + data.isi).fadeIn();
										$("#pg-bar").css("width","100%");
										
										$('.wizard-next-step-btn').parents('.ui-wizard-example').pixelWizard('nextStep');
										$('.ui-wizard-example').frezze();
									}
									else if(data.status == "error"){
										$('#account-setting #pg-loading').hide();
										$("#account-setting #pg-res").html("&nbsp;&nbsp;" + data.isi + " (" + data.error + ")").fadeIn();
									}
							   }
							});
							return false;
						});

					});