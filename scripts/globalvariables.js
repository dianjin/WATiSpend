var aDates;
var aCosts;

var dolFlex = 0;
var dolMeal = 0;
var dolBal = 0;
var dolSpent = 0;
var dolSuggest = 0;

var avgPerWeek = 0;
var avgPerDay = 0;

var numHistory = 13; // User views history 14 days ago from today.


// Current date: lol
var datToday = new Date();

// Start date: Always two weeks ago from current date.
var datStart = new Date();
datStart.setDate(datStart.getDate() - numHistory); // 8 
datStart.setHours(0);
datStart.setMinutes(31);
datStart.setSeconds(0);

// End date: The day the term ends. (Hardcoded lol)
var datEnd = new Date();
datEnd.setMonth(3); // April
datEnd.setDate(25); // 25
datEnd.setYear(2015)

var numDays = dayDiff(datToday, datEnd);


function dayDiff(start, end) {
	return Math.round(Math.abs((start.getTime() - end.getTime())/(24*60*60*1000)));
}