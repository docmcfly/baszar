$(document).ready(function(){
		$("input").attr('autocomplete','off');
    $("input#seller").keydown(function(e) {
		var code = e.keyCode || e.which;
		switch(code) {
		  case 9:
		  case 13: 
			if(validateSeller()) {
				$("input#amount")[0].focus();
				return false;				
			} else {
				$("input#seller")[0].focus(); 
				return false; 
			}
		  case 109: 
			$("input#cash").focus(); 
			return false; 
		}
		
		if(code === 9 || code === 13 ) {
		} 
		return true; 
	}); 	
	$("input#cash").keydown(function(e) {
		var code = e.keyCode || e.which;
		switch(code) {
		  case 9:
		  case 13: 
		    $("button#book")[0].focus(); 
		    return false; 
		}
		return true; 
	});

	$("input#cash").change(function(e) {
		refreshRefund(); 
	});
	
	$("input#amount").keydown(function(e) {
		var code = e.keyCode || e.which;
		switch(code) {
		  case 9:
		  case 13: 
		    addEntry();
		    return false; 
		  case 109: 
			$("input#cash").focus(); 
			return false; 
		}
		return true; 
	});
	$("button#enter").click(function(e) {
		var o = e.target ; 
		if(o.id == "enter") {
			addEntry();
	        return false;				
		} else {
		    removeEntry(o); 
	        return false;				
		}
	}); 
	$("button#enter").keypress(function(e) {
		var o = e.target; 
		var code = e.keyCode || e.which;
		if(code === 9 || code === 13 ) {
			if(o.id == enter) {
				addEntry();
				return false;				
 
			} else {
			    removeEntry(o); 
			    return false; 
			}
		}
	});
	$("button#booking").click(function(e) {	
		 sendVoucher();
		 return false; 
	}); 
	
	$("button#booking").keypress(function(e) {
		var o = e.target; 
		var code = e.keyCode || e.which;
		if(code === 9 || code === 13 ) {
			sendVoucher(); 
			return false; 
		}
	}); 
	refreshSum();
	$("input#seller").focus();
});

function sendVoucher(){
	var x = $("form");
	var y = x.serialize();
	$.post('/booking.php', y, function(rd) {
		$("#debug").text("out:"+rd);
	});
}


function removeEntry(o){
	$(o.parentElement.parentElement).remove(); 
	refreshSum();
}


function addEntry() {
	if(validateEntry()){
		addRow();
		refreshAmount();
		$("input#seller")[0].focus();
		return true; 
	} 
	return false; 
}

function validateEntry(){
	return validateSeller() && validateAmount();
}

function validateAmount(){
	var result = true; 
	var inputAmount = $("input#amount");
	var ia = inputAmount[0];
	var min = parseFloat(ia.min);
	var max = parseFloat(ia.max);
	var amount = parseFloat(ia.value); 
	if(isNaN(amount) || amount < min || amount > max ){
		inputAmount.addClass("error"); 
		ia.title = t_valid_amount_from_until.replace("{1}", min).replace("{2}",max);
		result = false; 
	} else {
		inputAmount.removeClass("error"); 
	}
	return result; 
}


function validateSeller(){
	var result = true; 
	var inputSeller = $("input#seller");
	var is = inputSeller[0];
	var min = parseInt(is.min);
	var max = parseInt(is.max);
	var seller = parseInt(is.value); 
	if(isNaN(seller) || seller < min || seller > max || is.value != seller ){
		inputSeller.addClass("error"); 
		
		
		is.title = t_valid_seller_from_until.replace("{1}", min).replace("{2}",max); 
		result = false; 
	} else {
		inputSeller.removeClass("error"); 
	}
	return result; 
}

function addRow(){
	var table = $("form div.table"); 
	var firstRow = $("form div.table div.tr.entry:first"); 
	var clone = firstRow.clone(true); 
	var idx = firstRow.attr("id"); 
	clone.attr("id", parseInt(idx) + 1) ; 
	
	clone.find("input").each(function(){
		this.value = "" ; 
	});
	
	firstRow.before(clone);
	var spaceRow = $("form div.table div.tr.space");
	spaceRow.after(firstRow); 
	firstRow.find("input").each(function(){
		var o = this; 
		var e = $(o); 
		e.attr("readonly","true");
		e.addClass(	o.id) ; 
		e.addClass("set" ); 
		e.removeClass("input"); 
		e.attr("id",  o.id +"["+idx+"]") ; 
		e.attr("name",  o.id ); 
		if(e.hasClass("amount")){
			o.value = parseFloat(o.value).toFixed(2).toString().replace(".",",");
		} 
		if(e.hasClass("seller")){
			o.value = parseInt(o.value);
		} 
		// +"["+idx+"]") ; 
	}); 
	var b = firstRow.find("button")
	b.text(t_remove); 
	b.attr("id", "remove"); 
	
	
	firstRow.find("div.td").each(function(){
		 $( this ).add("div").append( getDisplayValue( $( this ))); 
	}); 
	clone.find("input#seller")[0].focus(); 
	refreshSum(); 
}; 

function refreshAmount(){
	$("form div.table div.tr.entry input.set.amount").each(function(){
		var x = parseFloat(this.value);
		var y = x.toFixed(2);
		var z = y.toString();
		var a = z.replace(".",",");
		this.value =  a;
	});
}


function refreshSum(){
	var sum = 0.0; 
	$("form div.table div.tr.entry input.set.amount").each(function(){
		var v = parseFloat(this.value); 
		sum += isNaN(v) ? 0 : v;
	});  
	var s = $("form div.table div.tr.subtotal input#subtotal"); 
	s[0].value =sum.toFixed(2);
	refreshRefund();
}


function refreshRefund(){
	var sv = $("form div.table div.tr.subtotal input#subtotal")[0].value;
	var s = parseFloat( isNaN(sv) ? "0" : sv);
	var cv = $("form div.table div.tr.cash input#cash")[0].value;
	var c = parseFloat( isNaN(cv) ? "0" : cv ); 
	var r = $("form div.table div.tr.refund input#refund")[0]; 
	if( c > 0 ){
		r.value = (c - s).toFixed(2).toString().replace(".",","); 
	 } else {
		 r.value = "0,00"; 
	 }
}

function getDisplayValue(obj){
	var x = obj.find("input[type=hidden]:first");
	if(x == null || x.length == 0){
		return ""; 
	}
	var fixed = x[0].id.startsWith("seller") ? 0 : 2; 
	var v = x[0].value; 
	if( v == null || v == ""){
		v =  "0,00"; 
	} 
	return String(parseFloat(v).toFixed(fixed)).replace(".", ","); 
	
}


function sha256(str) {
  // We transform the string into an arraybuffer.
  var buffer = new TextEncoder("utf-8").encode(str);
  return crypto.subtle.digest("SHA-256", buffer).then(function (hash) {
    return hex(hash);
  });
}

function hex(buffer) {
  var hexCodes = [];
  var view = new DataView(buffer);
  for (var i = 0; i < view.byteLength; i += 4) {
    // Using getUint32 reduces the number of iterations needed (we process 4 bytes each time)
    var value = view.getUint32(i)
    // toString(16) will give the hex representation of the number without padding
    var stringValue = value.toString(16)
    // We use concatenation and slice for padding
    var padding = '00000000'
    var paddedValue = (padding + stringValue).slice(-padding.length)
    hexCodes.push(paddedValue);
  }

  // Join all the hex strings into one
  return hexCodes.join("");
}
