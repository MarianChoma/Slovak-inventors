function deleteRequest(url) {
    const id = document.getElementById("deleteId").value;
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("DELETE", url + id, false);
    xmlHttp.send(null);
    location.reload();
}

function updateRequest(url) {
    const updateId = document.getElementById("updateId").value;
    const updateName = document.getElementById("updateName").value;
    const updateSurname = document.getElementById("updateSurname").value;
    const updateBirthPlace = document.getElementById("updateBirthPlace").value;
    const updateBirthDate = document.getElementById("updateBirthDate").value;
    const updateDescription = document.getElementById("updateDescription").value;
    const updateDeathDate = document.getElementById("updateDeathDate").value;
    const updateDeathPlace = document.getElementById("updateDeathPlace").value;
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("PATCH", url, false);
    xmlHttp.send(JSON.stringify({
        "id": updateId,
        "name": updateName,
        "surname": updateSurname,
        "birthPlace": updateBirthPlace,
        "birthDate": updateBirthDate,
        "description": updateDescription,
        "deathDate": updateDeathDate,
        "deathPlace": updateDeathPlace
    }));
    location.reload();
}

function postRequest(url) {
    const newName = document.getElementById("newName").value;
    const newSurname = document.getElementById("newSurname").value;
    const newBirthPlace = document.getElementById("newBirthPlace").value;
    const newBirthDate = document.getElementById("newBirthDate").value;
    const newDescription = document.getElementById("newDescription").value;
    const newDeathDate = document.getElementById("newDeathDate").value;
    const newDeathPlace = document.getElementById("newDeathPlace").value;
    const inventionDate = document.getElementById("inventionDate").value;
    const inventionDescription = document.getElementById("inventionDescription").value;

    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", url, false);
    xmlHttp.send(JSON.stringify({
        "name": newName,
        "surname": newSurname,
        "birth_place": newBirthPlace,
        "birth_date": newBirthDate,
        "description": newDescription,
        "death_date": newDeathDate,
        "death_place": newDeathPlace,
        "inventionDescription": inventionDescription,
        "inventionYear": inventionDate
    }));
    location.reload();
}

function addInvention(url) {
    const addDescription = document.getElementById("addDescription").value;
    const addId = document.getElementById("addId").value;
    const addDate = document.getElementById("addDate").value;

    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", url, false);
    xmlHttp.send(JSON.stringify({
        "inventionDescription": addDescription,
        "inventionYear": addDate,
        "inventorId": addId
    }))
    location.reload();
}