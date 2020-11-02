/**
 * Created by Allegiance on 06/12/14.
 */

var pos = 0, test, test_status, question, choice, choices, chA, chB, chC, correct = 0;
var questions = [
    [   "Javascript supports what that means a letter can have a value of a number?", "Dynamic Typing", "Cricket", "Boolean", "A"],
    [   "To say Javascript is almost entirely object based would be?", "An exageration", "False", "True", "C"],
    [   "Whereas many other object orientated languages use classes for inheritance javascript uses?", "Copies", "Prototypes", "Witchcraft", "B" ],
    [   "In Javascript the distinction between a function and a method occurs during?", "Loading", "The Night", "Calling", "C" ]
];
function _(x){
    return document.getElementById(x);
}
function renderQuestion(){
    test = _("test");
    if(pos >= questions.length){
         test.innerHTML = "<h2>You got "+correct+" of "+questions.length+" questions correct</h2>";
        _("test_status").innerHTML = "Test Completed";
        pos = 0;
        correct = 0;
        test.innerHTML += ""+ "<input type='button' name='1' value=' Javascript Quiz 3 Help' onclick=' JavaScriptQuiz3Help()'<br><br>";
        test.innerHTML += ""+ "<input type='button' name='2' value='Restart Javascript Quiz 3 Test' onclick=' JavaScriptQuiz3RestartTest()'>";
        return false;
    }
    _("test_status").innerHTML = "Question "+(pos+1)+" of "+questions.length;
    question = questions[pos][0];
    chA = questions [pos][1];
    chB = questions [pos][2];
    chC = questions [pos][3];
    test.innerHTML = "<h3>"+question+"</h3>";
    test.innerHTML += "<input type='radio' name='choices' value='A'> "+chA+"<br>";
    test.innerHTML += "<input type='radio' name='choices' value='B'> "+chB+"<br>";
    test.innerHTML += "<input type='radio' name='choices' value='C'> "+chC+"<br><br>";
    test.innerHTML += "<button onclick='checkAnswer()' >Submit Answer</button>";



}

function checkAnswer()
{
    choices = document.getElementsByName("choices");
    for(var i=0; i<choices.length; i++)
    {
        if(choices[i].checked)
        {
            choice = choices[i].value;
        }
    }
    if(choice == questions[pos][4]){
        correct++;
    }
    pos++;
    renderQuestion();
}

window.addEventListener("load", renderQuestion, false);





function JavaScriptQuiz3Help()
{
    parent.location=" JavaScriptQuiz3Help.html";
}


function  JavaScriptQuiz3RestartTest()
{
    parent.location="JavaScriptQuiz3.html";
}