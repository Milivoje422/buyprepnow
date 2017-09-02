	$('.carousel').carousel({ interval: 5000 });
	$('.curved b , .curved i').on('click', function(){
		$(".price_lightbox").slideToggle( "slow");
	});

	var products = [];
	var product = {
		name:'Product',
		price: 0,
		color: 'white', 
		size:100,
		country: "" ,
		currency: "",
		provision: 0 }

	var productx3 = {
		name:'Productx3',
		price: 0,
		color:'white',
		size:300,
		country: "",
		currency: "",
		provision: 0 }

	var productx6 = {
		name:'Productx6',
		price: 0,
		color:'white',
		size:600,
		country: "",
		currency: "",
		provision: 0 }

var europe   =  "<option value=''>Select country</option>"+
				"<option value='nl'>Netherlands</option>"+
                "<option value='be'>Belgium</option>"+
                "<option value='de'>Germany</option>"+
                "<option value='es'>Spain</option>"+
                "<option value='it'>italy</option>"+
                "<option value='se'>Sweden</option>"+
                "<option value='no'>Norway</option>"+
                "<option value='fi'>Finland</option>"+
                "<option value='gr'>Greece</option>"+
                "<option value='uk'>United Kingdom</option>"+
                "<option value='ie'>Ireland</option>"+
                "<option value='other'>other</option>";
                
var america =   "<option value=''>Select country</option>"+
				'<option value="us">United State</option>' +
                '<option value="ca">Canada</option>' +
                '<option value="other">Other</option>';

var other  =    "<option value=''>Select country</option>"+
				'<option value="au">Australia</option>' +
                '<option value="il">Israel</option>' +
                '<option value="other">Other</option>';

