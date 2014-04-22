(function() {

$(document).foundation();

$(document).ready(function(){

	if($('form[name="product"]').length > 0){
		var productForm = new ProductForm();
		productForm.init();
	}

	if($('.solr-products').length > 0){
		var solrController = new SolrController();
		solrController.init();
	}

});

function SolrController(){

	var self = this;

	self.init = function(){
		
		$('button.migrate').on('click', function(){
			$.ajax({
				type: 'get',
				url: "/solr/product/migrate"
			}).done(function(data) {
				alert('done!');
			});
		});

	}
	
}

function ProductForm(){

	var self = this;

	self.init = function(){
		var form = $('form[name="product"]');
		
	}
	
}

})();