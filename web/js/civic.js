/**
 * Civic namespace
 * 
 * Provide a namespace and context based initialization 
 */

// Set up civic Namespace object.

if (typeof civic == "undefined" || !civic) {
	
	var civic = (function($) {
				
		function childNamespace(namespace, parent) {
			
			this.getNamespace = function() {
				
				return namespace;
			}
			
			if (typeof parent != 'undefined') {
				this.getParent = function() {				
					return parent;
				};
				
				this.assign = function(value) {				
					var parent = this.getParent();
					return parent[this.getNamespace().split('.').pop()] = value;				
				};
			}
		};
		
		function rootNamespace() { 
			
			var _autoload = new Array();
			
			this.load = function(selector, callback) {
				
				var loadee = { selector: '*', callback: null };
				
				if (typeof selector == 'function') {
					loadee.callback = selector;
				} else {
					loadee.selector = selector;
					loadee.callback = callback;		
				}
						
				_autoload.push(loadee);
			}; 
			
			this.bootstrap = function() {
				
				for (var index in _autoload) {
					
					if ($('body').is(_autoload[index].selector)) {
						_autoload[index].callback.call(civic, $);	
					}					
				}
				
				delete this.bootstrap;
				delete this.load;				
			};							
		};
		
		childNamespace.prototype = {
			execute: function(callback) {	
				return callback.call(this, $);			
			;}				
		};
							
		rootNamespace.prototype = new childNamespace('civic');
		
		rootNamespace.prototype.namespace = function() {						
			
			var a=arguments, o=null, i, j, d;
			var namespace = 'civic';
			
		    for (i=0; i<a.length; i=i+1) {
		        d=(""+a[i]).split(".");
		        o=civic;

		        for (j=(d[0] == "civic") ? 1 : 0; j<d.length; j=j+1) {
		        	namespace += '.' + d[j];
		        	o[d[j]]=o[d[j]] || new childNamespace(namespace, o);
		            o=o[d[j]];
		        }
		    }

		    return o;		    
		};
				
		return new rootNamespace();
	})(jQuery);
}

if (typeof console == "undefined" || !console) {	
	var console = {
		log: function(message) { }
	};
}

jQuery(document).ready(function() {
	civic.bootstrap();
});
