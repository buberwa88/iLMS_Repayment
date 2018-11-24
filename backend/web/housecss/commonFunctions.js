/* ************** Summary ****************
 * File Name 			: CommonFunctions.js
 * Version 		    	: 1.0
 * Author 				: Albert Vaz
 * Description			: Client Validations
 *
 * *************************************/

/////*********************************************************************
// Sr. No.		        : 2
// Program Author      	:Shiva [892227]
// BRD/CR/Codesk No 	: WI 2245
// Date Of Change    	: 26 apr 2013
// Change Description  	: add (key == 47) || (key == 92) key code in fnAddrAlphNumericValidation() function
//*********************************************************************
/* ************** INDEX ****************
 * *************************************/
/*********************************************************************
Sr. No.		            : 3
Program Author      	: Eram
Work Item               : 1374
Date Of Change    	    : 30/04/2013 
Change Description  	: 1. Changes on NL Registrationa
********************************************************************/


var isIE = (navigator.appName=="Netscape")? false:true;

var ansiArr = [" ", "!", "@" , "#", "$", "%", "^", "*", "(", ")", "-", "_", "+", "\\", "|", "=", ":", ";", ",", ".", "<", ">", "?", "”", "{", "}", "[", "]"];
// Allowed Chars: A-Z, a-z, 0-9, -, /, \
var mCodeArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "/", "\\"];
// Allowed Chars: A-Z, a-z, 0-9, -, ., (, )
var mNameArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", ".", "(", ")"];
// Allowed Chars: A-Z, a-z, 0-9, spaces, !,#, %, %, &, ', (, ), ., -, /, :, ;, @, [, \, ], _,  {, },
//var mDescriptionArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", " ", "!", "#", "%", "&", "'", "(", ")", ".", "-", "/", ":", ";", "@", "[", "\\", "]", "_",  "{", "}"];
//changes by mukesh 
var mNameCheckArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "-", ".", "(", ")"];

var mDescriptionArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "'", ".", "-", "/", ";", "_" , "&", "(", ")", ","];
// Allowed Chars: A-Z, a-z, 0-9, spaces, &, (, ), ,, ., -, /, :, ;, [, \, ], _, {, },
var mAddressArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", ".", "(", ")",","];
// Allowed Chars: 0-9, -, +, /
var mPhFaxPgMobArr = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-", "+", "/"];
// Allowed Chars: 0-9, .
var mAmountArr = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "."];
var mIntegerArr= ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
// Allowed Chars: A-Z, a-z
var mAlphaArr = [" ", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "/", "-", "(", ")"];
// Allowed Chars: A-Z, a-z, 0-9
var mAlphanumericArr  = mAlphaArr.concat(mAmountArr);
// Allowed Chars: A-Z, a-z, 0-9, _, -, @
var mPasswordArr = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "_", "-", "@"];

var arrMonths = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];

function fnCompareFromDate(strEndDate, strStartDate)
{     
    var arrStartDate = strStartDate.split('-');
    var arrEndDate = strEndDate.split('-');
    var intStartMonth = 0;
    var intEndMonth = 0;
    
    for(var i = 0; i < arrMonths.length; i++)
    {
        if(arrStartDate[1].toUpperCase() == arrMonths[i].toString())
        {
            intStartMonth = i + 1;
            break;
        }
    }
    
    for(var i = 0; i < arrMonths.length; i++)
    {
        if(arrEndDate[1].toUpperCase() == arrMonths[i].toString())
        {
            intEndMonth = i + 1;
            break;
        }
    }
    
    if(parseInt(arrStartDate[2], 10) > parseInt(arrEndDate[2], 10))
    {
        alert('To date must be greater than or equal to From date');
        return false;
    }
    
    if((parseInt(arrStartDate[2], 10) == parseInt(arrEndDate[2], 10)) && (parseInt(intStartMonth, 10) > parseInt(intEndMonth, 10)))
    {
        alert('To date must be greater than or equal to From date');
        return false;
    }
    
    if((parseInt(arrStartDate[2], 10) == parseInt(arrEndDate[2], 10)) && (parseInt(intStartMonth, 10) == parseInt(intEndMonth, 10)) && (parseInt(arrStartDate[0], 10) > parseInt(arrEndDate[0], 10)))
    {
        alert('To date must be greater than or equal to From date');
        return false;
    }
    return true;
}

function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function fnPopulateDropDownList(strObjId, arrList)
{
    var obj = document.getElementById(strObjId);
    if (obj != null)
    {
        obj.length = arrList.length;
        for(var i=0;i<arrList.length;i++)
        {
            obj[i].value = arrList[i].split('|')[0];
            obj[i].text = arrList[i].split('|')[1];
        }
        obj.selectedIndex = 0;
    }
}

//return ###,###,###
function FormatAmount(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
//    while (rgx.test(x1)) {
//	    x1 = x1.replace(rgx, '$1' + ',' + '$2');
//    }
    return CommaFormatted(x1) + x2;
}

