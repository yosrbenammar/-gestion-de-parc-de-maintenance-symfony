function verifDate(date_naissance) {
    var dateNow   =  new Date(),
        strSaisie    =  date_naissance.value,
        dateJour,
        dateSaisie;

    dateJour = new Date(dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate());
    strSaisie = strSaisie.replace(/-/g,"");
    dateSaisie = new Date(strSaisie.substr(0,4), strSaisie.substr(4,2)-1, strSaisie.substr(6,2));

    if (dateSaisie < dateJour ) {
        surligne(date_naissance, true);
    }
    else if (dateSaisie > dateJour) {
        surligne(date_naissance, false);
    }
    else {
        alert('=');
    }
}

