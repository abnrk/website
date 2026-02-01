// ==UserScript==
// @name Custom Google Proxy
// @match http://localhost:8000/search.php*
// ==/UserScript==
var search_name = localStorage.getItem("search_name");
var search_logo = localStorage.getItem("search_logo");
var settingsButton = document.createElement("a");
var settingsDialog = document.createElement("dialog");
var saveButton = document.createElement("button");
var closeButton = document.createElement("button");
saveButton.innerHTML = "Save";
closeButton.innerHTML = "Close";
settingsDialog.innerHTML = `<label for="search_name">Search Engine Name: </label><input type="text" id="search_name"/><br/><label for="search_logo">Search Engine Logo: </label><input type="text" id="search_logo"/><br/>`
settingsDialog.appendChild(saveButton);
settingsDialog.appendChild(closeButton);
settingsButton.innerHTML = "Custom Settings";
saveButton.onclick = function() {
  var search_name = document.getElementById("search_name").value;
  var search_logo = document.getElementById("search_logo").value;
  localStorage.setItem("search_name",search_name);
  localStorage.setItem("search_logo",search_logo);
  location.reload();
};
closeButton.onclick = function() {
  settingsDialog.close();
};
settingsButton.onclick = function() {
  settingsDialog.showModal();
};
document.body.appendChild(settingsDialog);
document.getElementById("search_name").value = search_name;
document.getElementById("search_logo").value = search_logo;
document.querySelector("title").innerHTML = document.querySelector("title").innerHTML.replace("Google",search_name);
document.querySelector("#hdr div a").innerHTML = `<img src="${search_logo}" width="92"></img>`;
document.querySelector("footer").appendChild(settingsButton);
