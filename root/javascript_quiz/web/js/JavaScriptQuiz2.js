/**
 * Created by Allegiance on 02/12/14.
 */

var buttonCount = 0;
var correctCount = 0;
var wrongCount = 0;
var totalScore = 0;
text2display = "";

function sayTrue()
{
    JavaScriptQuiz2Quiz.answersBox.value = text2display = text2display + "Correct 25%";
    buttonCount++
    correctCount++
    totalScore++

    if(buttonCount == 4)
        JavaScriptQuiz2Quiz.answersBox.value = text2display = "Total Score  " + correctCount*25 +"%" ;


    if(buttonCount == 4)
    {
        ShowButtons2()
    }

}

function sayFalse()
{
    JavaScriptQuiz2Quiz.answersBox.value = text2display = text2display + "Wrong 0%";
    buttonCount++
    wrongCount++
    totalScore++

    if(totalScore == 4)
        JavaScriptQuiz2Quiz.answersBox.value = text2display = "Total Score  " + correctCount*25 +"%", totalScore++;


    if(buttonCount == 4)
    {
        ShowButtons2()
    }
}


function ShowButtons2()
{
    document.getElementById("HelpButton2").style.visibility = "visible";
    document.getElementById("RestartButton2").style.visibility = "visible";
}


function JavaScriptQuiz2Help()
{
    parent.location="JavaScriptQuiz2Help.html";
}


function JavaScriptQuiz2RestartTest()
{
    parent.location="JavaScriptQuiz2.html";
}







function sayHi()
{
    alert("hello"+ totalScore)
}