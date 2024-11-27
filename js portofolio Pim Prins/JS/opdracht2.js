function leeftijdcal() {
    let geboortejaar = document.getElementById('geboortedatum').value;
    let gebo = new Date(geboortejaar).getFullYear();
    let huidigejaar = new Date().getFullYear();
    let leeftijd = huidigejaar - gebo;
    let resultaat = document.getElementById('output');

    console.log(leeftijd);
    
    if (leeftijd >= 0 && leeftijd <= 12){
        resultaat.innerText = "Je bent minder jarig."
    }
    else if (leeftijd >= 13 && leeftijd <= 17){
        resultaat.innerText = "Je bent een tiener."
    }
    else if (leeftijd >= 18){
        resultaat.innerText = "Je bent volwasse."
    }
    else {
        resultaat.innerText = "Ongeldig geboortedatum."
    }
}
