import { loginWithSpotifyClick, logoutClick, tokenStuff, isToken, getUserData, getWhat } from '/wrapper.js';

// Hulpfuncties voor weergave en data
function displayResult(jsonObject) {
    const jsonString = JSON.stringify(jsonObject, null, 2);
    document.getElementById('test').textContent = jsonString;
}

function getUserPlaylist(jsonObject) {
    const playlistsContainer = document.getElementById('playlists');
    if (!playlistsContainer) {
        // Stop de functie als het element niet bestaat
        return;
    }
    playlistsContainer.innerHTML = ''; // Leegmaken voor nieuwe inhoud

    jsonObject.items.forEach(playlist => {
        const playlistCard = document.createElement('div');
        playlistCard.classList.add('col-md-6', 'mb-3');

        playlistCard.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <iframe 
                        src="https://open.spotify.com/embed/playlist/${playlist.id}" 
                        width="100%" height="380" 
                        frameborder="0" 
                        allowtransparency="true" 
                        allow="encrypted-media">
                    </iframe>
                </div>
            </div>
        `;

        playlistsContainer.appendChild(playlistCard);
    });
}


function getUserRecentSong(jsonObject) {
    const recentSongsContainer = document.getElementById('recentSongs');
    recentSongsContainer.innerHTML = ''; // Leegmaken voor nieuwe inhoud

    jsonObject.items.forEach(track => {
        // Maak een container voor de afbeelding en tekst
        const songContainer = document.createElement('div');
        songContainer.classList.add('song-container');

        // Maak het albumafbeelding
        const img = document.createElement('img');
        img.src = track.track.album.images[0].url;
        img.alt = track.track.name;

        // Maak de tekst voor het nummer en de artiest
        const textContainer = document.createElement('div');
        textContainer.classList.add('song-text');

        const songTitle = document.createElement('p');
        songTitle.textContent = track.track.name; // Naam van het nummer

        const artistName = document.createElement('p');
        artistName.textContent = track.track.artists.map(artist => artist.name).join(', '); // Artiest(en)

        // Voeg de afbeelding en tekst toe aan de container
        textContainer.appendChild(songTitle);
        textContainer.appendChild(artistName);
        songContainer.appendChild(img);
        songContainer.appendChild(textContainer);

        // Voeg de nieuwe container toe aan de hoofdomgeving
        recentSongsContainer.appendChild(songContainer);
    });


    // Optioneel: Dubbele lijst maken voor een naadloze loop
    jsonObject.items.forEach(track => {
        const songContainer = document.createElement('div');
        songContainer.classList.add('song-container');

        const img = document.createElement('img');
        img.src = track.track.album.images[0].url;
        img.alt = track.track.name;

        const textContainer = document.createElement('div');
        textContainer.classList.add('song-text');

        const songTitle = document.createElement('p');
        songTitle.textContent = track.track.name;

        const artistName = document.createElement('p');
        artistName.textContent = track.track.artists.map(artist => artist.name).join(', ');

        textContainer.appendChild(songTitle);
        textContainer.appendChild(artistName);
        songContainer.appendChild(img);
        songContainer.appendChild(textContainer);

        recentSongsContainer.appendChild(songContainer);
    });
}



// Login-/uitlog functies
function login() {
    loginWithSpotifyClick();
}

function logoff() {
    logoutClick();
}

// Functie om de gebruikersdata in te stellen (indien nodig)
async function setUserData() {
    const user = document.getElementById('user');
    const userData = await getUserData();
    // Hier kun je userData verwerken, bijvoorbeeld tonen in de UI
}

// Initialisatie-functies voor niet-Spotify-gerelateerde zaken en Spotify-gerelateerde zaken
async function jouwInitZonderToken() {
    // Gebruik deze functie om zaken te regelen die direct moeten gebeuren,
    // onafhankelijk van of er een token is.
}

async function jouwInitMetToken() {
    if (isToken()) {
        const userData = await getUserData();
        const userId = userData.id;

        const playlists = await getWhat(`https://api.spotify.com/v1/users/${userId}/playlists`);
        console.log("Playlists response:", playlists);
        getUserPlaylist(playlists);

        const recentSongs = await getWhat('https://api.spotify.com/v1/me/player/recently-played?limit=50');
        console.log("Recent songs response:", recentSongs);
        getUserRecentSong(recentSongs);

        const followedArtists = await getWhat('https://api.spotify.com/v1/me/following'); }
        console.log("Followed artists response:", followedArtists);
        getUserArtists(followedArtists);
}

// Hoofdfunctie voor de initialisatie van de Spotify-login flow
async function init() {
    const args = new URLSearchParams(window.location.search);
    const code = args.get('code');
    const loginButton = document.getElementById('login-button');

    if (code) {
        await tokenStuff(code);
        const url = new URL(window.location.href);
        url.searchParams.delete("code");
        const updatedUrl = url.search ? url.href : url.href.replace('?', '');
        window.history.replaceState({}, document.title, updatedUrl);
    }
    
    if (isToken()) {
        loginButton.addEventListener('click', logoff);
        loginButton.textContent = "Log out of Spotify";
        const url = new URL(window.location.href);
        url.searchParams.delete("code");
        const updatedUrl = url.search ? url.href : url.href.replace('?', '');
        window.history.replaceState({}, document.title, updatedUrl);
        setUserData();
    } else {
        loginButton.addEventListener('click', login);
        loginButton.textContent = "Log in with Spotify";
    }
}

// Aanroepen van de initiële functies
init();
jouwInitZonderToken();
jouwInitMetToken();