var selectDefault = '<option value="">Select the region first</option>';

	function getCountry(parameter){
		if(parameter == "europe")  	 { $('#countries').html(europe); }
		else if(parameter == 'america') { $('#countries').html(america); }
		else if(parameter == 'other') { $('#countries').html(other); }
		else { $('#countries').html(selectDefault); }
	}

    function getValues(parameter, region, country){
 		if(parameter == 'nl' && region == 'europe') { 
 			return [37, 86, 120, 12, country] 
 		}
	 	else if(parameter == 'es'  && region == 'europe' || 
		 		parameter == 'de'  && region == 'europe' || 
		 		parameter == 'gr'  && region == 'europe' || 
		 		parameter == 'de'  && region == 'europe' ||
		 		parameter == 'be'  && region == 'europe' || 
		 		parameter == 'it'  && region == 'europe' )
	 	{
	 		return [56, 123, 150, 12, country] 
	 	}
	 	else if(parameter == 'uk' && region == 'europe' ||
 				parameter == 'ie' && region == 'europe' )
	 	{
	 		return [56, 123, 150, 12, country] 
	 	}
	 	else if(parameter == 'no' && region == 'europe' || 
	 			parameter == 'se' && region == 'europe' || 
	 			parameter == 'fi' && region == 'europe')
	 	{
	 		return [56, 123, 150, 12, country] 
	 	}
	 	else if(parameter == 'us' && region == 'america' || 
	 			parameter == 'ca' && region == 'america')
	 	{
	 		return [62, 141, 193, 17, country] 
	 	}
	 	else if(parameter == 'other' && region == 'europe'){
	 		return [62, 123, 180, 12, country]
	 	}
	 	else if(parameter == 'other' && region == 'america'){
	 		return [62, 141, 193, 17, country] }
	 	else if(parameter == 'au' && region == 'other'){
	 		return [42, 101, 135, 17, country] }
	 	else if(parameter == 'il' && region == 'other'){
	 		return [59, 135, 162, 17, country] }
	 	else if(parameter == 'other' && region == 'other'){
	 		return [59, 135, 162, 17, country] }
	 	else { 
	 		console.log(parameter, region);
	 		return false; 
	 	}
    }

	function offonInputs(selection, boolean){
	    $(selection).prop('disabled', boolean);
	}

	function convertingPrices(value, currency){
		var currentValue = value;
		if(currency == 'euro'){
			return value * 1.17976;
		}
		if(currency == 'dollar'){

			return currentValue;
		}
	}

	function contentUpdate(){
		$('.produtcs_prices').text(product.price);
		$('.produtcs_prices1').text(productx3.price);
		$('.produtcs_prices2').text(productx6.price);
		$('.items_').text(product.price);
	}


	// after select region 
	$('#region').on('change', function(){
		if($(this).val() !== ""){
			offonInputs("#countries", false);
			getCountry($(this).val());
			return true;
		}else{ 
			getCountry($(this).val());
			offonInputs('#currency', true ); 
			offonInputs('#countries', true ); 
		}
	});

	// select country 
	$('#countries').on('change', function(){
		if($(this).val() !== ""){
			var selectedRegion = $('#region :selected').val();
			offonInputs('#currency', false);
			var costValues = getValues($(this).val(), selectedRegion, $(this).find('option:selected').text());
			
			product.price = costValues[0];
			product.country = costValues[4];
			product.provision = costValues[3];
			product.currency = "US";

			productx3.price = costValues[1];
			productx3.country = costValues[4];
			productx3.provision = costValues[3];
			productx3.currency = "US";

			productx6.price = costValues[2];
			productx6.country = costValues[4];
			productx6.provision = costValues[3];
			productx6.currency = "US";

			console.log(product, productx3, productx6);
			contentUpdate();

			var array = $.map(product, function(value, index) {
			    return [value];
			});
			$('.product1Price').val(product.price);
			$('.product1Currency').val(product.currency);
			$('.product1Provision').val(product.provision);
			$('.product1Country').val(product.country);

			$('.product2Price').val(productx3.price);
			$('.product2Currency').val(productx3.currency);
			$('.product2Provision').val(productx3.provision);
			$('.product2Country').val(productx3.country);

			$('.product3Price').val(productx6.price);
			$('.product3Currency').val(productx6.currency);
			$('.product3Provision').val(productx6.provision);
			$('.product3Country').val(productx6.country);


		}else{ offonInputs('#currency', false); }

	});

 
 	$('#currency').on('change', function(){
 		var price1 = product.price;


		// var aa1 =  $(this).data("old", $(this).data("new") || "");
  //       var a1 =   $(this).data("new", $(this).val());
       
  //       var aa11 = aa1.data("old");
  //       var aa22 = a1.data("new");

  //       var aawas = getCurrency(aa11); 
  //       var aawas1 = getCurrency(aa22); 

  //       product.price = product.price + aawas1;
  //       if(!isNaN(aawas)){
  //       	product.price = product.price - aawas;
  //       }

 	// 	if($(this).val() == 'dollar'){

 	// 	}

		// product.price = 	convertingPrices(product.price,$(this).val());
		// productx3.price = 	convertingPrices(productx3.price,$(this).val());		
		// productx6.price = 	convertingPrices(productx6.price,$(this).val());
		// contentUpdate();



	});




 	// function submitDataApi(data){
 	// 	$.ajax({
 	// 		url:'../payments/',
 	// 		method: "POST",
 	// 		data:data
 	// 	}successfunction(){

 	// 	})
 	// }




	function productsItems(){	
		if(!products.length == 0){
			product11 = product.price; 
			product12 = products.length * product11;
			$('.items_').text(product12);	
		}
	}

	function productNum(){
		$('.number_produtcs').css('display','inline-table');
		$('.number_produtcs l').text(products.length);
	}

	function countProdutcs(){

		if(!products.length == 0){
			product1 = product12;
			product2 = product12 * 3;
			product3 = product12 * 6;

			$('.produtcs_prices').text(product1);
			$('.produtcs_prices1').text(product2);
			$('.produtcs_prices2').text(product3);
			$('.produtcs_prices3').text(product1);	
		}
	}

	function arrToUl(arr) {
	  var div = $('#myList ul');
	  var html = "";

	  for (var i = 0; i < arr.length; i++) {
	  	var list = arr[i];

	  	html += "<li>"+ 
	  	"<img src='/wp-content/themes/homeTheme/img/single-product.png' class='product_img_small'>" +
	  	"<div class='product_infos_'>"+
	  	"<p>"+list.name+"</p>"+
	  	"<p>Price: $<span>"+list.price+"</span></p>"+
	  	"<p>Quantity: <span>1</span></p>"+ 
	  	"</div>"+
	  	"</li>";
	  }
	  $(div).html(html);
	}

	function arrSmall(arr){
	  var div = $('#smallitems ul');
	  var html = "";

	  for (var i = 0; i < arr.length; i++) {
	  	var list = arr[i];
	  	html += "<li><a href='#' value="+list.price+">"+list.name+"</a></li>";
	  }
	  $(div).html(html);
	}

	// $('.add_to_card').on('click', function(){
	// 	products.push(product);
	// 	productsItems();
	// 	productNum();
	// 	countProdutcs();
	// 	arrToUl(products);
	// 	arrSmall(products);
	// });


