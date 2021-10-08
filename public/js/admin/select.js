$(document).ready(function() {
// Initializing arrays with city names.

var JHS = [{
	display: "Grade 7",value: "G7"},
	{display: "Grade 8", value: "G8"},
	{display: "Grade 9",value: "G9"},
	{display: "Grade 10",value: "G10"}];
	

var ABM = [{
	display: "Grade 11",value: "G11"},
	{display: "Grade 12",value: "G12"}];

var GAS = [{
	display: "Grade 11",value: "G11"},
	{display: "Grade 12",value: "G12"}];

var HUMMS = [{
	display: "Grade 11",value: "G11"},
	{display: "Grade 12",value: "G12"}];

var STEM = [{
	display: "Grade 11",value: "G11"},
	{display: "Grade 12",value: "G12"}];
	
var BEED = [{
	display: "First Year",value: "1ST"},
	{display: "Second Year",value: "2ND"},
	{display: "Third Year",value: "3RD"},
	{display: "Fourth Year", value: "4TH"}];

var BSCS = [{
	display: "First Year",value: "1ST"},
	{display: "Second Year",value: "2ND"},
	{display: "Third Year",value: "3RD"},
	{display: "Fourth Year", value: "4TH"}];

var CRIM = [{
	display: "First Year",value: "1ST"},
	{display: "Second Year",value: "2ND"},
	{display: "Third Year",value: "3RD"},
	{display: "Fourth Year", value: "4TH"}];

var BSBA = [{
	display: "First Year",value: "1ST"},
	{display: "Second Year",value: "2ND"},
	{display: "Third Year",value: "3RD"},
	{display: "Fourth Year", value: "4TH"}];

var BSA = [{
	display: "First Year",value: "1ST"},
	{display: "Second Year",value: "2ND"},
	{display: "Third Year",value: "3RD"},
	{display: "Fourth Year",value: "4TH"},
	{display: "Fifth Year", value: "5TH"}];

var FACULTY = [{
	display: "Faculty", value: "FACULTY"}];

var GUARD = [{
	display: "Guard", value: "GUARD"}];


// Function executes on change of first select option field.
$("#department").change(function() {

var select = $("#department option:selected").val();
switch (select) {
	case "JHS":
		city(JHS);
		break;

	case "ABM":
		city(ABM);
		break;

	case "GAS":
		city(GAS);
		break;

	case "HUMMS":
		city(HUMMS);
		break;

	case "STEM":
		city(STEM);
		break;

	case "BEED":
		city(BEED);
		break;

	case "BSCS":
		city(BSCS);
		break;

	case "CCJE":
		city(CRIM);
		break;

	case "BSBA":
		city(BSBA);
		break;

	case "BSA":
		city(BSA);
		break;

	case "FACULTY":
		city(FACULTY);
		break;

	case "GUARD":
		city(GUARD);
		break;
		default:

$("#depyear").empty();
$("#depyear").append("<option>--Select--</option>");

break;}
});


// Function To List out Cities in Second Select tags
function city(arr) {
$("#depyear").empty(); //To reset cities
$("#depyear").append("<option>Select</option>");
$(arr).each(function(i) { //to list cities
$("#depyear").append("<option value=\"" + arr[i].value + "\">" + arr[i].display + "</option>")
});
}



});


