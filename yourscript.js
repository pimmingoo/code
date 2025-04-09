
import {loginWithSpotifyClick,logoutClick,tokenStuff,isToken,getUserData,getWhat } from './wrapper.js';


function login()
{
    loginWithSpotifyClick();
}
function logoff()
{
    logoutClick();
}

async function init()
{
    const args = new URLSearchParams(window.location.search);
    const code = args.get('code');
    const loginButton = document.getElementById('login-button');
    if (code)
    {
        await tokenStuff(code);
        const url = new URL(window.location.href);
        url.searchParams.delete("code");
        const updatedUrl = url.search ? url.href : url.href.replace('?', '');
        window.history.replaceState({}, document.title, updatedUrl);
    }
    if (isToken())
    {
        loginButton.addEventListener('click', logoff);
        loginButton.textContent = "Log out of Spotify";
        const url = new URL(window.location.href);
        url.searchParams.delete("code");
        const updatedUrl = url.search ? url.href : url.href.replace('?', '');
        window.history.replaceState({}, document.title, updatedUrl);
        setUserData();
    }
    else
    {
        loginButton.addEventListener('click', login);
        loginButton.textContent = "Log in with Spotify";
    }
}

async function setUserData()
{
    const user = document.getElementById('user');
    const userData = await getUserData();
    user.innerHTML = "Welkom " + userData.display_name;
}

function displayResult(jsonObject)
{
    const jsonString = JSON.stringify(jsonObject, null, 2);
    document.getElementById('test').textContent=  jsonString;

}

async function jouwInitZonderToken()
{//gebruik deze functie om dingen te regelen die direkt moeten gebeuren dus zonder dat er bijv. op een knop wordt gedrukt
//en ook onafhankelijk of we een token hebben
//oftewel zaken die niet gerelateerd zijn aan spotify...

}

async function jouwInitMetToken()
{//gebruik deze functie om dingen te regelen die direkt moeten gebeuren dus zonder dat er bijv. op een knop wordt gedrukt
//maar MET een valide key
//oftewel zaken die wel gerelateerd zijn aan spotify...
    if(isToken)
    {
        displayResult(await getWhat("https://api.spotify.com/v1/search",{"q":"queen","type":"artist"}));
        //displayResult(await getWhat("https://api.spotify.com/v1/me/top/artists"));
        //displayResult(await getWhat("https://api.spotify.com/v1/me"));
    }
}

init();
jouwInitZonderToken();
jouwInitMetToken();



