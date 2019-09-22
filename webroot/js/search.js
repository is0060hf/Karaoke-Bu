function clearSearchElementsInSeikyuu(){
	document.getElementById( "deliveryman_name" ).selectedIndex = 0;
	document.getElementById( "customers_name" ).selectedIndex = 0;
	document.getElementById( "delivery_dest" ).selectedIndex = 0;
	document.getElementById( "appendix" ).value = "" ;
	document.getElementById( "upper_created" ).value = "" ;
	document.getElementById( "under_created" ).value = "" ;
}

function clearSearchElementsInUser(){
	document.getElementById( "mail_address" ).value = '';
	document.getElementById( "role" ).selectedIndex = 0;
}

function clearEventSearchElements() {
	document.getElementById("mail_address").value = '';
	document.getElementById("region").selectedIndex = 0;
	document.getElementById("prefecture").selectedIndex = 0;
}
