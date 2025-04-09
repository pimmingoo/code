
const authorizationEndpoint = "https://accounts.spotify.com/authorize";
const clientId = "26b32f38f33749818233cd3721b5eb70";
const scope = 'user-read-private user-read-email user-top-read user-read-recently-played';
const redirectUrl = 'http://127.0.0.1:5500/index.html';
const tokenEndpoint = "https://accounts.spotify.com/api/token";

const currentToken = {
  get access_token() { return localStorage.getItem('access_token') || null; },
  get refresh_token() { return localStorage.getItem('refresh_token') || null; },
  get expires_in() { return localStorage.getItem('refresh_in') || null },
  get expires() { return localStorage.getItem('expires') || null },

  save: function (response) {
    const { access_token, refresh_token, expires_in } = response;
    localStorage.setItem('access_token', access_token);
    localStorage.setItem('refresh_token', refresh_token);
    localStorage.setItem('expires_in', expires_in);

    const now = new Date();
    const expiry = new Date(now.getTime() + (expires_in * 1000));
    localStorage.setItem('expires', expiry);
  }
};


export async function loginWithSpotifyClick()
{
    await redirectToSpotifyAuthorize();
}

async function redirectToSpotifyAuthorize() {
  const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const randomValues = crypto.getRandomValues(new Uint8Array(64));
  const randomString = randomValues.reduce((acc, x) => acc + possible[x % possible.length], "");

  const code_verifier = randomString;
  const data = new TextEncoder().encode(code_verifier);
  const hashed = await crypto.subtle.digest('SHA-256', data);

  const code_challenge_base64 = btoa(String.fromCharCode(...new Uint8Array(hashed)))
    .replace(/=/g, '')
    .replace(/\+/g, '-')
    .replace(/\//g, '_');

  window.localStorage.setItem('code_verifier', code_verifier);

  const authUrl = new URL(authorizationEndpoint)
  const params = {
    response_type: 'code',
    client_id: clientId,
    scope: scope,
    code_challenge_method: 'S256',
    code_challenge: code_challenge_base64,
    redirect_uri: redirectUrl,
  };

  authUrl.search = new URLSearchParams(params).toString();
  window.location.href = authUrl.toString(); // Redirect the user to the authorization server for login
}

export async function logoutClick() {
  localStorage.clear();
  window.location.href = redirectUrl;
}

export async function tokenStuff(iCode)
{
    const token = await getToken(iCode);
    currentToken.save(token);
}
export async function getUserData()
{
    const response = await fetch("https://api.spotify.com/v1/me", {
    method: 'GET',
    headers: { 'Authorization': 'Bearer ' + currentToken.access_token },
  });

  return await response.json();
}
export async function getEndpointContent(endpoint,parameters)
{
    if(isToken())
    {
        const url = new URL(endpoint);
        url.search = new URLSearchParams(parameters).toString();
        const response = await fetch(url.toString(),
        {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + currentToken.access_token },
        });
        return await response.json();
    }
    return false;
}
export async function getWhat(url,parameters)
{
     return await getEndpointContent(url,parameters);
}

async function getToken(code)
{
  const code_verifier = localStorage.getItem('code_verifier');

  const response = await fetch(tokenEndpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
      client_id: clientId,
      grant_type: 'authorization_code',
      code: code,
      redirect_uri: redirectUrl,
      code_verifier: code_verifier,
    }),
  });

  return await response.json();
}

export function isToken()
{
    const accessToken = localStorage.getItem('access_token');
    const expires = localStorage.getItem('expires');
    if (accessToken && expires)
    {
        const expiryDate = new Date(expires);
        const now = new Date();
        if (expiryDate > now)
        {
          return true;
        }
    }
    return false;
}
