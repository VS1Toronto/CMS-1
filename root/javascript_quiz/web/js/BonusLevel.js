/**
 * Created by Allegiance on 03/12/14.
 */

var buttonCount = 0;
var correctCount = 0;
var wrongCount = 0;




text2display = "";


function sayTrue()
{
    StarTrekQuiz.answersBox.value = text2display = text2display + "Correct";
    buttonCount++
    correctCount++
    if( buttonCount > 11)
    {
        StarTrekQuiz.answersBox.value = text2display = "Total Score  " + correctCount +" out of 12";
        ShowButtons3();
    }
}

function sayFalse()
{
    StarTrekQuiz.answersBox.value = text2display = text2display + "Wrong";
    buttonCount++
    wrongCount++
    if( buttonCount > 11)
    {
        StarTrekQuiz.answersBox.value = text2display = "Total Score  " + correctCount +" out of 12";
        ShowButtons3();
    }
}


function ShowButtons3()
{
    audio = new Audio();
    audio.src = "audio/TransferComplete.mp3";
    audio.play()
    document.getElementById("HelpButton4").style.visibility = "visible";
    document.getElementById("RestartButton4").style.visibility = "visible";
}


function StarTrekHelp()
{
    parent.location="BonusLevelHelp.html";
}


function RestartStarTrekTest()
{
    parent.location="BonusLevel.html";
}




function sayHi()
{
    alert("hello"+ buttonCount);
}