//##,##,##,###
function CommaFormatted(amount)
{
    var delimiter = ","; // replace comma if desired
    var a = amount.split('.',2)
    var d = a[1];;
//    if(a.length > 1)
//        d = a[1];
//    else
//        d = '00';
    var i = parseInt(a[0]);
    if(isNaN(i)) { return ''; }
    var minus = '';
    if(i < 0) { minus = '-'; }
    i = Math.abs(i);
    var n = new String(i);
    var a = [];
    var j = 0;
    while((j == 0 && n.length > 3) || (j > 0 && n.length > 2))
    {
        var nn;
        if(j == 0)
            nn = n.substr(n.length-3);
        else
            nn = n.substr(n.length-2);
        a.unshift(nn);
        if(j == 0)
            n = n.substr(0,n.length-3);
        else
            n = n.substr(0,n.length-2);
        
        j++;
    }
    if(n.length > 0) { a.unshift(n); }
    n = a.join(delimiter);
    if(d == null || d == 'undefined' || d == '' || d.length < 1) { amount = n; }
    else { amount = n + '.' + d; }
    amount = minus + amount;
    return amount;
}


function fnEmailValidation1(mObj)
{

	var emailID = mObj.value;
	if (emailID != "")
	{
		//var mailPat = new RegExp("^[a-zA-Z0-9]{1,}[.]{0,}[_]{0,}[a-zA-Z0-9]{1,}[@][a-zA-Z0-9]{1,}[.][a-zA-Z0-9]{2,}[.]{0,}[a-zA-Z0-9]{0,}$")
		var mailPat = new RegExp(/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9])+(\.[a-zA-Z0-9_-]+)+$/);
		if(!mailPat.test(emailID))
		{
			mObj.focus();
			return false;
		}
	}
	return true;
}

