$(function () {
	$('body').on('click','[data-toggle=yg-modal]',function(e){
		var $launcher = $(this);
		var id = $.fn.ygModal.getGuid();
		var $modal = $.fn.ygModal.createModal(id, $launcher.data('modalHeight'));
		$modal.data('yg.launcher',$launcher);
		$launcher.data('yg.modal',$modal);
		$modal.modal().find('.modal-body').load($launcher.attr('href'), function (data) {
			$modal.find('.modal-content').removeClass('remote-modal-loading');
		});
		e.preventDefault();
	});
	jQuery.fn.extend({
		ygModal: {
			createModal: function (id, modalHeight) {
				modalHeight = modalHeight || 'auto';
				var html = '<div class="modal fade" id="' + id + '"><div class="modal-dialog"><div class="modal-content remote-modal-loading"><div class="modal-body"></div></div></div></div>'
				$('body').append(html).find('#'+id + ' .modal-content').css('minHeight', modalHeight);
				this.bindEvents(id);
				return $('#'+id);
			},
			bindEvents: function (id) {
				var modal = $('#' + id),
				    self = this;
				modal.on('hidden.bs.modal', function () {
					modal.data('yg.launcher').removeData('yg.modal');
					modal.data('bs.modal', null).remove();
				}).on('shown.bs.modal', function () {
					var shownModalsCount = $('.modal-backdrop.fade.in').length;
					$(this).data('bs.modal').$backdrop.css('zIndex', 1020 + shownModalsCount * 10);
					$(this).data('bs.modal').$element.css('zIndex', 1030 + shownModalsCount * 10)
				}).on('submit', 'form', function (e) {
					var form = $(this);
					$.post(form.prop('action'), form.serialize(), function (data) {
						if (data.success) {
							if (data.close) {
								modal.modal('hide');
							} else {
								self.successFlash(id, data.success)
							}
							var launcher = modal.data('yg.launcher');
							if (launcher.data('modalSuccessRise'))
								launcher.trigger(launcher.data('modalSuccessRise'), data);
						} else {
                   			self.errorFlash(id, data.error)
						}
					}, 'json');
					e.preventDefault();
				});
			},
			renderFlash: function(modalId, message, flashType){
				if(typeof message !== 'string'){
					var errors = [];
					jQuery.each(message, function(key, fieldErrors) {
						errors.push('<strong>'+key+':</strong> ' + ([].concat(fieldErrors).join('. ')));
					});
					message = '<ul class="list-unstyled"><li>' + errors.join('</li><li>') + '</li></ul>';
				}
				$('#'+modalId).find('hr:eq(0)').after('<div class="alert alert-'+flashType+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+message+'</div>')
			},
			errorFlash: function(modalId, message){
				this.renderFlash(modalId, message, 'danger');
			},
			successFlash: function(modalId, message){
				this.renderFlash(modalId, message, 'success');
			},
			getGuid: function(){
				var S4 = function() {
					return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
				};
				return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
			}
		}
	});

	$('[data-ml-group]').each(function(){

	});

	$.fn.extend({
		ygMultilang: {
			register: function(selector, options){
				options = options || {};
				var $group = $(selector);
				var $handlers = $('<div>', {
					'class':'ml-handlers btn-group pull-right ' + (options.handlerCssClass ? options.handlerCssClass : '')
				});
				$group.prepend($handlers);
				$group.find('[data-ml-language]').each(function(){
					var $control = $(this);
					var $handler = $('<button>', {
						'class':'btn btn-xs btn-default btn-ml ' + ($control.hasClass('hidden') ? "" : 'btn-success')
					}).text($control.data('mlLanguage')).data('mlControl', $control);
					$handlers.append($handler);
				});
				$group.on('click', '.btn-ml', function(e){
					var $handler = $(this);
					if(!$handler.hasClass('btn-success')){
						$group.find('.btn-success').removeClass('btn-success').data('mlControl').addClass('hidden');
						$handler.data('mlControl').removeClass('hidden');
						$handler.addClass('btn-success')
					}
					e.preventDefault();
				});
			}
		}
	})



});