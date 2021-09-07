var lecteur;

function creerBoutons() {
    // Crée les boutons de gestion du lecteur
    var btnLecture = document.createElement("button");
    var btnPause = document.createElement("button");
    var btnStop = document.createElement("button");
    var btnReculer = document.createElement("button");
    var btnAvancer = document.createElement("button");
    var controlesBox = document.getElementById("controles");
    lecteur = document.getElementById("mavideo");
    // Ajoute un peu de texte
    btnLecture.textContent = "Lecture";
    btnPause.textContent = "Pause";
    btnStop.textContent = "Stop";
    btnReculer.textContent = "-10s";
    btnAvancer.textContent = "+10s";
    // Ajoute les boutons à l'interface
    controlesBox.appendChild(btnLecture);
    controlesBox.appendChild(btnPause);
    controlesBox.appendChild(btnStop);
    controlesBox.appendChild(btnReculer);
    controlesBox.appendChild(btnAvancer);
    // Lie les fonctions aux boutons
    btnLecture.addEventListener("click", lecture, false);
    btnPause.addEventListener("click", pause, false);
    btnStop.addEventListener("click", stop, false);
    btnReculer.addEventListener("click", function() { reculer(10) }, false);
    btnAvancer.addEventListener("click", function() { avancer(10) }, false);

    // Affiche les nouveaux boutons et supprime l'interface originale
    controlesBox.removeAttribute("hidden");
    lecteur.removeAttribute("controls");
}
//Crée les boutons lorsque le DOM est chargé
document.addEventListener('DOMContentLoaded', creerBoutons, false);

function lecture() {
    // Lit la vidéo
    lecteur.play();
}

function pause() {
    // Met la vidéo en pause
    lecteur.pause();
}
//133 Interagir un peu plus avec les médias
function stop() {
    // Arrête la vidéo

    // On met en pause
    lecteur.pause();
    // Et on se remet au départ
    lecteur.currentTime = 0;
}

function avancer(duree) {
    // Avance de 'duree' secondes
    // On parse en entier pour être sûr d'avoir un nombre
    lecteur.currentTime += parseInt(duree);
}

function reculer(duree) {
    // Recule de 'duree' secondes
    // On parse en entier pour être sûr d'avoir un nombre
    lecteur.currentTime -= parseInt(duree);
}