function init(page) {

	// include
	switch (page) {
	case "edit_mailbox":
		// autoresonder_set_editable();
		break;
	default:
	}

	// exclude
	switch (page) {
	case "help":
	case "login":
		break;
	default:
		set_auto_logout();
	}
}

function set_auto_logout() {
//	window.setTimeout(function() {
//		window.open("index.php?action=logout", "_self")
//	}, "900000");
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

function get_today_string() {
	var today = new Date();
	var yyyy = today.getFullYear().toString();
	var mm = (today.getMonth() + 1).toString(); // getMonth() is zero-based
	var dd = today.getDate().toString();
	var result = yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-"
			+ (dd[1] ? dd : "0" + dd[0]);
	return result;
};
