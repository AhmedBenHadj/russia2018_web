function CompteARebours() {
    var date_actuelle = new Date(); // On déclare la date d'aujourd'hui.
    var annee = date_actuelle.getFullYear();

    var noel = new Date(annee, 5, 14, 18, 0, 0); // On déclare la date de Noël.

    if (noel.getTime() < date_actuelle.getTime()) // Si Noël est dépassé, on passe au Noël suivant !
        noel = new Date(++annee, 5, 14, 18, 0, 0); // On re-déclare Noël pour qu'il ne soit pas passé.

    // Reste du script.
    var tps_restant = noel.getTime() - date_actuelle.getTime(); // Temps restant en millisecondes

//============ CONVERSIONS

    var s_restantes = tps_restant / 1000; // On convertit en secondes
    var i_restantes = s_restantes / 60;
    var H_restantes = i_restantes / 60;
    var d_restants = H_restantes / 24;


    s_restantes = Math.floor(s_restantes % 60); // Secondes restantes
    i_restantes = Math.floor(i_restantes % 60); // Minutes restantes
    H_restantes = Math.floor(H_restantes % 24); // Heures restantes
    d_restants = Math.floor(d_restants); // Jours restants
//==================
     var d=d_restants;
     var h=H_restantes;
     var i=i_restantes;
     var s=s_restantes;

     document.getElementById("date").innerHTML=d;
    document.getElementById("heure").innerHTML=h;
    document.getElementById("minute").innerHTML=i;
    document.getElementById("seconde").innerHTML=s;

}
setInterval(CompteARebours, 1000);