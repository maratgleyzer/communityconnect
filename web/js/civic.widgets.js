civic.namespace('widgets').execute(function($) {
		
	this.Radioset = function() {				
		return {
			onmatch: function() {
				
				var self = this;
						
				this.find('input[type="radio"]').each(function() {
					
					var span = $(document.createElement('span')).addClass('ui-checkbox');
					
					$(this).before(span);	
				
					if ($(this).is(':checked')) {
						span.addClass('ui-checkbox-state-checked');
					}
					
					$(this).change(function() {						
						
						self.find('input[type="radio"]').not(this).prev().removeClass('ui-checkbox-state-checked');
						
						if ($(this).is(':checked')) {
							$(this).prev().addClass('ui-checkbox-state-checked');
						} else {
							$(this).prev().removeClass('ui-checkbox-state-checked');
						}
					});
				});				
			}
		};		
	};
	
	this.ImageToggle = function() {
		return {
			onmatch: function() {
			
				var self = this;
			
				var hidden = $(document.createElement('input'))
								.attr({
									type: 'hidden',
									name: 'selectedValue',
									disabled: 'disabled'
								});
														
				this.prepend(hidden);
			
				this.find('input[type="image"]').click(function() {
					hidden.val($(this).val());
					
					self.find('input[type="image"]').not(this).removeClass('selected');
					
					$(this).addClass('selected');
					
					return false;
				});
				
				var defaultValue = this.find('input[type="image"].selected').val();
				
				if (defaultValue) {
					hidden.val(defaultValue);
				}
			}
		};	
	};
		
	$('.radioset').entwine(this.Radioset);
	$('.imageToggle').entwine(this.ImageToggle);	
	$('.imageToggle').click(this.ImageToggle);	
});
