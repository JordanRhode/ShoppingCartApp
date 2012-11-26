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