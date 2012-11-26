function validateCheckout()
{
	var sfName = document.getElementById("sfName").value;
	var slName = document.getElementById("slName").value;
	var shouseNum = document.getElementById("shouseNum").value;
  	var sstreet = document.getElementById("sstreet").value;
 	var scity = document.getElementById("scity").value;
  	var sstate = document.getElementById("sstate").value;
  	var szip = document.getElementById("szip").value;
  	var bfName = document.getElementById("bfName").value;
	var blName = document.getElementById("blName").value;
	var bhouseNum = document.getElementById("bhouseNum").value;
  	var bstreet = document.getElementById("bstreet").value;
 	var bcity = document.getElementById("bcity").value;
  	var bstate = document.getElementById("bstate").value;
  	var bzip = document.getElementById("bzip").value;
  	if (sfName==null || sfName=="" || slName==null || slName=="" ||
  		shouseNum==null || shouseNum=="" || sstreet==null || sstreet=="" ||
  		scity==null || scity=="" || sstate==null || sstate=="" ||
  		szip==null || szip=="" || 
  		bfName==null || bfName=="" || blName==null || blName=="" ||
  		bhouseNum==null || bhouseNum=="" || bstreet==null || bstreet=="" ||
  		bcity==null || bcity=="" || bstate==null || bstate=="" ||
  		bzip==null || bzip=="")
  	{
  		alert("Entire Form Must Be Filled Out");
  		return false;
  	}
  	return true;
}

function validateRegister() 
{
	var fname=document.getElementById("fName").value;
	var lname=document.getElementById("lName").value;
	var housenum=document.getElementById("houseNum").value;
	var street=document.getElementById("street").value;
	var city=document.getElementById("city").value;
	var state=document.getElementById("state").value;
	var zip=document.getElementById("fName").value;
	var password1=document.getElementById("password").value;
	var password2=document.getElementById("password2").value;
	if (fname==null || fname=="" || lname==null || lname == "" ||
		housenum==null || housenum == "" ||
		street==null || street=="" || city==null || city == "" ||
		state==null || state=="" || zip==null || zip == "" ||
		password1==null || password1=="" || password2==null || password2 == "")
	  {
	  alert("Entire Form Must Be Filled Out");
	  return false;
	  }

	var email=document.forms["register_form"]["email"].value;
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
	  {
	  alert("Must Have Valid Email");
	  return false;
	  }
	return true;
}