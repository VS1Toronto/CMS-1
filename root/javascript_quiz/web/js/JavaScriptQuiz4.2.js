/**
 * Created by Allegiance on 03/12/14.
 */


var audio;

function Door1(){
    audio = new Audio();
    audio.src = "audio/Door/levelnineauthorizationrequired.mp3";
    audio.play();
}

function Door2(){
    audio = new Audio();
    audio.src = "audio/Door/cargobay.mp3";
    audio.play();
}

function AccessDeniedAway() {
    document.getElementById("DoorAccessDenied").style.visibility = "hidden";
}

function AccessGrantedAppear() {
    document.getElementById("DoorAccessGranted").style.visibility = "visible";
}

