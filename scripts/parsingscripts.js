// This script parses the transact history page.
// Generates [arrDate, arrMoney]
// EDIT dSTART!!!

function strip(html)
{
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}

function parseBalance(sBalance) {
	var s;
	var rawString = strip(sBalance);
	rawString = rawString.trim();
	var firstCut = rawString.indexOf("Normal");
	
	s = rawString.slice(firstCut+8);
	var sSub;
	
	// Scan for "MEAL"
	iMeal = s.indexOf("MEAL");
	iNorm = s.indexOf("Normal");
	while (iMeal >= 0) {
		sSub = s.substring(iMeal+26, iNorm-25);
		dolMeal += parseFloat(sSub.replace(/,/g, ''));
		s = s.slice(iNorm + 7);
		iMeal = s.indexOf("MEAL");
		iNorm = s.indexOf("Normal");

	}
	
	// Scan for "FLEX"
	iFlex = s.indexOf("FLEXIBLE");
	iNorm = s.indexOf("Normal");
	while (iFlex >= 0) {
		sSub = s.substring(iFlex+36, iNorm-25);
		dolFlex += parseFloat(sSub.replace(/,/g, ''));
		s = s.slice(iNorm + 7);
		iFlex = s.indexOf("FLEXIBLE");
		iNorm = s.indexOf("Normal");
	}

	// Scan for "TRANSFER"
	//iTrans = s.indexOf("TRANSFER MP");
	//iNorm = s.indexOf("Normal");
	//sSub = s.substring(iTrans+36, iNorm-25);

	compute();
}

function compute() {
	avgPerDay = dolSpent / numHistory;
	avgPerWeek = dolSpent / (numHistory/7);
	dolBal = dolMeal + dolFlex;
	dolSuggest = dolBal / numDays;
}

function formatDate(myDate) {
	return myDate.toDateString().substring(0,10);
}
function precise_round(num,decimals){
    var sign = num >= 0 ? 1 : -1;
    return (Math.round((num*Math.pow(10,decimals))+(sign*0.001))/Math.pow(10,decimals)).toFixed(decimals);
}
function parseTransact(sTransact) {
	//Trim the top half the Transact history page.
	var s;
	var rawString = strip(sTransact);
	rawString = rawString.trim();
	var firstCut = rawString.indexOf("Terminal");
	s = rawString.slice(firstCut+8);

	
	// Generate arrDate, arrMoney
    var arrDate = [];
    var arrMoney = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    var startDate = new Date(datStart);
    var thisDate;
    while (startDate <= datToday) {
    	thisDate = new Date(startDate);
        arrDate.push(formatDate(thisDate));
        arrMoney.push(0);
        startDate.setDate(startDate.getDate() + 1);
    }
	        
	// Parse the text.
	var iFS; // Index of WAT-FS
	var iDate; // Diff between current date and the parsed date.
	var iSlash; // Index of slash
	var iMonEnd; // Index of bracket
	var iMonStart;
	var sSub; // Substring from Date
	var sDate; // substring fo date
	var d = new Date(); // current date
	var money;
	var parts;

	//alert(s.indexOf("WAT-FS"));
	while (s.indexOf("WAT-FS") >= 0) {
		iFS = s.indexOf("WAT-FS");
		sSub = s.substring(0, iFS);
		iSlash = sSub.lastIndexOf("/") - 5;
		sSub = sSub.substring(iSlash, sSub.length);
		sDate = sSub.substring(0,12);
		iMonEnd = sSub.indexOf("(") - 2;
		iMonStart = sSub.indexOf("-") + 1;
		money = parseFloat(sSub.substring(iMonStart, iMonEnd));
		parts = sDate.split('/');
		d.setMonth(parts[0]-1);
		d.setDate(parts[1]);
		iDate = dayDiff(datStart, d);
		arrMoney[iDate-1] += parseFloat(money);
		dolSpent += money;
		iFS = s.indexOf("WAT-FS");
		s = s.slice(iFS+6);
	}

	for (i = 0; i < arrMoney.length; i++) {
		arrMoney[i] = parseFloat(arrMoney[i]).toFixed(2);
	}

	return [arrDate, arrMoney];
}
