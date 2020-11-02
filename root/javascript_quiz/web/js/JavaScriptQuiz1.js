/**
 * Created by Allegiance on 02/12/14.
 */



var buttonCount = 0;
var correctCount = 0;
var finalCount = 0;

var text2display = "";
var answers = new Array(4);
    answers[0] = "1. A dynamic computer programming language";
    answers[1] = "2. Livescript";
    answers[2] = "3. Netscape";
    answers[3] = "4. It was a marketing ploy to give customers a good impression of it";

var questions = new Array(4);
    questions[0] = "q1";
    questions[1] = "q2";
    questions[2] = "q3";
    questions[3] = "q4";



function checkQs(s)
{
        var qs = document.getElementsByName(s);
        var noOfRadios = qs.length;
        var percent = 0;

        for(var i = 0; i < noOfRadios; i++)
        {
                if(qs[i].checked)
                {
                text2display = "";
                if(qs[i].value =="correct")
                    percent = percent + 25 , text2display = "You got that correct!" + "     "  + percent  + "%", correctCount++;
                else
                    if(qs[i].value =="wrong") text2display = "Incorrect" + answers[questions.indexOf(s)] + "     0" + "%"+ text2display;
                    break;
                }
        }
}


function checkAll()
{
    for(var i = 0; i < questions.length; i++)
    {
        checkQs(questions[i]);
    }
    buttonCount++
    JavaScriptQuiz1Quiz.answersBox.value = text2display;

    if(correctCount == 0)
        finalCount = 0;
    else
        if(correctCount == 1)
            finalCount = 25;
        else
            if(correctCount == 2)
                finalCount = 50;
            else
                if(correctCount == 3)
                    finalCount = 25;
                else
                    if(correctCount == 4)
                        finalCount = 25;
                    else
                        if(correctCount == 5)
                            finalCount = 50;
                        else
                            if(correctCount == 6)
                                finalCount = 75;
                            else
                                if(correctCount == 7)
                                    finalCount = 50;
                                else
                                    if(correctCount == 8)
                                        finalCount = 50;
                                    else
                                        if(correctCount == 9)
                                            finalCount = 75;
                                        else
                                            if(correctCount == 10)
                                                finalCount = 100;

    if(buttonCount == 4)
    {
        JavaScriptQuiz1Quiz.answersBox.value = text2display = "Total Score  " + finalCount +"%";

        ShowButtons();
    }

}





function ShowButtons()
{
    document.getElementById("HelpButton1").style.visibility = "visible";
    document.getElementById("RestartButton1").style.visibility = "visible";
}



function JavaScriptQuiz1Help()
{
    parent.location="JavaScriptQuiz1Help.html";
}


function JavaScriptQuiz1RestartTest()
{
    parent.location="JavaScriptQuiz1.html";
}




function sayHello()
{
    alert("hello" + correctCount);
}


