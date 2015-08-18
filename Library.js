/*
	JavaScript Function Libaray.
	Author:  Michael Neely, Joey Moloney March-April 2015
	Copyright Michael Neely and Joey Moloney 2015 All Rights Reserved
	This software is the proprietary property of Michael Neely and Joey Moloney
	You may not distribute or disclose the source code, or use this documentation to reengineer the library.
	
	List of functions:
		-Countdown (for error and success messages)
		-Form validators
		
		
	
*/

//Counts down from ten to 0
//used for redirect countdowns
(function countdown(){
	var timeLeft = 10, cinterval;
	var timeDec = function (){
		timeLeft--;
		document.getElementById('countdown').innerHTML = timeLeft;
		if(timeLeft === 0){
			clearInterval(cinterval);
		}
	};
	cinterval = setInterval(timeDec, 1000);
})();

function validate_gaffs_contact_form(){
	var title = document.forms["contactgaffs"]["title"].value;
	var message = document.forms["contactgaffs"]["message"].value;
	var category = document.forms["contactgaffs"]["category"].selectedIndex;
	var errors = "There were errors in the form submission: \n";
	var can_submit = true;
	if (title.length <10)
	{
		errors += "-title must be at least 10 characters.\n";
		can_submit = false;
	}
	if (message.length < 50)
	{
		errors += "-message must be at least 50 characters.\n";
		can_submit = false;
	}
	if (category == 0)
	{
		errors += "-you must select a category.\n";
		can_submit = false;
	}
	if (can_submit)
	{
		return true;
	}
	else
	{
		alert(errors);
		return false;
	}
}
function validate_contact_poster(){
	var email = document.forms["contactposter"]["senderemail"].value;
	var message = document.forms["contactposter"]["message"].value;
	var category = document.forms["contactposter"]["category"].selectedIndex;
	var errors = "There were errors in the form submission: \n";
	var can_submit = true;
	if (email.length < 10)
	{
		errors += "-Email address must be at least 10 characters\n";
		can_submit = false;
	}
	if (email.indexOf("@") == -1)
	{
		errors += "-Email address must contain an '@' symbol\n";
		can_submit = false;
	}
	if (email.indexOf(".") == -1)
	{
		errors += "-Email address must contain a '.' symbol\n";
		can_submit = false;
	}
	if (message.length < 50)
	{
		errors += "-message must be at least 50 characters.\n";
		can_submit = false;
	}
	if (can_submit)
	{
		return true;
	}
	else
	{
		alert(errors);
		return false;
	}
}
