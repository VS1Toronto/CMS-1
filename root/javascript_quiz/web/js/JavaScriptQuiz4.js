/**
 * Created by Allegiance on 02/12/14.
 */

var fname, lname, gender, country, nation;
function function_(x)
{
    return document.getElementById(x);
}

/*function_(x)
{
    return document.getElementById(x);
}
*/
function processPhase1()
{
    firstword = _("firstword").value;
    secondword = _("secondword").value;
    if(firstword.length > 9 && secondword.length > 8){
        _("phase1").style.display = "none";
        _("phase2").style.display = "block";
        _("progressBar").value = 33;
        _("status").innerHTML = "Phase 2 of 3";
    }
    else
    {
        WrongAnswer();
    }
}


function processPhase2()
{
    question2 =_("question2").value;
    if(question2.length > 10){
        _("phase2").style.display = "none";
        _("phase3").style.display = "block";
        _("progressBar").value = 66;
        _("status").innerHTML = "Phase 3 of 3";
    }
    else
    {
        WrongAnswer();
    }
}


function processPhase3()
{
   question3 =_("question3").value;
   if(question3.length > 10){
       _("phase3").style.display = "none";
       _("show_all_data").style.display = "block";
       _("progressBar").value = 100;
       _("display_firstword").innerHTML = firstword;
       _("display_secondword").innerHTML = secondword;
       _("display_question2").innerHTML = question2;
       _("display_question3").innerHTML = question3;
       _("status").innerHTML = "Data Overview";
   }
   else
   {
       WrongAnswer();
   }
}



function WrongAnswer()
{
    audio = new Audio();
    audio.src = "audio/InputAlgorithmNotAccepted.mp3";
    audio.play();
}

function bonusLevelDelay()
{
    setTimeout("bonusLevel()", 6000);
}


function ShowButtons3()
{
    audio = new Audio();
    audio.src = "audio/Door/TransferOfDataComplete.mp3";
    audio.play()
    document.getElementById("HelpButton4").style.visibility = "visible";
    document.getElementById("RestartButton4").style.visibility = "visible";
}


function JavaScriptQuiz4Help()
{
    parent.location="JavaScriptQuiz4Help.html";
}


function JavaScriptQuiz4RestartTest()
{
    parent.location="JavaScriptQuiz4.html";
}



function bonusLevel()
{
    parent.location="BonusLevel.html";
}