function fnAddressValidation(obj,lblErr)
{
    var pattern1 = /\s{2,}/g;
    
   // var pattern2 = /[A-za-z]{3,}/;

   var pattern2 = /(.)\1\1/;
    var pattern3 = /^\s/;
    var pattern4 = /^[^A-Z0-9]/;
    var pattern5 = /\s[-]/g;
    var pattern51 = /[-]\s/g;
    var pattern6 = /\s[\']/g;
    var pattern61 = /[\']\s/g;
    var pattern62 = /[^A-za-z][\']/g;
    var pattern63 = /[\'][^A-za-z]/g;
    var pattern64 = /[\']$/g;
    var pattern71 = /[^A-za-z0-9)][,]/g;
    var pattern72 = /[,][^\s]/g;
    var pattern8 = /^.\s/;
         
    var lblError = document.getElementById(lblErr);
    if(lblError == null)
    {
        lblError = lblErr;
    }
    lblError.style.display="none";
    
    if(obj.value.search(pattern1) > -1)
    {
        //lblError.innerHTML = 'Invalid: two spaces together';
        obj.value = obj.value.replace(pattern1,' ');
    }


    //Comment by shiva [892227] wino:-2245 
    //In Address Line1,2& 3 online system should accept same Alphabets/numbers in continuity. 
    

            //    if (obj.value.search(pattern2) > -1)
            //    {
            //        lblError.innerHTML = 'Invalid: three identical characters must not be together';
            //        lblError.style.display = '';
            //        return false;
            //    }
            //    else if(obj.value.search(pattern3) > -1)
            //    {
            //        lblError.innerHTML = 'Invalid: first character must not be a space';
            //        lblError.style.display = '';
            //        return false;
            //    }

    //End by shiva wino:-2245 

    if(obj.value.search(pattern3) > -1)
    {
        lblError.innerHTML = 'Invalid: first character must not be a space';
        lblError.style.display = '';
        return false;
        }




    // Comment By shiva [892227] on 26 apr 2013 wino:-2245
                //Code should be Accept 1st character must be an upper case

            //    else if(obj.value.search(pattern4) > -1)
            //    {
            //        lblError.innerHTML = 'Invalid: first character is must be an upper case letter';
            //        lblError.style.display = '';
            //        return false;
                //    }

    //End Comment By shiva [892227] on 26 apr 2013




    else if(obj.value.search(pattern5) > -1 || obj.value.search(pattern51) > -1 )
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after a hyphen';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern6) > -1)
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern61) > -1)
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern62) > -1)
    {
        lblError.innerHTML = 'Invalid: apostrophe must follow a character';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern63) > -1 || obj.value.search(pattern64) > -1 )
    {
        lblError.innerHTML = 'Invalid: character must follow an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern71) > -1)
    {
        lblError.innerHTML = 'Invalid: comma must immediately follow a character';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern72) > -1)
    {
        lblError.innerHTML = 'Invalid: comma must be followed by a space';
        lblError.style.display = '';
        return false;
    }
  
    //alert("Ouuuuuuut");
    return true;
}
function fnNameValidation(obj,lblErr)
{
    var pattern1 = /\s{2,}/g;
    //var pattern2 = /[A-za-z]{3,}/;
    var pattern2 = /(.)\1\1/;
    var pattern3 = /^\s/;
    var pattern4 = /^[^A-Z0-9]/;
    var pattern5 = /\s[-]/g;
    var pattern51 = /[-]\s/g;
    var pattern6 = /\s[\']/g;
    var pattern61 = /[\']\s/g;
    var pattern62 = /[^A-za-z][\']/g;
    var pattern63 = /[\'][^A-za-z]/g;
    var pattern64 = /[\']$/g;
    var pattern71 = /[^A-za-z0-9)][,]/g;
    var pattern72 = /[,][^\s]/g;
    var pattern8 = /^.\s/;
         
    var lblError = document.getElementById(lblErr);
    if(lblError == null)
    {
        lblError = lblErr;
    }
    lblError.style.display="none";
    
    if(obj.value.search(pattern1) > -1)
    {
        //lblError.innerHTML = 'Invalid: two spaces together';
        obj.value = obj.value.replace(pattern1,' ');
    }
    
    if (obj.value.search(pattern2) > -1)
    {
        lblError.innerHTML = 'Invalid: three identical characters must not be together';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern3) > -1)
    {
        lblError.innerHTML = 'Invalid: first character must not be a space';
        lblError.style.display = '';
        return false;
    }
    //      ************ Eram :3.1- start .(Changes on NL Registration)
    else if(obj.value.search(pattern4) > -1 && (obj.id!='ctl00_ContentPlaceHolder1_txtLastNameReg' && obj.id!='ctl00_ContentPlaceHolder1_txtFirstNameReg') )
    {
        lblError.innerHTML = 'Invalid: first character is must be an upper case letter';
        lblError.style.display = '';
        return false;
    }
    //      ************ Eram :3.1- end .(Changes on NL Registration)
    else if(obj.value.search(pattern5) > -1 || obj.value.search(pattern51) > -1 )
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after a hyphen';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern6) > -1)
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern61) > -1)
    {
        lblError.innerHTML = 'Invalid: No space allowed before or after an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern62) > -1)
    {
        lblError.innerHTML = 'Invalid: apostrophe must follow a character';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern63) > -1 || obj.value.search(pattern64) > -1 )
    {
        lblError.innerHTML = 'Invalid: character must follow an apostrophe';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern71) > -1)
    {
        lblError.innerHTML = 'Invalid: comma must immediately follow a character';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern72) > -1)
    {
        lblError.innerHTML = 'Invalid: comma must be followed by a space';
        lblError.style.display = '';
        return false;
    }
    else if(obj.value.search(pattern8) > -1)
    {
        lblError.innerHTML = 'Invalid: second character must not be a space';
        lblError.style.display = '';
        return false;
    }
    //alert("Ouuuuuuut");
    return true;
}
function fnAddrAlphNumericValidation(e)
{ 
    var key;
    var keychar;

    if (window.event)
       key = window.event.keyCode;
    else if (e)
       key = e.which;
    else
       return true;
    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();

    // control keys

    //wino:- 2245 --this two key code charector added by shiva on 26 apr 2013 (key==47) and (key==92) to allow in Addr1,Addr2,Addr3 
    //In Address Line1,2& 3 online system should allow the user to enter “/” & “\” 
     
    if ((key==null) || (key==0) || (key==8) ||
        (key == 9) || (key == 13) || (key == 27) || (key == 47) || (key == 92))
       return true;

    // alphas and numbers//
    else if ((("abcdefghijklmnopqrstuvwxyz0123456789,#()'!.- ").indexOf(keychar) > -1))
       return true;
    else
       return false;
}

function CalculateAge(bDay)
{
    now = new Date()
    bD = bDay.value.split('/');
    if(bD.length==3)
    {
        born = new Date(bD[2], bD[1]*1-1, bD[0]);
        years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
        return years;
    }
}

function fnCheckDateFormat(input, objID, ErrorMsg)
{
    var obj = document.getElementById(objID);
    obj.style.display = 'none';
    if(input.value != '' || document.getElementById('cal_container').style.display == 'none')
    {
        var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
        var returnval=false;
        txtDOB = input;

        if (!validformat.test(input.value))
        {
            if(document.getElementById('tblCal') == null || document.getElementById('tblCal').style.display == 'none' || document.getElementById('cal_container').style.display == 'none' )
                setTimeout("txtDOB.focus();", 1);
	        obj.innerHTML = ErrorMsg;
	        obj.style.display = '';
	    }
        else
        { //Detailed check for valid date ranges
	        var dayfield=input.value.split("/")[0]
	        var monthfield=input.value.split("/")[1]
	        var yearfield=input.value.split("/")[2]
	        var dayobj = new Date(yearfield, monthfield-1, dayfield)

	        if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
	        {
	            if(document.getElementById('tblCal') == null || document.getElementById('tblCal').style.display == 'none' || document.getElementById('cal_container').style.display == 'none' )
	                setTimeout("txtDOB.focus();", 1);
		        obj.innerHTML = ErrorMsg;
		        obj.style.display = '';
		    }
	        else
		        returnval=true
        }
    }
    return true;
}