const myTable = document.getElementsByClassName('table')[0];
const InventionTable = document.getElementsByClassName('table')[1];
myTable.style.display = "none";
InventionTable.style.display = "none";

function httpGetId(theUrl) {
    deleteTable(myTable);
    deleteTable(InventionTable)
    myTable.style.display = "block";
    InventionTable.style.display = "block";
    const id = document.getElementById("inputName").value;
    if (id) {
        const xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", theUrl + id, false);
        xmlHttp.send(null);
        const jsonResponse = JSON.parse(xmlHttp.responseText)
        if(jsonResponse["Inventor"]){
            let start = document.querySelector('div');
            let row = document.createElement('tr');
            createTd(row, jsonResponse["Inventor"]["ID"])
            createTd(row, jsonResponse["Inventor"]["Name"])
            createTd(row, jsonResponse["Inventor"]["Surname"])
            createTd(row, jsonResponse["Inventor"]["Description"])
            createTd(row, jsonResponse["Inventor"]["Birth_date"])
            createTd(row, jsonResponse["Inventor"]["Birth_place"])
            createTd(row, jsonResponse["Inventor"]["Death_date"]);
            createTd(row, jsonResponse["Inventor"]["Death_place"])
            myTable.style.width="100%"
            row.style.width="100%";
            myTable.appendChild(row)
            start.appendChild(myTable)

            for (let i = 0; i < Object.keys(jsonResponse["inventions"]).length; i++) {
                row = document.createElement('tr');
                createTd(row, jsonResponse["inventions"][i]["ID"])
                createTd(row, jsonResponse["inventions"][i]["Invention_date"])
                createTd(row, jsonResponse["inventions"][i]["Description"])
                row.style.width="100%";
                InventionTable.appendChild(row)
            }
            start.appendChild(InventionTable)

        }

    }
}

function getAll(theUrl) {
    deleteTable(myTable);
    myTable.style.display = "block";
    InventionTable.style.display = "none";
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", theUrl, false);
    xmlHttp.send(null);
    const jsonResponse = JSON.parse(xmlHttp.responseText)
    createTable(jsonResponse)
}

function findInventionsByCentury(url){
    myTable.style.display="none"
    const century= document.getElementById("inputName").value;
    if(century){
        const xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", url+"?century="+century, false);
        xmlHttp.send(null);
        const jsonResponse = JSON.parse(xmlHttp.responseText)
        deleteTable(InventionTable)
        let start = document.querySelector('div');
        InventionTable.style.display = "block";
        for (let i = 0; i < Object.keys(jsonResponse).length; i++) {
            let row = document.createElement('tr');
            createTd(row, jsonResponse[i]["ID"])
            createTd(row, jsonResponse[i]["Invention_date"])
            createTd(row, jsonResponse[i]["Description"])
            InventionTable.appendChild(row)
        }
        start.appendChild(InventionTable)
    }
}


function getBySurname(url){
    const surname= document.getElementById("inputName").value;
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", url+"?Name="+surname , false);
    xmlHttp.send(null);
    const jsonResponse = JSON.parse(xmlHttp.responseText)
    InventionTable.style.display = "none";
    deleteTable(myTable);
    //deleteTable(InventionTable)
    if(jsonResponse[0]["Surname"]){
        createTable(jsonResponse)

    }
}
function findByYear(url){
    const year= document.getElementById("inputName").value;
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", url+"?year="+year , false);
    xmlHttp.send(null);
    const jsonResponse = JSON.parse(xmlHttp.responseText)
    deleteTable(myTable);
    deleteTable(InventionTable)
    InventionTable.style.display = "none";
    myTable.style.display = "none";
    if(jsonResponse["birth"] || jsonResponse["death"]){
        myTable.style.display = "block";
        createTable(jsonResponse["birth"])
        createTable(jsonResponse["death"])
    }
    if(jsonResponse["inventions"]){
        let start = document.querySelector('div');
        InventionTable.style.display = "block";
        for (let i = 0; i < Object.keys(jsonResponse["inventions"]).length; i++) {
            let row = document.createElement('tr');
            createTd(row, jsonResponse["inventions"][i]["ID"])
            createTd(row, jsonResponse["inventions"][i]["Invention_date"])
            createTd(row, jsonResponse["inventions"][i]["Description"])
            InventionTable.appendChild(row)
        }
        start.appendChild(InventionTable)
    }


}

const deleteTable = (dTable) => {
    let myRows = dTable.rows.length
    for (let i = myRows - 1; i > 0; i--) {
        dTable.deleteRow(i);
    }
}

const createTd = (row, name) => {
    let td = document.createElement('td');
    td.innerHTML = name;
    row.appendChild(td);
}

const createTable=(jsonResponse)=>{
    let start = document.querySelector('div');
    //
    for (let i = 0; i < Object.keys(jsonResponse).length; i++) {
        let row = document.createElement('tr');
        createTd(row, jsonResponse[i]["ID"])
        createTd(row, jsonResponse[i]["Name"])
        createTd(row, jsonResponse[i]["Surname"])
        createTd(row, jsonResponse[i]["Description"])
        createTd(row, jsonResponse[i]["Birth_date"])
        createTd(row, jsonResponse[i]["Birth_place"])
        createTd(row, jsonResponse[i]["Death_date"]);
        createTd(row, jsonResponse[i]["Death_place"])
        myTable.appendChild(row)
    }
    start.appendChild(myTable)
}


